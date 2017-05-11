<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
     * How it works
     */
    public function features(Request $request)
    {
		return View('basic.features');
    }
    /**
     * How it works
     */
    public function aboutUs(Request $request)
    {
		return View('basic.about-us');
    }
    /**
     * How it works
     */
    public function pricing(Request $request)
    {
		return View('basic.pricing');
    }
    /**
     * How it works
     */
    public function contact(Request $request)
    {
		return View('basic.contact');
    }
}
