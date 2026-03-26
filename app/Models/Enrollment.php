<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Enrollment extends Model
{
    use HasFactory;

    /** Pivot `course_enrollment.status` values */
    public const PIVOT_PENDING = 'pending';

    public const PIVOT_ACCEPTED = 'accepted';

    public const PIVOT_REJECTED = 'rejected';

    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'nrc',
        'age_range',
        'location',
        'education_level',
        'employment_status',
        'workplace',
        'reason',
        'total_price',
        'status',
        'enrolled_at',
        'admin_notes',
        'decision_email_sent_at',
        'verification_code',
        'verification_expires_at',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
        'enrolled_at' => 'datetime',
        'decision_email_sent_at' => 'datetime',
        'verification_expires_at' => 'datetime',
    ];

    /* ── Relationships ──────────────────────────────────────── */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'course_enrollment')
            ->withPivot(['price_at_enrollment', 'status', 'reviewed_at'])
            ->withTimestamps();
    }

    /**
     * Whether every attached course has a final decision (accepted or rejected).
     */
    public function allCoursesDecided(): bool
    {
        $courses = $this->relationLoaded('courses')
            ? $this->courses
            : $this->courses()->get();

        if ($courses->isEmpty()) {
            return true;
        }

        foreach ($courses as $course) {
            $status = $course->pivot->status ?? self::PIVOT_PENDING;
            if ($status === self::PIVOT_PENDING) {
                return false;
            }
        }

        return true;
    }

    /**
     * Derive `enrollments.status` from pivot rows: pending | approved | rejected | partial.
     */
    public function rollupStatus(): string
    {
        $courses = $this->relationLoaded('courses')
            ? $this->courses
            : $this->courses()->get();

        if ($courses->isEmpty()) {
            return 'pending';
        }

        $statuses = $courses->map(fn ($course) => $course->pivot->status ?? self::PIVOT_PENDING);

        if ($statuses->contains(self::PIVOT_PENDING)) {
            return 'pending';
        }

        $total = $courses->count();
        $accepted = $statuses->filter(fn (string $s) => $s === self::PIVOT_ACCEPTED)->count();
        $rejected = $statuses->filter(fn (string $s) => $s === self::PIVOT_REJECTED)->count();

        if ($accepted === $total) {
            return 'approved';
        }
        if ($rejected === $total) {
            return 'rejected';
        }

        return 'partial';
    }
}
