# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

**Digital Future Labs** is a Laravel 12 application for managing course enrollments. It has a public-facing enrollment system (no auth required) and a private admin panel for reviewing and approving/rejecting applications.

## Common Commands

```bash
# Full project setup (install deps, generate key, migrate, build assets)
composer setup

# Start all dev servers concurrently (artisan serve, queue:listen, pail logs, vite HMR)
composer dev

# Run tests
composer test

# Individual servers
php artisan serve
npm run dev
npm run build
```

## Architecture

### Two-Tier Authentication
- **Public:** No login required. Enrollment form is fully open.
- **Admin:** Login at `/dfl-admin/login`, redirects to `/admin` dashboard. Protected by `auth` + `AdminMiddleware` (checks `is_admin` flag on the User model).
- Public login at `/login` explicitly **rejects** users with `is_admin=true`.

### Enrollment Flow (Stateless → Stateful)
1. Student submits form → `Enrollment` created with `status = pending_verification`
2. 6-digit OTP generated (15-min expiry), sent via email
3. OTP verified → `status = pending` (awaiting admin review)
4. Admin reviews each course individually; pivot `course_enrollment.status` set to `accepted` or `rejected`
5. When all pivots are decided, `Enrollment::rollupStatus()` derives final status:
   - All accepted → `approved`
   - All rejected → `rejected`
   - Mixed → `partial`
6. Decision email sent automatically; enrollment moves from Applications to Enrollments in admin panel

### Applications vs. Enrollments (Admin Panel)
- **`/admin/applications`** — Enrollments with at least one `pending` course pivot
- **`/admin/enrollments`** — Enrollments where all course pivots are decided

### Pricing Logic (Kwacha)
Calculated in `EnrollmentController::calculatePrice()`:
- 1 course = K1,750 | 2 = K3,000 | 3 = K4,750 | 4+ = K4,750 + (N−3 × K1,750)

### Key Models
- **`Enrollment`** — Central model. Has `rollupStatus()` and `allCoursesDecided()` methods. Constants: `PIVOT_PENDING`, `PIVOT_ACCEPTED`, `PIVOT_REJECTED`.
- **`Course`** — Has `active()` scope, boolean flags (`is_active`, `is_popular`, `is_recommended`, `is_new`), and `modules` cast as JSON array.
- **`User`** — Admin staff only. No public user accounts.
- **Pivot:** `course_enrollment` table tracks `price_at_enrollment`, `status`, and `reviewed_at` per course per enrollment.

### Routes
- Public routes in `routes/web.php`
- Admin routes in `routes/admin.php` (prefixes: `/dfl-admin` for auth, `/admin` for protected pages)

### Frontend Assets (Vite)
Separate entry points per section — do not mix them:
- `app.css` / `app.js` — Public site
- `admin.css` / `admin.js` — Admin panel
- `enrollment.css` / `enrollment.js` — Enrollment flow
- `about.css` — About page

Tailwind CSS v4 via `@tailwindcss/vite` plugin. No JS framework — vanilla JS + Blade.

### Email
Four mail classes in `app/Mail/`: `ContactMail`, `EnrollmentOtpMail`, `EnrollmentSubmittedMail`, `EnrollmentDecisionMail`. In dev, mail is logged to console (`MAIL_MAILER=log`).

### Database
SQLite by default. Sessions, cache, and queue are all database-backed.

## Out of Scope
- Admin user management (no UI — create users via seeder or direct DB)
- Audit logs / event tracking
