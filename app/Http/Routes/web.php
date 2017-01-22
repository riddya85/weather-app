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

    Route::get('/forecast', ['as'=>'front.prepareForecast','uses'=>'Front\MainController@prepareForecast']);
    
    Route::get('/history', ['as'=>'front.history','uses'=>'Front\MainController@history']);
    Route::get('/history/user', ['as'=>'front.userHistory','uses'=>'Front\MainController@userHistory']);
    
    Route::post('/load-more-user-history', ['as'=>'front.loadHistory','uses'=>'Front\MainController@loadHistory']);
});

Route::group([
    'middleware' => 'auth',
], function () {
    Route::get('/history/user/{user}', ['as'=>'admin.userHistory','uses'=>'Front\MainController@adminUserHistory']);
});

Auth::routes();