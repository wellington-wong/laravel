<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use App\EmailTemplate;

class ReferralDeclined extends Notification
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

        if ($emailHtml = $this->request->_company->emailTemplates()->where('status', true)->where('type', 5)->first()) {

            // Prepare custom email
            $emailHtml = $emailHtml->email_html;
            $emailHtml = EmailTemplate::prepareEmail( $this->request, $this->referral, $emailHtml );

            return (new MailMessage)
                ->from($from, $fromName)
                ->markdown('email-templates.referral-declined', ['referral' => $this->referral, 'email_template' => $emailHtml]);
        } else {
            return (new MailMessage)
                ->from($from, $fromName)
                ->line('Your referral for ' . $this->referral->referred->getName() . ' has been declined.')
                ->line('Note: ' . strip_tags($this->referral->note))
                ->action('Go to referrals', url('/referrals'))
                ->line('Thank you for using our application!');
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
