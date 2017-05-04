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
            return true;
        });

        Gate::define('edit-account-details', function (\User $user) {
            return true;
        });

        Gate::define('submit-referral', function (\User $user) {
            return true;
        });

        Gate::define('track-referral', function (\User $user) {
            return true;
        });

        // Admin
        Gate::define('submit-member-referral', function (\User $user) {
            return true;
        });

        Gate::define('edit-member-information', function (\User $user) {
            return true;
        });
        
        Gate::define('export-member-information', function (\User $user) {
            return true;
        });
        
        Gate::define('change-referral-statuses', function (\User $user) {
            return true;
        });

        // Super Admin
        Gate::define('submit-member-referral', function (\User $user) {
            return true;
        });

        Gate::define('edit-member-information', function (\User $user) {
            return true;
        });
        
        Gate::define('export-member-information', function (\User $user) {
            return true;
        });
        
        Gate::define('change-referral-statuses', function (\User $user) {
            return true;
        });
        
        Gate::define('add-delete-admin', function (\User $user) {
            return true;
        });
        
        Gate::define('define-user-roles', function (\User $user) {
            return true;
        });
        
        Gate::define('add-change-billing-information', function (\User $user) {
            return true;
        });


    }
}
