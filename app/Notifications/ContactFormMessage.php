<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Http\Request;
use App\LogEmail;

class ContactFormMessage extends Notification
{
    use Queueable;

    protected $request;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Request $request)
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
        $fromName = isset($this->request->_company->company_name) ? $this->request->_company->company_name : 'Admin';

        $name = $this->request->get('name');
        $email = $this->request->get('email');
        $message = $this->request->get('message');

        LogEmail::insert([
            'user_id' => 0, 
            'recipient_id' => 0, 
            'company_id' => isset($this->request->_company->id) ? $this->request->_company->id : null, 
            'subject' => 'A new message has been received from ' . $name, 
            'body' => 'Email: ' . $email . ' <br />Message: ' . strip_tags($message), 
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(), 
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
        ]);

        return (new MailMessage)
                    ->from($from, $fromName)
                    ->line('A new message has been received from ' . $name . '.')
                    ->line('Email: ' . $email)
                    ->line('Message: ' . strip_tags($message));
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
