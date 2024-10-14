<?php

namespace App\Mail\Shipper;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailData)
    {
        $this->mailData = $mailData;

        Log::info('from mail' . print_r($this->mailData, true));
    }

    public function build()
    {
        return $this->subject('Welcome to Laxmi transportation')
            ->view('emails.shipper.verifyemail');
        
    }
}
