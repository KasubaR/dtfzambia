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

    /** @var Collection<int, \App\Models\Course> */
    public Collection $waitlistedCourses;

    /** all_accepted | all_rejected | all_waitlisted | mixed */
    public string $outcome;

    public function __construct(public Enrollment $enrollment)
    {
        $this->enrollment->loadMissing('courses');

        $accepted   = collect();
        $rejected   = collect();
        $waitlisted = collect();

        foreach ($this->enrollment->courses as $course) {
            $status = $course->pivot->status ?? Enrollment::PIVOT_PENDING;
            if ($status === Enrollment::PIVOT_ACCEPTED) {
                $accepted->push($course);
            } elseif ($status === Enrollment::PIVOT_REJECTED) {
                $rejected->push($course);
            } elseif ($status === Enrollment::PIVOT_WAITLISTED) {
                $waitlisted->push($course);
            }
        }

        $this->acceptedCourses   = $accepted;
        $this->rejectedCourses   = $rejected;
        $this->waitlistedCourses = $waitlisted;

        if ($accepted->isNotEmpty() && $rejected->isEmpty() && $waitlisted->isEmpty()) {
            $this->outcome = 'all_accepted';
        } elseif ($rejected->isNotEmpty() && $accepted->isEmpty() && $waitlisted->isEmpty()) {
            $this->outcome = 'all_rejected';
        } elseif ($waitlisted->isNotEmpty() && $accepted->isEmpty() && $rejected->isEmpty()) {
            $this->outcome = 'all_waitlisted';
        } else {
            $this->outcome = 'mixed';
        }
    }

    public function envelope(): Envelope
    {
        $subject = match ($this->outcome) {
            'all_accepted'   => 'Congratulations — you have been accepted — Digital Future Labs',
            'all_rejected'   => 'Update on your Digital Future Labs application',
            'all_waitlisted' => 'You have been added to the waiting list — Digital Future Labs',
            default          => 'Your course application decisions — Digital Future Labs',
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
