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
}
