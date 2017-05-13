<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class MembersController extends Controller
{
	public function getIndex ()
	{
		
        return view('members.index');
	}

    public function members(Request $request, User $user, $sid)
    {
        return $user->getMembers($sid);
    }
}
