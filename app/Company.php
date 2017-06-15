<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
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
        return $this->hasManyThrough( User::class, RoleUser::class , 'company_id', 'id' );
    }


}
