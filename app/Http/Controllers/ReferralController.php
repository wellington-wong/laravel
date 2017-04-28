<?php

namespace App\Http\Controllers;

use App\User;
use App\Phone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

        $referrals = $request->user()->referrals()->get();

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
            'city'=>'',
            'state'=>'alpha|max:2',
            'zip'=>'max:11',
            'subdomain_id'=>'required'
        ];
        $validator = Validator::make($request->input(), $rules);

        if ( $validator->fails() ) {
            return redirect()->back()->withInput()
                ->with(['errors'=>$validator->errors()]);
        }

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
            'user_id'       => $user->id
        ]);

        return redirect(route('referrals'));
    }

    public function autocomplete( Request $request )
    {

        $result = '';

        switch (true) {
            case ($request->has('email')):
                $result = User::where('email', $request->get('email'))->first();
                break;
            case ($request->has('phone')):
                $result = Phone::where('number', $request->get('phone'))->first();
                break;
        }
        
        return $result;
    }

}
