<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class DashboardUpdated implements ShouldBroadcast
{
    use SerializesModels;

    public $model;
    public $action;

    public function __construct($model, $action)
    {
        $this->model = $model;
        $this->action = $action;
        Log::info("Broadcasting DataChanged: action={$action}, id={$model->id}");
    }

    public function broadcastOn()
    {
        return new Channel('public-channel');
    }

    public function broadcastAs()
    {
        return 'data.changed';
    }
}
