<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class replyMarked extends Notification
{
    use Queueable;

    protected $reply;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($reply)
    {
        //

        $this->reply = $reply;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */


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
            'message' => $this->reply->thread->owner->name . ' Marked Your Reply As The Best Reply On ' . $this->reply->thread->title,

            'link'    => $this->reply->thread->path()
        ];
    }
}
