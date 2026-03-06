<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TeacherWelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    // 1. Declare the public data variable
    public $data;

    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        // 2. Assign the passed data to the public variable
        $this->data = $data;
    }

    /**
     * Get the message envelope (Handles the Subject Line).
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to EdFlow - Your Instructor Credentials',
        );
    }

    /**
     * Get the message content definition (Handles the View Template).
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.teacher_welcome', // Points to your beautiful email blade file
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}