<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Application decision</title>
</head>
<body style="font-family: system-ui, sans-serif; line-height: 1.6; color: #191b22; max-width: 560px; margin: 0 auto; padding: 24px;">
    <p>Hi {{ $enrollment->full_name }},</p>

    @if ($outcome === 'all_accepted')
        <p><strong>Congratulations.</strong></p>
        <p>We are pleased to inform you that you have been <strong>accepted</strong> for the programme(s) you applied for at Digital Future Labs.</p>
        <p><strong>Accepted Programme(s):</strong></p>
        <ul style="padding-left:20px;">
            @foreach ($acceptedCourses as $course)
                <li>{{ $course->title }}</li>
            @endforeach
        </ul>
        <p>For further information or inquiries, kindly call or text <strong>0960320384</strong> or email <a href="mailto:info@dflzambia.com">info@dflzambia.com</a>.</p>
        <p>We look forward to having you on board.</p>

    @elseif ($outcome === 'all_rejected')
        <p>Thank you for applying to Digital Future Labs.</p>
        <p>After careful consideration, we regret to inform you that your application was not successful for this cohort.</p>
        <p>We sincerely appreciate your interest in our programmes and the time you took to apply. Due to the high number of applications received, we were unable to accommodate all qualified applicants.</p>
        <p>We encourage you to stay connected with us for future opportunities and upcoming cohorts. To receive updates or learn more about future programmes, kindly call or text <strong>0960320384</strong> or email <a href="mailto:info@dflzambia.com">info@dflzambia.com</a>.</p>
        <p>Thank you once again for your interest in Digital Future Labs, and we wish you all the best in your future endeavors.</p>

    @elseif ($outcome === 'all_waitlisted')
        <p>Thank you for applying to Digital Future Labs.</p>
        <p>We are pleased to let you know that you have been <strong>added to the waiting list</strong> for the following programme(s):</p>
        <ul style="padding-left:20px;">
            @foreach ($waitlistedCourses as $course)
                <li>{{ $course->title }}</li>
            @endforeach
        </ul>
        <p>Being on the waiting list means your application is still under consideration. We will send you a follow-up email as soon as a place becomes available or when our next cohort opens. <strong>No action is required from you at this time.</strong></p>
        <p>To find out more about future cohorts or upcoming opportunities, kindly call or text <strong>0960320384</strong> or email <a href="mailto:info@dflzambia.com">info@dflzambia.com</a>.</p>
        <p>Thank you for your interest in Digital Future Labs, and we appreciate your patience.</p>

    @else
        <p>Thank you for your patience. We have completed our review of your application. Below is the outcome <strong>for each programme</strong> you selected.</p>

        @if ($acceptedCourses->isNotEmpty())
            <p><strong>Accepted</strong></p>
            <ul style="padding-left:20px;">
                @foreach ($acceptedCourses as $course)
                    <li>{{ $course->title }}</li>
                @endforeach
            </ul>
        @endif

        @if ($waitlistedCourses->isNotEmpty())
            <p><strong>Waiting list</strong></p>
            <ul style="padding-left:20px;">
                @foreach ($waitlistedCourses as $course)
                    <li>{{ $course->title }}</li>
                @endforeach
            </ul>
            <p style="font-size:14px;color:#5a5e72;">For programme(s) on the waiting list, we will contact you as soon as a place becomes available or when the next cohort opens.</p>
        @endif

        @if ($rejectedCourses->isNotEmpty())
            <p><strong>Not offered</strong></p>
            <ul style="padding-left:20px;">
                @foreach ($rejectedCourses as $course)
                    <li>{{ $course->title }}</li>
                @endforeach
            </ul>
            <p style="font-size:14px;color:#5a5e72;">You are welcome to <strong>register for the next cohort</strong> for any programme listed above.</p>
        @endif

        @if ($acceptedCourses->isNotEmpty())
            <p>For programme(s) listed under <em>Accepted</em>, we will send further instructions separately.</p>
        @endif

        <p>If you have questions about any decision, reply to this email.</p>
    @endif

    <p style="margin-top: 24px; font-size: 14px; color: #5a5e72;">Reference: enrollment #{{ $enrollment->id }}</p>

    <p style="margin-top: 16px; color: #5a5e72; font-size: 14px;">Kind regards,<br>
        <strong>Digital Future Labs</strong>
    </p>
</body>
</html>
