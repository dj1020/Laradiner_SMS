<?php

namespace App\Handlers\Events;

use App\Events\SendSMSEvent;
use App\Sms\SmsCourierInterface;
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
        var_dump("Fired SendSMS event handler");
        $data = $event->getData();

        // 挑戰 1：有沒有什麼寫法是可以換簡訊平台卻不需要修改這一段已經寫好的 Production Code？
        // Solution 2: 提取 SmsCourierInterface 透過 Dependency Injection 注入，
        //             可利用 Laravel 的 constructor typehint 和 service provider
        $this->courier->sendTextMessage([
            'to'      => $data['phone'],
            'message' => $data['message'],
        ]);

        // 這裡和 Eloquent 的資料庫相依性太高，造成另一個測試上的困難，
        // 無法再不觸及資料庫的情況下來做測試，違背單元測試的原則。

        // 挑戰 3：如何在不觸及資料庫操作的前提下，寫測試驗證 handle 方法內的處理邏輯？
        // Solution: user repository
        $user = $this->users->find($data['user']['id']);

        $user->messages()->create([
            'to'      => $data['phone'],
            'message' => $data['message'],
        ]);

    }
}
