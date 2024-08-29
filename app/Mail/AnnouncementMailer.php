<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AnnouncementMailer extends Mailable
{
    use Queueable, SerializesModels;

    public $announcement;
    public $announcementtype;
    public $announcementposted;

    /**
     * Create a new message instance.
     */
    public function __construct($announcement, $announcementtype, $announcementposted)
    {
        $this->announcement = $announcement;
        $this->announcementtype = $announcementtype;
        $this->announcementposted = $announcementposted;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Announcement has been posted!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.announcementview-mail',
            with: [
                'announcement' => $this->announcement,
                'announcement' => $this->announcementtype,
                'announcementposted' => $this->announcementposted
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
