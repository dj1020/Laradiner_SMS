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

        $courier = Mockery::mock(SmsCourierInterface::class);
        $courier->shouldReceive('sendTextMessage')->once()->with([
            'to'      => $data['phone'],
            'message' => $data['message']
        ]);

        $event = Mockery::mock(SendSMSEvent::class);
        $event->shouldReceive('getData')->andReturn($data);

        $users = Mockery::mock(UserRepository::class);
        $stubUser = Mockery::mock(User::class);
        $relation = Mockery::mock('stdClass');

        $users->shouldReceive('find')->andReturn($stubUser);
        $stubUser->shouldReceive('messages')->once()->andReturn($relation);
        $relation->shouldReceive('create')->once()->with([
            'to' => $data['phone'],
            'message' => $data['message'],
        ]);

        // Act & Assert
        (new SendSMS($users, $courier))->handle($event);
    }

}
