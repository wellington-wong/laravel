<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reviews;
use App\UserReviews;
use Illuminate\Support\Facades\Validator;
use App\Notifications\NewReviewAdmin;
use App\Notifications\NewReviewSubmitted;
use App\EmailTemplateRecipients;
use Illuminate\Support\Facades\Redirect;

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

    /**
     * List all reviews
     * @return
     */
    public function getIndex (Request $request) {

        $reviews = Reviews::where('company_id', $request->_company->id)->orderBy('created_at', 'DESC')->paginate(15);

        return view ('reviews.index')
            ->with(compact('reviews'));

    }

    /**
     * Get create review form
     * @return
     */
    public function create (Request $request) {

        $reviews = Reviews::where('company_id', $request->_company->id)->get();
    	return view ('reviews.create')
        ->with(compact('reviews'));

    }

    /**
     * Process review submission
     * @return
     */
    public function postCreate (Request $request) {

        $rules = [
            'display_name'=>'required',
            'review_url'=>'required|regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
            'review_screenshot_blob'=>'required',
            'rating'=>'required|min:1|numeric',
        ];

        $messages = [
            'review_url.url' => 'Please use complete url starting with "http://" or "https://"',
            'review_screenshot_blob.required' => 'The review screenshot is required.',
            'rating.min' => 'The rating must be at least 1 star.',
        ];

        $validator = Validator::make($request->input(), $rules, $messages);

        if ( $validator->fails() ) {
            return redirect()->back()->withInput()
                ->with(['errors'=>$validator->errors()]);
        }

        // CREATE REVIEW
        $review = Reviews::firstOrCreate([
            'company_id' => $request->_company->id,
            'display_name' => $request->input('display_name') ?: auth()->user()->getDisplayNameAttribute(),
            'url'=>$request->input('review_url'),
            'snippet'=>$request->input('review_snippet'),
            'rating'=>$request->input('rating'),
            'screenshot'=>$request->file('review_screenshot')->store('reviews-screenshots'),
            'photo'=>$request->has('review_photo_blob') ? $request->file('review_photo')->store('reviews-photos') : null,
            'user_id'=>auth()->user()->id,
            //'screenshot'=>$request->has('review-photo') ?: null,
        ]);

        // Notify new admin
        if ($request->_company->emailTemplateStatus(6)) {
            $userClone = clone(auth()->user());
            $userClone->email = EmailTemplateRecipients::where('company_id', $request->_company->id)
                ->where('email_template', 6)
                ->pluck('recipient')->toArray();
            if (isset($userClone->email)) {
                $userClone->notify(new NewReviewSubmitted( $request, $review ));
            }
        }

    	return back();

    }

    /**
     * List all reviews
     * @return
     */
    public function userReviews (Request $request) {

        $reviews = UserReviews::where('company_id', $request->_company->id)->orderBy('created_at', 'DESC')->paginate(15);

        return view ('reviews.index2')
            ->with(compact('reviews'));

    }

    /**
     * Get create review form
     * @return
     */
    public function submit (Request $request) {

        $reviews = Reviews::where('company_id', $request->_company->id)->get();
        return view ('reviews.create2')
        ->with(compact('reviews'));

    }

    /**
     * Process review submission
     * @return
     */
    public function postSubmit (Request $request) {

        $rules = [
            'review_url'=>'required_without_all:review_screenshot_blob|nullable|regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
            'review_screenshot_blob'=>'required_without_all:review_url',
        ];

        $messages = [
            'review_url.required_without_all' => 'Please enter the review url',
            'review_screenshot_blob.required_without_all' => 'Please upload a screenshot.',
            'review_screenshot_blob.required' => 'The review screenshot is required.',
        ];

        $validator = Validator::make($request->input(), $rules, $messages);

        if ( $validator->fails() ) {
            return redirect()->back()->withInput()
                ->with(['errors'=>$validator->errors()]);
        }

        // CREATE REVIEW        
        $user_id = $request->get('as_member') ?: auth()->user()->id;
        $review = UserReviews::firstOrCreate([
            'company_id' => $request->_company->id,
            'url'=> $request-> input('review_url'),
            'screenshot'=> $request->file('review_screenshot') ? $request->file('review_screenshot')->store('reviews-screenshots') : null,
            'user_id' => $user_id,
        ]);


        // Notify new admin
        if ($request->_company->emailTemplateStatus(8)) {
            $userClone = clone(auth()->user());
            $userClone->email = EmailTemplateRecipients::where('company_id', $request->_company->id)
                ->where('email_template', 8)
                ->pluck('recipient')->toArray();
            if (isset($userClone->email)) {
                $userClone->notify(new NewReviewAdmin( $request, $review ));
            }
        }

        // Notify user that a review has been received
        if ($request->_company->emailTemplateStatus(8)) {
            auth()->user()->notify(new NewReviewSubmitted( $request, $review ));
        }

        return Redirect::route('user-reviews', ['success' => true]);

    }

}
