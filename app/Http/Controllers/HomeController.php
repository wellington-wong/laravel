<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\Company;

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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Assign user as member when no role is found
        if (auth()->check() && !count(auth()->user()->roles)) {
            if ($member = Role::where('name', 'member')->first()) {
                auth()->user()->attachRole($member);
            }
        }

        $company = Company::find(auth()->user()->id);

        return view('home')
        ->with(compact('company'));
    }
}
