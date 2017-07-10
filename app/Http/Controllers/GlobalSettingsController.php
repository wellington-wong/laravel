<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use App\User;
use Auth;
use Session;

class GlobalSettingsController extends Controller
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
     * Show submit referral member
     *
     * @return view
     */
    public function submitReferralMember(Request $request) 
    {
        return view('global-settings.submit-referral-member');
    }

    /**
     * Show edit member information
     *
     * @return view
     */
    public function editMemberInformation(Request $request) 
    {
        return view('global-settings.edit-member-information');
    }

    /**
     * Show export member information
     *
     * @return view
     */
    public function exportMemberInformation(Request $request) 
    {
        return view('global-settings.export-member-information');
    }

    /**
     * Show add/delete admin
     *
     * @return view
     */
    public function addDeleteAdmin(Request $request) 
    {
        return view('global-settings.add-delete-admin');
    }

    /**
     * Show define user roles
     *
     * @return view
     */
    public function defineUserRoles(Request $request) 
    {
        return view('global-settings.define-user-roles');
    }

    /**
     * Show login as any super admin
     *
     * @return view
     */
    public function loginSuperAdmin(Request $request) 
    {
        return view('global-settings.login-super-admin');
    }

    /**
     * Show login as user
     *
     * @return view
     */
    public function loginAsUser(Request $request) 
    {
        $companies = Company::orderBy('company_name')->get();

        return view('global-settings.login-as-user')
        ->with(compact('companies'));
    }

    /**
     * Show login as user id
     *
     * @return view
     */
    public function loginAsUserId(Request $request, $id) 
    {
        Session::put( 'currentUserId', Auth::user()->id);
        Auth::loginUsingId($id);

        return redirect(route('home'))->with('success', ['Successfully logged in as ' . auth()->user()->getName()]);
    }

    /**
     * Show login as original user
     *
     * @return view
     */
    public function loginAsOrigin(Request $request) 
    {   
        Auth::loginUsingId(Session::get('currentUserId'));
        Session::forget( 'currentUserId' );
        return redirect(route('home'))->with('success', ['Successfully logged in back as ' . auth()->user()->getName()]);
    }
}
