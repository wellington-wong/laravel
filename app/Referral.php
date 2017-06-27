<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\DB;
use Carbon\Carbon;

class Referral extends Model
{
    use \Venturecraft\Revisionable\RevisionableTrait;

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
    public function filterSortReferrals($defaultSort = 'referrals.created_at') {

        $request = request();

        // Get sort and filter
        $column = $request->has('column') ? $request->get('column') : null;
        $sort = $request->has('sort') ? $request->get('sort') : null;
        $status = $request->has('status') ? $request->get('status') : null;
        $q = strtolower($request->has('q') ? $request->get('q') : null);

        // Get date range
        $daterange = explode('|', $request->get('daterange'));
        $datarangeFrom = isset($daterange[0]) && (bool)strtotime($daterange[0]) ? $daterange[0] : null;
        $datarangeTo = isset($daterange[1]) && (bool)strtotime($daterange[1]) ? $daterange[1] : null;

        // Change query when sorting and filtering.
        $referrals = $this->join('users', 'users.id', 'referrals.user_id');

        if ((auth()->user()->hasRole('member'))) {
            $referrals->where('referrer_id', auth()->user()->id);
        }

        if (isset($status)) {
            $referrals->where('referrals.status', $status);
        }

        if (isset($datarangeFrom) && isset($datarangeTo)) {
            $referrals->whereBetween('users.created_at', [Carbon::parse($datarangeFrom)->toDateTimeString(), Carbon::parse($datarangeTo)->addDay()->toDateTimeString()]);
        }

        if (isset($q)) {
            $referrals->where(function ($query) use ($q) {
                $query->where(\DB::raw('lower(users.first_name)'), 'LIKE', '%' . $q . '%');
                $query->where(\DB::raw('lower(users.last_name)'), 'LIKE', '%' . $q . '%');
                $query->where(\DB::raw('lower(users.name)'), 'LIKE', '%' . $q . '%');
            });
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
            default:
                $referrals->orderBy($defaultSort, 'desc');
                break;
        }

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
        $referral->note = $request->get('note');
        $referral->save();

        $referral_message = '';
        if ($referral->status == self::STATUS_DENIED) {
            $referral_message = 'Your referral has been denied.';
        } else if ($referral->status == self::STATUS_APPROVED) {
            $referral_message = 'Your referral has been approved.';
        } else if ($referral->status == self::STATUS_REWARD_SENT) {
            $referral_message = 'Your reward has been sent.';
        }

        if ($referral->status > 1) {
            $email = $referral->first()->referred->email;
            \Mail::send('emails.notify-referred', array('user' => auth()->user(), 'referral' => $referral,'note' => $referral->note, 'referral_message' => $referral_message, 'referred' => $referral->referred), function ($message) use ($email) {
                $message->from('admin@' . env('APP_URL'), 'Laravel');
                $message->to($email);
            });
        }

        return $referral;
    }

    /**
     * Delete Referrals
     * @return
     */
    public function deleteReferral() {

        $request = request();

        $referral = $this->find($request->get('id'));
        $referral->status = $request->get('status');
        return $referral->delete();
    }

    /**
     * Get referral pending approval and reward
     * @return
     */
    public function getReferralTally() {

        $request = request();

        $pendingReferrals['approval'] = $request->user()->referrals()
            ->where('status', 1)
            ->get();
        $pendingReferrals['reward'] = $request->user()->referrals()
            ->where('status', 2)
            ->get();

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
        $paramVal['sort'] = $request->has('sort') ? $request->get('sort') : null;
        $paramVal['column'] = $request->has('column') ? $request->get('column') : null;
        $paramVal['status'] = $request->has('status') ? $request->get('status') : null;
        $paramVal['q'] = $request->has('q') ? $request->get('q') : null;
        $paramVal['daterange'] = $request->has('daterange') ? $request->get('daterange') : null;

        // Arrange query parameters
        $parameter = new \stdClass();
        foreach (['status', 'q', 'daterange', 'column_sort'] as $param) {
            foreach ($paramVal as $key => $value) {
                if ($key != $param && isset($value)) {          
                    if ($param == 'column_sort') { 
                        if (!in_array($key, ['sort', 'column'])) {
                            $parameter->$param[] = $key . '=' . $value;
                        }
                    } else {
                        $parameter->$param[] = $key . '=' . $value;
                    }
                }
            }
        }
        foreach ($parameter as $key => $p) {
            $parameter->$key = '&' . implode('&', $p);
        }

        return $parameter;
    }


}
