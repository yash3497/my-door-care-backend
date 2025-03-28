<?php

namespace App\Notifications\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class ServiceTaskComplate extends Notification
{
    use Queueable;
    protected $data;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
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
        $data = $this->data;
        $user = $notifiable;
        return (new MailMessage)
            ->greeting("Hello, $user->fullname !")
            ->subject('Task complate')
            ->line(new HtmlString("<b>Your bill</b>" . "<br>Nanny Name: " . $data->nanny->fullname . "<br>Daily working hour: " . $data->daily_working_hour . "/hr" . "<br>Service day: " . $data->service_day . "/d" . "<br>Charge: " . $data->nanny_charge . " " . $data->currency_code . "<br>Total hour: " . $data->totl_hour . "/hr" . "<br>Total: " . $data->total . " " . $data->currency_code . "<br>Service Charge: " . $data->service_charge . " " . $data->currency_code . "<br>Payable: " . $data->payable . " " . $data->currency_code))
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
