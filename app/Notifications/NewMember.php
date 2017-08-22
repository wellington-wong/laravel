<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use App\EmailTemplate;
use App\LogEmail;

class NewMember extends Notification
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

        // Insert email log
        /*LogEmail::insert([
            'user_id' => 0, 
            'recipient_id' => 0, 
            'company_id' => isset($this->request->_company->id) ? $this->request->_company->id : null, 
            'subject' => 'A new message has been received from ' . $name, 
            'body' => 'Email: ' . $email . ' <br />Message: ' . strip_tags($message), 
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(), 
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
        ]);*/

        // Custom 'from' email
        $from = isset($this->request->_company->email) ? $this->request->_company->email : 'admin@' . env('DOMAIN');
        $fromName = isset($this->request->_company->company_name) ? $this->request->_company->company_name : '';

        if ($emailHtml = $this->request->_company->emailTemplates()->where('status', true)->where('type', 1)->where('email_html', '<>', '')->first()) {

            // Prepare custom email
            $emailHtml = $emailHtml->email_html;
            $emailHtml = EmailTemplate::prepareEmailUser( $this->request, $this->user, $emailHtml );

            return (new MailMessage)
                ->from($from, $fromName)
                ->markdown('email-templates.new-member', ['user' => $this->user, 'email_template' => $emailHtml]);
        } else {

              // Render default html if not yet set
              $newMemberHtml = str_replace('{ {', '{{', view('email-templates.new-member')->render());
              $emailHtml = EmailTemplate::prepareEmailUser( $this->request, $this->user, $newMemberHtml );

              return (new MailMessage)
                ->from($from, $fromName)
                ->markdown('email-templates.new-member', ['user' => $this->user, 'email_template' => $emailHtml]);
        
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
