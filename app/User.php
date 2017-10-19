<?php

namespace App;

use App\Role;
use App\RoleUser;
use App\Referral;
use App\Traits\ReferralTrait;
use Illuminate\Support\Facades\DB;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Laravel\Cashier\Billable;
use Cmgmyr\Messenger\Traits\Messagable;
use Carbon\Carbon;
use App\Traits\PhoneTrait;
use App\Traits\AddressTrait;
use App\Notifications\CreatedUser;

class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait { EntrustUserTrait::restore insteadof SoftDeletes; }
    use Billable;
    use Messagable;
    use PhoneTrait;
    use AddressTrait;
    use ReferralTrait;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'first_name', 'last_name', 'email', 'password', 'provider', 'provider_id', 'profile_image', 'how_did_you_hear_about_us', 'stripe_id', 'card_brand', 'card_last_four'
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
    public function attachRole( Role $role, Company $company = null )
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
        return $this->hasMany( Referral::class, 'referrer_id', 'id' )
            ->where('company_id', $request->_company->id);
    }

    public function userReferrals($user_id) {
        $request = request();
        return Referral::where('referrer_id',  $user_id )
            ->where('company_id', $request->_company->id);
    }

    public function referred() {
        $request = request();
        return $this->hasMany( Referral::class, 'user_id', 'id' )
            ->where('company_id', $request->_company->id);
    }

    public function allReferrals() {
        return $this->hasMany( Referral::class, 'referrer_id', 'id' );
    }

    public function allReferred() {
        return $this->hasMany( Referral::class, 'user_id', 'id' );
    }

    public function referred_companies() {
        return $this->belongsToMany(Company::class, 'user_referred');
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

    public function getName() {
        return isset($this->name) ? $this->name : (isset($this->first_name) || isset($this->last_name) ? $this->first_name . ' ' . $this->last_name : '') ;
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotificationCustom($token)
    {
        $this->notify(new CreatedUser($token));
    }

}
