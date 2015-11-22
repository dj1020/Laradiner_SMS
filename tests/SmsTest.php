<?php

use App\Events\SendSMSEvent;
use App\Handlers\Events\SendSMS;
use App\Sms\Mitake_SMS;
use App\Sms\SmsCourierInterface;
use App\User;
use App\UserRepository;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery\Mock;

class SmsTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_send_sms_message()
    {
        // Arrange
        $data = [
            'user'    => ['id' => 1],
            'phone'   => '12345678',
            'message' => 'test message here...'
        ];

        $user = Mockery::mock('\App\User[sms]'); // partial mock
        $relation = Mockery::mock('stdClass');
        $courier = Mockery::mock(SmsCourierInterface::class);

        $user->shouldReceive('sms')->once()->andReturn($relation);
        $relation->shouldReceive('create')->once()->with([
            'to' => $data['phone'],
            'message' => $data['message'],
        ]);

        $courier->shouldReceive('sendTextMessage')->once()->with([
            'to'      => $data['phone'],
            'message' => $data['message']
        ]);

        // Act & Assert
        $user->sendSms($courier, $data['message'], $data['phone']);
    }

}
