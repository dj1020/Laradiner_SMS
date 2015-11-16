<?php

namespace App\Handlers\Events;

use App\Events\SendSMSEvent;
use App\Sms\Mitake_SMS;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendSMS implements ShouldQueue
{
    use InteractsWithQueue;
    private $apiKey = "some_random_string_here_adfqweradf";

    /**
     * Create the event handler.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SendSMSEvent $event
     * @return void
     */
    public function handle(SendSMSEvent $event)
    {
        var_dump("Fired SendSMS event handler");
        $data = $event->getData();

        $mitake = new Mitake_SMS($this->apiKey);

        $mitake->sendTextMessage([
            'to'      => $data['phone'],
            'message' => $data['message'],
        ]);

        $user = \App\User::find($data['user']['id']);

        $user->messages()->create([
            'to'      => $data['phone'],
            'message' => $data['message'],
        ]);
    }
}
