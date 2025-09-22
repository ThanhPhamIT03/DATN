<?php

namespace App\Services;

use Twilio\Rest\Client;

class SmsService
{
    public static function send($to, $message)
    {
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $from = env('TWILIO_PHONE_NUMBER');

        $twilio = new Client($sid, $token);

        if (substr($to, 0, 1) === '0') {
            $to = '+84' . substr($to, 1); 
        }

        return $twilio->messages->create($to, [
            'from' => $from,
            'body' => $message,
        ]);
    }
}
