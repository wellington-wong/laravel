<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{

    public function login(Request $request) {

        return view('company.login');
    }

    public function register(Request $request) {

        return view('company.register');
    }
}
