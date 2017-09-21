<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BasicPages extends Model
{

    protected $table = 'basic_pages';

    protected $fillable = ['company_id', 'route_name', 'title', 'content'];

    const REWARDS = 1;
    const HOW_THIS_WORKS = 2;
    const HOW_TO_GET_MORE_REFERRALS = 3;

    const HOW_IT_WORKS = 4;
    const FEATURES = 5;
    const ABOUT_US = 6;
    const PRICING = 7;
    const CONTACT_US = 8;

    static $pageType = [
        self::REWARDS => 'referral-rewards',
        self::HOW_THIS_WORKS => 'how-this-works',
        self::HOW_TO_GET_MORE_REFERRALS => 'how-to-get-more-referrals',
    ];


}
