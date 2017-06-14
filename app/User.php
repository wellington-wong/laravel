<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use App\Role;
use App\RoleUser;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait;
    use Billable;

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
        return $this->hasMany( Referral::class, 'referrer_id', 'id' );
    }

    public function referred_companies() {
        return $this->belongsToMany(Company::class, 'user_referred');
    }

    /*
     * adds a default phone number to a user from a request
     */
    public function addDefaultPhone( \Illuminate\Http\Request $request ) {
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

    public function addDefaultAddress( \Illuminate\Http\Request $request ) {
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

    public static function getUsersBySubdomain() {
        return User::join('companies', 'owner_id', 'users.id')
        ->orderBy('subdomain', 'desc')
        ->paginate(15);
    }

}
