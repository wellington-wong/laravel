<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
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
        $admins = $request->_company->admins;
        $superAdmins = $request->_company->superAdmins;
        $users = $admins->merge($superAdmins);

        foreach ($users as $user){            
            $user->notify(new ContactFormMessage($request));
        }
        
        return;
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
