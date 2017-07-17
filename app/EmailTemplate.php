<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{

    const NEW_MEMBER			= 1;
    const REFERRAL_RECEIVED	= 2;
    const REFERRAL_VERIFIED		= 3;
    const REFERRAL_SENT			= 4;
    const REFERRAL_DECLINED	= 5;

    const ADMIN_NEW_MEMBER	= 6;
    const ADMIN_NEW_REFERRAL	= 5;

    static $status = [
        self::NEW_MEMBER => 'New Member Welcome Email',
        self::REFERRAL_RECEIVED => 'Referral Received Email',
        self::REFERRAL_VERIFIED => 'Referral Verified Notification Email',
        self::REFERRAL_SENT => 'Referral Has Been Sent Email',
        self::REFERRAL_DECLINED => 'Referral Has Been Declined Email',

        self::ADMIN_NEW_MEMBER => 'New Member Signup',
        self::ADMIN_NEW_REFERRAL => 'New Referral'
    ];

    protected $table = 'email_templates';

    protected $fillable = ['user_id', 'company_id', 'email_html'];

    public function owner() {
    	return $this->hasOne(User::class);
    }

    public function prepareEmail($referral) {
    	return dd($referral);
    }

}
