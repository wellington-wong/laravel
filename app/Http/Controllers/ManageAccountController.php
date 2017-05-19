<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManageAccountController extends Controller
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
     * Show manage account.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {

        return view('manage-account.index');
    }
}
