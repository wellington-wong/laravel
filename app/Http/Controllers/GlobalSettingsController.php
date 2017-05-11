<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GlobalSettingsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function submitReferralMember(Request $request) {

        return view('global-settings.submit-referral-member');
    }

    public function editMemberInformation(Request $request) {

        return view('global-settings.edit-member-information');
    }

    public function exportMemberInformation(Request $request) {

        return view('global-settings.export-member-information');
    }

    public function changeReferralStatus(Request $request) {

        return view('global-settings.change-referral-status');
    }

    public function addDeleteAdmin(Request $request) {

        return view('global-settings.add-delete-admin');
    }

    public function defineUserRoles(Request $request) {

        return view('global-settings.define-user-roles');
    }

    public function addChangeBillingInformation(Request $request) {

        return view('global-settings.add-change-billing-information');
    }
}
