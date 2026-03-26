<?php

namespace App\Mail;

use App\Models\Enrollment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EnrollmentSubmittedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Enrollment $enrollment)
    {
        $this->enrollment->loadMissing('courses');
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Thank you — we received your enrollment — Digital Future Labs',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.enrollment-submitted',
        );
    }
}
