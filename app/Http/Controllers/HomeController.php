<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\RoleUser;
use App\Company;
use App\Referral;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function home(Request $request)
    {
        if ( !is_null($request->subdomain_id) ) {
            return redirect()->route('referral-create');
        } else {
            return redirect()->route('home');
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Assign user as member when no role is found
        if (auth()->check() && !count(auth()->user()->roles)) {
            if ($member = Role::where('name', 'member')->first()) {
                auth()->user()->attachRole($member);
                if (isset(auth()->user()->companies()->first()->subdomain)){
                    $roleUser = RoleUser::where('user_id', auth()->user()->id)->first();
                    $roleUser->subdomain = auth()->user()->companies()->first()->subdomain;
                    $roleUser->timestamps = false;
                    $roleUser->save();
                }
            }
        }

        $company = Company::find(auth()->user()->id);

        // Get referral pending approval and reward
        $pendingReferrals = new Referral();
        $pendingReferrals = $pendingReferrals->getReferralTally();

        return view('home')
        ->with(compact('company'))
        ->with(compact('pendingReferrals'));
    }
}
