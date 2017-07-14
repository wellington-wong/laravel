<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cmgmyr\Messenger\Models\Thread;
use App\Thread as ThreadByCompany;
use App\EmailTemplate;
use App\Traits\PhoneTrait;
use App\Traits\AddressTrait;

class Company extends Model
{
    use PhoneTrait;
    use AddressTrait;
    
    protected $table = 'companies';

    protected $fillable = ['company_name', 'subdomain', 'owner_id'];

    public function owner() {
        return $this->hasOne(User::class);
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
        if( !is_array($role) ) { $role = [$role]; }
        $role_ids = Role::whereIn('name', $role)->pluck('id');

        return $this->hasManyThrough( User::class, RoleUser::class , 'company_id', 'id' )
            ->whereIn('role_id', $role_ids);
    }

    public function threads() {
        return $this->hasManyThrough( Thread::class, ThreadByCompany::class, 'company_id', 'id' );
    }

    public function forms() {
        return $this->hasMany( ReferralForms::class );
    }

    public function emailTemplate() {
        return $this->hasOne( EmailTemplate::class );
    }

}
