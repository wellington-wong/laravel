<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use App\EmailTemplate;
use App\LogEmail;

class ReferralSent extends Notification
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

        // Prepare email log
        $emailLog = [
            'user_id' => $this->referral->referrer->id, 
            'recipient_id' => $notifiable->id, 
            'company_id' =>$this->request->_company->id, 
            'subject' => 'Reward Sent', 
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(), 
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
        ];

        // Custom 'from' email
        $from = isset($this->request->_company->email) ? $this->request->_company->email : 'admin@' . env('DOMAIN');
        $fromName = isset($this->request->_company->company_name) ? $this->request->_company->company_name : '';

        if ($emailHtml = $this->request->_company->emailTemplates()->where('status', true)->where('type', 4)->where('email_html', '<>', '')->first()) {

            // Prepare custom email
            $emailSubject = isset($emailHtml->subject) ? $emailHtml->subject : 'Referral Sent';
            $emailHtml = $emailHtml->email_html;
            $emailHtml = EmailTemplate::prepareEmail( $this->request, $this->referral, $emailHtml );

            // Insert email log
            $emailLog['body'] = 'Your reward for referring ' . isset($this->referral->referred->name) ? $this->referral->referred->name : $this->referral->referred->email . ' has been received.';
            LogEmail::insert($emailLog);

            return (new MailMessage)
                ->from($from, $fromName)
                ->subject($emailSubject)
                ->markdown('email-templates.referral-sent', ['referral' => $this->referral, 'email_template' => $emailHtml]);
        } else {

            // Render default html if not yet set
            $referralSentHtml = str_replace('{ {', '{{', view('email-templates.referral-sent')->render());
            $emailHtml = EmailTemplate::prepareEmail( $this->request, $this->referral, $referralSentHtml );

            // Insert email log
            $emailLog['body'] = 'Your reward for referring ' . isset($this->referral->referred->name) ? $this->referral->referred->name : $this->referral->referred->email . ' has been sent.';
            LogEmail::insert($emailLog);
            
            return (new MailMessage)
                ->from($from, $fromName)
                ->markdown('email-templates.referral-sent', ['referral' => $this->referral, 'email_template' => $emailHtml]);
        
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
