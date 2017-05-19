<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProgramOptionsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of all users.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function users( Request $request )
    {
    	$users = [];
    	return view('program-options.users')
    	->with(compact('users'));
    }

    /**
     * Display a listing of all users.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function referralProgramSettings( Request $request )
    {
        $referralProgramSettings = [];
        return view('program-options.referral-program-settings')
        ->with(compact('referralProgramSettings'));
    }

    /**
     * Display a listing of all users.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function rewardSettings( Request $request )
    {
        $rewardSettings = [];
        return view('program-options.reward-settings')
        ->with(compact('rewardSettings'));
    }

    /**
     * Display a listing of all users.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function notificationSettings( Request $request )
    {
        $notificationSettings = [];
        return view('program-options.notification-settings')
        ->with(compact('notificationSettings'));
    }
}
