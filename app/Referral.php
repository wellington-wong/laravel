<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{

    const STATUS_SUBMITTED      = 1;
    const STATUS_APPROVED       = 3;
    const STATUS_REWARD_SENT    = 7;
    const STATUS_DENIED         = 9;

    protected $table = 'referrals';
}
