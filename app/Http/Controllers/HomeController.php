<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;

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
        if (auth()->check() && !(auth()->user()->ability('admin,superAdmin,globalAdmin', []))) {
            if ($member = Role::where('name', 'member')->first()) {
                auth()->user()->attachRole($member);
            }
        }

        return view('home');
    }
}
