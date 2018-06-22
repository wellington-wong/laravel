<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $table = 'user_address';

    /**
     * Get user address
     * @return
     */
    public function address(){
    	return $this->hasOne(Address::class, 'id', 'address_id');
    }

}
