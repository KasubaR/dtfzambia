# Digital Future Labs — Admin Panel Guide

## Table of Contents
1. [Logging In](#1-logging-in)
2. [Dashboard](#2-dashboard)
3. [Applications](#3-applications)
4. [Enrollments](#4-enrollments)
5. [Courses](#5-courses)
6. [Reports](#6-reports)
7. [How the Enrollment Flow Works](#7-how-the-enrollment-flow-works)

---

## 1. Logging In

Navigate to:
```
/dfl-admin/login
```
Enter your admin credentials. Once authenticated you will be redirected to the admin dashboard at `/admin`.

> Only accounts with the admin flag enabled can access the panel. There is no self-registration for admin accounts.

---

## 2. Dashboard

**URL:** `/admin`

The dashboard gives you a live snapshot of the platform:

| Stat | What it shows |
|------|---------------|
| Total Enrollments | All approved/partial enrollments |
| Enrollments Today | Approved enrollments submitted today |
| Total Applications | Every application regardless of status |
| Pending Applications | Applications still awaiting a course decision |
| Approval / Rejection Rate | Percentage breakdown of decided applications |

**What to look for:**
- If the **Pending Applications** count is high, go to **Applications** and start reviewing.
- The **Top 5 Courses** list shows which programmes have the most interest.
- Recent applications are listed at the bottom for a quick glance.

---

## 3. Applications

**URL:** `/admin/applications`

This is where you review and decide on incoming enrolment requests. An application only appears here while it still has at least one **pending** course decision.

### Reviewing an Application

1. Click an application row to open the detail view.
2. You will see the applicant's personal details and a list of the courses they applied for.
3. For each course, click **Approve** or **Reject**.
4. Once every course on the application has been decided, the system automatically:
   - Rolls the application status up to **Approved**, **Partial** (some courses accepted, some rejected), or **Rejected**.
   - Sends a decision email to the applicant.

### Bulk Actions

Select multiple applications using the checkboxes, then choose:

| Action | Effect |
|--------|--------|
| Bulk Approve | Approves all pending courses on the selected applications |
| Bulk Reject | Rejects all pending courses on the selected applications |
| Bulk Delete | Permanently removes the selected applications |

> **Note:** Bulk approve/reject will trigger the decision email for any application where all courses are now decided.

---

## 4. Enrollments

**URL:** `/admin/enrollments`

Enrollments are applications that have been fully decided (approved, partial, or rejected). This section has two tabs:

- **Accepted** — approved and partial enrollments
- **Rejected** — fully rejected enrollments

### Actions

| Action | How |
|--------|-----|
| View details | Click any row |
| Delete a single enrollment | Click the delete icon on the row |
| Export to CSV | Select rows → click **Export** |
| Bulk delete | Select rows → click **Delete** |

### CSV Export

The export file includes:

```
ID, Full Name, Email, Phone, NRC, Status, Courses, Submitted At
```

Filename format: `enrollments-export-YYYYMMDD-HHiiss.csv`

---

## 5. Courses

**URL:** `/admin/courses`

Manage the course catalogue — everything students can enrol in.

### Creating a Course

1. Click **Add Course**.
2. Fill in the fields:

| Field | Notes |
|-------|-------|
| Title | Required. Max 255 characters |
| Description | Optional. Max 1000 characters |
| Duration | e.g. "8 Weeks", "3 Months" |
| Mode | Hybrid / Online / Physical |
| Price | Numeric. Enter 0 for free courses |

3. Click **Save**.

### Editing a Course

Click the edit icon on any course row, update the fields, and save.

### Deleting a Course

Click the delete icon. This is a **permanent** delete — there is no undo or trash.

> The course list also shows a bar chart of enrolment counts per course so you can see which programmes are most popular at a glance.

---

## 6. Reports

**URL:** `/admin/reports`

Generate filtered views of enrolment data and export them.

### Filters Available

| Filter | Options |
|--------|---------|
| Course | Any active course |
| Status | Pending / Approved / Partial / Rejected |
| Date Range | From date — To date |
| Name Search | Partial match on applicant name |

### Summary Stats

At the top of the report you will see:

- Total enrollments matching filters
- Pending / Approved / Rejected counts
- **Revenue** — sum of fees for approved and partial enrollments

### Exporting

Click **Export** to download a filtered CSV of approved/partial enrollments with their accepted courses. The export respects all active filters.

---

## 7. How the Enrollment Flow Works

Understanding this flow will help you process applications correctly.

```
Student fills in enrolment form
        │
        ▼
Application created (status: pending)
Each chosen course gets its own decision slot (status: pending)
        │
        ▼
Admin reviews in Applications panel
Approves or rejects each course individually
        │
        ▼
All courses decided?
   ├── All accepted      → Enrollment: Approved
   ├── Mix of results    → Enrollment: Partial
   └── All rejected      → Enrollment: Rejected
        │
        ▼
Decision email sent automatically to student
Application moves out of Applications, appears in Enrollments
```

### Status Glossary

| Status | Meaning |
|--------|---------|
| Pending | Awaiting admin decision |
| Approved | All selected courses accepted |
| Partial | At least one course accepted, at least one rejected |
| Rejected | All selected courses rejected |

---

## Quick Reference

| Task | Where to go |
|------|-------------|
| See overall stats | Dashboard |
| Review new applications | Applications |
| Find a specific student | Reports → name search |
| Add or update a course | Courses |
| Download enrolment data | Enrollments → Export or Reports → Export |
| Check revenue | Reports → summary stats |
