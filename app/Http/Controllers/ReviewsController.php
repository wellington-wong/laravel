<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reviews;
use Illuminate\Support\Facades\Validator;

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


        $rules = [
            'review_url'=>'required',
        ];
        $validator = Validator::make($request->input(), $rules);

        if ( $validator->fails() ) {
            return redirect()->back()->withInput()
                ->with(['errors'=>$validator->errors()]);
        }

        // CREATE REVIEW
        $user = Reviews::firstOrCreate([
            'company_id' => $request->_company->id,
            'url'=>$request->input('review_url'),
            'rating'=>$request->input('rating'),
            'screenshot'=>$request->file('review_screenshot')->store('reviews-screenshots'),
            //'screenshot'=>$request->has('review-photo') ?: null,
        ]);

        if ($request->file('review_photo')) {
    		$request->file('review_photo')->store('reviews-photos');
        }
        if ($request->file('review_screenshot')) {
    		$request->file('review_screenshot')->store('reviews-screenshots');
        }
    	return back();

    }

}
