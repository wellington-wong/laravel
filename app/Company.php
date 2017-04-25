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


}
