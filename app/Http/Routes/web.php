<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group([
    'middleware' => 'web',
], function () {
    Route::get('/',['as'=>'front.home','uses'=>'Front\MainController@index']);
    Route::post('/forecast/{lng}/{lat}', ['as'=>'front.prepareForecast','uses'=>'Front\MainController@prepareForecast']);
    Route::get('/forecast/{lng}/{lat}', ['as'=>'front.prepareForecast','uses'=>'Front\MainController@prepareForecast']);
//    Route::get('/history', ['as'=>'front.history','uses'=>'Front\MainController@history']);
//    Route::get('/history/{user}', ['as'=>'front.userHistory','uses'=>'Front\MainController@userHistory']);
});

Route::group([
    'middleware' => 'auth',
], function () {

});

Auth::routes();