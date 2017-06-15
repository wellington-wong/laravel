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
        
        // Optimize variables
        $user = auth()->user();
        $company = $request->_company;
        $hosts = explode('.', $request->getHost());
        $shareUrl = (isset($company->subdomain) ? $company->subdomain : '') . '.' . $hosts[1] . '.' . $hosts[2];

        // Get referral pending approval and reward
        $pendingReferrals = new Referral();
        $pendingReferrals = $pendingReferrals->getReferralTally();

        return view('home')
        ->with(compact('company', 'pendingReferrals', 'user', 'shareUrl'));
    }
}
