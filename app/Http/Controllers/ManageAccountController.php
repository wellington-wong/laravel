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
     * @return view
     */
    public function getIndex( Request $request )
    {
        return view('manage-account.index');
    }

    /**
     * Update account.
     *
     * @return view
     */
    public function postUpdate( Request $request )
    {
        dd($request->input());
        return view('manage-account.index');
    }

    /**
     * Show help
     *
     * @return \Illuminate\Http\Response
     */
    public function help( Request $request )
    {
        return view('manage-account.help');
    }
}
