<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

   public function build()
    {
        return $this->subject('Reset Password')
                    ->view('emails.resetPassword')
                    ->with([
                        'url' => $this->url  // Pastikan ini string, bukan array
                    ]);
    }

}
