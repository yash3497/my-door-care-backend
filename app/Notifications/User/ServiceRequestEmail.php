<?php

namespace App\Notifications\User;

use Illuminate\Bus\Queueable;
use Illuminate\Support\HtmlString;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ServiceRequestEmail extends Notification
{
    use Queueable;

    protected $nanny;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($nanny)
    {
        $this->nanny = $nanny;
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
            ->greeting('Hey ' . $user->fullname . "!")
            ->subject('Request accepted')
            ->line(new HtmlString("<b>$nanny->fullname </b> have accepted your request."))
            ->line(new HtmlString("<b>Nanny's short summery</b><br>Email: $nanny->email <br>Phone: $nanny->mobile<br>Experience: " . $nanny->nannyProfession->work_experience . "<br>Charge: " . $nanny->nannyProfession->amount . "/hr" . "<br>Bio: " . $nanny->nannyProfession->bio . "."))
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
