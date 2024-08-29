<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MessageReplyMailer extends Mailable
{
    use Queueable, SerializesModels;

    public $reply;
    public $usermessage;
    /**
     * Create a new message instance.
     */
    public function __construct($reply, $usermessage)
    {
        $this->reply = $reply;
        $this->usermessage = $usermessage;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'MDRRMO Morong, Rizal replied.',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.replyview-mail',
            with: [
                'reply' => $this->reply,
                'usermessage' => $this->usermessage
            ]
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
