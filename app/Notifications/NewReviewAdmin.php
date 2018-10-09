<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use App\EmailTemplate;
use App\LogEmail;

class NewReviewAdmin extends Notification
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
        
        if ($emailHtml = $this->request->_company->emailTemplates()->where('status', true)->where('type', 9)->where('email_html', '<>', '')->first()) {

            // Prepare custom email
            $emailSubject = isset($emailHtml->subject) ? $emailHtml->subject : 'New Review Submitted';
            $emailHtml = $emailHtml->email_html;
            $emailHtml = $emailHtml;

            // Insert email log
            $emailLog['body'] = 'A new review has been submitted by ' . auth()->user()->getDisplayNameAttribute();
            LogEmail::insert($emailLog);

            return (new MailMessage)
                ->from($from, $fromName)
                ->subject($emailSubject)
                ->markdown('email-templates.new-review', ['email_template' => $emailHtml]);
        } else {
            
            return (new MailMessage)
                ->from($from, $fromName)
                ->line('A new review has been submitted.')
                ->action('View Customer Reviews', url('/user-reviews'))
                ->line('Thank you for using our application!');

        }

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
