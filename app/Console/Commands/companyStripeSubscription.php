<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Stripe;
use App\Company;

class companyStripeSubscription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'companyStripeSubscription';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and update db with the current company stripe subscription';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        // Get all stripe customers, and update companies current status
        $stripe = new Stripe();
        $customers = $stripe->getAllCustomers( );
        foreach ($customers as $customer) {
            if (isset($customer->id) && $company = Company::where('stripe_id', $customer->id)->first()) {
                $company->current = isset($customer->subscriptions->data[0]->status);
                $company->save();
                $this->info($company->company_name . '\'s current status have been changed to ' . (isset($customer->subscriptions->data[0]->status) ? 'true' : 'false'));
            }
        }

        $this->info('--------------------------------------------------');
        $this->info('All company stripe subscriptions have been updated.');
    }
}
