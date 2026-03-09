<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminNewEnquiry extends Mailable
{
    use Queueable, SerializesModels;

    public $mailData;

    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }

    public function build()
    {
        $mail = $this->subject('New Contact Enquiry from '.$this->mailData['name'])
            ->view('emails.admin_new_enquiry')
            ->with(['mailData' => $this->mailData]);

        if (!empty($this->mailData['proof_image_path'])) {
            $mail->attach(storage_path('app/public/' . $this->mailData['proof_image_path']));
        }

        return $mail;
    }
}
