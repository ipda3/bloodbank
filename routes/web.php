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

/*
 *
 * todo install entrust package
 * todo create roles module
 * todo create users module
 * todo create permissions module
 * todo apply permissions to project actions
 * user m-to-m  roles
 * roles  m-to-m  permissions
 * // spatie users m-to-m  permissions
 *
 */

Route::get('/', function () {
    return view('front.home');

});
Route::get('clear', function () {
    \Illuminate\Support\Facades\Artisan::call('config:cache');
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
});
Route::get('client-login', 'FrontController@login');
Route::post('client-login', 'FrontController@loginPost');
Route::get('client/logout', 'FrontController@logout');
Route::get('sign-up', 'FrontController@register');
Route::post('sign-up', 'FrontController@registerPost');

Auth::routes();
//Admin panel
Route::group(['middleware' => ['auth', 'auto-check-permission'], 'prefix' => 'admin'], function () {

    Route::get('home', 'HomeController@index')->name('home');
    Route::resource('governorates', 'GovernorateController');
    Route::resource('cities', 'CityController');
    Route::resource('categories', 'CategoryController');
    Route::resource('posts', 'PostController');
    Route::resource('donations', 'DonationController');
    Route::resource('contacts', 'ContactController');
    Route::resource('reports', 'ReportController');
    Route::get('clients-activate/{id}', 'ClientController@activate')->name('clients.activate');
    Route::get('clients-deactivate/{id}', 'ClientController@deactivate')->name('clients.deactivate');
    Route::get('clients-toggle-activation/{id}', 'ClientController@toggleActivation')->name('clients.toggle-activation');
    Route::resource('clients', 'ClientController');
    Route::resource('settings', 'SettingController');
    Route::resource('user', 'UserController');
    Route::resource('role', 'RoleController');
    // User reset password
    Route::get('user/change-password', 'UserController@changePassword');
    Route::post('user/change-password', 'UserController@changePasswordSave');

});
