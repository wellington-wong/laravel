<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use App\EmailTemplate;

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
        if (($emailHtml = $this->request->_company->emailTemplates()->where('type', 1)->first()->email_html) != '') {
            // Prepare custom email
            $emailHtml = EmailTemplate::prepareEmail($this->referral, $emailHtml, $this->referralValues);
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
