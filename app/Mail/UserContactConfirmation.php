<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserContactConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $mailData;

    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }

    public function build()
    {
        return $this->subject('We received your message - Adrahan')
            ->view('emails.user_contact_confirmation')
            ->with([
                'mailData' => $this->mailData
            ]);
    }
}
