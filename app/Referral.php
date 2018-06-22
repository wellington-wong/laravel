<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\DB;
use Carbon\Carbon;
use App\Notifications\ReferralVerified;
use App\Notifications\ReferralSent;
use App\Notifications\ReferralDeclined;

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

    public function check() {
        return $this->belongsToMany( Check::class );
    }

    /**
     * Update Referrals
     * @return
     */
    public function updateReferral() {

        $request = request();


        $referral = $this->find($request->get('id'));

        // Disable updating of referral after reward is sent.
        if ($referral->status == 3) {
            return;
        }
        
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

        if (isset($referral->referrer)) {
            switch ($request->get('status')) {
                case (2):
                    if ($request->_company->emailTemplateStatus(3)) {
                         $referral->referrer->notify(new ReferralVerified( $referral, $request ));
                    }
                    break;
                case (3):
                    if ($request->_company->emailTemplateStatus(4)) {
                        $referral->referrer->notify(new ReferralSent( $referral, $request ));
                    }
                    break;
                case (4):
                    if ($request->_company->emailTemplateStatus(5)) {
                        $referral->referrer->notify(new ReferralDeclined( $referral, $request ));
                    }
                    break;
            }
        }

        return $this->getReferralTally();//$referral;
    }

    /**
     * Delete Referrals
     * @return
     */
    public function deleteReferral() {

        $request = request();

        $referral = $this->find($request->get('id'));
        return $referral->delete();
    }

    /**
     * Get referral pending approval and reward
     * @return
     */
    public function getReferralTally() {

        $request = request();

        if (auth()->user()->hasRole(['admin', 'superAdmin', 'globalAdmin'])) {
            $pendingReferrals['approval'] = $request->_company->referrals()
                ->where('status', 1)
                ->get();
            $pendingReferrals['reward'] = $request->_company->referrals()
                ->where('status', 2)
                ->get();
        } else {
            $pendingReferrals['approval'] = $request->user()->referrals()
                ->where('status', 1)
                ->get();
            $pendingReferrals['reward'] = $request->user()->referrals()
                ->where('status', 2)
                ->get();
        }

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

    public function userAddress() {
        return $this->hasOne(UserAddress::class, 'user_id', 'user_id');
    }

}
