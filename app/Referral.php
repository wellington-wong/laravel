<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\DB;
use Carbon\Carbon;

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
    public function filterSortReferrals($paginate) {

        $request = request();

        // Get sort and filter
        $column = $request->has('column') ? $request->get('column') : null;
        $sort = $request->has('sort') ? $request->get('sort') : null;
        $filterby = $request->has('filterby') ? $request->get('filterby') : null;
        $q = $request->has('q') ? $request->get('q') : null;

        // Get date range
        $daterange = explode('|', $request->get('daterange'));
        $datarangeFrom = isset($daterange[0]) && (bool)strtotime($daterange[0]) ? $daterange[0] : null;
        $datarangeTo = isset($daterange[1]) && (bool)strtotime($daterange[1]) ? $daterange[1] : null;

        // Change query when sorting and filtering.
        $referrals = $this->select('referrals.*')
        ->where('referrer_id', auth()->user()->id)
        ->join('users', 'users.id', 'referrals.user_id');

        if (isset($filterby)) {
            $referrals->where('referrals.status', $filterby);
        }

        if (isset($datarangeFrom) && isset($datarangeTo)) {
            $referrals->whereBetween('users.created_at', [Carbon::parse($datarangeFrom)->toDateTimeString(), Carbon::parse($datarangeTo)->toDateTimeString()]);
        }

        switch ($column) {
            case ('referred'):
                $referrals->orderBy('users.id', $sort);
                break;        
            case ('created_at'):
                $referrals->orderBy('users.'.$column, $sort);
                break;
            case ('id' || 'user_id' || 'status'):
                $referrals->orderBy('referrals.'.$column, $sort);
                break;
        }

        $referrals = $referrals->paginate($paginate);

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

    /**
     * Get referral pending approval and reward
     * @return
     */
    public function getReferralTally() {

        $request = request();

        $pendingReferrals['approval'] = $request->user()->referrals()
            ->where('status', 1)
            ->paginate(0);
        $pendingReferrals['reward'] = $request->user()->referrals()
            ->where('status', 2)
            ->paginate(0);

        return $pendingReferrals;
    }

    /**
     * Get url parameters
     * @return
     */
    public function getParams() {

        $request = request();

        // Get sort and filter
        $paramVal = [];
        $sort = $request->has('sort') ? $request->get('sort') : null;
        $paramVal['column_sort'] = $request->has('column') ? 'sort=' . $sort . '&column=' . $request->get('column') : null;
        $paramVal['filterby'] = $request->has('filterby') ? $request->get('filterby') : null;
        $paramVal['q'] = $request->has('q') ? $request->get('q') : null;
        $paramVal['daterange'] = $request->has('daterange') ? $request->get('daterange') : null;

        // Arrange query parameters
        $parameter = new \stdClass();
        foreach (['column_sort', 'filterby', 'q', 'daterange'] as $param) {
            foreach ($paramVal as $key => $value) {
                if ($key != $param) {
                    $parameter->$param[] = $key . '=' . $value;
                }
            }
        }
        foreach ($parameter as $key => $p) {
            $p = array_filter($p);
            $parameter->$key = implode('&', $p);
        }

        return $parameter;
    }


}
