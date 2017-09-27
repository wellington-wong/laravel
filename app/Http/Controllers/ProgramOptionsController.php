<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LogEmail;
use App\EmailTemplate;
use App\EmailTemplateRecipients;
use App\ReferralForms;
use App\Company;
use App\RewardSetting;
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
        $success = $request->input('success') ? ['Referral Program Settings saved.'] : null;
        return view('program-options.referral-program-settings')
        ->with(compact('companyReferralForm'))
        ->with('success', $success);
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
        $company->tos_text = $request->input('tos_text');
        $company->tos_link = $request->input('tos_link');
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
        $rewardSettings = $request->_company->rewardSettings()->first();
        return view('program-options.reward-settings')
        ->with(compact('rewardSettings'));
    }

    /**
     * Display a listing of reward settings
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function postRewardSettings( Request $request )
    {

        $rules = [
            'title'=>'required',
            'reward_kind'=>'required',
            'reward_send'=>'required',
            'approved_referral_ratio'=>'required',
            'reward_referral_ratio'=>'required',
            'leaderboard'=>'required'
        ];

        $validator = Validator::make($request->input(), $rules);

        if ( $validator->fails() ) {
            return redirect()->back()->withInput()
                ->with(['errors'=>$validator->errors()]);
        }

        $request->merge([
            'company_id' => $request->_company->id,
            'reward_ratio' => serialize([$request->input('approved_referral_ratio'), $request->input('reward_referral_ratio')]),            
        ]);

        if ($request->_company->rewardSettings()->first()) {
            $request->_company->rewardSettings()->update(
                $request->only('title', 'reward_kind', 'reward_send', 'leaderboard', 'reward_ratio')
            );
        } else {
            $request->merge(['company_id' => $request->_company->id]);
            RewardSetting::create($request->only('company_id', 'title', 'reward_kind', 'reward_send', 'leaderboard', 'reward_ratio'));

        }

        return back()->with('success', ['Reward settings successfully saved.']);
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
        $recipients = EmailTemplateRecipients::where('recipient_id', '<>', null)
            ->where('company_id', $request->_company->id)
            ->where('email_template', $id)
            ->get()->keyBy('recipient_id')->toArray();
        $customRecipients = EmailTemplateRecipients::where('recipient_id',  null)
            ->where('company_id', $request->_company->id)
            ->where('email_template', $id)
            ->pluck('recipient')->toArray();

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
        ->with(compact('emailTemplate', 'emailTemplateType', 'emailBlade', 'recipients', 'customRecipients'));
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
            //'recipients' => $request->get('type') > 5 ? 'required' : '',
        ];

        // Add array validation for comma-separated emails
        if ($request->has('custom_recipients')) {    
            $request->merge(['custom_recipient' => explode(',', str_replace(' ', '', $request->get('custom_recipients')))]);
            $rules['custom_recipient.*'] = 'email';
        }

        $messages = [
            //'custom_recipient.*.email' => 'A custom recipient contains an invalid email.',
        ];

        $validator = Validator::make($request->input(), $rules, $messages);

        if ( $validator->fails() ) {
            return redirect()->back()->withInput()
                ->with(['errors'=>$validator->errors()]);
        }
         
        // Save admin email recipients
        if ($request->has('recipients')) {
            $recipients = $request->get('recipients');
            foreach ($recipients as $key => $recipient) {
                if (!EmailTemplateRecipients::where('recipient', $recipient)
                    ->where('email_template', $request->get('type'))
                    ->where('company_id', $request->_company->id)
                    ->get()->first()) {
                    $recipientData = ['company_id' => $request->_company->id, 'email_template' => $request->get('type'), 'recipient_id' => $key, 'recipient' => $recipient];
                    EmailTemplateRecipients::create($recipientData);
                }
            }
        }

        // Save custom recipients
        if ($request->has('custom_recipients')) {
            $customRecipients = $request->get('custom_recipient');
            foreach ($customRecipients as $recipient) {
                if (!EmailTemplateRecipients::where('recipient', $recipient)->first()) {
                    $recipientData = ['company_id' => $request->_company->id, 'email_template' => $request->get('type'), 'recipient' => $recipient];
                    EmailTemplateRecipients::create($recipientData);
                }
            }
        }

        // Compare request recipients to recipients in db and delete.
        if ($request->has('recipients') || $request->has('custom_recipients')) {
            $emailTemplateRecipients = EmailTemplateRecipients::where('company_id', $request->_company->id)
                ->where('email_template', $request->get('type'))
                ->pluck('recipient')->toArray();
            $recipients = $request->has('recipients') ? $request->get('recipients') : [];
            $customRecipients = $request->has('custom_recipient') ? $request->get('custom_recipient') : [];
            $recipientDiff = array_diff($emailTemplateRecipients, $recipients, $customRecipients);
            foreach ($recipientDiff as $delRecipient) {
                EmailTemplateRecipients::where('recipient', $delRecipient)
                    ->where('company_id', $request->_company->id)
                    ->where('email_template', $request->get('type'))
                    ->delete();
            }
        }

        // Save email template
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
