<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Company;
use App\ReferralForms;
use App\RewardSetting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use Illuminate\Auth\Events\Registered;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Notifications\NewMember;
use App\Notifications\NewMemberAdmin;
use App\EmailTemplateRecipients;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    public function showRegistrationSimple()
    {
        return view('auth.register_simple');
    }

    public function showRegistrationForm( Request $request )
    {
        if ($request->_company->subdomain != 'app') {
            return view('company.register');
        } else {
            if ( !is_null( $request->_company ) ) {
                return $this->showRegistrationSimple();
            }
            return view('auth.register');
        }
    }



    public function register(Request $request)
    {
        //$this->validator($request->all())->validate();

        $rules = [
            'first_name'=>'required',
            'last_name'=>'required',
            'phone'=>'required|phone:US',
            'email'=>'unique:users|required|email',
            'password' => 'required|min:6|confirmed',
            //'profile_blob' => 'required',
        ];

        $request->merge([
            'name' => $request->get('first_name') && $request->get('last_name') ? $request->get('first_name') . ' ' . $request->get('last_name') : '',
        ]);

        $validator = Validator::make($request->input(), $rules);

        if ( $validator->fails() ) {
            return redirect()->back()->withInput()
                ->with(['errors'=>$validator->errors()]);
        }

        event(new Registered($user = $this->create($request)));

        $this->guard()->login($user);

        //ADD PHONE
        $phone = $user->addDefaultPhone($request);
        //ADD ADDRESS
        $address = $user->addDefaultAddress($request);

        // Notify new user and admin
        if ($request->_company->emailTemplateStatus(2)) {
            $user->notify(new NewMember( $request, $user ));
        }

        // Notify new admin
        if ($request->_company->emailTemplateStatus(6)) {
            $userClone = clone($user);
            $userClone->email = EmailTemplateRecipients::where('company_id', $request->_company->id)
                ->where('email_template', 6)
                ->pluck('recipient')->toArray();
            if (isset($userClone->email)) {
                $userClone->notify(new NewMemberAdmin( $request, $user ));
            }
        }

        return $this->registered($request, $user)
                        ?: redirect(route('referral-create'))->with('success', ['Your account has been created successfully, you can start referring by filling up the form below.']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }


    
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create( $request )
    {
        $data = $request->all();
        $user = User::create([
            'name' => $data['name'],
            'first_name' => isset($data['first_name']) ? $data['first_name'] : null,
            'last_name' => isset($data['last_name']) ? $data['last_name'] : null,
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'how_did_you_hear_about_us' => $data['how_did_you_hear'],
        ]);
        if ( !is_null($request->subdomain_id) ) {
            $user->referred_companies()->attach($request->subdomain_id);
        }
        return $user;
    }

    /**
     * Redirect the user to the OAuth Provider.
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from provider.  Check if the user already exists in our
     * database by looking up their provider_id in the database.
     * If the user exists, log them in. Otherwise, create a new user then log them in. After that
     * redirect them to the authenticated users homepage.
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->user();

        $authUser = $this->findOrCreateUser($user, $provider);
        Auth::login($authUser, true);
        return redirect($this->redirectTo);
    }

    /**
     * If a user has registered before using social auth, return the user
     * else, create a new user object.
     * @param  $user Socialite user object
     * @param $provider Social auth provider
     * @return  User
     */
    public function findOrCreateUser($user, $provider)
    {
        $authUser = User::where('provider_id', $user->id)->first();
        if ($authUser) {
            return $authUser;
        }
        return User::create([
            'name'     => $user->name,
            'email'    => $user->email,
            'provider' => $provider,
            'provider_id' => $user->id
        ]);
    }

    /**
     * Process simple register with multistep registration
     * @return
     */
    public function postRegistrationSimple( Request $request )
    {
            $rules = [
                'first_name'=>'required',
                'last_name'=>'required',
                'phone'=>'required|phone:US',
                'email'=>'unique:users|required|email',
                'password' => 'required|min:6|confirmed',
                'company_name'=>'required',
                'subdomain'=>'required|unique:companies|not_in:app,www',
                'company_phone'=>'required|phone:LENIENT,AUTO,US',
                'company_email'=>'required|unique:companies,email|email',
                'business_type'=>'required',
                'company_address_1'=>'required|max:100',
                'company_address_2'=>'max:25',
                'company_city'=>'required',
                'state'=>'required|max:2',
                'company_zip'=>'required|digits:5',
                'reward_title'=>'required',
                'reward_kind'=>'required',
                'reward_send'=>'required',
                'leader_board'=>'required',
                'approved_referral_ratio'=>'required',
                'reward_referral_ratio'=>'required',
                'referral_form_json'=>'required',
            ];

            $validator = Validator::make($request->input(), $rules);

            if ( $validator->fails() ) {
                return back()->with(['errors' => $validator->errors()]);
            }

            // Create User
            $user = User::firstOrCreate([
                'email'=>$request->input('email'),
                'name'=>$request->input('first_name') . ' ' . $request->input('last_name'),
                'first_name'=>$request->input('first_name'),
                'last_name'=>$request->input('last_name'),
                'password'=> Hash::make($request->input('password'))
            ]);
            //ADD PHONE
            $phone = $user->addDefaultPhone($request);
            //ADD ADDRESS
            $address = $user->addDefaultAddress($request);

            // Create Company            
            $request->merge([
                'owner_id'=>$user->id,
                'address' =>$request->input('company_address_1'),
                'address2' =>$request->input('company_address_2'),
                'city' =>$request->input('company_city'),
                'state' =>$request->input('state'),
                'zip' =>$request->input('company_zip'),
                'email' =>$request->input('company_email'),
                'type' =>$request->input('business_type'),
            ]);
            $company = $user->companies()
                ->create( $request->only('owner_id', 'company_name', 'subdomain', 'type', 'email') );
            $address = $company->address()->create(
                $request->only('address', 'address2', 'city', 'state', 'zip')
            );

            $request->merge(['country'=>'']);
            $request->merge(['country_code'=>'']);
            $phone = $company->phone()->create(
                $request->only('country', 'country_code', 'phone')
            );
            // Add address to company
            $company->addresses()->updateExistingPivot($address->id, ['default'=>1]);
            // Add phone to company
            $company->phones()->updateExistingPivot($phone->id, ['default'=>1]);

            // Create reward setting
            RewardSetting::firstOrCreate([
                'company_id' => $company->id,
                'title' => $request->input('reward_title'),
                'reward_kind' => $request->input('reward_kind'),
                'reward_send' => $request->input('reward_send'),
                'leaderboard' => $request->input('leader_board'),
                'reward_ratio' => serialize([$request->input('approved_referral_ratio'), $request->input('reward_referral_ratio')])
            ]);

            // Create generated referral form
            ReferralForms::firstOrCreate([
                'company_id' => $company->id,
                'form_name' => $company->company_name . ' Referral Form',
                'raw_form_json' => $request->input('referral_form_json')                
            ]);

            // Automatically login created user
            Auth::loginUsingId($user->id, true);

            // Redirect to created company subdomain and show success message
            return redirect( 'https://' . $company->subdomain . '.' . config('app.domain') )
                ->with('success', ['Congratulations! your company has been successfully created.']);
    }

    /**
     * Validate registration details via Ajax
     * @return
     */
    public function ajaxValidate( Request $request )
    {

        $type = $request->get('type');

        switch ( $type ) {
            case ('user'):
                $rules = [
                    'first_name'=>'required',
                    'last_name'=>'required',
                    'phone'=>'required|phone:US',
                    'email'=>'unique:users|required|email',
                    'password' => 'required|min:6|confirmed',
                ];
                break;
            case ('company'):                
                $rules = [
                    'company_name'=>'required',
                    'subdomain'=>'required|unique:companies|not_in:app,www',
                    'company_phone'=>'required|phone:LENIENT,AUTO,US',
                    'company_email'=>'required|unique:companies,email|email',
                    'business_type'=>'required',
                    'company_address_1'=>'required|max:100',
                    'company_address_2'=>'max:25',
                    'company_city'=>'required',
                    'state'=>'required|max:2',
                    'company_zip'=>'required|digits:5',
                ];
                break;
            case ('reward_info'):                
                $rules = [
                    'reward_title'=>'required',
                    'reward_kind'=>'required',
                    'reward_send'=>'required',
                    'leader_board'=>'required',
                    'approved_referral_ratio'=>'required',
                    'reward_referral_ratio'=>'required',
                ];
                break;
        }

        if ($request->has('type')) {
            $validator = Validator::make($request->input(), $rules);

            if ( $validator->fails() ) {
                return $validator->errors();
            }               
        } 

        return 'success';
    }

}
