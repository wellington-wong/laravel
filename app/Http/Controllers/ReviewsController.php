<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReviewsController extends Controller
{

    public function getIndex (Request $request) {

    	return view ('reviews.index');

    }

}
