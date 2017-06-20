<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Phone;
use App\Address;

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

        $phone = new Phone();
        //$phone = auth()->user()->updateDefaultPhone($request);
        auth()->user()->updateProfile($request);
        //dd(auth()->user()->phones()->first()->update($request->only('phone')));
        return back();
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
