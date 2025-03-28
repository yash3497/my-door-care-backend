<?php

namespace App\Notifications\User\SitterHub;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PaymentMail extends Notification
{
    use Queueable;

    protected $user;
    protected $output;
    protected $trx_id;
    protected $user_request;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $output, $trx_id, $user_request)
    {
        $this->user = $user;
        $this->output = $output;
        $this->trx_id = $trx_id;
        $this->user_request = $user_request;
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
        $user = $this->user;
        $user_request = $this->user_request;
        $output = $this->output;
        $trx_id = $this->trx_id;
        $date = Carbon::now();
        $dateTime = $date->format('Y-m-d h:i:s A');

        return (new MailMessage)
            ->greeting("Hello, " . $user->fullname . " !")
            ->subject("Your payment successfully")
            ->line("Your have been payment successfully")
            ->line("Nanny Name: " . $user_request->nanny->fullname)
            ->line("Nanny's Bill: " . getAmount($user_request->total, 2) . " " . $user_request->currency_code)
            ->line("Service Charge: " . getAmount($user_request->service_charge, 2) . " " . $user_request->currency_code)
            ->line("Total: " . getAmount($user_request->payable, 2) . ' ' . $user_request->currency_code)
            ->line("Transaction Id: " . $trx_id)
            ->line("Status: Success")
            ->line("Date And Time: " . $dateTime)
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
