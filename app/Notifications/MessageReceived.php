<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Participant;
use Cmgmyr\Messenger\Models\Thread;
use Auth;

class MessageReceived extends Notification
{
    use Queueable;

    protected $thread;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Thread $thread, Message $message, Participant $participant)
    {
        $this->thread = $thread;
        $this->message = $message;
        $this->participant = $participant;
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
        return (new MailMessage)
                    ->subject('Perxi: New Message Received')
                    ->line('You have received a new message from ' . (isset(Auth::user()->name) ? Auth::user()->name : Auth::user()->first_name . ' ' . Auth::user()->last_name) . '.')
                    ->action('Go to message', url('/messages/' . $this->thread->id));
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
