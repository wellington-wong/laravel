<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReferralValues extends Model
{

	protected $table = 'referral_values';

    protected $fillable = ['name', 'value'];
    public $timestamps = true;
}
