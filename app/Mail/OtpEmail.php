<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( private readonly string $code, private readonly string $email)
    {
        //
    }


    public function build()
    {

        return $this->subject('کد ورود')
                    ->view('emails.otp')
            ->to($this->email)->with(['code' => $this->code]);
    }
}
