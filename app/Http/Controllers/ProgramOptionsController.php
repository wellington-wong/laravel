<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LogEmail;
use App\EmailTemplate;
use App\ReferralForms;
use App\Company;
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
        $company = Company::find($request->get('company_id'));
        $company->subdomain_login_text = $request->input('subdomain_login_text');
        $company->foreground_color = $request->input('foreground_color');
        $company->background_color = $request->input('background_color');
        $company->footer_color = $request->input('footer_color');
        $company->save();

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
        $emailTemplate = EmailTemplate::where('company_id', $request->_company->id)->get()->keyBy('type')->toArray();
        return view('program-options.notification-emails')
        ->with(compact('emailTemplate'));
    }

    /**
     * Save notification emails status
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function postNotificationEmails ( Request $request )
     {
        $emailTemplate = EmailTemplate::where('company_id', $request->_company->id)->where('type', $request->get('type'))->first();
        $request->merge(['user_id' => auth()->user()->id]);
        $request->merge(['company_id' => $request->_company->id]);
        $request->merge(['email_html' => isset($emailTemplate) ? $emailTemplate->email_html : '']);

        if (isset($emailTemplate)) {
            $emailTemplate->update([
                'status' => $request->get('status')
            ]);
        } else {
            EmailTemplate::create($request->all());
            return;
        }
    }

    /**
     * Display a listing of notification emails
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function notificationEmail ( Request $request, $id )
    {
        $emailTemplate = EmailTemplate::where('company_id', $request->_company->id)->where('type', $id)->first();
        $emailTemplateType = $id;

        $emailBlade[] = [];
        switch ($id){
            case (1):
                $emailBlade[$id] = 'new-member';
                break;
            case (2):
                $emailBlade[$id] = 'referral-received';
                break;
            case (3):
                $emailBlade[$id] = 'referral-verified';
                break;
            case (4):
                $emailBlade[$id] = 'referral-sent';
                break;
            case (5):
                $emailBlade[$id] = 'referral-declined';
                break;
            case (6):
                $emailBlade[$id] = 'new-member-admin';
                break;
            case (7):
                $emailBlade[$id] = 'new-referral-admin';
                break;
        }

        return view('program-options.notification-email')
        ->with(compact('emailTemplate', 'emailTemplateType', 'emailBlade'));
    }

    /**
     * Save notification email template
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function postNotificationEmail( Request $request )
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
        
        if ($emailTemplate = EmailTemplate::where('company_id', $request->_company->id)->where('type', $request->get('type'))->first()) {
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

        $num_bankaccounts = null;
        if ( !is_null($l) ) {
            $l->verifyKey();

            if ( true == $l->verified ) {
                $num_bankaccounts = $l->numberBankAccounts();
                $all_verified = $l->banksVerified();
            }
        }


        return view('program-options.lob')
            ->with(compact('l', 'num_bankaccounts', 'all_verified'));

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
