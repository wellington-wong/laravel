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
Route::get('/referral/history', 'ReferralController@history')->name('referral-history');
Route::get('/referral/rewards', 'ReferralController@rewards')->name('referral-rewards');
Route::get('/referral/history', 'ReferralController@history')->name('referral-history');

// Static Page Routes
Route::get('/how-it-works', 'BasicPageController@howItWorks')->name('how-it-works');
Route::get('/features', 'BasicPageController@features')->name('features');
Route::get('/about-us', 'BasicPageController@aboutUs')->name('about-us');
Route::get('/pricing', 'BasicPageController@pricing')->name('pricing');
Route::get('/contact', 'BasicPageController@contact')->name('contact');
Route::get('/how-this-works', 'BasicPageController@howThisWorks')->name('how-this-works');
Route::get('/how-to-get-more-referrals', 'BasicPageController@howToGetMoreReferrals')->name('how-to-get-more-referrals');

// Manage Account
Route::get('/manage-account', 'ManageAccountController@getIndex')->name('manage-account');
Route::get('/help', 'ManageAccountController@help')->name('help');

// Global Settings Routes
// Filter routes by role and permission
Route::group(['prefix' => '/', 'middleware' => ['role:admin|superAdmin|globalAdmin']], function() {
	Route::get('/global-settings/submit-referral-member', ['uses' => 'GlobalSettingsController@submitReferralMember', 'middleware' => ['permission:submit_member_referral']])->name('submit-referral-member');
	Route::post('/global-settings/submit-referral-member', ['uses' => 'GlobalSettingsController@submitReferralMember', 'middleware' => ['permission:submit_member_referral']])->name('submit-referral-member');
	Route::get('/global-settings/edit-member-information', ['uses' => 'GlobalSettingsController@editMemberInformation', 'middleware' => ['permission:edit_member_information']])->name('edit-member-information');
	Route::get('/global-settings/export-member-information', ['uses' => 'GlobalSettingsController@exportMemberInformation', 'middleware' => ['permission:export_member_information']])->name('export-member-information');
	Route::get('/global-settings/add-delete-admin', ['uses' => 'GlobalSettingsController@addDeleteAdmin', 'middleware' => ['permission:add_delete_admin']])->name('add-delete-admin');
	Route::get('/global-settings/define-user-roles', ['uses' => 'GlobalSettingsController@defineUserRoles', 'middleware' => ['define_user_roles']])->name('define-user-roles');	
	Route::get('/global-settings/login-super-admin', ['uses' => 'GlobalSettingsController@loginSuperAdmin', 'middleware' => ['permission:login_super_admin_all_accounts']])->name('login-super-admin');

	// Export
	Route::get('/export/{id}', 'ExportController@referral')->name('export');
	Route::get('/export/all', 'ExportController@referrals')->name('export-all');

	// Program Options
	Route::get('/program-options/users', 'ProgramOptionsController@users')->name('program-options-users');
	Route::get('/program-options/referral-program-settings', 'ProgramOptionsController@referralProgramSettings')->name('program-options-referral-program');
	Route::get('/program-options/reward-settings', 'ProgramOptionsController@rewardSettings')->name('program-options-reward-settings');
	Route::get('/program-options/notification-emails', 'ProgramOptionsController@notificationEmails')->name('program-options-notification-emails');

	// Member Routes
	Route::get('/members', 'MembersController@getIndex')->name('members');
	Route::get('/members/{id}', 'MembersController@members')->name('member');

	// Notification Routes
	Route::post('/user/{id}/notification/{nid}', 'NotificationsController@markAsRead')->name('mark-notification');
});
