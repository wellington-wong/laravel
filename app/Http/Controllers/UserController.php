<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show manage account.
     *
     * @return view
     */
    public function getView( Request $request, $id )
    {
    	$user = User::find($id);
        return view('user.view')->with(compact('user'));
    }

    /**
     * Create user account.
     *
     * @return view
     */
    public function create( Request $request )
    {
        return view('user.create');
    }

    /**
     * Save user account.
     *
     * @return view
     */
    public function postCreate( Request $request )
    {

        $rules = [
            'name'=>'required',
            'email'=>'required|email',
            'phone'=>'required|phone:US',
            'address'=>'max:100',
            'address2'=>'max:25',
            'city'=>'required',
            'state'=>'required|alpha|max:2',
            'zip'=>'required|digits:5'
        ];

        $validator = Validator::make($request->input(), $rules, $messages);

        if ( $validator->fails() ) {
            return redirect()->back()->withInput()
                ->with(['errors'=>$validator->errors()]);
        }


        return back;
    }
}
