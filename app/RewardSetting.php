<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RewardSetting extends Model
{
    protected $table = 'reward_settings';

    protected $fillable = ['company_id', 'title', 'reward_kind', 'reward_send', 'leaderboard', 'reward_ratio'];
    
}
