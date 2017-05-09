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
        
        $user = auth()->user();

        // Member
        Gate::define('can-create-account', function ($user) {
            return $user->can('can_create_account');
        });

        Gate::define('can-edit-account-details', function (\User $user) {
            return $user->can('can_edit_account');
        });

        Gate::define('can-submit-referral', function (\User $user) {
            return $user->can('can_submit_referral');
        });

        Gate::define('can-track-referral', function (\User $user) {
            return $user->can('can_track_referral');
        });

        // Admin, Super Admin, Global Admin
        Gate::define('can-submit-member-referral', function (\User $user) {
            return $user->can('can_submit_member_referral');
        });

        Gate::define('can-edit-member-information', function (\User $user) {
            return $user->can('can_edit_member_information');
        });
        
        Gate::define('can-export-member-information', function (\User $user) {
            return $user->can('can_export_member_information');
        });
        
        Gate::define('can-change-referral-statuses', function (\User $user) {
            return $user->can('can_change_referral_statuses');
        });
        
        // Super Admin, Global Admin
        Gate::define('can-add-delete-admin', function (\User $user) {
            return $user->can('can_add_delete_admin');
        });
        
        Gate::define('can-define-user-roles', function (\User $user) {
            return $user->can('can_define_user_roles');
        });
        
        Gate::define('can-add-change-billing-information', function (\User $user) {
            return $user->can('can_add_change_billing_information');
        });
        
        // Global Admin
        Gate::define('can-login-super-admin-all-accounts', function (\User $user) {
            return $user->can('can_login_super_admin_all_accounts');
        });

    }
}
