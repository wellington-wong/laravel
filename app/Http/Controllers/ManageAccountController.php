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

        $address = null !== auth()->user()->address()->first() ? auth()->user()->address()->first() : '';

        return view('manage-account.index')->with(compact('address'));
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
            'address'=>'max:100',
            'address2'=>'max:25',
            'city'=>'required',
            'state'=>'required|alpha|max:2',
            'zip'=>'required|digits:5',
            'profile_blob' => 'required',
        ];

        $messages = [
            'profile_blob.required' => 'The profile image field is required.',
        ];

        $validator = Validator::make($request->input(), $rules, $messages);

        if ( $validator->fails() ) {
            return redirect()->back()->withInput()
                ->with(['errors'=>$validator->errors()]);
        }

        if (null !== auth()->user()->phones()->first()) {
            auth()->user()->updateDefaultPhone($request);
        } else {
            auth()->user()->addDefaultPhone($request);
        }

        if (null !== auth()->user()->addresses()->first()) {
            auth()->user()->updateDefaultAddress($request);
        } else {
            auth()->user()->addDefaultAddress($request);
        }

        auth()->user()->profile_image = $request->file('profile')->store('profile-images');
        auth()->user()->save();

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
