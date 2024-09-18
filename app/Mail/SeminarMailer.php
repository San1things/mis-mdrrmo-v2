<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SeminarMailer extends Mailable
{
    use Queueable, SerializesModels;

    public $seminartitle;
    public $seminarposted;


    /**
     * Create a new message instance.
     */
    public function __construct($seminartitle, $seminarposted)
    {
        $this->seminartitle = $seminartitle;
        $this->seminarposted = $seminarposted;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'A seminar has been posted on our page.',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.seminarview-mail',
            with: [
                'seminartitle' => $this->seminartitle,
                'seminarposted' => $this->seminarposted
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
