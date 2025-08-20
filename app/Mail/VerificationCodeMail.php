<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $code;

    /**
     * Create a new message instance.
     */
    public function __construct($code)
    {
        $this->code = $code; // <-- Guardamos el código para usarlo en la vista
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Tu código de verificación')
                    ->view('livewire.verification-code') // <-- vista Blade
                    ->with([
                        'code' => $this->code,
                    ]);
    }
}
