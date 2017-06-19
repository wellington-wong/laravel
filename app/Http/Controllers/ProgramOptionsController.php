<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LogEmail;

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
     * Display a listing of referral program settings.
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
     * Display a listing of reward settings
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
     * Display a listing of notification emails
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function notificationEmails( Request $request )
    {
        $notificationSettings = [];
        return view('program-options.notification-emails')
        ->with(compact('notificationSettings'));
    }

    /**
     * Display a listing of email logs
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function emailLogs( Request $request )
    {
        $emailLogs = $request->_company->emailLogs()->paginate(15);
        return view('program-options.email-logs')
        ->with(compact('emailLogs'));
    }
}
