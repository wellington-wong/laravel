<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\DB;
use Carbon\Carbon;

class ReferralSubmissions extends Model
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

	protected $table = 'referral_submissions';

	protected $fillable = ['referrer_id', 'company_id', 'user_id', 'as_admin_id', 'status', 'note'];

    public function referrer() {
        return $this->hasOne(User::class, 'id', 'referrer_id');
    }

    public function referred() {
        return $this->hasOne(User::class, 'id', 'user_id');
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
        $referral->save();dd($referral);

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
            /*\Mail::send('emails.notify-referred', array('user' => auth()->user(), 'referral' => $referral,'note' => $referral->note, 'referral_message' => $referral_message, 'referred' => $referral->referred), function ($message) use ($email) {
                $message->from('admin@' . env('APP_URL'), 'Laravel');
                $message->to($email);
            });*/
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
}
