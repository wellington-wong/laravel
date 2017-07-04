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


// OAuth Routes
Route::get('auth/{provider}', 'Auth\RegisterController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\RegisterController@handleProviderCallback');

Route::get('register_simple', 'Auth\RegisterController@showRegistrationSimple')->name('register_simple');

//$this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
//$this->post('register', 'Auth\RegisterController@register');
Auth::routes();

// Home Routes
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@home')->name('find-home');

// Company Routes
Route::get('/company/create', 'CompanyController@create')->name('company-create');
Route::post('/company/create', 'CompanyController@postCreate')->name('post-company-create');
Route::get('/company/{id}', 'CompanyController@getCompany')->name('get-company');
Route::get('/companies', 'CompanyController@allCompanies')->name('all-companies');
Route::post('/company/update', 'CompanyController@postUpdate')->name('post-company-update');
Route::post('/company/update-logo/{cid}', 'CompanyController@postUpdateLogo')->name('post-company-update-logo');

// Referral Routes
Route::get('/form/{id}', 'ReferralController@formJson')->name('form-json');

Route::get('/referral/create/{id}', 'ReferralController@create')->name('referral-create-id');
Route::post('/referral/create/{id}', 'ReferralController@postCreate')->name('post-referral-create-id');
Route::get('/referral/create', 'ReferralController@findForm')->name('referral-create');
Route::post('/referral/create', 'ReferralController@postCreate')->name('post-referral-create');
Route::get('/referral/check-duplicate', 'ReferralController@checkDuplicate')->name('check-duplicate');
Route::get('/referrals', 'ReferralController@referrals')->name('referrals');
Route::get('/referral/rewards', 'ReferralController@rewards')->name('referral-rewards');
Route::get('/referral/history', 'ReferralController@history')->name('referral-history');
Route::get('/referral/history/{id}', 'ReferralController@historyDetails')->name('referral-history-details');
Route::get('/referral/export', 'ReferralController@referralsExport')->name('referrals-export');
Route::post('/referral/update', 'ReferralController@update')->name('referrals-update');
Route::get('/referral/view/{id}', 'ReferralController@getView')->name('referral-view');

// Static Page Routes
Route::get('/how-it-works', 'BasicPageController@howItWorks')->name('how-it-works');
Route::get('/features', 'BasicPageController@features')->name('features');
Route::get('/about-us', 'BasicPageController@aboutUs')->name('about-us');
Route::get('/pricing', 'BasicPageController@pricing')->name('pricing');
Route::get('/contact', 'BasicPageController@contact')->name('contact');
Route::post('/contact', 'BasicPageController@postContact')->name('contact');
Route::get('/how-this-works', 'BasicPageController@howThisWorks')->name('how-this-works');
Route::get('/how-to-get-more-referrals', 'BasicPageController@howToGetMoreReferrals')->name('how-to-get-more-referrals');

// Manage Account
Route::get('/manage-account', 'ManageAccountController@getIndex')->name('manage-account');
Route::post('/manage-account', 'ManageAccountController@postUpdate')->name('post-account-update');
Route::get('/help', 'ManageAccountController@help')->name('help');

// User
Route::get('/user/view/{id}', 'UserController@getView')->name('view-user');
Route::get('/user/create', 'UserController@create')->name('create-user');

// Login as original user
Route::get('/global-settings/login-as-origin', ['uses' => 'GlobalSettingsController@loginAsOrigin'])->name('login-as-origin');

// Global Settings Routes
// Filter routes by role and permission
Route::group(['prefix' => '/', 'middleware' => ['role:admin|superAdmin|globalAdmin']], function() {
	Route::get('/global-settings/submit-referral-member', ['uses' => 'GlobalSettingsController@submitReferralMember', 'middleware' => ['permission:submit_member_referral']])->name('submit-referral-member');
	Route::post('/global-settings/submit-referral-member', ['uses' => 'GlobalSettingsController@submitReferralMember', 'middleware' => ['permission:submit_member_referral']])->name('submit-referral-member');
	Route::get('/global-settings/edit-member-information', ['uses' => 'GlobalSettingsController@editMemberInformation', 'middleware' => ['permission:edit_member_information']])->name('edit-member-information');
	Route::get('/global-settings/export-member-information', ['uses' => 'GlobalSettingsController@exportMemberInformation', 'middleware' => ['permission:export_member_information']])->name('export-member-information');
	Route::get('/global-settings/add-delete-admin', ['uses' => 'GlobalSettingsController@addDeleteAdmin', 'middleware' => ['permission:add_delete_admin']])->name('add-delete-admin');
	Route::get('/global-settings/define-user-roles', ['uses' => 'GlobalSettingsController@defineUserRoles', 'middleware' => ['permission:define_user_roles']])->name('define-user-roles');	
	Route::get('/global-settings/login-super-admin', ['uses' => 'GlobalSettingsController@loginSuperAdmin', 'middleware' => ['permission:login_super_admin_all_accounts']])->name('login-super-admin');
	Route::get('/global-settings/login-as-user', ['uses' => 'GlobalSettingsController@loginAsUser', 'middleware' => ['permission:login_as_user']])->name('login-as-user');
	Route::get('/global-settings/login-as-user/{id}', ['uses' => 'GlobalSettingsController@loginAsUserId', 'middleware' => ['permission:login_as_user']])->name('login-as-user-id');
	Route::get('/global-settings/login-as-user/{id}', ['uses' => 'GlobalSettingsController@loginAsUserId', 'middleware' => ['permission:login_as_user']])->name('login-as-user-id');

	// Export
	Route::get('/export/{id}', 'ExportController@referral')->name('export');
	Route::get('/export/all', 'ExportController@referrals')->name('export-all');

	// Program Options
	Route::get('/program-options', 'ProgramOptionsController@index')->name('program-options');
	Route::get('/program-options/email-logs', 'ProgramOptionsController@emailLogs')->name('program-options-email-logs');
	Route::get('/program-options/users', 'ProgramOptionsController@users')->name('program-options-users');
	Route::get('/program-options/referral-program-settings', 'ProgramOptionsController@referralProgramSettings')->name('program-options-referral-program-settings');
	Route::post('/program-options/referral-program-settings', 'ProgramOptionsController@referralProgramSettingsPost')->name('program-options-referral-program-settings-save');
	Route::get('/program-options/reward-settings', 'ProgramOptionsController@rewardSettings')->name('program-options-reward-settings');
	Route::get('/program-options/notification-emails', 'ProgramOptionsController@notificationEmails')->name('program-options-notification-emails');

	// Member Routes
	Route::get('/members', 'MembersController@getIndex')->name('members');
	//Route::get('/members/{id}', 'MembersController@members')->name('member');
	Route::get('/member/create', 'MembersController@create')->name('members-create');

	// Notification Routes
	Route::get('/notification/{nid}', 'NotificationsController@getNotification')->name('notification');
	Route::post('/user/{id}/notification/{nid}', 'NotificationsController@markAsRead')->name('mark-notification');
});

// Laravel scout with algolia driver
Route::get('/api/search', [
	'as' => 'api/search',
	'uses' => 'Api\SearchController@search'
]);

// Laravel messenger
// https://github.com/cmgmyr/laravel-messenger
Route::group(['prefix' => 'messages'], function () {
    Route::get('/', ['as' => 'messages', 'uses' => 'MessagesController@index']);
    Route::get('create', ['as' => 'messages.create', 'uses' => 'MessagesController@create']);
    Route::post('/', ['as' => 'messages.store', 'uses' => 'MessagesController@store']);
    Route::get('{id}', ['as' => 'messages.show', 'uses' => 'MessagesController@show']);
    Route::put('{id}', ['as' => 'messages.update', 'uses' => 'MessagesController@update']);
});