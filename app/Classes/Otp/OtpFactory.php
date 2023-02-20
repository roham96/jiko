<?php

namespace App\Classes\Otp;

use App\Classes\Otp\Contracts\OtpInterface;
use Illuminate\Support\Str;

class OtpFactory
{

    /**
     * generate types class for send otp message
     * @param string $type
     * @return OtpInterface
     */
    public function generate( string $type) : OtpInterface
    {
        $class = __NAMESPACE__ . '\\Types\\' . Str::studly($type);
        return new $class();
    }

}
