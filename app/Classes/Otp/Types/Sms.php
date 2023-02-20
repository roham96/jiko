<?php

namespace App\Classes\Otp\Types;

use App\Classes\Otp\Contracts\OtpInterface;
use Kavenegar;

class Sms implements OtpInterface
{
    public function send(string $receptor, string $code)
    {
        try {
            $sender = config('otp.admin_number');
            $api = new \Kavenegar\KavenegarApi(
                config('otp.api_key')
            );
            $api->Send($sender, $receptor, $code);
        } catch (\Kavenegar\Exceptions\ApiException $e) {
            // when response status is not 200!
            echo $e->errorMessage();
        } catch (\Kavenegar\Exceptions\HttpException $e) {
            // when we hane a connection problem
            echo $e->errorMessage();
        }
    }
}