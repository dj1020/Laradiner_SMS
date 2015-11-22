<?php
/**
 * Author: twinkledj
 * Date: 11/22/15
 */
namespace App\Sms;

interface SmsCourierInterface
{
    public function sendTextMessage($params);
}