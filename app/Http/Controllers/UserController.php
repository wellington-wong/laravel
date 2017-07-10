<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Phone;
use App\Address;
use App\Referral;
use Illuminate\Support\Facades\Validator;

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
        $sortc = array_fill_keys(['created_at', 'id', 'user_id', 'referred', 'status'], null);
        $sort = array_fill_keys(['created_at', 'id', 'user_id', 'referred', 'status'], 'desc');

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
        if (count($request->all())) {
            $param = $referrals->getParams();
            $referrals = $request->user()->filterSortReferralSubmissions()->paginate(15);
        } else {
            $referrals = $request->user()->referrals()->orderBy('created_at', 'desc')->paginate(15);
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
        return view('user.create');
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
            'profile_image'=>isset($profile_image) ? $profile_image : null
        ]);

        //ADD PHONE
        $phone = $user->addDefaultPhone($request);
        //ADD ADDRESS
        $address = $user->addDefaultAddress($request);


        return redirect(route('view-user', $user->id));
    }
}
