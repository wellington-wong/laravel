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

	public function getIndex ( Request $request )
	{

        $members = collect(new User);
        if ( 'app' != $request->current_subdomain ) {
            $members = $request->_company->members()->paginate(15);
            $admins = $request->_company->membersByRole(['admin', 'superadmin'])
                ->paginate(15);
        }
        //dd($admins);

        return view('members.index')
        ->with(compact('members', 'admins'));
    }


    public function members(Request $request, User $user, $sid)
    {
        return $user->getMember($sid);
    }
}
