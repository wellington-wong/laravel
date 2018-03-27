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

    	dd($request->all());
        if ($request->file('review-photo')) {
    		$request->file('review-photo')->store('reviews-photos');
        }
        if ($request->file('review-screenshot')) {
    		$request->file('review-screenshot')->store('reviews-screenshots');
        }
    	return back();

    }

}
