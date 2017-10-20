<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Stripe;

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
        //
        $this->info('companyStripeSubscription');
    }
}
