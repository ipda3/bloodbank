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



Route::get('/', function () {
    /*$today = now();
    dd($today);*/
    return view('welcome');

});

Auth::routes();
//Admin panel
Route::group(['middleware'=>'auth' , 'prefix'=>'admin'],function() {

    Route::get('home', 'HomeController@index');
    Route::resource('governorates','GovernorateController');
    Route::resource('cities','CityController');
    Route::resource('categories','CategoryController');
    Route::resource('posts','PostController');
    Route::resource('donations','DonationController');
    Route::resource('contacts','ContactController');
    Route::resource('reports','ReportController');
    Route::resource('clients','ClientController');
    Route::resource('settings','SettingController');
    // User reset password
    Route::get('user/change-password','UserController@changePassword');
    Route::post('user/change-password','UserController@changePasswordSave');

});
