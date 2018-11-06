<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{

    const NEW_MEMBER		= 1;
    const REFERRAL_RECEIVED	= 2;
    const REFERRAL_VERIFIED		= 3;
    const REFERRAL_SENT		= 4;
    const REFERRAL_DECLINED       = 5;

    const ADMIN_NEW_MEMBER	= 6;
    const ADMIN_NEW_REFERRAL	= 7;

    const NEW_REVIEW    = 8;
    const ADMIN_NEW_REVIEW    = 9;

    static $labels = [
        self::NEW_MEMBER => 'New Member Welcome Email',
        self::REFERRAL_RECEIVED => 'Referral Received Email',
        self::REFERRAL_VERIFIED => 'Referral Verified Notification Email',
        self::REFERRAL_SENT => 'Referral Has Been Sent Email',
        self::REFERRAL_DECLINED => 'Referral Has Been Declined Email',
        self::NEW_REVIEW => 'New Review Received',

        self::ADMIN_NEW_MEMBER => 'New Member Signup',
        self::ADMIN_NEW_REFERRAL => 'New Referral',
        self::ADMIN_NEW_REVIEW => 'New Review',

    ];

    protected $table = 'email_templates';

    protected $fillable = ['user_id', 'company_id', 'subject', 'email_html', 'status', 'type'];

    public function owner() {
    	return $this->hasOne(User::class);
    }

    public static function prepareEmail( $request, $referral, $emailHtml ) {

        $regex = '#{{(.*?)}}#';
        $code = preg_match_all($regex, $emailHtml, $matches);

        // Get referred vars for referral
        $replacementVars = [];
        foreach ($matches[1] as $match) {
            if (stristr($match, 'referrer')) {
                $varName = str_replace('referrer_', '', trim($match));
                switch (trim($match)) {
                    case ('referrer_name'):
                        $replacementVars[trim($match)] = $referral->referrer->getName() ?: null;
                        break;
                    case ('referrer_email'):
                        $replacementVars[trim($match)] = isset($referral->referrer->email) ? $referral->referrer->email : null;
                        break;
                    case ('referrer_phone'):
                        $replacementVars[trim($match)] = isset($referral->referrer->phone[0]->phone) ? $referral->referrer->phone[0]->phone : null;
                        break;
                    case ('referrer_address'):
                        $replacementVars[trim($match)] = isset($referral->referrer->address[0]->address) ? $referral->referrer->address[0]->address : null;
                        break;
                    default:
                        $replacementVars[trim($match)] = $referral->referrer->$varName;
                }
            }                
        }

        // Get referred vars for referral
        foreach ($matches[1] as $match) {
            if (stristr($match, 'referred')) {
                $varName = str_replace('referred_', '', trim($match));
                switch (trim($match)) {
                    case ('referred_name'):
                        $replacementVars[trim($match)] = $referral->referred->getName() ?: null;
                        break;
                    case ('referred_email'):
                        $replacementVars[trim($match)] = isset($referral->referred->email) ? $referral->referred->email : null;
                        break;
                    case ('referred_phone'):
                        $replacementVars[trim($match)] = isset($referral->referred->phone[0]->phone) ? $referral->referred->phone[0]->phone : null;
                        break;
                    case ('referred_address'):
                        $replacementVars[trim($match)] = isset($referral->referred->address[0]->address) ? $referral->referred->address[0]->address : null;
                        break;
                    default:
                        $replacementVars[trim($match)] = $referral->referred->$varName;
                }       
            }       
        }

        // Replace placeholder with real user data
        foreach ($replacementVars as $key => $replacementVar) {
            $emailHtml = str_replace('{{ ' . $key . ' }}', $replacementVars[$key], $emailHtml);
        }


        $emailHtml = str_replace('{{ perxi_home }}', 'https://' . $request->_company->subdomain . '.' . env('DOMAIN'), $emailHtml);
        $emailHtml = str_replace('{{ referral_note }}', (isset($referral->note) ? $referral->note : ''), $emailHtml);
        $emailHtml = str_replace('{{ password }}', $request->get('password'), $emailHtml);

        return $emailHtml;

    }

    public static function prepareEmailUser( $request, $user, $emailHtml ) {

        $regex = '#{{(.*?)}}#';
        $code = preg_match_all($regex, $emailHtml, $matches);

        // Get referred vars for referral
        $replacementVars = [];
        foreach ($matches[1] as $match) {
            switch (trim($match)) {
                case ('name'):
                    $replacementVars[trim($match)] = $user->getName() ?: null;
                    break;
                case ('email'):
                    $replacementVars[trim($match)] = isset($user->email) ? $user->email : null;
                    break;
                case ('phone'):
                    $replacementVars[trim($match)] = isset($user->phones()->first()->phone) ? $user->phones()->first()->phone : '';
                    break;
                case ('address'):
                    $replacementVars[trim($match)] = isset($user->addresses()->first()->address) ? $user->addresses()->first()->address : '';
                    break;
            }          
        }

        // Replace placeholder with real user data
        foreach ($replacementVars as $key => $replacementVar) {
            $emailHtml = str_replace('{{ ' . $key . ' }}', $replacementVars[$key], $emailHtml);
        }


        $emailHtml = str_replace('{{ perxi_home }}', 'https://' . $request->_company->subdomain . '.' . env('DOMAIN'), $emailHtml);
        $emailHtml = str_replace('{{ user_id }}', $user->id, $emailHtml);
        $emailHtml = str_replace('{{ password }}', $request->get('password'), $emailHtml);
       
        return $emailHtml;

    }

    public function recipients (){
        return $this->hasMany( EmailTemplateRecipients::class, 'email_template' );
    }

}
