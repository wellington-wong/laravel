<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Phone;
use App\Address;
use App\Referral;
use App\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show manage account.
     *
     * @return view
     */
    public function getView( Request $request, $id )
    {    

        $referrals = new Referral();

        // Get constants
        $referralStatus = new \ReflectionClass(new Referral());
        $referralStatus = $referralStatus->getConstants();
        $referralStatus = array_splice($referralStatus, 0, count($referralStatus) -2);

        // Configure sort class
        $column = $request->get('column');
        $sortc = array_fill_keys(['created_at', 'id', 'referrer_id', 'referred', 'status'], null);
        $sort = array_fill_keys(['created_at', 'id', 'referrer_id', 'referred', 'status'], 'desc');

        // Configure sort links
        $sort[$column] = 'desc';
        $sortClass = '';
        switch ($request->get('sort')) {
            case ('desc'):
                $sort[$column] = 'asc';
                $sortClass = '-desc';
                break;
            case ('asc'):
                $sort[$column] = '';
                $sortClass = '-asc';
                break;
        }
        $sortc[$column] = $sortClass;        

        // Get query parameters
        $param = [];
        if (count($request->all()) > 1) {
            $param = $referrals->getParams();
            $referrals = $request->user()->filterSortReferralSubmissions(null, $id)->paginate(15);
        } else {
            $referrals = $request->user()->userReferrals($id)->orderBy('created_at', 'desc')->paginate(15);
        }

    	$user = User::find($id);
        return view('user.view')->with(compact('user'))
        ->with(compact('referrals', 'sort' ,'sortc', 'referralStatus', 'param'));
    }

    /**
     * Create user account.
     *
     * @return view
     */
    public function create( Request $request )
    {   
        $userRoles = Role::pluck('name', 'id')->toArray();
        return view('user.create')->with(compact('userRoles'));
    }

    /**
     * Save user account.
     *
     * @return view
     */
    public function postCreate( Request $request )
    {

        $rules = [
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'unique:users|required|email',
            'phone'=>'required|phone:US',
            'address'=>'unique:addresses|max:100',
            'address2'=>'max:25',
            'city'=>'required',
            'state'=>'required|alpha|max:2',
            'zip'=>'required|digits:5',
            //'profile_blob' => 'required',
        ];

        $validator = Validator::make($request->input(), $rules);

        if ( $validator->fails() ) {
            return redirect()->back()->withInput()
                ->with(['errors'=>$validator->errors()]);
        }

        if ( $request->file('profile') ) {
            $profile_image = $request->file('profile')->store('profile-images');
        }

        $user = User::firstOrCreate([
            'email'=>$request->input('email'),
            'name'=>$request->input('first_name') . ' ' . $request->input('last_name'),
            'first_name'=>$request->input('first_name'),
            'last_name'=>$request->input('last_name'),
            'password'=> Hash::make(str_random(8)),
            'profile_image'=>isset($profile_image) ? $profile_image : null
        ]);

        //ADD PHONE
        $phone = $user->addDefaultPhone($request);
        //ADD ADDRESS
        $address = $user->addDefaultAddress($request);

        // Attach role to user
        if ($request->has('user_role') && auth()->user()->hasRole('globalAdmin')) {
            $role = Role::find($request->get('user_role'));
        } else {
            $role = Role::where('name', 'member')->first();
        }        
        $user->attachRole($role);

        return redirect(route('view-user', $user->id))->with('success', ['User ' . $user->name . ' has been successfully created.']);
    }

    public function update ( Request $request, $id ){        

        $rules = [
            'first_name'=>'required',
            'last_name'=>'required',
            'phone'=>'required|phone:US',
            //'profile_blob' => 'required',
        ];

        $validator = Validator::make($request->input(), $rules);

        if ( $validator->fails() ) {
            return redirect()->back()->withInput()
                ->with(['errors'=>$validator->errors()]);
        }

        $user = User::find($id);


        if ( !$user->phone->isEmpty() ) {
            $user->updateDefaultPhone($request);
        } else {
            $user->addDefaultPhone($request);
        }

        if ( !$user->address->isEmpty() ) {
            $user->updateDefaultAddress($request);
        } else {
            $user->addDefaultAddress($request);
        }
        
        $user->update( $request->all() );

        return back()->with('success', ['Account successfully updated']);
    }
}
