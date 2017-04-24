<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'companies';

    protected $fillable = ['company_name', 'subdomain', 'address_id', 'owner_id'];

    public function owner() {
        return $this->hasOne(User::class);
    }

    public function address() {
        return $this->hasOne(Address::class);
    }
}
