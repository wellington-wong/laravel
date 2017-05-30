<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\DB;

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

        $request = request();

        $column = $request->has('column') ? $request->get('column') : null;
        $sort = $request->has('sort') ? $request->get('sort') : null;

        // Change query when sorting and filtering.
        $referrals = $this->select('referrals.*')
        ->where('referrer_id', auth()->user()->id)
        ->join('users', 'users.id', 'referrals.user_id');

        if (isset($column) && isset($sort)) {
            $referrals->orderBy('users.'.$column, $sort);
        }

       $referrals = $referrals->paginate(15);
        return $referrals;
    }

    /**
     * Update Referrals
     * @return
     */
    public function updateReferral() {

        $request = request();

        $referral = $this->find($request->get('id'));
        $referral->status = $request->get('status');
        $referral->save();

        return;
    }



}
