<?php

namespace App\Mail;

use App\Models\Enrollment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class EnrollmentDecisionMail extends Mailable
{
    use Queueable, SerializesModels;

    /** @var Collection<int, \App\Models\Course> */
    public Collection $acceptedCourses;

    /** @var Collection<int, \App\Models\Course> */
    public Collection $rejectedCourses;

    /** all_accepted | all_rejected | mixed */
    public string $outcome;

    public function __construct(public Enrollment $enrollment)
    {
        $this->enrollment->loadMissing('courses');

        $accepted = collect();
        $rejected = collect();

        foreach ($this->enrollment->courses as $course) {
            $status = $course->pivot->status ?? Enrollment::PIVOT_PENDING;
            if ($status === Enrollment::PIVOT_ACCEPTED) {
                $accepted->push($course);
            } elseif ($status === Enrollment::PIVOT_REJECTED) {
                $rejected->push($course);
            }
        }

        $this->acceptedCourses = $accepted;
        $this->rejectedCourses = $rejected;

        if ($accepted->isNotEmpty() && $rejected->isEmpty()) {
            $this->outcome = 'all_accepted';
        } elseif ($rejected->isNotEmpty() && $accepted->isEmpty()) {
            $this->outcome = 'all_rejected';
        } else {
            $this->outcome = 'mixed';
        }
    }

    public function envelope(): Envelope
    {
        $subject = match ($this->outcome) {
            'all_accepted' => 'Congratulations — you have been accepted — Digital Future Labs',
            'all_rejected' => 'Update on your Digital Future Labs application',
            default => 'Your course application decisions — Digital Future Labs',
        };

        return new Envelope(
            subject: $subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.enrollment-decision',
        );
    }
}
