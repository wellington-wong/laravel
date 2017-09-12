<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cmgmyr\Messenger\Models\Thread;
use App\Thread as ThreadByCompany;
use App\EmailTemplate;
use App\RewardSetting;
use App\Traits\PhoneTrait;
use App\Traits\AddressTrait;
use App\Traits\ReferralTrait;
use App\Referral;

class Company extends Model
{
    use PhoneTrait;
    use AddressTrait;
    use ReferralTrait;
    
    protected $table = 'companies';

    protected $fillable = ['company_name', 'subdomain', 'owner_id', 'email', 'type'];

    const SMALL      = 1;
    const MEDIUM       = 2;
    const ENTERPRISE    = 3;

    static $businessType = [
        self::SMALL => 'Small',
        self::MEDIUM => 'Medium',
        self::ENTERPRISE => 'Enterprise',
    ];

    public function owner() {
        return $this->hasOne(User::class);
    }

    public function referrals() {
        return $this->hasMany(Referral::class);
    }

    public function addresses() {
        return $this->belongsToMany(Address::class, 'company_address');
    }

    public function address() {
        return $this->addresses()->where('default', 1);
    }

    public function phones() {
        return $this->belongsToMany(Phone::class, 'company_phone');
    }

    public function phone() {
        return $this->phones()->where('default', 1);
    }

    public function members() {
        return $this->membersByRole('member');
    }

    public function admins() {
        return $this->membersByRole('admin');
    }

    public function superAdmins() {
        return $this->membersByRole('superadmin');
    }

    public function emailLogs() {
        return $this->hasMany( LogEmail::class )->with('sender', 'recipient');
    }

    public function membersByRole( $role ) {

        $request = app('request');
        $cid = $request->get('cid');
        $q = $request->get('q-' . $cid);

        if( !is_array($role) ) { $role = [$role]; }
        $role_ids = Role::whereIn('name', $role)->pluck('id');

        $query = $this->hasManyThrough( User::class, RoleUser::class , 'company_id', 'id' )
            ->whereIn('role_id', $role_ids);

        if (isset($q)) {
            $query->where(\DB::raw('lower(users.first_name)'), 'LIKE', '%' . $q . '%');
            $query->orWhere(\DB::raw('lower(users.last_name)'), 'LIKE', '%' . $q . '%');
            $query->orWhere(\DB::raw('lower(users.name)'), 'LIKE', '%' . $q . '%');            
            $query->where('role_user.company_id', $cid);
        }

        return  $query;
    }

    public function threads() {
        return $this->hasManyThrough( Thread::class, ThreadByCompany::class, 'company_id', 'id' );
    }

    public function forms() {
        return $this->hasMany( ReferralForms::class );
    }

    public function emailTemplates() {
        return $this->hasMany( EmailTemplate::class );
    }

    public function lob() {
        return $this->hasOne( Lob::class );
    }

    public function rewardSettings() {
        return $this->hasOne( RewardSetting::class );
    }
    

}
