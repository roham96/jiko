<?php

namespace App\Jobs;

use App\Classes\Otp\OtpFactory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendOtpCodeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * @param string $type
     * @param string $value
     * @param string $code
     */
    public function __construct(
        private readonly string $type,
        private readonly string $value,
        private readonly string $code)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        (new OtpFactory())->generate($this->type)->send($this->value, $this->code);
    }
}