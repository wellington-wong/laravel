<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProgramOptionsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     *	@return
     */
    public function users( Request $request )
    {
    	return;
    }
}
