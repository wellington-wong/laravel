<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CompanyNotCurrentNotice extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct( $request )
    {
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
        return ['mail'];
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

        return (new MailMessage)
                    ->from($from, $fromName)
                    ->subject('New referral for ' . (isset($this->request->_company->company_name) ? $this->request->_company->company_name : ''))
                    ->line('A referral has been submitted for ' . (isset($this->request->_company->company_name) ? $this->request->_company->company_name : ''))
                    ->action('Go to referral', url('/'))
                    ->line('Please update your credit card information to continue using Perxi.');
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
