<?php

namespace App\Http\Controllers;

use App\User;
use App\Phone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Referral;
use App\Notifications\ReferralNotify;

class ReferralController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create( Request $request )
    {

        //IF THERE IS NO SUBDOMAIN
        if( is_null($request->subdomain_id) ) {
            //FIRST CHECK IF THE PERSON HAD BEEN REFERRED
            //@todo

            //ELSE GIVE A LIST OF COMPANIES
            //return redirect(route('all-companies'));
        }



        //dd($request->subdomain);
        return view('referral.create')
            ->with('subdomain_id', $request->subdomain_id);
    }

    public function referrals( Request $request ) {

        $referrals = new Referral();

        // Get constants
        $referralStatus = new \ReflectionClass(new Referral());
        $referralStatus = $referralStatus->getConstants();
        $referralStatus = array_splice($referralStatus, 0, count($referralStatus) -2);

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

        // Get referral pending approval and reward
        $pendingReferrals = $referrals->getReferralTally();

        // Get query parameters
        $param = [];
        if (count($request->all())) {
            $param = $referrals->getParams();
            $referrals = $referrals->filterSortReferrals(15);
        } else {
            $referrals = $request->user()->referrals()->orderBy('id', 'desc')->paginate(15);
        }

        return view('referral.referrals')
        ->with(compact('referrals', 'sort' ,'sortc', 'referralStatus', 'pendingReferrals', 'param'));
    }

    /**
     * Prepare referrals for excel export
     * @return
     */
    public function referralsExport( Request $request ) {

        if (count($request->all())) {
            $referrals = new Referral();
            $referrals = $referrals->filterSortReferrals(0);
        } else {
            $referrals = $request->user()->referrals()->get();
        }

        $referralArray = [];
        foreach ($referrals as $referral) {
            $currentReferral = [
                'SUBMITTED' => $referral->referred->created_at->format('m/d/y'),
                'REFERRAL ID' => $referral->id,
                'SUBMITTED BY' => auth()->user()->name,
                'NAME' => $referral->referred->first_name . ' ' . $referral->referred->last_name,
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
        $validator = Validator::make($request->input(), $rules);

        if ( $validator->fails() ) {
            return redirect()->back()->withInput()
                ->with(['errors'=>$validator->errors()]);
        }
        
        $duplicate = $this->checkDuplicate($request);

        //CREATE USER
        $user = User::firstOrCreate(
            ['email'=>$request->input('email')],
            ['first_name'=>$request->input('first_name'),
             'last_name'=>$request->input('last_name')]
        );
        //ADD PHONE
        $phone = $user->addDefaultPhone($request);
        //ADD ADDRESS
        $address = $user->addDefaultAddress($request);

        //ADD THAT USER TO A NEW REFERRAL
        $user->referral_id = $request->user()->referrals()->insertGetId([
            'referrer_id'   => $request->user()->id,
            'company_id'    => $request->get('subdomain_id'),
            'user_id'       => $user->id,
            'referrer_admin_id' => $request->has('member_id') ? $request->get('member_id') : 0,            
            'installation_complete' => $request->has('install_complete') ? $request->get('install_complete') : 0,
            'created_at' =>  \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        if (isset($duplicate['email']) || isset($duplicate['phone'])) {
            $user->duplicate = $duplicate;
        }

        \Mail::send('emails.customer', array('user' => $user, 'address' => $address, 'phone' => $phone), function ($message) use ($user) {
            $message->from('admin@' . env('APP_URL'), 'Laravel');
            $message->to($user->email);
        });

        auth()->user()->notify(new ReferralNotify($user));

        return redirect(route('referrals'));
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
            $referrals = $referrals->filterSortReferrals(15, 'updated_at');
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
        $referralHistory = Referral::find($id);

        return view('referral.history-details')
        ->with(compact('referral', 'referralHistory'));
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
