<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;

class MembersController extends Controller
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

	public function getIndex ()
	{
        
            $members = auth()->user()->getMembers();  

            return view('members.index')
            ->with(compact('members'));
        }


    public function members(Request $request, User $user, $sid)
    {
        return $user->getMember($sid);
    }
}
