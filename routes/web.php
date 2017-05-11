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

// Home Routes
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');

// Company Routes
Route::get('/company/create', 'CompanyController@create')->name('company-create');
Route::post('/company/create', 'CompanyController@postCreate')->name('post-company-create');
Route::get('/company/{id}', 'CompanyController@getCompany')->name('get-company');
Route::get('/companies', 'CompanyController@allCompanies')->name('all-companies');

// Referral Routes
Route::get('/referral/create', 'ReferralController@create')->name('referral-create');
Route::post('/referral/create', 'ReferralController@postCreate')->name('post-referral-create');
Route::get('/referral/check-duplicate', 'ReferralController@checkDuplicate')->name('check-duplicate');
Route::get('/referrals', 'ReferralController@referrals')->name('referrals');

// Notification Routes
Route::post('/user/{id}/notification/{nid}', 'NotificationsController@markAsRead')->name('mark-notification');

// Static Page Routes
Route::get('/how-it-works', 'StaticPageController@howItWorks')->name('how-it-works');
Route::get('/features', 'StaticPageController@features')->name('features');
Route::get('/about-us', 'StaticPageController@aboutUs')->name('about-us');
Route::get('/pricing', 'StaticPageController@pricing')->name('pricing');
Route::get('/contact', 'StaticPageController@contact')->name('contact');

// Admin Routes
Route::get('/settings', 'AdminController@settings')->name('referral-create');
Route::post('/admins', 'AdminController@getIndex')->name('post-referral-create');
Route::get('/admins/view', 'AdminController@getView')->name('check-duplicate');

// Global Settings Routes
Route::get('/global-settings/submit-referral-member', 'GlobalSettingsController@submitReferralMember')->name('submit-referral-member');
Route::get('/global-settings/edit-member-information', 'GlobalSettingsController@editMemberInformation')->name('edit-member-information');
Route::get('/global-settings/export-member-information', 'GlobalSettingsController@exportMemberInformation')->name('export-member-information');
Route::get('/global-settings/change-referral-status', 'GlobalSettingsController@changeReferralStatus')->name('change-referral-status');
Route::get('/global-settings/add-delete-admin', 'GlobalSettingsController@addDeleteAdmin')->name('add-delete-admin');
Route::get('/global-settings/define-user-roles', 'GlobalSettingsController@defineUserRoles')->name('define-user-roles');
Route::get('/global-settings/add-change-billing-information', 'GlobalSettingsController@addChangeBillingInformation')->name('add-change-billing-information');
Route::get('/global-settings/login-super-admin', 'GlobalSettingsController@loginSuperAdmin')->name('login-super-admin');
Route::get('/global-settings/members/{id}', 'GlobalSettingsController@members')->name('members');