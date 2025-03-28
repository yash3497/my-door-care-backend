<?php

namespace App\Events\Nanny;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NannyRequestEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $nanny_request_data;
    public function __construct($nanny_request_data)
    {
        return $this->nanny_request_data = $nanny_request_data;
    }

    public function broadcastOn()
    {
        return ['nanny'];
    }
    public function broadcastAs()
    {
        return 'nanny-request-push';
    }
}
