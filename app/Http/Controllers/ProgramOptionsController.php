<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LogEmail;
use App\EmailTemplate;
use App\ReferralForms;
use Illuminate\Support\Facades\Validator;

class ProgramOptionsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of all program options.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request )
    {
        return view('program-options.index');
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
        $companyReferralForm = ReferralForms::where('company_id', $request->_company->id)->first();
        return view('program-options.referral-program-settings')
        ->with(compact('companyReferralForm'));
    }

    /**
     * Save/Update referral program settings.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function referralProgramSettingsPost( Request $request )
    {
        if (!$companyReferralForm = ReferralForms::where('company_id', $request->get('company_id'))->first()) {
            $companyReferralForm = new ReferralForms();
            $companyReferralForm->create($request->all());
        } else {
            $companyReferralForm->update($request->all());
        }
        return $request;
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
    public function notificationEmails ( Request $request )
    {
        $notificationSettings = [];
        return view('program-options.notification-emails')
        ->with(compact('notificationSettings'));
    }

    /**
     * Display a listing of notification emails
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function notificationEmail ( Request $request )
    {
        $notificationSettings = [];
        return view('program-options.notification-email')
        ->with(compact('notificationSettings'));
    }

    /**
     * Save notification email template
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function postNotificationEmails( Request $request )
    {
        $rules = [
            //'email_html'=>'required'
        ];

        $validator = Validator::make($request->input(), $rules);

        if ( $validator->fails() ) {
            return redirect()->back()->withInput()
                ->with(['errors'=>$validator->errors()]);
        }

        $request->merge(['user_id' => auth()->user()->id]);
        $request->merge(['company_id' => $request->_company->id]);
        
        if ($emailTemplate = EmailTemplate::where('company_id', $request->_company->id)->first()) {
            $emailTemplate->update([
                'email_html' => $request->input('email_html') ? : ''
            ]);
            return back()->with('success', ['Email template successfully saved.']);
        } else {
            EmailTemplate::create($request->all());
            return back()->with('success', ['Email template successfully created.']);
        }

    }

    /**
     * Display a listing of email logs
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function emailLogs( Request $request )
    {
        $emailLogs = $request->_company->emailLogs()->orderBy('created_at', 'desc')->paginate(15);
        return view('program-options.email-logs')
        ->with(compact('emailLogs'));
    }


    public function getLobConfig( Request $request )
    {
        $l = $request->_company->lob()->first();

        //dd ( $l->verifyKey() );

        return view('program-options.lob')
            ->with(compact('l'));

        return $view;
        return view('program-options.lob');
    }

    public function postLobConfig( Request $request ) {

        //dd( $request->input('apikey') );

        $l = $request->_company->lob()
            ->firstOrCreate( ['company_id'=>$request->_company->id],
                ['apikey'=>$request->input('apikey')] );
        $l->apikey = $request->input('apikey');
        $l->save();
        return redirect()->route('program-options-lob');

    }


}
