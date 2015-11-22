<?php
/**
 * Author: twinkledj
 * Date: 11/11/15
 */

namespace App\Sms;


class Mitake_SMS implements SmsCourierInterface
{
    private $apiKey;

    /**
     * Mitake_SMS constructor.
     */
    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function sendTextMessage($params)
    {
        var_dump("Sending SMS by Mitake Platform");
        var_dump($params);
    }
}