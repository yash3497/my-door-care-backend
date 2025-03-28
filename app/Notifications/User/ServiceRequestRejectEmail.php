<?php

namespace App\Notifications\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class ServiceRequestRejectEmail extends Notification
{
    use Queueable;
    protected $nanny;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($nannay)
    {
        $this->nanny = $nannay;
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
        $user = $notifiable;
        $nanny = $this->nanny;
        return (new MailMessage)
            ->greeting('Hello ' . $user->fullname . "!")
            ->subject('Request reject')
            ->line(new HtmlString("<b>$nanny->fullname</b> have rejected your request"))
            ->line('Thank you for using our application!');
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
