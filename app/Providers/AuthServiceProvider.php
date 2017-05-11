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
            return Auth::user()->can('create_account');
        });

        Gate::define('edit-account-details', function () {
            return Auth::user()->can('edit_account');
        });

        Gate::define('submit-referral', function () {
            return Auth::user()->can('submit_referral');
        });

        Gate::define('track-referral', function () {
            return Auth::user()->can('track_referral');
        });

        // Admin, Super Admin, Global Admin
        Gate::define('submit-member-referral', function () {
            return Auth::user()->can('submit_member_referral');
        });

        // Admin, Super Admin
        Gate::define('edit-member-information', function () {
            return Auth::user()->can('edit_member_information');
        });
        
        Gate::define('export-member-information', function () {
            return Auth::user()->can('export_member_information');
        });
        
        Gate::define('change-referral-statuses', function () {
            return Auth::user()->can('change_referral_statuses');
        });
        
        // Super Admin, Global Admin
        Gate::define('add-delete-admin', function () {
            return Auth::user()->can('add_delete_admin');
        });
        
        Gate::define('define-user-roles', function () {
            return Auth::user()->can('define_user_roles');
        });
        
        Gate::define('add-change-billing-information', function () {
            return Auth::user()->can('add_change_billing_information');
        });
        
        // Global Admin
        Gate::define('login-super-admin-all-accounts', function () {
            return Auth::user()->can('login_super_admin_all_accounts');
        });

    }
}
