<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

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
        // Get all users
        $users = User::join('companies', 'owner_id', 'users.id')
        ->orderBy('.subdomain', 'desc')
        ->paginate(15);

        return view('global-settings.login-as-user')
        ->with(compact('users'));
    }
}
