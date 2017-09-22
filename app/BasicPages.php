<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BasicPages extends Model
{

    protected $table = 'basic_pages';

    protected $fillable = ['company_id', 'route_name', 'title', 'content'];

    const REWARDS = 'referral-rewards';
    const HOW_THIS_WORKS = 'how-this-works';
    const HOW_TO_GET_MORE_REFERRALS = 'how-to-get-more-referrals';
    const NEED_HELP = 'help';

    const HOW_IT_WORKS = 'how-it-works';
    const FEATURES = 'features';
    const ABOUT_US = 'about-us';
    const PRICING = 'pricing';
    const CONTACT_US = 'contact';

    static $pageTypes = [
        self::REWARDS => 'Rewards',
        self::HOW_THIS_WORKS => 'How This Works',
        self::HOW_TO_GET_MORE_REFERRALS => 'How to Get More Referrals',
        self::NEED_HELP => 'Need Help?',

        self::HOW_IT_WORKS => 'How it Works',
        self::FEATURES => 'Features',
        self::ABOUT_US => 'About Us',
        self::PRICING => 'Pricing',
        self::CONTACT_US => 'Contact Us',
    ];


}
