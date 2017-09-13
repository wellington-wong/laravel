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
        $admins = collect(new User);

        $q_admins = $request->input('q-admins');
        $q_members = $request->input('q-members');

        if ( 'app' != $request->current_subdomain ) {
            if (isset($q_admins)) {
                $members = $request->_company->members()->where(function ($q){

                })->paginate(15);
            } else {
                $members = $request->_company->members()->paginate(15);
            }

            $admins = $request->_company->membersByRole(['admin', 'superadmin'])
                ->paginate(15);
        }
        //dd($admins);

        return view('members.index')
        ->with(compact('members', 'admins'));
    }


    public function create(Request $request)
    {
        return view('members.create');
    }
}
