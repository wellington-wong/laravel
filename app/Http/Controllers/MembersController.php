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
        // Change user's password
        if ($request->get('user_new_password') != $request->get('user_new_password_confirmation')) { return 'Password Mismatch'; }
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

    /**
     * Export members
     * @param $request
     * @return
     */
    public function exportMembers (Request $request)
    {

        // Get all users
        $membersArray = $request->_company->members()->with('addresses', 'phones')->skip(1)->limit(1)->get()->toArray();

        // Flatten array
        foreach ($membersArray as $key => $member) {
            if (isset($membersArray[$key]['addresses'][0])) {
                $membersArray[$key] =  array_merge ($membersArray[$key], $membersArray[$key]['addresses'][0]);
            }
            unset($membersArray[$key]['addresses']);
            if (isset($membersArray[$key]['phones'][0])) {
                $membersArray[$key] =  array_merge ($membersArray[$key], $membersArray[$key]['phones'][0]);
            }
            unset($membersArray[$key]['phones']);
            unset($membersArray[$key]['pivot']);
        }

        $unsetFields = [
            'provider', 'provider_id', 'stripe_id', 'card_brand', 
            'card_last_four', 'trial_ends_at', 'deleted_at', 'lob_verified', 
            'lob_response', 'lob_adr_id', 'country', 'country_code', 'type',
            'company_id', 'profile_image', 'created_at', 'updated_at'
        ];

        // Unset internal use fields
        foreach ($membersArray as $keyParent => $member) {
            foreach ($member as $keyChild => $filteredMemberFields) {
                if (in_array($keyChild, $unsetFields)) {
                    unset($membersArray[$keyParent][$keyChild]);
                }
            }
        }

        $membersArray = isset($membersArray) ? $membersArray : [];

        // Load users to csv exporter
        \Excel::create('Referrals', function($excel) use ($membersArray) {
            $excel->sheet('Members', function($sheet) use ($membersArray) {
                $sheet->fromArray($membersArray);
            });
        })->export('xls');

        return;
    }

    /**
     * Export members fields
     * @param $request
     * @return
     */
    public function exportMembersFields (Request $request)
    {

        $userCols = \Schema::getColumnListing('users');
        $addressCols = \Schema::getColumnListing('addresses');
        $phoneCols = \Schema::getColumnListing('phones');

        $columns = array_merge($userCols, $addressCols, $phoneCols);

        $unsetFields = [
            'id', 'provider', 'provider_id', 'stripe_id', 'card_brand', 
            'card_last_four', 'trial_ends_at', 'deleted_at', 'lob_verified', 
            'lob_response', 'lob_adr_id', 'country', 'country_code', 'type',
            'company_id', 'profile_image', 'created_at', 'updated_at'
        ];

        // Unset internal use fields
        foreach ($columns as $key => $column) {
            if (in_array($key, $unsetFields)) {
                unset($columns[$key]);
            }
         }
        dd($columns);

    }

}
