<?php

Route::post('/set-password', 'UserController@setPassword');

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/me', 'UserController@me');

    Route::get('/affiliates', 'Affiliates\AffiliateController@index');
    Route::post('/affiliates', 'Affiliates\AffiliateController@store');
});

Route::get('/workouts', 'Api\WorkoutController@index');
Route::post('/workouts/{workout}', 'Api\WorkoutController@store');

Route::get('/workouts/goals', 'Api\GoalController@index');
Route::put('/workouts/goals', 'Api\GoalController@update');

Route::get('/workouts/settings', 'Api\WorkoutSettingController@index');
Route::put('/workouts/settings', 'Api\WorkoutSettingController@update');

Route::get('/workouts/{workout}', 'Api\WorkoutController@show');
Route::get('/workouts/preview/{exercise}', 'Api\WorkoutController@preview');
Route::get('/exercises/{workoutExercise}', 'Api\ExerciseController@show');



Route::post('/summary/new', 'UserController@addCalculation');
Route::post('/summary/email', 'UserController@addEmail');
Route::post('/summary/get', 'UserController@getUserInfo');
Route::post('/summary/search', 'UserController@searchPlan');
Route::post('/summary/firstname', 'UserController@setFirstName');
Route::post('/summary/sendmail', 'UserController@sendMail');
Route::post('/summary/learnketo', 'UserController@learnKeto');
Route::post('/summary/viewcontent', 'UserController@viewContent');

Route::post('/payment/paypal', 'PaymentController@addPaypal');
Route::post('/payment/stripe', 'PaymentController@addStripe');

Route::post('/meal/get-products', 'MealController@getProducts');
Route::post('/meal/update-products', 'MealController@updateProducts');
Route::post('/meal/update-profile', 'MealController@updateProfile');
Route::post('/meal/restart-cycle', 'MealController@restartCycle');
Route::post('/meal/save-weight', 'MealController@saveWeight');
Route::post('/meal/get-progresses', 'MealController@getProgresses');
Route::post('/meal/remove-progress', 'MealController@removeProgress');
Route::post('/meal/get-meal-option', 'MealController@getMealOption');
Route::post('/meal/update-meal-plan', 'MealController@updateMealPlan');
Route::post('/meal/get-meal-plan', 'MealController@getMealPlan');
Route::post('/meal/get-meal-info', 'MealController@getMealInfo');
Route::post('/meal/get-replace-item', 'MealController@getReplaceItem');
Route::post('/meal/update-meal-item', 'MealController@updateMealItem');
Route::post('/meal/get-grocery-list', 'MealController@getGroceryList');
Route::post('/meal/update-currDay-meal', 'MealController@updateCurrDayMeal');







