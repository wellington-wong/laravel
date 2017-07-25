<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class importAYC extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'importAYC';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'import referrals and users from AYC rewards club';

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
        dd('yup');
    }
}
