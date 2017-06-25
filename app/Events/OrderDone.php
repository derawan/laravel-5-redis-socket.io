<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class OrderDone implements ShouldBroadcast
{
    public $id;
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public function __construct($id)
    {
        $this->id = $id;
    }

    public function broadcastOn()
    {
        return ['orderDone-channel'];
    }
}
