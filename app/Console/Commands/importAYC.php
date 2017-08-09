<?php

namespace App\Console\Commands;

use App\Company;
use App\Lob;
use App\Referral;
use App\Role;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

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

    /*
    const STATUS_SUBMITTED      = 1;
    const STATUS_APPROVED       = 2;
    const STATUS_REWARD_SENT    = 3;
    const STATUS_DENIED         = 4;
     */
    public static $stati = [
        'Reward Sent' => Referral::STATUS_REWARD_SENT ,
        'Claimed' => Referral::STATUS_SUBMITTED ,
        'Denied' => Referral::STATUS_DENIED ,
        'New' => Referral::STATUS_SUBMITTED ,
        'Verified' => Referral::STATUS_APPROVED ,
    ];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $ayc_users = DB::table('rewards_users')->get();

        $c = Company::where('subdomain', 'ayc')->first();

        $request = request();
        $request->merge([''=>'']);

        $userIdByRewardsId = [];

        foreach ($ayc_users as $au) {

            if ( !User::where('email', $au->email)->exists() && $au->deleted != 1 ) {

                $u = new User();
                $u->email = $au->email;
                $u->first_name = $au->firstname;
                $u->last_name = $au->lastname;
                $u->name = $au->first_name . " " . $au->last_name;
                $u->created_at = $au->created_at;
                $u->updated_at = $au->updated_at;
                $u->save();

                //ADD PHONE
                $request->merge(['phone'=>$au->phone_number]);
                $u->addDefaultPhone();

                //ADD ADDRESS
                //CLEANING UP DATA
                $state = $au->state;
                if ( array_key_exists($state, Lob::$states ) ) {
                    $state = Lob::$states[$state];
                }
                if( strlen($state) > 2 ) {
                    $state = 'NA';
                }
                $zip = $au->zip;
                if ( strlen($zip) > 11 ) {
                    $zip = substr($zip, 0, 10);
                }
                $request->merge(['address'=>$au->address]);
                $request->merge(['city'=>$au->city]);
                $request->merge(['state'=>$state]);
                $request->merge(['zip'=>$zip]);
                $u->addDefaultAddress();

                //ADD ROLE
                if ( 2 == $au->usertype ) {
                    $role = 'superAdmin';
                } elseif ( 1 == $au->usertype ) {
                    $role = 'admin';
                } else {
                    $role = 'member';
                }
                $role = Role::where('name', $role)->first();
                $u->attachRole($role, $c);

                //dd($u);

            } else {
                $u = User::where('email', $au->email)->first();
            }

            if ( isset($u) )
            $userIdByRewardsId[$au->id] = $u->id;

        }

        $ayc_referrals = DB::table('rewards_referrals')->get();

        foreach ( $ayc_referrals as $au ) {

            $email = $au->email;
            if ('' == $email) {
                $email = $au->first_name . "." . $au->last_name . '@' . config('app.domain');
                $email = strtolower($email);
            }

            if ( !User::where('email', $email)->exists() && $au->deleted != 1 && '' != $au->first_name ) {

                $u = new User();
                $u->email = $email;
                $u->first_name = $au->first_name;
                $u->last_name = $au->last_name;
                $u->name = $au->first_name . " " . $au->last_name;
                $u->created_at = $au->created_at;
                $u->updated_at = $au->updated_at;
                $u->save();

                //ADD PHONE
                $request->merge(['phone'=>$au->phone_number]);
                $u->addDefaultPhone();

                //ADD ADDRESS
                //CLEANING UP DATA
                $state = $au->state;
                if ( array_key_exists($state, Lob::$states ) ) {
                    $state = Lob::$states[$state];
                }
                if( strlen($state) > 2 ) {
                    $state = 'NA';
                }
                $zip = $au->zip;
                if ( strlen($zip) > 11 ) {
                    $zip = substr($zip, 0, 10);
                }
                $request->merge(['address'=>$au->address]);
                $request->merge(['city'=>$au->city]);
                $request->merge(['state'=>$state]);
                $request->merge(['zip'=>$zip]);
                $u->addDefaultAddress();

                //ADD ROLE
                $role = 'member';
                $role = Role::where('name', $role)->first();
                $u->attachRole($role, $c);

            } else {
                $u = User::where('email', $email)->first();
            }

            if ( $au->deleted != 1  && '' != $au->first_name ) {
                $ref = new Referral();
                $ref->referrer_id   = $userIdByRewardsId[$au->user_id];
                $ref->company_id    = $c->id;
                $ref->user_id       = $u->id;
                $ref->status        = static::$stati[$au->status];
                $ref->created_at    = $au->created_at;
                $ref->updated_at    = $au->updated_at;
                $ref->save();
            }


            //dd($au);
        }
        //dd($ayc_referrals);
    }
}
