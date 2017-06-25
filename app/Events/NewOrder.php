<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewOrder implements ShouldBroadcast
{
    public $form;


    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct($form)
    {
        $this->form=$form;
    }


    public function broadcastOn()
    {
        return ['newOrder-channel'];
    }
}
