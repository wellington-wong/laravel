<?php

namespace App;

use App\Role;
use App\RoleUser;
use Illuminate\Support\Facades\DB;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Laravel\Cashier\Billable;
use Cmgmyr\Messenger\Traits\Messagable;
use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait;
    use Billable;
    use Messagable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'first_name', 'last_name', 'email', 'password', 'provider', 'provider_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * Entrust overrides
     */
    public function allRoles() {
        return $this->belongsToMany(config('entrust.role'), config('entrust.role_user_table'),
            config('entrust.user_foreign_key'), config('entrust.role_foreign_key'));
    }

    public function roles( Company $company = null )
    {
        if ( is_null($company) ) {
            $company_id = config('company_id');
        } else {
            $company_id = $company->id;
        }
        return $this->belongsToMany(config('entrust.role'), config('entrust.role_user_table'),
            config('entrust.user_foreign_key'), config('entrust.role_foreign_key'))
            ->where( function($q) use ($company_id) {
                $q->where( 'company_id', $company_id )
                    ->orWhere('role_id', DB::raw(4));
            });
    }

    public function hasAnyRole() {
        return $this->roles()->count() > 0;
    }

    /**
     * Alias to eloquent many-to-many relation's attach() method.
     *
     * @param mixed $role
     */
    public function attachRole( $role, Company $company = null )
    {
        if(is_object($role)) {
            $role = $role->getKey();
        }

        if(is_array($role)) {
            $role = $role['id'];
        }

        if( null == $company ) {
            $company_id = config('company_id');
        } else {
            $company_id = $company->id;
        }

        //$this->roles()->attach($role);
        $this->roles()->attach($role, ['company_id'=>$company_id ]);
    }

    public function detachRole( $role, Company $company = null )
    {
        if (is_object($role)) {
            $role = $role->getKey();
        }

        if (is_array($role)) {
            $role = $role['id'];
        }

        if( null == $company ) {
            $company_id = config('company_id');
        } else {
            $company_id = $company->id;
        }

        $r = RoleUser::where( 'role_id', $role )
            ->where( 'user_id', $this->id )
            ->where( 'company_id', $company_id );
        $r->delete();
    }

    /*
     * Entrust Extension
     */
    public function getRoleCompanies( $role )
    {
        if( !is_array($role) ) { $role = [$role]; }
        $role_ids = $this->allRoles()->whereIn('name', $role)->pluck('id');

        $companies = Company::leftJoin('role_user', 'role_user.company_id', 'companies.id')
            ->whereIn('role_user.role_id', $role_ids)
            ->where('role_user.user_id', $this->id)->get();

        return $companies;
    }



    public function getDisplayNameAttribute() {
        if ( !is_null($this->name) ) {
            return $this->name;
        } else {
            return $this->first_name . " " . $this->last_name;
        }
    }


    public function companies() {
        return $this->hasMany(Company::class, 'owner_id', 'id');
    }

    public function addresses() {
        return $this->belongsToMany(Address::class, 'user_address');
    }

    public function address() {
        return $this->addresses()->where('default', 1);
    }

    public function phones() {
        return $this->belongsToMany(Phone::class, 'user_phone');
    }

    public function phone() {
        return $this->phones()->where('default', 1);
    }

    public function referrals() {
        $request = request();
        return $this->hasMany( ReferralSubmissions::class, 'referrer_id', 'id' )->where('company_id', $request->_company->id);
    }

    public function referred_companies() {
        return $this->belongsToMany(Company::class, 'user_referred');
    }

    /*
     * adds a default phone number to a user from a request
     */
    public function addDefaultPhone() {

        $request = request();
        if ( null == $request->input('phone')) {
            return null;
        } else {
            $request->merge(['phone'=>Phone::sanitize($request->input('phone'))]);
            $request->merge(['number'=>Phone::sanitize($request->input('phone'))]);
            $request->merge(['country'=>'']);
            $request->merge(['country_code'=>'']);
        }
        $input = [];
        $phone = new Phone();
        foreach ($phone->getFillable() as $c) {
            if ( isset($request->$c) ) {
                $input[] = $c;
            }
        }
        $phone = $this->phone()->create(
            $request->only($input)
        );
        $this->phone()->updateExistingPivot($phone->id, ['default'=>1]);
        return $phone;
    }

    /*
     * update default phone number to a user from a request
     */
    public function updateDefaultPhone() {

        $request = request();
        if ( null == $request->input('phone')) {
            return null;
        } else {
            $request->merge(['phone'=>Phone::sanitize($request->input('phone'))]);
            $request->merge(['number'=>Phone::sanitize($request->input('phone'))]);
            $request->merge(['country'=>'']);
            $request->merge(['country_code'=>'']);
        }
        $input = [];
        $phone = new Phone();
        foreach ($phone->getFillable() as $c) {
            if ( isset($request->$c) ) {
                $input[] = $c;
            }
        }
        $phone = $this->phones()->first()->update(
            $request->only($input)
        );
        $this->phone()->updateExistingPivot($this->phones()->first()->id, ['default'=>1]);
        return $phone;
    }

    public function addDefaultAddress() {

        $request = request();
        if ( null == $request->input('address')) {
            return null;
        }
        $input = [];
        $address = new Address();
        foreach ($address->getFillable() as $c) {
            if ( isset($request->$c) ) {
                $input[] = $c;
            }
        }
        $address = $this->address()->create(
            $request->only($input)
        );
        $this->address()->updateExistingPivot($address->id, ['default'=>1]);
        return $address;
    }

    /*
     * update default address to a user from a request
     */
    public function updateDefaultAddress() {

        $request = request();
        if ( null == $request->input('address')) {
            return null;
        }

        $input = [];
        $address = new Address();
        foreach ($address->getFillable() as $c) {
            $input[] = $c;
        }
        $address = $this->address()->first()->update(
            $request->only($input)
        );
        $this->address()->updateExistingPivot($this->address()->first()->id, ['default'=>1]);
        return $address;
    }

    public static function getMembers() {

        // Get users with member and empty roles.
        $members = User::paginate(15);
        $roles = Role::where('name', '<>' ,'member')->get();
        $roles->map(function ($role) use ($members) {
            $role->users()->get()->map(function($user) use ($members) {
                $members->forget($user->id);
            });
        });

        return $members;
    }


    public static function getMember($id) {
        return  Role::where('name','member')->first()->users()->pluck('id', 'name');
    }

    public static function getUsersBySubdomain(  ) {
        return User::join('companies', 'owner_id', 'users.id')
        ->orderBy('subdomain', 'desc')
        ->paginate(15);
    }

    public function updateProfile() {

        $request = request();
        foreach ($this->getFillable() as $c) {
            if ( isset($request->$c) ) {
                $input[] = $c;
            }
        }
        return $this->update(
            $request->only($input)
        );
    }

    /**
     * Sort Referrals
     * @return
     */
    public function filterSortReferralSubmissions($defaultSort = 'created_at') {

        $request = request();

        // Get sort and filter
        $column = $request->has('column') ? $request->get('column') : null;
        $sort = $request->has('sort') ? $request->get('sort') : null;
        $status = $request->has('status') ? $request->get('status') : null;
        $q = strtolower($request->has('q') ? $request->get('q') : null);

        // Get date range
        $daterange = explode('|', $request->get('daterange'));
        $datarangeFrom = isset($daterange[0]) && (bool)strtotime($daterange[0]) ? $daterange[0] : null;
        $datarangeTo = isset($daterange[1]) && (bool)strtotime($daterange[1]) ? $daterange[1] : null;

        // Change query when sorting and filtering.
        $referrals = $this->referrals();

        if ((auth()->user()->hasRole('member'))) {
            $referrals->where('referrer_id', auth()->user()->id);
        }

        if (isset($status)) {
            $referrals->where('status', $status);
        }

        if (isset($datarangeFrom) && isset($datarangeTo)) {
            $referrals->whereBetween('created_at', [Carbon::parse($datarangeFrom)->toDateTimeString(), Carbon::parse($datarangeTo)->addDay()->toDateTimeString()]);
        }

        switch ($column) {
            case ('referred'):
                $referrals->orderBy('id', $sort);
                break;        
            case ('created_at'):
                $referrals->orderBy($column, $sort);
                break;
            case ('id' || 'user_id' || 'status'):
                $referrals->orderBy($column, $sort);
                break;
            default:
                $referrals->orderBy($defaultSort, 'desc');
                break;
        }
        
        return $referrals;
    }

}
