<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use App\EmailTemplate;

class ReferralVerified extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct( $referral, $request )
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

        // Custom 'from' email
        $from = isset($this->request->_company->email) ? $this->request->_company->email : 'admin@' . env('DOMAIN');
        $fromName = isset($this->request->_company->company_name) ? $this->request->_company->company_name : '';

        if ($emailHtml = $this->request->_company->emailTemplates()->where('status', true)->where('type', 3)->where('email_html', '<>', '')->first()) {

            // Prepare custom email
            $emailHtml = $emailHtml->email_html;
            $emailHtml = EmailTemplate::prepareEmail( $this->request, $this->referral, $emailHtml );

            return (new MailMessage)
                ->from($from, $fromName)
                ->markdown('email-templates.referral-verified', ['referral' => $this->referral, 'email_template' => $emailHtml]);
        } else {

            // Render default html if not yet set
            $referralVerifiedHtml = str_replace('{ {', '{{', view('email-templates.referral-verified')->render());
            $emailHtml = EmailTemplate::prepareEmail( $this->request, $this->referral, $referralVerifiedHtml );
            
            return (new MailMessage)
                ->from($from, $fromName)
                ->markdown('email-templates.referral-verified', ['referral' => $this->referral, 'email_template' => $emailHtml]);

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
