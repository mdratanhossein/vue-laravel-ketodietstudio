<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Payment;
use App\Progress;
use App\MealPlan;
use App\Membership;
use App\Recipe;
use App\Product;

use DateTime;

class PaymentController extends Controller
{
    /**
     * Add payment to the user in which case in Paypal
     *
     * @param post $request
     */
    public function addPaypal(Request $request)
    {
        // Retrieve post data from request
        $user_data = $request->data;

        $key_value        = $user_data[ 'summaryId' ];
        $payment_id_value = $user_data[ 'paymentId' ];
        $method_value     = boolval($user_data[ 'method' ]);
        $email_addr_value = $user_data[ 'email_addr' ];
        $option_value     = intval($user_data[ 'option' ]);
        $amount_value     = intval($user_data[ 'amount' ]);
        $currency_value   = $user_data[ 'currency' ];
        $detail_value     = $user_data[ 'detail' ];

        // Find user with key value
        $user = User::where('key', $key_value)->first();
        if (!$user) {
            return (['success' => false, 'summaryId' => $key_value]);
        }

        // Insert new payment
        $payment = Payment::where('payment_id', $payment_id_value)->first();
        if (!$payment) {
            $payment             = new Payment;
            $payment->payment_id = $payment_id_value;
            $payment->method     = $method_value;
            $payment->email      = $email_addr_value;
            $payment->amount     = $amount_value;
            $payment->currency   = $currency_value;
            $payment->detail     = $detail_value;
            $payment->save();
        }

        // Insert payment id to the user
        $user->payment()->associate($payment);

        // Insert membership id to the user
        $membership = Membership::where('id', $option_value + 1)->first();
        $user->membership()->associate($membership);

        // Insert payment datetime to the user
        $datetime         = new DateTime();
        $user->started_at = $datetime->format('Y-m-d H:i:s');

        // Save user
        $user->save();

        // Insert new progress
        $progress = new Progress;
        if ($user->unit) {
            $progress->weight_kg = $user->weight_kg;
            $progress->weight_lb = round(floatval($user->weight_kg) * 2.20462);
        } else {
            $progress->weight_kg = round(floatval($user->weight_lb) * 0.453592);
            $progress->weight_lb = $user->weight_lb;
        }
        $progress->user()->associate($user);
        $progress->save();

        // Call auto assigning function for meal plan
        return $this->autoAssignPlan($key_value);
    }

    /**
     * Add payment to the user in which case in Stripe
     *
     * @param post $request
     */
    public function addStripe(Request $request)
    {
        // Load stripe vendor component by using the stripe security key stored in .env
        \Stripe\Stripe::setApiKey(env('STRIPE_SECURITY_KEY', ''));

        // Retrieve data from post
        $user_data = $request->data;

        $key_value = $user_data[ 'summaryId' ];
        $plan      = intval($user_data[ 'plan' ]);
        $token     = $user_data[ 'token' ];

        if ($plan == 0) {
            $amount = 3300;
        } else {
            if ($plan == 1) {
                $amount = 6600;
            } else {
                if ($plan == 2) {
                    $amount = 4600;
                } else {
                    return (['success' => false, 'error' => 'invalid input']);
                }
            }
        }

        // Create charge by using input data
        $charge = \Stripe\Charge::create([
            'amount'      => $amount,
            'currency'    => 'usd',
            'description' => 'Ketodietstudio charge',
            'source'      => $token,
        ]);


        if ($charge[ 'status' ] == "succeeded") {

            // Find user by using the key value
            $user = User::where('key', $key_value)->first();
            if (!$user) {
                return (['success' => false, 'summaryId' => $key_value]);
            }

            // Insert new payment
            $payment = Payment::where('payment_id', $charge[ 'id' ])->first();
            if (!$payment) {
                $payment             = new Payment;
                $payment->payment_id = $charge[ 'id' ];
                $payment->method     = 1;
                $payment->email      = $charge[ 'billing_details' ][ 'email' ] ? $charge[ 'billing_details' ][ 'email' ] : "";
                $payment->amount     = $charge[ 'amount' ] / 100;
                $payment->currency   = $charge[ 'currency' ];
                $payment->detail     = $charge;
                $payment->save();
            }

            // Insert membership id
            $membership = Membership::where('id', $plan + 1)->first();
            $user->membership()->associate($membership);

            // Insert new payment id
            $user->payment()->associate($payment);

            // Insert payment datetime
            $datetime         = new DateTime();
            $user->started_at = $datetime->format('Y-m-d H:i:s');

            $user->save();

            // Insert new progress
            $progress = new Progress;
            if ($user->unit) {
                $progress->weight_kg = $user->weight_kg;
                $progress->weight_lb = round(floatval($user->weight_kg) * 2.20462);
            } else {
                $progress->weight_kg = round(floatval($user->weight_lb) * 0.453592);
                $progress->weight_lb = $user->weight_lb;
            }

            $progress->user()->associate($user);
            $progress->save();

            // Call auto assigning function
            return $this->autoAssignPlan($key_value);
        } else {
            return (['success' => false, 'error' => $charge]);
        }
    }

    /**
     * Auto assign meal plan for the user
     *
     * @param string summaryId
     *
     * @return
     */
    private function autoAssignPlan($key_value)
    {
        // Find user according the key value
        $user = User::where('key', $key_value)->first();
        if (!$user) {
            return (['success' => false]);
        }

        // Prepare recipe array according the user's prepare option
        if ($user->preparation == 0) {
            $recipes = Recipe::where('total_time', '<=', 30)->get();
        } else {
            if ($user->preparation == 1) {
                $recipes = Recipe::where('total_time', '<=', 60)->get();
            } else {
                $recipes = Recipe::get();
            }
        }

        // Prepare product array for the user by using relation
        $user_products = $user->products()->get()->pluck('name')->toArray();

        // Loop for 5 meal time : breakfast, morning_snack, lunch, evening_snack, dinner
        for ($meal_time = 0; $meal_time < 5; $meal_time++) {

            // Filter for getting right recipes matching product & meal time
            $plan_time = $recipes->filter(function ($recipe) use ($user_products, $meal_time) {
                if ($recipe->meal_type == $meal_time) { // match meal time
                    $recipe_products = $recipe->products()->get()->pluck('name');
                    foreach ($recipe_products as $recipe_product) {
                        if (in_array($recipe_product, $user_products)) { // match product
                            return true;
                        }
                    }
                }
            });

            // Prepare array for storing recipes' id
            $plan_options = [];
            foreach ($plan_time as $key => $item) {
                array_push($plan_options, $item->id);
            }

            if (count($plan_options)) {
                // Attach random recipe for each cycle date
                $cycle_length = 28;
                for ($day = 0; $day < $cycle_length; $day++) {
                    $plan_item = intval($plan_options[ rand(0, count($plan_options) - 1) ]);
                    $user->recipes()->attach($plan_item, ['cycle' => $day, 'mealtime' => $meal_time]);
                }
            } else {
                return (['success' => false, 'summaryId' => $key_value]);
            }
        }

        return (['success' => true, 'summaryId' => $key_value]);
    }
}
