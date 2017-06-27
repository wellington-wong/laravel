<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Phone;
use App\Address;
use Illuminate\Support\Facades\Validator;

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
            'name'=>'required',
            'email'=>'required|email',
            'phone'=>'required|phone:US',
        ];
        $validator = Validator::make($request->input(), $rules);

        if ( $validator->fails() ) {
            return redirect()->back()->withInput()
                ->with(['errors'=>$validator->errors()]);
        }

        if (null != auth()->user()->phone()) {
            auth()->user()->updateDefaultPhone($request);
        } else {
            auth()->user()->addDefaultPhone($request);
        }

        if (null != auth()->user()->address()) {
            auth()->user()->updateDefaultAddress($request);
        } else {
            auth()->user()->addDefaultAddress($request);
        }

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
