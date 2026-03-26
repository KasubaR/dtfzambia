<?php

namespace Tests\Feature;

use App\Mail\EnrollmentDecisionMail;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

/**
 * QA: 1-course accept/reject + rollup + decision email;
 * 3-course mixed → partial + per-course email sections;
 * duplicate PATCH → decision email sent once (decision_email_sent_at + lock).
 */
class AdminEnrollmentDecisionTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['is_admin' => true]);
    }

    private function makeCourse(string $title): Course
    {
        return Course::create([
            'title' => $title,
            'description' => 'Test course',
            'price' => 1750,
        ]);
    }

    /**
     * @param  array<int, Course>  $courses
     */
    private function makeEnrollmentWithCourses(array $courses): Enrollment
    {
        $enrollment = Enrollment::create([
            'full_name' => 'Applicant User',
            'email' => 'applicant@example.test',
            'phone' => '+260970000001',
            'nrc' => 'T'.uniqid(),
            'age_range' => '25-34',
            'location' => 'Lusaka',
            'education_level' => 'bachelor',
            'employment_status' => 'employed',
            'workplace' => 'ACME',
            'reason' => 'I want to learn digital skills for my career.',
            'total_price' => 1750,
            'status' => 'pending',
            'enrolled_at' => now(),
        ]);

        $sync = [];
        foreach ($courses as $course) {
            $sync[$course->id] = [
                'price_at_enrollment' => $course->price,
                'status' => Enrollment::PIVOT_PENDING,
            ];
        }
        $enrollment->courses()->sync($sync);

        return $enrollment->fresh(['courses']);
    }

    public function test_single_course_accept_rollup_and_decision_email(): void
    {
        Mail::fake();

        $course = $this->makeCourse('Only Course');
        $enrollment = $this->makeEnrollmentWithCourses([$course]);

        $response = $this->actingAs($this->admin)->patchJson(
            route('admin.applications.update', $enrollment),
            ['courses' => [(string) $course->id => 'accepted']]
        );

        $response->assertRedirect();
        $enrollment->refresh();
        $this->assertSame('approved', $enrollment->status);
        $this->assertNotNull($enrollment->decision_email_sent_at);

        Mail::assertSent(EnrollmentDecisionMail::class, function (EnrollmentDecisionMail $mail) use ($enrollment) {
            return $mail->enrollment->is($enrollment)
                && $mail->outcome === 'all_accepted'
                && $mail->acceptedCourses->count() === 1;
        });
    }

    public function test_single_course_reject_rollup_and_decision_email(): void
    {
        Mail::fake();

        $course = $this->makeCourse('Solo Reject');
        $enrollment = $this->makeEnrollmentWithCourses([$course]);

        $this->actingAs($this->admin)->patchJson(
            route('admin.applications.update', $enrollment),
            ['courses' => [(string) $course->id => 'rejected']]
        );

        $enrollment->refresh();
        $this->assertSame('rejected', $enrollment->status);
        $this->assertNotNull($enrollment->decision_email_sent_at);

        Mail::assertSent(EnrollmentDecisionMail::class, function (EnrollmentDecisionMail $mail) {
            return $mail->outcome === 'all_rejected'
                && $mail->rejectedCourses->count() === 1;
        });
    }

    public function test_three_courses_mixed_partial_and_email_lists_each_course(): void
    {
        Mail::fake();

        $a = $this->makeCourse('Course Alpha');
        $b = $this->makeCourse('Course Beta');
        $c = $this->makeCourse('Course Gamma');
        $enrollment = $this->makeEnrollmentWithCourses([$a, $b, $c]);

        $response = $this->actingAs($this->admin)->patchJson(
            route('admin.applications.update', $enrollment),
            [
                'courses' => [
                    (string) $a->id => 'accepted',
                    (string) $b->id => 'rejected',
                    (string) $c->id => 'accepted',
                ],
            ]
        );

        $response->assertRedirect();

        $enrollment->refresh();
        $this->assertSame('partial', $enrollment->status);
        $this->assertNotNull($enrollment->decision_email_sent_at);

        Mail::assertSent(EnrollmentDecisionMail::class, function (EnrollmentDecisionMail $mail) use ($a, $b, $c) {
            if ($mail->outcome !== 'mixed') {
                return false;
            }
            if ($mail->acceptedCourses->count() !== 2 || $mail->rejectedCourses->count() !== 1) {
                return false;
            }
            $html = $mail->render();

            return str_contains($html, $a->title)
                && str_contains($html, $b->title)
                && str_contains($html, $c->title);
        });
    }

    public function test_double_submit_does_not_send_decision_email_twice(): void
    {
        Mail::fake();

        $course = $this->makeCourse('Idempotent');
        $enrollment = $this->makeEnrollmentWithCourses([$course]);

        $url = route('admin.applications.update', $enrollment);
        $payload = ['courses' => [(string) $course->id => 'accepted']];

        $this->actingAs($this->admin)->patchJson($url, $payload);
        $this->actingAs($this->admin)->patchJson($url, $payload);

        Mail::assertSent(EnrollmentDecisionMail::class, 1);
    }
}
