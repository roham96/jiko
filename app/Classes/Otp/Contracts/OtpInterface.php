<?php

namespace App\Classes\Otp\Contracts;

interface OtpInterface
{

    /**
     * receptor maybe be a mobile number or email or firebase token!
     *
     * @param string $receptor
     * @param string $code
     * @return mixed
     */
    public function send(string $receptor, string $code);

}
