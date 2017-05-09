<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Member
        Gate::define('create-account', function () {
            return Auth::user()->can('can_create_account');
        });

        Gate::define('edit-account-details', function () {
            return Auth::user()->can('can_edit_account');
        });

        Gate::define('submit-referral', function () {
            return Auth::user()->can('can_submit_referral');
        });

        Gate::define('track-referral', function () {
            return Auth::user()->can('can_track_referral');
        });

        // Admin, Super Admin, Global Admin
        Gate::define('submit-member-referral', function () {
            return Auth::user()->can('can_submit_member_referral');
        });

        Gate::define('edit-member-information', function () {
            return Auth::user()->can('can_edit_member_information');
        });
        
        Gate::define('export-member-information', function () {
            return Auth::user()->can('can_export_member_information');
        });
        
        Gate::define('change-referral-statuses', function () {
            return Auth::user()->can('can_change_referral_statuses');
        });
        
        // Super Admin, Global Admin
        Gate::define('add-delete-admin', function () {
            return Auth::user()->can('can_add_delete_admin');
        });
        
        Gate::define('define-user-roles', function () {
            return Auth::user()->can('can_define_user_roles');
        });
        
        Gate::define('add-change-billing-information', function () {
            return Auth::user()->can('can_add_change_billing_information');
        });
        
        // Global Admin
        Gate::define('login-super-admin-all-accounts', function () {
            return Auth::user()->can('can_login_super_admin_all_accounts');
        });

    }
}
