<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ReferralNotifyUser extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($referral, $request)
    {
        $this->referral = $referral;
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
        $referralValues = ReferralValues::where('referral_id', $id)->get();
        $referral = Referral::find($id);

        if ($emailHtml = $request->_company->emailTemplate()->first()) {
            $regex = '#{{(.*?)}}#';
            $code = preg_match_all($regex, $emailHtml, $matches);

            // Group referral vars from referred
            $referrer = [];
            foreach ($matches[1] as $match) {
                if (stristr($match, 'referrer')) {
                    $varName = str_replace('referrer_', '', trim($match));
                    if ($varName == 'address') {
                        // /dd($referral->referrer->$varName);
                    }
                    $referrer[str_replace('referrer_', '', trim($match))] = $referral->referrer->$varName;
                }                
            }

            $referralValues->map(function ($referralVal) use ($matches) {
                array_map(function ($match) use ($referralVal) {
                    //print '<pre>'.print_r($referralVal->name,1).'</pre>';
                    //print '<pre>'.print_r('str  ' . stristr($match, 'referred'),1).'</pre>';
                    if ($referralVal->name == $match) {
                        print_r($referralVal->name);
                    }
                }, $matches[1]);
            });
        }

        if (isset($this->request->_company->emailTemplate()->first()->email_html)) {
            return (new MailMessage)
                ->markdown('email-templates.referral-notify-user', ['referral' => $this->referral, 'email_template' => $this->request->_company->emailTemplate()->first()->email_html]);
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
