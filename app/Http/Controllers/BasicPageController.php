<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\BasicPages;
use App\Notifications\ContactFormMessage;

class BasicPageController extends Controller
{
    /**
     * How it works
     */
    public function howItWorks(Request $request)
    {
        $page = BasicPages::where('route_name', 'how-it-works')->where('company_id', 0)->first();
        return View('basic.how-it-works')
            ->with(compact('page'));
    }

    /**
     * Features
     */
    public function features(Request $request)
    {
        $page = BasicPages::where('route_name', 'features')->where('company_id', 0)->first();
        return View('basic.features')
            ->with(compact('page'));
    }

    /**
     * About Us
     */
    public function aboutUs(Request $request)
    {
        $page = BasicPages::where('route_name', 'about-us')->where('company_id', 0)->first();
        return View('basic.about-us')
            ->with(compact('page'));
    }

    /**
     * Pricing
     */
    public function pricing(Request $request)
    {
        $page = BasicPages::where('route_name', 'pricing')->where('company_id', 0)->first();
        return View('basic.pricing')
            ->with(compact('page'));
    }

    /**
     * Contact Form
     */
    public function contact(Request $request)
    {
        $page = BasicPages::where('route_name', 'contact')->where('company_id', 0)->first();
        return View('basic.contact')
            ->with(compact('page'));
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
        $page = BasicPages::where('route_name', 'how-this-works')->where('company_id', 1)->first();
        return View('basic.how-this-works')
            ->with(compact('page'));
    }

    /**
     * How to get more referrals
     */
    public function howToGetMoreReferrals(Request $request)
    {
        $page = BasicPages::where('route_name', 'how-to-get-more-referrals')->where('company_id', 1)->first();

        return View('basic.how-to-get-more-referrals')
            ->with(compact('page'));
    }
}
