<?php
Route::post('/login', 'Auth\LoginController@login');

Route::get('/u/{hash}', 'RefferalController@index');
Route::post('/u/check/{key}', 'RefferalController@store');

Route::group([
    'prefix'     => 'admin',
    'as'         => 'admin.',
    'middleware' => [
        'laradium'
    ]
], function () {
    Route::get('products/search', '\App\Laradium\Resources\RecipeResource@search')->name('products.search');
    Route::get('ingredients/search', '\App\Laradium\Resources\RecipeResource@searchI')->name('ingredients.search');
});
Route::view('/{any}', 'application')->where('any', '.*');
// Route::get('/{vue_capture?}', function () { return view('application'); })->where('vue_capture', '[\/\w\.-]*');
