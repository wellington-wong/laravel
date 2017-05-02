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
 * WRAP EVERYTHING IN THIS TO GET SUBDOMAIN IF ROUTING ISSUE EVER FIGURED OUT.
 * SEE Domain MIDDLEWARE COMMENTS
Route::group(['domain' => '{subdomain}.' . Config::get('app.url') ], function () {
});
*/

Auth::routes();

// OAuth Routes
Route::get('auth/{provider}', 'Auth\RegisterController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\RegisterController@handleProviderCallback');
Auth::routes();


Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');

Route::get('/company/create', 'CompanyController@create')->name('company-create');
Route::post('/company/create', 'CompanyController@postCreate')->name('post-company-create');
Route::get('/company/{id}', 'CompanyController@getCompany')->name('get-company');
Route::get('/companies', 'CompanyController@allCompanies')->name('all-companies');

Route::get('/referral/create', 'ReferralController@create')->name('referral-create');
Route::post('/referral/create', 'ReferralController@postCreate')->name('post-referral-create');
Route::get('/referral/check-duplicate', 'ReferralController@checkDuplicate')->name('check-duplicate');
Route::get('/referrals', 'ReferralController@referrals')->name('referrals');

Route::post('/user/{id}/notification/{nid}', 'NotificationsController@markAsRead')->name('mark-notification');