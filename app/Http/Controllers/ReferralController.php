<?php

namespace App\Http\Controllers;

use App\User;
use App\Phone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Notifications\Referral;

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

        // Add sort functionality
        $sort = $request->get('sort');

        $referrals = $request->user()->referrals()
        ->orderBy($sort)
        ->paginate(15);

        return view('referral.referrals')
            ->with(compact('referrals'));
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
            'subdomain_id'=>'required'
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
        $request->user()->referrals()->insert([
            'referrer_id'   => $request->user()->id,
            'company_id'    => $request->get('subdomain_id'),
            'user_id'       => $user->id,
            'referrer_admin_id' => $request->has('member_id') ? $request->get('member_id') : 0
        ]);

        if (isset($duplicate['email']) || isset($duplicate['phone'])) {
            $user->duplicate = $duplicate;
        }

        \Mail::send('emails.customer', array('user' => $user, 'address' => $address, 'phone' => $phone), function ($message) use ($user) {
            $message->from('admin@' . env('APP_URL'), 'Laravel');
            $message->to($user->email);
        });

        auth()->user()->notify(new Referral($user));

        return redirect(route('referrals'));
    }

    public function rewards( Request $request ) {

        $referrals = $request->user()->referrals()->paginate(15);

        return view('referral.rewards')
            ->with(compact('referrals'));
    }

    public function history( Request $request ) {

        $referrals = $request->user()->referrals()->paginate(15);

        return view('referral.history')
            ->with(compact('referrals'));
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
                $result['phone'] = Phone::where('number', Phone::sanitize($request->input('phone')))->first();
        }        

        return $result;
    }

}
