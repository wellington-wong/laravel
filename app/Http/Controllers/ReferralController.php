<?php

namespace App\Http\Controllers;

use App\ReferralForms;
use App\ReferralValues;
use App\User;
use App\Phone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use App\Referral;
use App\Notifications\ReferralNotifyUser;
use App\Notifications\ReferralNotifyAdmin;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Participant;
use Cmgmyr\Messenger\Models\Thread;
use App\Thread as ThreadByCompany;
use Carbon\Carbon;
use App\Notifications\MessageReceived;
use App\Notifications\ReferralReceived;
use App\Notifications\NewReferralAdmin;

class ReferralController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create( Request $request, $id = null )
    {

        //IF THERE IS NO SUBDOMAIN
        if( is_null($request->subdomain_id) ) {
            //FIRST CHECK IF THE PERSON HAD BEEN REFERRED
            //@todo

            //ELSE GIVE A LIST OF COMPANIES
            //return redirect(route('all-companies'));
        }


        $form = ReferralForms::find($id);
        //dd($form);

        //dd($request->subdomain);
        return view('referral.create')
            ->with(compact('form'))
            ->with('subdomain_id', $request->subdomain_id);
    }

    public function formJson( $id ) {
        $form = ReferralForms::find($id);
        return $form->raw_form_json;
    }

    public function findForm( Request $request ) {
        $company = $request->_company;
        if ( $id = $company->forms->first() ) {
            return redirect()->route( 'referral-create-id' , [$id] );
        } else {
            return view('referral.create')
                ->with(compact('form'))
                ->with('subdomain_id', $request->subdomain_id);
        }
    }


    public function companyReferrals( Request $request ) {

        $referrals = new Referral();

        // Get constants
        $referralStatus = new \ReflectionClass(new Referral());
        $referralStatus = $referralStatus->getConstants();
        $referralStatus = array_splice($referralStatus, 0, count($referralStatus) -2);

        // Configure sort class
        $column = $request->get('column');
        $sortc = array_fill_keys(['created_at', 'id', 'referrer_id', 'referred', 'status'], null);
        $sort = array_fill_keys(['created_at', 'id', 'referrer_id', 'referred', 'status'], 'desc');

        // Configure sort links
        $sort[$column] = 'desc';
        $sortClass = '';
        switch ($request->get('sort')) {
            case ('desc'):
                $sort[$column] = 'asc';
                $sortClass = '-desc';
                break;
            case ('asc'):
                $sort[$column] = '';
                $sortClass = '-asc';
                break;
        }
        $sortc[$column] = $sortClass;

        // Get referral pending approval and reward
        $pendingReferrals = $referrals->getReferralTally();

        // Get query parameters
        $param = [];
        if (count($request->all())) {
            $param = $referrals->getParams();
            $referrals = $request->_company->filterSortReferralSubmissions()->paginate(15);
        } else {
            $referrals = $request->_company->referrals()->orderBy('status', 'asc')->paginate(15);
        }

        $route = $request->route()->action['as'];

        return view('referral.referrals')
            ->with(compact('referrals', 'sort' ,'sortc', 'referralStatus', 'pendingReferrals', 'param', 'route'));
    }


    public function referrals( Request $request ) {

        $referrals = new Referral();

        // Get constants
        $referralStatus = new \ReflectionClass(new Referral());
        $referralStatus = $referralStatus->getConstants();
        $referralStatus = array_splice($referralStatus, 0, count($referralStatus) -2);

        // Configure sort class
        $column = $request->get('column');
        $sortc = array_fill_keys(['created_at', 'id', 'referrer_id', 'referred', 'status'], null);
        $sort = array_fill_keys(['created_at', 'id', 'referrer_id', 'referred', 'status'], 'desc');

        // Configure sort links
        $sort[$column] = 'desc';
        $sortClass = '';
        switch ($request->get('sort')) {
            case ('desc'):
                $sort[$column] = 'asc';
                $sortClass = '-desc';
                break;
            case ('asc'):
                $sort[$column] = 'desc';
                $sortClass = '-asc';
                break;
        }
        $sortc[$column] = $sortClass;        

        // Get referral pending approval and reward
        $pendingReferrals = $referrals->getReferralTally();

        // Get query parameters
        $param = [];
        if (count($request->all())) {
            $param = $referrals->getParams();

            if (Gate::allows('see-company-referrals')) {
                $referrals = $request->_company->filterSortReferralSubmissions()->paginate(15);
            } else {
                $referrals = $request->user()->filterSortReferralSubmissions()->paginate(15);
            }
        } else {
            if (Gate::allows('see-company-referrals')) {
                $referrals = $request->_company->referrals()->orderBy('status', 'asc')->orderBy('created_at', 'desc')->paginate(15);
            } else {
                $referrals = $request->user()->referrals()->orderBy('status', 'asc')->orderBy('created_at', 'desc')->paginate(15);
            }
        }

        $route = $request->route()->action['as'];

        return view('referral.referrals')
        ->with(compact('referrals', 'sort' ,'sortc', 'referralStatus', 'pendingReferrals', 'param', 'route'));
    }

    /**
     * Prepare referrals for excel export
     * @return
     */
    public function referralsExport( Request $request ) {

        if (count($request->all())) {
            $referrals = new Referral();
            $param = $referrals->getParams();
            if (Gate::allows('see-company-referrals')) {
                $referrals = $request->_company->filterSortReferralSubmissions()->get();
            } else {
                $referrals = $request->user()->filterSortReferralSubmissions()->get();
            }
        } else {
            if (Gate::allows('see-company-referrals')) {
                $referrals = $request->_company->referrals()->orderBy('status', 'asc')->orderBy('created_at', 'desc')->get();
            } else {
                $referrals = $request->user()->referrals()->orderBy('status', 'asc')->orderBy('created_at', 'desc')->get();
            }
        }

        $referralArray = [];
        foreach ($referrals as $referral) {
            $currentReferral = [
                'SUBMITTED' => $referral->referred->created_at->format('m/d/y'),
                'REFERRAL ID' => $referral->id,
                'SUBMITTED BY' => isset($referral->referrer->name) ? $referral->referrer->name : $referral->referrer->first_name . ' ' . $referral->referrer->last_name,
                'NAME' => isset($referral->referred->name) ? $referral->referred->name : $referral->referred->first_name . ' ' . $referral->referred->last_name,
                'EMAIL' => $referral->referred->email,
                'STATUS' => \App\Referral::$status[$referral->status]
            ];
            $referralArray[] = $currentReferral;
        }

        \Excel::create('Referrals', function($excel) use ($referralArray) {
            $excel->sheet('Members', function($sheet) use ($referralArray) {
                $sheet->fromArray($referralArray);
            });
        })->export('xls');
        return;
    }

    public function postCreate( Request $request )
    {

        /*
        $rules = [
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required|email',
            'phone'=>'required|phone:US',
            'address'=>'max:100',
            'address2'=>'max:25',
            'city'=>'required',
            'state'=>'required|alpha|max:2',
            'zip'=>'required|max:11',
            'subdomain_id'=>'required',
            'install_complete'=>'required'
        ];
        */

        $request->merge(['subdomain_id' => $request->_company->id]);

        $rules = [
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'unique:users|required|email',
            'phone'=>'phone:US|required',
            'address'=>'required:max:100',
            'address2'=>'required:max:25',
            'city'=>'required',
            'state'=>'required|alpha|max:2',
            'company_zip'=>'required|digits:5',
        ];
        $validator = Validator::make($request->input(), $rules);

        if ( $validator->fails() ) {
            return redirect()->back()->withInput()
                ->with(['errors'=>$validator->errors()]);
        }
        
        $duplicate = $this->checkDuplicate($request);

        //CREATE USER
        $user = User::firstOrCreate([
            'email'=>$request->input('email'),
            'name'=>$request->input('first_name') . ' ' . $request->input('last_name'),
            'first_name'=>$request->input('first_name'),
            'last_name'=>$request->input('last_name')
        ]);
        //ADD PHONE
        $phone = $user->addDefaultPhone($request);
        //ADD ADDRESS
        $address = $user->addDefaultAddress($request);

        //ADD THAT USER TO A NEW REFERRAL
        $user->referral_id = $request->user()->referrals()->insertGetId([
            'referrer_id'   => $request->user()->id,
            'company_id'    => $request->get('subdomain_id'),
            'user_id'       => $user->id,
            //'as_admin_id' => $request->has('member_id') ? $request->get('member_id') : 0,            
            //'referrer_admin_id' => $request->has('member_id') ? $request->get('member_id') : 0,  
            //'installation_complete' => $request->has('install_complete') ? $request->get('install_complete') : 0,
            'created_at' =>  \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        if (isset($duplicate['email']) || isset($duplicate['phone'])) {
            $user->duplicate = $duplicate;
        }

        // Save referral values
        $referralValues = null;
        if (isset($user->referral_id)) {
            foreach ($request->request as $key => $val) {
                if ($key != '_token') {
                   $referralValues = ReferralValues::create([
                        'name' => $key, 
                        'value' => $val, 
                        'referral_id' => $user->referral_id
                    ]);
                }
            }
        }

        $user->notify(new ReferralReceived(Referral::find($user->referral_id), $request, $referralValues));
        foreach ($request->_company->admins()->get() as $admin) {
            $admin->notify(new NewReferralAdmin(Referral::find($user->referral_id), $request, $referralValues));
        }

        return redirect(route('referrals'));
    }


    public function sendMessage( Request $request, Referral $referral, $type  ) {
        if ( 'No Address' == $type ) {
            $subject = 'We need your address.';
            $message = 'Please go to your ' . config('app.domain') . ' account and
             click on '. link_to_route('manage-account') .' to
             enter your address.';
        }
        if ( 'Verify Address' == $type ) {
            $subject = 'Please correct your address.';
            $message = 'Your address could not be verified as deliverable.';
            $message .= 'Please go to your ' . config('app.domain') . ' account and
             click on '. link_to_route('manage-account') .' to
             correct your address.';
        }
        //echo $message;exit();
        $thread = Thread::create(
            [
                'subject' => $subject,
            ]
        );
        $threadByCompany = ThreadByCompany::create(
            [
                'thread_id' => $thread->id,
                'company_id' => $request->_company->id,
            ]
        );

        // Message
        $message = Message::create(
            [
                'thread_id' => $thread->id,
                'user_id'   => $request->user()->id,
                'body'      => $message,
            ]
        );
        // Sender
        $participant = Participant::create(
            [
                'thread_id' => $thread->id,
                'user_id'   => $request->user()->id,
                'last_read' => new Carbon,
            ]
        );
        // Recipients
        $recipient = $referral->referrer->id;
        $notifyUser = User::find($recipient);
        $notifyUser->notify(new MessageReceived($thread, $message, $recipient, $request));

    }


    public function sendCheck( Request $request, $referral_id ) {

        if ( Gate::denies('send-check') ) {
            return App::abort(401, 'Access Denied');
        }

        $rules = ['amount'=>'required'];
        $validator = Validator::make( $request->input() , $rules );
        if ( $validator->fails() ) {
            return redirect()->back()->withErrors($validator->messages());
        }

        $amount = $request->input('amount');
        $memo   = $request->input('memo');

        //CHECK ADDRESS
        if ( 0 == $request->_company->address()->count() ) {
            return redirect()->back()->withErrors('Your company needs an address to mail a check.');
        }
        if ( $ba = $request->_company->address->first() ) {
            $fields = ['address', 'city', 'state', 'zip'];
            foreach( $fields as $f ) {
                if ('' == $ba->$f ) {
                    $address_error = "Your company address needs a $f.";
                }
            }
            if ( isset($address_error) ) {
                return redirect()->back()->withErrors($address_error)->withInput();
            }
        }

        //CHECK IF COMPANY ADDRESS IS VERIFIED
        if ( null == $request->_company->address->first()->lob_adr_id ) {
            //IF THERE'S NO lob_adr_id, CHECK IF VERIFIED
            if ( 0 == $request->_company->address->first()->lob_verified ) {
                $request->_company->lob->verifyAddress( $request->_company, $request->_company->address->first() );
            }

            //CHECK AGAIN
            if ( 0 == $request->_company->address->first()->lob_verified ) {
                //RETURN ERROR
                return redirect()->back()->withErrors("The company address cannot be verified.");

                //IF VERIFIED, CREATE LOB ADDRESS
            } elseif ( 1 == $request->_company->address->first()->lob_verified ) {
                if ( null == $request->_company->address->first()->lob_adr_id ) {
                    $request->_company->lob->createAddress( $request->_company, $request->_company->address->first() );
                }
            }
        }

        //CHECK IF THERE IS A LOB ID TIED TO THIS COMPANY
        if ( 0 == $request->_company->lob()->count() ) {
            return redirect()->back()->withErrors("Your company needs to have a Lob API key associated with your account.  Click on 'Bank Account' in the sidebar.");
        }

        //THEN VERIFY THE LOB ACCOUNT
        $request->_company->lob->verifyKey();
        if ( false == $request->_company->lob->verified ) {
            return redirect()->back()->withErrors("Your Lob API key is incorrect.  Click on 'Bank Account' in the sidebar.");
        }

        //THEN CHECK IF THERE'S A BANK ACCOUNT
        if ( 0 == count( $request->_company->lob->lob->bankAccounts()->all() ) ) {
            return redirect()->back()->withErrors("You have no bank accounts set up in lob.  Please go to lob.com and set up a bank account.");
        }

        $referral = $request->_company->referrals()->findOrFail($referral_id);



        //CHECK IF USER HAS AN ADDRESS
        if ( 0 == $referral->referrer->address()->count() ) {
            //SEND MESSAGE/EMAIL TO USER
            $this->sendMessage( $request, $referral, 'No Address' );
            return redirect()->back()->withErrors("The referrer has no address to send a check to.");
        }

        //FIRST CHECK IF ADDRESS ALREADY HAS A lob_adr_id
        if ( null == $referral->referrer->address->first()->lob_adr_id ) {
            
            //IF THERE'S NO lob_adr_id, CHECK IF VERIFIED
            if ( 0 == $referral->referrer->address->first()->lob_verified ) {
                $request->_company->lob->verifyAddress( $referral->referrer, $referral->referrer->address->first() );
            }

            //CHECK AGAIN
            if ( 0 == $referral->referrer->address->first()->lob_verified ) {
                //@todo CAN'T SEND A CHECK, NO VERIFIABLE ADDRESS
                //SEND MESSAGE/EMAIL TO USER
                $this->sendMessage( $request, $referral, 'Verify Address' );
                //RETURN ERROR
                return redirect()->back()->withErrors("The referrer's default address cannot be verified.");

            //IF VERIFIED, CREATE LOB ADDRESS
            } elseif ( 1 == $referral->referrer->address->first()->lob_verified ) {
                if ( null == $referral->referrer->address->first()->lob_adr_id ) {
                    $request->_company->lob->createAddress( $referral->referrer, $referral->referrer->address->first() );
                }
            }
        }
        

        $request->_company->lob->sendCheck( $request, $referral, $amount, $memo );

        return redirect()->route('company-referrals');

    }


    /**
     * Rewards view
     * @return
     **/
    public function rewards( Request $request ) {

        $referrals = $request->user()->referrals()->paginate(15);

        return view('referral.rewards')
            ->with(compact('referrals'));
    }

    /**
     * Referral history view
     * @return
     **/
    public function history( Request $request ) {

        
        $referrals = new Referral();
        // Get query parameters
        $param = [];
        if (count($request->all())) {
            $param = $referrals->getParams();
            $referrals = $request->user()->filterSortReferralSubmissions('updated_at')->get();
        } else {
            $referrals = $request->user()->referrals()->orderBy('updated_at', 'desc')->paginate(15);
        }


        // Configure sort class
        $column = $request->get('column');
        $sortc = array_fill_keys(['created_at', 'id', 'user_id', 'referred', 'status'], null);
        $sort = array_fill_keys(['created_at', 'id', 'user_id', 'referred', 'status'], 'desc');

        // Configure sort links
        $sort[$column] = 'desc';
        $sortClass = '';
        switch ($request->get('sort')) {
            case ('desc'):
                $sort[$column] = 'asc';
                $sortClass = '-desc';
                break;
            case ('asc'):
                $sort[$column] = '';
                $sortClass = '-asc';
                break;
        }
        $sortc[$column] = $sortClass;

        return view('referral.history')
        ->with(compact('referrals', 'sort', 'sortc'));
    }

    /**
     * Referral history details
     * @return
     **/
    public function historyDetails( Request $request, $id ) {

        $referral = Referral::find($id);

        return view('referral.history-details')
        ->with(compact('referral'));
    }

    /**
     * View referral
     * @return
     **/
    public function getView( Request $request, $id ) {
        
        $referral = Referral::find($id);
        $referralValues = ReferralValues::where('referral_id', $id)
            ->where('name', '<>', '__log_id')
            ->where('name', '<>', 'subdomain_id')
            ->where('name', '<>', 'country')
            ->where('name', '<>', 'country_code')
            ->get();
        //dd($referralValues);

        return view('referral.view')
        ->with(compact(['referralValues', 'referral']));
    }

    /**
     * View referral
     * @return
     **/
    public function confirmation( Request $request ) {

        return view('referral.confirmation');
    }

    /**
     * Update referral status
     * @return
     **/
    public function update( Request $request ) {

        $referral = new Referral();
        return $referral->updateReferral();
    }

    /**
     * Delete referral
     * @return
     **/
    public function delete( Request $request ) {

        $referral = new Referral();
        return $referral->deleteReferral();
    }

    /**
     * Check if phone or email already exists
     **/
    public function checkDuplicate( Request $request )
    {
        $result = [];

        if ($request->has('email')) {
                $result['email'] = User::where('email', $request->get('email'))->first();
        } 

        if ($request->has('phone')) {
                $result['phone'] = Phone::where('phone', Phone::sanitize($request->input('phone')))->first();
        }        

        return $result;
    }

}
