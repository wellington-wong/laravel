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
            if ( !empty($members = Role::where('name','member')->first()) && !empty($members->users()) ) {
                $members = $members->users()->get();
            } else {
                $members = [];                
            }
            return view('members.index')
            ->with(compact('members'));
        }


    public function members(Request $request, User $user, $sid)
    {
        return $user->getMembers($sid);
    }
}
