<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notification;
use App\Referral;

class NotificationsController extends Controller
{

    public function __construct() 
    {
    	$this->middleware('auth');
    }

    /**
     * View notification
     */
    public function getNotification(Request $request, $nid)
    {
        
        $notification = Notification::find($nid);
        $data = json_decode($notification->data);
        $referral = isset($data->id) ? Referral::where('id', $data->id)->first() : 0;
        
        return view('notifications.view')->with(compact('notification', 'referral'));

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
