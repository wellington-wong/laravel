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
            if (isset($q_members)) {
                $members = $request->_company->members()->where(function ($q) use ($q_members) {
                    $q->where(\DB::raw('lower(users.first_name)'), 'LIKE', '%' . $q_members . '%');
                    $q->orWhere(\DB::raw('lower(users.last_name)'), 'LIKE', '%' . $q_members . '%');
                    $q->orWhere(\DB::raw('lower(users.name)'), 'LIKE', '%' . $q_members . '%'); 
                    $q->orWhere(\DB::raw('lower(users.email)'), 'LIKE', '%' . $q_members . '%'); 
                })->paginate(15);
            } else {
                $members = $request->_company->members()->paginate(15);
            }

            if (isset($q_admins)) {
                $admins = $request->_company->membersByRole(['admin', 'superadmin'])->where(function ($q) use ($q_admins) {
                    $q->where(\DB::raw('lower(users.first_name)'), 'LIKE', '%' . $q_admins . '%');
                    $q->orWhere(\DB::raw('lower(users.last_name)'), 'LIKE', '%' . $q_admins . '%');
                    $q->orWhere(\DB::raw('lower(users.name)'), 'LIKE', '%' . $q_admins . '%'); 
                    $q->orWhere(\DB::raw('lower(users.email)'), 'LIKE', '%' . $q_admins . '%'); 
                })->paginate(15);
            } else {
                $admins = $request->_company->membersByRole(['admin', 'superadmin'])
                    ->paginate(15);
            }
        }
        

        return view('members.index')
        ->with(compact('members', 'admins'));
    }


    public function create(Request $request)
    {
        return view('members.create');
    }

    public function delete(Request $request, $id)
    {
        // Delete user, user's phone and address
        $deleteUser = User::find($id);
        $deleteUser->phones()->delete();
        $deleteUser->addresses()->delete();
        $deleteUser->delete();
        return;
    }
}
