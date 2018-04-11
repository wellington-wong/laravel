<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use App\EmailTemplate;
use App\LogEmail;

class NewMemberAdmin extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct( $request, $user )
    {
        $this->request = $request;
        $this->user = $user;
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
            'user_id' => $this->user->id, 
            'recipient_id' => $this->user->id, 
            'company_id' =>$this->request->_company->id, 
            'subject' => 'New Member Admin', 
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(), 
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
        ];

        // Custom 'from' email
        $from = isset($this->request->_company->email) ? $this->request->_company->email : 'admin@' . env('DOMAIN');
        $fromName = isset($this->request->_company->company_name) ? $this->request->_company->company_name : '';

        if ($emailHtml = $this->request->_company->emailTemplates()->where('status', true)->where('type', 6)->where('email_html', '<>', '')->first()) {

            // Prepare custom email
            $emailSubject = isset($emailHtml->subject) ? $emailHtml->subject : 'New Member Admin';
            $emailHtml = $emailHtml->email_html;
            $emailHtml = EmailTemplate::prepareEmailUser( $this->request, $this->user, $emailHtml );

            // Insert email log
            $emailLog['body'] = 'A new user has registered.';
            LogEmail::insert($emailLog);

            return (new MailMessage)
                ->from($from, $fromName)
                ->subject($emailSubject)
                ->markdown('email-templates.new-member-admin', ['user' => $this->user, 'email_template' => $emailHtml]);
        } else {

              // Render default html if not yet set
              $newMemberHtml = str_replace('{ {', '{{', view('email-templates.new-member-admin')->render());
              $emailHtml = EmailTemplate::prepareEmailUser( $this->request, $this->user, $newMemberHtml );
              
                // Insert email log
                $emailLog['body'] = 'A new user has registered.';
                LogEmail::insert($emailLog);
            
            //  Get EmailTemplate object
            $emailObj = $this->request->_company->emailTemplates()->where('status', true)->where('type', 6)->where('email_html', '<>', '')->first();

              return (new MailMessage)
                ->from($from, $fromName)
                ->markdown('email-templates.new-member-admin', ['user' => $this->user, 'email_template' => $emailHtml]);
        
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
        return $this->user->toArray();
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
