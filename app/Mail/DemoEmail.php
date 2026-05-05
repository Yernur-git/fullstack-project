<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
class DemoEmail extends Mailable
{
    use Queueable, SerializesModels;

    public string $messageContent;
    public string $senderName;

    public $objDemo;

    public function __construct($objDemo)
    {
        $this->objDemo = $objDemo;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Message from Creator File Storage',
        );
    }

    public function content(): Content
    {
        return new Content(
            view:  'mails.demo',
            text:  'mails.demo_plain',
        );
    }
}
