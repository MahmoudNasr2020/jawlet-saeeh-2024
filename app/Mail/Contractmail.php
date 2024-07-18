<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Contractmail extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;
    public function __construct($reservation)
    {
        $this->reservation = $reservation;
    }


    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Contract mail',
        );
    }


    public function content(): Content
    {
        return new Content(
            view: 'mail.contractMail',
        );
    }


    public function attachments(): array
    {
        return [];
    }
}
