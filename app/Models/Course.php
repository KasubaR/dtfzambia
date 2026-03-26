<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'duration',
        'mode',
        'price',
        'icon',
        'modules',
        'seats_remaining',
        'is_popular',
        'is_recommended',
        'is_new',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'modules'        => 'array',
        'is_popular'     => 'boolean',
        'is_recommended' => 'boolean',
        'is_new'         => 'boolean',
        'is_active'      => 'boolean',
    ];

    /* ── Relationships ──────────────────────────────────────── */

    public function enrollments(): BelongsToMany
    {
        return $this->belongsToMany(Enrollment::class, 'course_enrollment')
            ->withPivot(['price_at_enrollment', 'status', 'reviewed_at'])
            ->withTimestamps();
    }

    /* ── Scopes ─────────────────────────────────────────────── */

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    /* ── Accessors ───────────────────────────────────────────── */

    /**
     * Formatted price with Kwacha symbol.
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'K' . number_format($this->price);
    }
}
