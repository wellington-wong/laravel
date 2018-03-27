<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReviewsController extends Controller
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

    public function getIndex (Request $request) {

    	return view ('reviews.index');

    }

    public function postReview (Request $request) {

    	// dd($request);
    	return back();

    }

}
