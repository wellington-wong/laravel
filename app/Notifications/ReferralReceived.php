<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ReferralReceived extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct( $referral, $request, $referralValues )
    {
        $this->referral = $referral;
        $this->referralValues = $referralValues;
        $this->request = $request;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if (($emailHtml = $this->request->_company->emailTemplate()->first()->email_html) != '') {

            $regex = '#{{(.*?)}}#';
            $code = preg_match_all($regex, $emailHtml, $matches);

            // Get referred vars for referral
            $replacementVars = [];
            foreach ($matches[1] as $match) {
                if (stristr($match, 'referrer')) {
                    $varName = str_replace('referrer_', '', trim($match));
                    if (trim($match) == 'referrer_phone') {
                        $replacementVars[trim($match)] = isset($this->referral->referrer->phone[0]->phone) ? $this->referral->referrer->phone[0]->phone : null;
                    } else if (trim($match) == 'referrer_address') {
                        $replacementVars[trim($match)] = isset($this->referral->referrer->address[0]->address) ? $this->referral->referrer->address[0]->address : null;
                    } else {
                        $replacementVars[trim($match)] = $this->referral->referrer->$varName;
                    }
                }                
            }

            // Get referrer vars for referral
            foreach ($this->referralValues as $referralValue) {
                foreach ($matches[1] as $match) {
                    if (stristr($match, 'referred')) {
                        $varName = str_replace('referred_', '', trim($match));
                        if (trim($match) == 'referred_phone') {
                            $replacementVars[trim($match)] = isset($this->referral->referred->phone[0]->phone) ? $this->referral->referred->phone[0]->phone : null;
                        } else if (trim($match) == 'referred_address') {
                            $replacementVars[trim($match)] = isset($this->referral->referred->address[0]->address) ? $this->referral->referred->address[0]->address : null;
                        } else {
                            $replacementVars[trim($match)] = $this->referral->referred->$varName;
                        }
                    }                
                }
            }

            // Replace placeholder with real user data
            foreach ($replacementVars as $key => $replacementVar) {
                $emailHtml->email_html = str_replace('{{ ' . $key . ' }}', $replacementVars[$key], $emailHtml);
            }    

            return (new MailMessage)
                ->markdown('email-templates.referral-received', ['referral' => $this->referral, 'email_template' => $emailHtml]);
        } else {
            return (new MailMessage)
                ->line('You have been referred by ' . auth()->user()->getName());
        }
    }

    /**
     * Get the database representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return $this->referral->toArray();
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
