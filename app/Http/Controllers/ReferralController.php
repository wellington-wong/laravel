<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReferralController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create( Request $request )
    {
        //dd($request->subdomain);
        return view('referral.create')
            ->with('domain', $request->subdomain);
    }

    public function postCreate( Request $request )
    {
        //dd($request->subdomain);
        return view('referral.create')
            ->with('domain', $request->subdomain);
    }

}
