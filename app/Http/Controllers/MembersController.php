<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Hash;

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
        
        $allRoles = Role::pluck('name', 'id');

        return view('members.index')
        ->with(compact('members', 'admins', 'allRoles'));
    }

    /**
     * Create a new controller instance.
     *
     * @return
     */
    public function create(Request $request)
    {
        return view('members.create');
    }

    /**
     * Change user role
     *
     * @return
     */
    public function changeRole(Request $request, $id)
    {

        if ($request->input('role_id') && $request->input('role_id_new')) {
            $changeUserRole = User::find($id);
            $changeUserRole->detachRole(Role::find($request->input('role_id')));
            return $changeUserRole->attachRole(Role::find($request->input('role_id_new')));
        } 

        return;
    }

    /**
     * Change user password
     *
     * @return
     */
    public function changePassword(Request $request, $id)
    {
        // Delete user, user's phone and address
        $user = User::find($id);
        $user->password = Hash::make($request->get('user_new_password'));
        $user->save();

        return;
    }

    /**
     * Delete user
     *
     * @return
     */
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
