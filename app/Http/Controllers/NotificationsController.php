<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationsController extends Controller
{

    public function __construct() 
    {
    	$this->middleware('auth');
    }


    /**
     * Mark notification as read
     */
    public function markAsRead(Request $request, $id, $nid)
    {

    	$notification = auth()->user()->notifications()->findOrFail($nid);
	$notification->markAsRead();
	return 'success';

    }

}
