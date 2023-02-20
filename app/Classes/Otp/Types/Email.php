<?php

namespace App\Classes\Otp\Types;

use App\Classes\Otp\Contracts\OtpInterface;
use App\Mail\OtpEmail;
use Illuminate\Support\Facades\Mail;


class Email implements OtpInterface
{

    public function send( string $receptor, string $code )
    {
        Mail::to('your_email@gmail.com')
            ->send(new OtpEmail($code, $receptor));

    }
}
