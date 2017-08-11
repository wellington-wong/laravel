<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Notifications\ContactFormMessage;

class BasicPageController extends Controller
{
    /**
     * How it works
     */
    public function howItWorks(Request $request)
    {
		return View('basic.how-it-works');
    }

    /**
     * Features
     */
    public function features(Request $request)
    {
		return View('basic.features');
    }

    /**
     * About Us
     */
    public function aboutUs(Request $request)
    {
		return View('basic.about-us');
    }

    /**
     * Pricing
     */
    public function pricing(Request $request)
    {
		return View('basic.pricing');
    }

    /**
     * Contact Form
     */
    public function contact(Request $request)
    {
		return View('basic.contact');
    }

    /**
     * Post Contact Form
     */
    public function postContact(Request $request)
    {
        $admins = isset($request->_company->admins) ? $request->_company->admins : null;
        $superAdmins = isset($request->_company->superAdmins) ? $request->_company->superAdmins : null;
        $users = (isset($superAdmins) && isset($admins)) ? $admins->merge($superAdmins) : Role::where('name', 'globalAdmin')->first()->users()->get();

        foreach ($users as $user){        
            $user->notify(new ContactFormMessage($request));
        }

        return back()->with('success', 'Thank you for contacting us, we will get back to you soon.');
    }

    /**
     * How this works
     */
    public function howThisWorks(Request $request)
    {
        return View('basic.how-this-works');
    }

    /**
     * How to get more referrals
     */
    public function howToGetMoreReferrals(Request $request)
    {
        return View('basic.how-to-get-more-referrals');
    }
}
