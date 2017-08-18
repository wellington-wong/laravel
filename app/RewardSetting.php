<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RewardSetting extends Model
{

    const MAIL      = 1;
    const EMAIL       = 2;
    const CHECK    = 3;
    const GIFTCARD         = 4;

    const CASH      = 5;
    const CHECK2       = 6;
    const GIFTCHECK    = 7;

    static $rewardSend = [
        self::MAIL => 'Mail',
        self::EMAIL => 'Email',
        self::CHECK => 'Check',
        self::GIFTCARD => 'Gift Card'
    ];

    static $rewardKind = [
        self::CASH => '$100 Cash',
        self::CHECK2 => '$100 Check',
        self::GIFTCHECK => '$100 Gift Card',
    ];

    protected $table = 'reward_settings';

    protected $fillable = ['company_id', 'title', 'reward_kind', 'reward_send', 'leaderboard', 'reward_ratio'];
    
}
