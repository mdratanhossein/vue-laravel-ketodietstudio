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

class MealController extends Controller
{
    /**
     * Update product setting of the user
     *
     * @param post $request
     *
     * @return bool success
     * @return string summaryId
     */
    public function updateProducts(Request $request)
    {
        // Retrieve post data from request
        $user_data = $request->data;

        $key_value        = $user_data[ 'summaryId' ];
        $updated_products = $user_data[ 'products' ];

        // Find the user according the key value
        $user = User::where('key', $key_value)->first();
        if (!$user) {
            return (['success' => false, 'summaryId' => $key_value]);
        }

        // Prepare product array requested from the user
        $productIds = [];
        foreach ($updated_products as $product) {
            $productId = Product::where('name', $product)->first()->id;
            array_push($productIds, $productId);
        }

        // Update products
        $user->products()->sync($productIds);

        return (['success' => true, 'summaryId' => $key_value]);
    }

    /**
     * Update the profile of the user
     *
     * @param post $request
     *
     * @return bool success
     * @return string summaryId
     */
    public function updateProfile(Request $request)
    {
        // Retrieve
        $user_data = $request->data;

        $key_value      = $user_data[ 'summaryId' ];
        $email_value    = $user_data[ 'email' ];
        $age_value      = intval($user_data[ 'age' ]);
        $gender_value   = boolval($user_data[ 'gender' ]);
        $unit_value     = boolval($user_data[ 'unit' ]);
        $target_value   = floatval($user_data[ 'target' ]);
        $physical_value = intval($user_data[ 'physical' ]);
        $willing_value  = intval($user_data[ 'willing' ]);
        $prepare_value  = intval($user_data[ 'prepare' ]);

        // Find the user by using the key value
        $user = User::where('key', $key_value)->first();
        if (!$user) {
            return (['success' => false, 'summaryId' => $key_value]);
        }

        $user->email           = $email_value;
        $user->gender          = $gender_value;
        $user->preparation     = $prepare_value;
        $user->physical_active = $physical_value;
        $user->willing_option  = $willing_value;
        $user->unit            = $unit_value;
        if ($unit_value == false) {
            $user->target_lb = $target_value;
            if ($user->weight_lb == null && $user->weight_kg) {
                $user->weight_lb = round(floatval($user->weight_kg) * 2.20462);
            }
        } else {
            $user->target_kg = $target_value;
            if ($user->weight_kg == null && $user->weight_lb) {
                $user->weight_kg = round(floatval($user->weight_lb) * 0.453592);
            }
        }
        $user->save();

        return (['success' => true, 'summaryId' => $key_value]);
    }

    /**
     * Restart the user cycle
     *
     * @param post $request
     *
     * @return bool success
     * @return string summaryId
     */
    public function restartCycle(Request $request)
    {
        // Retrieve post data from request
        $user_data = $request->data;
        $key_value = $user_data[ 'summaryId' ];

        // Find the user by using the key value
        $user = User::where('key', $key_value)->first();
        if (!$user) {
            return (['success' => false, 'summaryId' => $key_value]);
        }

        // Update the started_at item with current datetime
        $datetime         = new DateTime();
        $user->started_at = $datetime->format('Y-m-d H:i:s');

        $user->save();

        return (['success' => true, 'summaryId' => $key_value]);
    }

    /**
     * Save the input weight to progress
     *
     * @param post $request
     *
     * @return bool success
     * @return string summaryId
     */
    public function saveWeight(Request $request)
    {
        // Retrieve post data from request
        $user_data = $request->data;

        $key_value    = $user_data[ 'summaryId' ];
        $weight_value = intval($user_data[ 'weight' ]);

        // Find the user by using the key value
        $user = User::where('key', $key_value)->first();
        if (!$user) {
            return (['success' => false, 'summaryId' => $key_value]);
        }

        // Insert new progress
        $progress = new Progress;
        if ($user->unit) {
            $progress->weight_kg = $weight_value;
            $progress->weight_lb = round(floatval($weight_value) * 2.20462);
        } else {
            $progress->weight_kg = round(floatval($weight_value) * 0.453592);
            $progress->weight_lb = $weight_value;
        }
        $progress->user()->associate($user);
        $progress->save();

        return (['success' => true, 'summaryId' => $key_value]);
    }

    /**
     * Get all progressed related to the user
     *
     * @param post $request
     *
     * @return bool success
     * @return string summaryId
     * @return array progresses
     */
    public function getProgresses(Request $request)
    {
        // Retrieve the post data from request
        $user_data = $request->data;
        $key_value = $user_data[ 'summaryId' ];

        // Find the user by using the key value
        $user = User::where('key', $key_value)->first();
        if (!$user) {
            return (['success' => false, 'summaryId' => $key_value]);
        }        

        // Get all progress ordered by datetime
        $progresses = $user->progresses->sortByDesc('created_at')->pluck('id');

        // Prepare empty arrays for chart data
        $chartData = [];
        $xData     = [];
        $yData     = [];

        if ($user->unit) {
            $yData[ 'name' ] = 'weight (kg)';
            $yData[ 'data' ] = $progresses = $user->progresses->pluck('weight_kg');
        } else {
            $yData[ 'name' ] = 'weight (lbs)';
            $yData[ 'data' ] = $progresses = $user->progresses->pluck('weight_lb');
        }
        $xData[ 'type' ] = 'datetime';
        $xData[ 'data' ] = $progresses = $user->progresses->pluck('created_at');

        $series = [];
        array_push($series, $yData);
        array_push($chartData, $series);
        array_push($chartData, $xData);


        return ([
            'success' => true, 
            'summaryId' => $key_value, 
            'progresses' => $user->progresses->all(),
            'chartData' => $chartData
            ]);
    }

    /**
     * Remove progress from the list of progresses related with the user
     *
     * @param post $request
     *
     * @return bool success
     * @return string summaryId
     */
    public function removeProgress(Request $request)
    {
        // Retrieve post data from request
        $user_data         = $request->data;
        $key_value         = $user_data[ 'summaryId' ];
        $progress_id_value = $user_data[ 'progressId' ];

        // Find the user by using the key
        $user = User::where('key', $key_value)->first();
        if (!$user) {
            return (['success' => false, 'summaryId' => $key_value]);
        }

        // Get all progresses of the user by using relation
        $progresses = $user->progresses->pluck('id');

        // Delete the appropriate progress
        if ($progresses->contains($progress_id_value)) {
            $progress = Progress::where('id', $progress_id_value)->first();
            $progress->delete();

            return (['success' => true, 'summaryId' => $key_value]);
        } else {
            return (['success' => false, 'summaryId' => $key_value]);
        }
    }

    /**
     * Get all possible array of the meal plan for the user
     *
     * @param post $request
     *
     * @return bool success
     * @return string summaryId
     * @return array breakfast
     * @return array morning_snack
     * @return array lunch
     * @return array evening_snack
     * @return array dinner
     */
    public function getMealOption(Request $request)
    {
        // Retrieve post data from request
        $user_data = $request->data;
        $key_value = $user_data[ 'summaryId' ];

        // Find the user by using th key value
        $user = User::where('key', $key_value)->first();
        if (!$user) {
            return (['success' => false, 'summaryId' => $key_value]);
        }

        // Prepare recipe array according the user's meal prepare time setting
        if ($user->preparation == 0) {
            $recipes = Recipe::where('total_time', '<=', 30)->get();
        } else {
            if ($user->preparation == 1) {
                $recipes = Recipe::where('total_time', '<=', 60)->get();
            } else {
                $recipes = Recipe::get();
            }
        }

        // Get all products of the user by using relation
        $meal_products = $user->products()->get()->pluck('name')->toArray();

        // Filter recipes for geting matching recipe according the meal time for breakfast and product setting of the user
        $breakfast = $recipes->filter(function ($recipe) use ($meal_products) {
            if ($recipe->meal_type == 0) {
                $recipe_products = $recipe->products()->get()->pluck('name');
                foreach ($recipe_products as $recipe_product) {
                    if (in_array($recipe_product, $meal_products)) {
                        return true;
                    }
                }
            }
        });

        // Filter recipes for geting matching recipe according the meal time for morning snack and product setting of the user
        $morning_snack = $recipes->filter(function ($recipe) use ($meal_products) {
            if ($recipe->meal_type == 1) {
                $recipe_products = $recipe->products()->get()->pluck('name');
                foreach ($recipe_products as $recipe_product) {
                    if (in_array($recipe_product, $meal_products)) {
                        return true;
                    }
                }
            }
        });

        // Filter recipes for geting matching recipe according the meal time for lunch and product setting of the user
        $lunch = $recipes->filter(function ($recipe) use ($meal_products) {
            if ($recipe->meal_type == 2) {
                $recipe_products = $recipe->products()->get()->pluck('name');
                foreach ($recipe_products as $recipe_product) {
                    if (in_array($recipe_product, $meal_products)) {
                        return true;
                    }
                }
            }
        });

        // Filter recipes for geting matching recipe according the meal time for evening snack and product setting of the user
        $evening_snack = $recipes->filter(function ($recipe) use ($meal_products) {
            if ($recipe->meal_type == 3) {
                $recipe_products = $recipe->products()->get()->pluck('name');
                foreach ($recipe_products as $recipe_product) {
                    if (in_array($recipe_product, $meal_products)) {
                        return true;
                    }
                }
            }
        });

        // Filter recipes for geting matching recipe according the meal time for dinner and product setting of the user
        $dinner = $recipes->filter(function ($recipe) use ($meal_products) {
            if ($recipe->meal_type == 4) {
                $recipe_products = $recipe->products()->get()->pluck('name');
                foreach ($recipe_products as $recipe_product) {
                    if (in_array($recipe_product, $meal_products)) {
                        return true;
                    }
                }
            }
        });

        // Prepare breakfast array
        $breakfast_options = [];
        foreach ($breakfast as $key => $value) {
            array_push($breakfast_options, ['value' => $value->id, 'label' => $value->title]);
        }

        // Prepare morning snack array
        $morning_snack_options = [];
        foreach ($morning_snack as $key => $value) {
            array_push($morning_snack_options, ['value' => $value->id, 'label' => $value->title]);
        }

        // Prepare lunch array
        $lunch_options = [];
        foreach ($lunch as $key => $value) {
            array_push($lunch_options, ['value' => $value->id, 'label' => $value->title]);
        }

        // Prepare evening snack array
        $evening_snack_options = [];
        foreach ($evening_snack as $key => $value) {
            array_push($evening_snack_options, ['value' => $value->id, 'label' => $value->title]);
        }

        // Prepare dinner array
        $dinner_options = [];
        foreach ($dinner as $key => $value) {
            array_push($dinner_options, ['value' => $value->id, 'label' => $value->title]);
        }

        return ([
            'success'       => true,
            'summaryId'     => $key_value,
            'breakfast'     => $breakfast_options,
            'morning_snack' => $morning_snack_options,
            'lunch'         => $lunch_options,
            'evening_snack' => $evening_snack_options,
            'dinner'        => $dinner_options,
        ]);
    }

    /**
     * Update individual meal plan of the user
     *
     * @param post $request
     *
     * @return
     */
    public function updateMealPlan(Request $request)
    {
        // Retrieve post data from request
        $user_data = $request->data;

        $key_value     = $user_data[ 'summaryId' ];
        $meal_prepared = $user_data[ 'meal_prepared' ];

        // Find the user by using the key value
        $user = User::where('key', $key_value)->first();
        if (!$user) {
            return (['success' => false, 'summaryId' => $key_value]);
        }

        //
        $breakfast     = $user_data[ 'breakfast' ];
        $morning_snack = $user_data[ 'morning_snack' ];
        $lunch         = $user_data[ 'lunch' ];
        $evening_snack = $user_data[ 'evening_snack' ];
        $dinner        = $user_data[ 'dinner' ];

        if ($meal_prepared) {
            $meal_plan                = $user->mealplan()->first();
            $meal_plan->breakfast     = $breakfast;
            $meal_plan->morning_snack = $morning_snack;
            $meal_plan->lunch         = $lunch;
            $meal_plan->evening_snack = $evening_snack;
            $meal_plan->dinner        = $dinner;
            $meal_plan->save();
        } else {
            $meal_plan                = new MealPlan;
            $meal_plan->breakfast     = $breakfast;
            $meal_plan->morning_snack = $morning_snack;
            $meal_plan->lunch         = $lunch;
            $meal_plan->evening_snack = $evening_snack;
            $meal_plan->dinner        = $dinner;
            $meal_plan->user()->associate($user);
            $meal_plan->save();
        }

        return (['success' => true, 'summaryId' => $key_value]);
    }

    /**
     * Get all meal plan of the user
     *
     * @param post $request
     *
     * @return bool success
     * @return string summaryId
     * @return array meal_plan
     */
    public function getMealPlan(Request $request)
    {
        // Retrieve post data from request
        $user_data = $request->data;
        $key_value = $user_data[ 'summaryId' ];

        // Find the user by using the key value
        $user = User::where('key', $key_value)->first();
        if (!$user) {
            return (['success' => false, 'summaryId' => $key_value]);
        }

        // Get all recipes prepared for meal plan of the user
        $mealplan = $user->recipes()->get();

        $updated_mealplan = $mealplan->map(function ($recipe) {
            $recipe[ 'image_url' ] = $recipe->image->url();

            return $recipe;
        });

        $success  = $mealplan ? true : false;

        return (['success' => $success, 'summaryId' => $key_value, 'meal_plan' => $mealplan]);
    }

    //Update user's meal according current day
    public function updateCurrDayMeal(Request $request)
    {
        $update_data = $request->data;

        $key_value = $update_data['summaryId'];
        $currDay = $update_data['currDay'];

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
                    $plan_item = intval($plan_options[ rand(0, count($plan_options) - 1) ]);
                    $user->recipes()->wherePivot('cycle','=',$currDay)->wherePivot('mealtime','=',$meal_time)->detach();
                    $user->recipes()->attach($plan_item, ['cycle' => $currDay, 'mealtime' => $meal_time]);
            } else {
                return (['success' => false, 'summaryId' => $key_value]);
            }
        }

        return (['success' => true, 'summaryId' => $key_value]);
    } 

    /**
     * Get products array according type
     *
     * @param post $request
     *
     * @return bool success
     * @return array products
     */
    public function getProducts(Request $request)
    {
        // Retrieve post data from request
        $user_data = $request->data;
        $typeVal   = boolval($user_data[ 'type' ]);

        // Find the recipe by using the id
        $products = Product::where('type', $typeVal)->get()->pluck('name');

        return (['success' => true, 'products' => $products]);
    }

    private function getPrepareString(int $prep_time) {
        if($prep_time > 5 &&  $prep_time < 11) {
            $prepare = 'Up to 10min';
        } else if($prep_time > 10 &&  $prep_time < 16) {
            $prepare = 'Up to 15min';
        }  else if($prep_time > 15 &&  $prep_time < 31) {
            $prepare = 'Up to 30min';
        } else if($prep_time > 30 &&  $prep_time < 46) {
            $prepare = 'More than 30min';
        } else if($prep_time > 45 &&  $prep_time < 61) {
            $prepare = 'Up to 1hour';
        } else if($prep_time > 60 &&  $prep_time < 76) {
            $prepare = 'More than 1hour';
        } else if($prep_time > 75 &&  $prep_time < 91) {
            $prepare = 'Up to 1hour 30min';
        } else if($prep_time > 90 &&  $prep_time < 106) {
            $prepare = 'More than 1hour 30min';
        } else if($prep_time > 105 &&  $prep_time < 121) {
            $prepare = 'Up to 2hours';
        } else if($prep_time > 120) {
            $prepare = 'More than 2hours';  
        } else {
            $prepare = 'Up to ' . strval($prep_time) .'min';          
        }

        return $prepare;
    }

    /**
     * Get meal information for individual ID
     *
     * @param post $request
     *
     * @return bool success
     * @return object meal_info
     */
    public function getMealInfo(Request $request)
    {
        // Retrieve post data from request
        $user_data = $request->data;
        $meal_id   = $user_data[ 'id' ];

        // Find the recipe by using the id
        $recipe  = Recipe::where('id', $meal_id)->first();
        $success = $recipe ? true : false;

        if ($recipe) {
            $recipe->image_url   = $recipe->image->url();
            $recipe->ingredients = $recipe->ingredients()->get()->toArray();
            $recipe->nutrients   = $recipe->nutrients()->get()->toArray();
            $recipe->steps       = $recipe->steps()->get()->toArray();
            
            $prep_time = intval($recipe->prep_time);
            $recipe->prep = $this->getPrepareString($prep_time);     
        }

        return (['success' => $success, 'meal_info' => $recipe]);
    }

    /**
     * Get meal plan array according the user setting and meal time
     *
     * @param post $request
     *
     * @return bool success
     * @return string summaryId
     * @return array items
     */
    public function getReplaceItem(Request $request)
    {
        // Retrieve post data from request
        $user_data = $request->data;

        $key_value      = $user_data[ 'summaryId' ];
        $mealtime_value = $user_data[ 'time' ];

        // Find the user by using the key value
        $user = User::where('key', $key_value)->first();
        if (!$user) {
            return (['success' => false, 'summaryId' => $key_value]);
        }

        // Prepare recipe array according the user's prepare time setting
        if ($user->preparation == 0) {
            $recipes = Recipe::where('total_time', '<=', 30)->get();
        } else {
            if ($user->preparation == 1) {
                $recipes = Recipe::where('total_time', '<=', 60)->get();
            } else {
                $recipes = Recipe::get();
            }
        }

        // Prepare product array of the user by using the relation
        $meal_products = $user->products()->get()->pluck('name')->toArray();

        $updated_recipes = $recipes->map(function ($recipe) {
            $recipe[ 'image_url' ] = $recipe->image->url();
            
            $prep_time = intval($recipe->prep_time);
            $recipe->prep = $this->getPrepareString($prep_time);    

            return $recipe;
        });

        // Filter the recipe array according the user product setting and meal time
        $plan_time = $updated_recipes->filter(function ($recipe) use ($meal_products, $mealtime_value) {
            if ($recipe->meal_type == $mealtime_value) {
                $recipe_products = $recipe->products()->get()->pluck('name');
                foreach ($recipe_products as $recipe_product) {
                    if (in_array($recipe_product, $meal_products)) {
                        return true;
                    }
                }
            }
        });

        return response()->json([
            'success'   => true,
            'summaryId' => $key_value,
            'items'     => $plan_time
        ]);
    }

    /**
     * Update the individual item of meal plan according the user and the cycle Id and meal time
     *
     * @param post $request
     *
     * @return bool success
     * @return string summaryId
     * @return array item
     */
    public function updateMealItem(Request $request)
    {
        // Retrieve post data from request
        $user_data = $request->data;

        $key_value      = $user_data[ 'summaryId' ];
        $mealdate_value = intval($user_data[ 'date' ]);
        $mealtime_value = intval($user_data[ 'time' ]);
        $mealid_value   = intval($user_data[ 'mealId' ]);

        // Find the user by using the key value
        $user = User::where('key', $key_value)->first();
        if (!$user) {
            return (['success' => false, 'summaryId' => $key_value]);
        }

        // Remove the recipe related with the user according the cycle date and meal time
        $user->recipes()->wherePivot('cycle', $mealdate_value)->wherePivot('mealtime',
            $mealtime_value)->detach();

        // Add the updated recipe for the user
        $user->recipes()->attach($mealid_value, ['cycle' => $mealdate_value, 'mealtime' => $mealtime_value]);

        return ([
            'success'   => true,
            'summaryId' => $key_value,
            'item'      => $mealid_value
        ]);
    }

    /**
     * Get grocery list for certain week
     * 
     * @param post $request
     * 
     * @return bool success
     * @return string summaryId
     * @return array grocery
     * 
     */
    public function getGroceryList(Request $request) 
    {
        // Retrieve post data from request
        $user_data = $request->data;

        $key_value      = $user_data['summaryId'];
        $week_value     = intval($user_data['week']);

        // Find the user by using the key value
        $user = User::where('key', $key_value)->first();
        if (!$user) {
            return (['success' => false, 'summaryId' => $key_value]);
        }

        $unit_system = boolval($user->unit);

        $cycle_min_value = $week_value * 7;
        $cycle_max_value = $week_value * 7 + 6;

        // Get list of avaiable recipes in certain week
        $week_recipes = $user->recipes()->wherePivot('cycle', '>=', $cycle_min_value)
                ->wherePivot('cycle', '<=', $cycle_max_value)->get();

        $grocery_list = [];

        foreach ($week_recipes as $recipe) {
            $ingredients = $recipe->ingredients()->get();
            foreach($ingredients as $ingredient) {
                $ingredient_name = (string)$ingredient->name;

                $temp_arr = array_map(function($grocery) {
                    return (string)$grocery['name'];
                }, $grocery_list);

                if(in_array($ingredient_name, $temp_arr)) {
                    if($unit_system) {
                        if(in_array($ingredient->pivot->type_metric, $grocery_list[$ingredient_name])) {
                            $grocery_list[$ingredient_name][$ingredient->pivot->type_metric] += $ingredient->pivot->count_metric;
                        } else {
                            $grocery_list[$ingredient_name][$ingredient->pivot->type_metric] = $ingredient->pivot->count_metric;
                        }
                    } else {
                        if(in_array($ingredient->pivot->type_imperial, $grocery_list[$ingredient_name])) {
                            $grocery_list[$ingredient_name][$ingredient->pivot->type_imperial] += $ingredient->pivot->count_imperial;
                        } else {
                            $grocery_list[$ingredient_name][$ingredient->pivot->type_imperial] = $ingredient->pivot->count_imperial;
                        }
                    }
                } else {
                    $grocery_list[$ingredient_name] = [];
                    $grocery_list[$ingredient_name]['name'] = $ingredient_name;
                    if($unit_system) {
                        $grocery_list[$ingredient_name][$ingredient->pivot->type_metric] = $ingredient->pivot->count_metric;
                    } else {
                        $grocery_list[$ingredient_name][$ingredient->pivot->type_imperial] = $ingredient->pivot->count_imperial;
                    }
                }
            }
        }

        return ([
            'success'   => true,
            'summaryId' => $key_value,
            'grocery'   => $grocery_list
        ]);
    }
}
