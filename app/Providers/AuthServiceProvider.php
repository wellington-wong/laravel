<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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
        Gate::define('create-account', function (\User $user) {
            return $user->hasPermission('can_create_account');
        });

        Gate::define('edit-account-details', function (\User $user) {
            return $user->hasPermission('can_edit_create_account');
        });

        Gate::define('submit-referral', function (\User $user) {
            return $user->hasPermission('can_submit_referral');
        });

        Gate::define('track-referral', function (\User $user) {
            return $user->hasPermission('can_track_referral');
        });

        // Admin, Super Admin, Global Admin
        Gate::define('submit-member-referral', function (\User $user) {
            return $user->hasPermission('can_submit_member_-referral');
        });

        Gate::define('edit-member-information', function (\User $user) {
            return $user->hasPermission('can_edit_member_information');
        });
        
        Gate::define('export-member-information', function (\User $user) {
            return $user->hasPermission('can_export_member_information');
        });
        
        Gate::define('change-referral-statuses', function (\User $user) {
            return $user->hasPermission('can_change_referral_statuses');
        });
        
        // Super Admin, Global Admin
        Gate::define('add-delete-admin', function (\User $user) {
            return $user->hasPermission('can_add_delete_admin');
        });
        
        Gate::define('define-user-roles', function (\User $user) {
            return $user->hasPermission('can_define_user_roles');
        });
        
        Gate::define('add-change-billing-information', function (\User $user) {
            return $user->hasPermission('can_add_change_billing_information');
        });
        
        // Global Admin
        Gate::define('login-super-admin-all-accounts', function (\User $user) {
            return $user->hasPermission('can_login_super_admin_all_accounts');
        });

    }
}
