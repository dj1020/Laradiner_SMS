<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SendSMSEvent extends Event
{
    use SerializesModels;

    private $data;
    private $courier;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(array $data, $courier)
    {
        $this->data = $data;
        $this->courier = $courier;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getCourier()
    {
        return $this->courier;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
