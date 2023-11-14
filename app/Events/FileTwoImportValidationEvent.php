<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FileTwoImportValidationEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $file;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
