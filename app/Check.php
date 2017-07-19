<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Check extends Model
{
    protected $table = 'checks';

    public function referrals() {
        $this->belongsToMany( Referral::class );
    }
}
