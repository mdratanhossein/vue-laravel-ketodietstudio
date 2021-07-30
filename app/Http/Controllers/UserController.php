<?php

namespace App\Http\Controllers;

use Hashids\Hashids;
use Illuminate\Http\Request;

use App\User;
use App\HelpArticle;
use App\Payment;
use App\MealPlan;
use App\Product;
use Config;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

use isfonzar\TDEECalculator\TDEECalculator;


class UserController extends Controller
{
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Sets a password for user.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setPassword(Request $request)
    {
        $email    = $request->get('email');
        $password = $request->get('password');

        $user = \App\User::whereEmail($email)->first();

        if( !$user ){
            return response()->json(['error' => 'Forbidden'], 403);
        }

        //if user already has password, we cant set it again
        //or if password is not set
        if( $user->password || !$password ){
            return response()->json(['error' => 'Bad Request'], 400);
        }

        $user->password = bcrypt($password);
        $user->save();

        return response()->json(['message' => 'Successfully set password']);
    }

    /**
     * Insert item to Users with only diet plan details
     *
     * @param post $request
     *
     * @return string summaryId
     */
    public function addCalculation(Request $request)
    {
        // Retrieve post data from request
        $user_data = $request->data;

        // Insert new User
        $user = new User;

        // Fill items from post data
        $user->gender = boolval($user_data['gender']);
        $user->familiar = intval($user_data['familiar']);
        $user->preparation = intval($user_data['preparation']);
        $user->physical_active = intval($user_data['physical_active']);
        $user->willing_option = intval($user_data['willing_option']);
        $user->age = intval($user_data['age']);
        $user->unit = boolval($user_data['unit']);

        // Decide the gender
        $genderStr = $user->gender ? 'male' : 'female';

        if ($user_data['unit']) {
            $user->height_cm = intval($user_data['height_cm']);
            $user->weight_kg = intval($user_data['weight_kg']);
            $user->target_kg = intval($user_data['target_kg']);

            // Calculate the bmi value according the user's height, weight
            $height = $user->height_cm / 100;
            $user->bmi = $user->weight_kg / round(($height * $height), 2);
            $options = ['formula' => 'revised_harris_benedict', 'unit' => 'metric'];

            // Calculate the calorie according the user's gender, target_weight, height (metric option)
            $tdeeCalculator = new TDEECalculator($options);
            $user->calorie = $tdeeCalculator->calculate($genderStr, $user->target_kg, $user->height_cm,
                $user->age);
        } else {
            $user->height_ft = intval($user_data['height_ft']);
            $user->height_in = intval($user_data['height_in']);
            $user->weight_lb = intval($user_data['weight_lb']);
            $user->target_lb = intval($user_data['target_lb']);

            // Calculate the bmi value according the user's height, weight
            $height = $user->height_ft * 12 + $user->height_in;
            $user->bmi = ($user->weight_lb * 703) / ($height * $height);

            // Calculate the calorie according the user's gender, target_weight, height (imperial option)
            $options = ['formula' => 'mifflin_st_jeor', 'unit' => 'imperial'];
            $tdeeCalculator = new TDEECalculator($options);
            $user->calorie = $tdeeCalculator->calculate($genderStr, $user->target_lb, floatval($height) / 12,
                $user->age);
        }

        // Adjust the value for reality
        $user->calorie -= 440;

        // Create unique id for column key
        $uniqId = md5(uniqid(time()));
        $user->key = $uniqId;

        // Save the user information
        $user->save();

        // Insert product_user relation items
        $meal_products = $user_data['meal_product'];
        $productIds = [];
        foreach ($meal_products as $product) {
            $productId = Product::where('name', $product)->first()->id;
            array_push($productIds, $productId);
        }
        $user->products()->attach($productIds);


        // Return key of the user
        return (['summaryId' => $uniqId]);
    }

    /**
     * Insert email address to appropriate user column
     *
     * @param post $request
     *
     * @return bool success
     * @return string summaryId
     */
    public function addEmail(Request $request)
    {
        // Retrieve post data from request
        $user_data = $request->data;

        $emailAddrValue = $user_data['email_addr'];
        $key_value = $user_data['summaryId'];

        // Find user with key value and return if cannot find the user
        $user = User::where('email', $emailAddrValue)->first();
        if ($user) {
            if ($user->payment()->first()) {
                return (['success' => false, 'paid' => true, 'summaryId' => $user->key]);
            }
        }

        // Find user with key value and return if cannot find the user
        $user = User::where('key', $key_value)->first();
        if (!$user) {
            return (['success' => false, 'summaryId' => $key_value]);
        }

        // Save email on the user
        $user->update([
            'email' => $emailAddrValue
        ]);

        return (['success' => true, 'summaryId' => $key_value]);
    }

    /**
     * Get the detail of the appropriate user
     *
     * @param post $request
     *
     * @return bool success
     * @return bool paid
     * @return string summaryId
     * @return array userInfo
     * @return array products
     */
    public function getUserInfo(Request $request)
    {
        // Retrieve key valur from request
        $key_value = $request->summaryId;

        // Find the appropriate user according the key value
        $user = User::where('key', $key_value)->first();
        if (!$user) {
            return (['success' => false, 'summaryId' => $key_value]);
        }

        // Get the payment related with the user
        $payment = $user->payment()->first();
        $paid = $payment ? true : false;

        // Get the product array related with the user
        $products = $user->products()->get()->pluck('name');
        $hashids = new Hashids();

        return ([
            'success'   => true,
            'paid'      => $paid,
            'summaryId' => $key_value,
            'userInfo'  => $user,
            'ref_url'   => url('/u/' . $hashids->encode($user->id)),
            'products'  => $products,
        ]);
    }

    /**
     * Search user by using email address
     *
     * @param post $request
     *
     * @return bool success
     * @return bool paid
     * @return string result
     */
    public function searchPlan(Request $request)
    {
        // Retrieve email address from request
        $email = $request->data;
        $paid = true;

        // Find the user according the email address
        $user = User::where('email', $email)->whereNotNull('payment_id')->first();

        if (!$user) {
            $paid = false;
            $user = User::where('email', $email)->first();
        }

        if (!$user) {
            return (['success' => false, 'result' => null]);
        }

        return (['success' => true, 'paid' => $paid, 'result' => $user->key]);
    }

    public function setFirstName(Request $request)
    {
        $user_data = $request->data;
        $key_value = $user_data['summaryId'];
        $user_name = $user_data['username'];

        $user = User::where('key', $key_value)->first();
        if (!$user) {
            return (['success' => false, 'summaryId' => $key_value]);
        }

        $user->name = $user_name;
        $user->save();

        return (['success' => true, 'summaryId' => $key_value]);
    }

    public function sendMail(Request $request)
    {
        $user_data = $request->data;
        Mail::to(Config::get('mail.to.address'))->send(new SendMail($user_data));

        return (['success' => true]);
    }

    public function learnKeto(Request $request)
    {
        $article_data = HelpArticle::get();

        $article_data->map(function ($article) {
            $article[ 'image_url' ] = $article->image->url();

            return $article;
        });
        return (['success' => true, 'article_data' => $article_data]);
    }   

    public function viewContent(Request $request)
    {
        $article_id = $request->data;

        $article_data = HelpArticle::where('id', $article_id)->get();

        $article_data->map(function ($article) {
            $article[ 'image_url' ] = $article->image->url();

            return $article;
        });

        return (['success' => true, 'article_data' => $article_data]);
    }   
}
