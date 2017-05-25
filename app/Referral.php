<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{

    const STATUS_SUBMITTED      = 1;
    const STATUS_APPROVED       = 2;
    const STATUS_REWARD_SENT    = 3;
    const STATUS_DENIED         = 4;

    static $status = [
        self::STATUS_SUBMITTED => 'Submitted',
        self::STATUS_APPROVED => 'Approved',
        self::STATUS_REWARD_SENT => 'Reward Sent',
        self::STATUS_DENIED => 'Denied'
    ];

    protected $table = 'referrals';

    public function referrer() {
        return $this->hasOne(User::class, 'id', 'referrer_id');
    }

    public function referred() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * Sort Referrals
     * @return
     */
    public function sortReferrals() {


        if ($request->has('sort')) {
            $referrals->orderBy($sort);
        }

        // Change query when sorting by Submitted and Referrer's name.
        return Referral::where('referrer_id', auth()->user()->id)
        ->join('users', 'users.id', 'referrals.referrer_id')->get();
    }

}
