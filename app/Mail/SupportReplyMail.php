<?php

namespace App\Mail;

use App\Models\SupportTicket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SupportReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public SupportTicket $ticket;

    public function __construct(SupportTicket $ticket)
    {
        $this->ticket = $ticket;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your doubt has been answered — EdFlow Support',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.support_reply',
        );
    }
}
