<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class StudentWelcomeMail extends Mailable
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to EdFlow - Your Student Account'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.student_welcome'
        );
    }

}