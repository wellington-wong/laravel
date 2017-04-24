<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReferralController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request)
    {
        return view('referral.create');
    }

}
