<?php

namespace App\Handlers\Events;

use App\Events\SendSMSEvent;
use App\Sms\SmsCourierInterface;
use App\User;
use App\UserRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendSMS implements ShouldQueue
{
    use InteractsWithQueue;

    private $users;
    /**
     * @var SmsCourierInterface
     */
    private $courier;

    /**
     * Create the event handler.
     *
     * @return void
     */
    public function __construct(UserRepository $repo, SmsCourierInterface $courier)
    {
        $this->users = $repo;
        $this->courier = $courier;
    }

    /**
     * Handle the event.
     *
     * @param  SendSMSEvent $event
     * @return void
     */
    public function handle(SendSMSEvent $event)
    {
        $data = $event->getData();

        /** @var User $user */
        $user = $this->users->find($data['user']['id']);

        $user->sendSms($this->courier, $data['message'], $data['phone']);
    }
}
