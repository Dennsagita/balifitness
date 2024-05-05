<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class KontakEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $kontak;

    public function __construct($kontak)
    {
        $this->kontak = $kontak;
    }

    public function build()
    {
        return $this->view('emails.kontak');
    }
}
