<?php

use App\Events\SendSMSEvent;
use App\Handlers\Events\SendSMS;
use App\Sms\Mitake_SMS;
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

        $courier = Mockery::mock(Mitake_SMS::class);
        $courier->shouldReceive('sendTextMessage')->once()->with([
            'to'      => $data['phone'],
            'message' => $data['message']
        ]);

        $event = Mockery::mock(SendSMSEvent::class);
        $event->shouldReceive('getCourier')->andReturn($courier);
        $event->shouldReceive('getData')->andReturn($data);

        // Act & Assert
        (new SendSMS())->handle($event);
    }

}
