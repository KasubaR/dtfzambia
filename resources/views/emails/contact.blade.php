<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <style>
    body { font-family: Arial, sans-serif; background: #f5f5f5; margin: 0; padding: 0; }
    .wrapper { max-width: 580px; margin: 32px auto; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,.08); }
    .header { background: #1a3c6e; padding: 24px 32px; }
    .header h1 { color: #fff; margin: 0; font-size: 18px; }
    .body { padding: 28px 32px; color: #333; font-size: 14px; line-height: 1.6; }
    .field { margin-bottom: 16px; }
    .label { font-weight: bold; color: #555; font-size: 12px; text-transform: uppercase; letter-spacing: .05em; margin-bottom: 4px; }
    .value { background: #f9f9f9; border: 1px solid #e5e5e5; border-radius: 4px; padding: 10px 14px; }
    .footer { background: #f5f5f5; padding: 16px 32px; font-size: 11px; color: #999; text-align: center; }
  </style>
</head>
<body>
  <div class="wrapper">
    <div class="header">
      <h1>New Contact Enquiry — Digital Future Labs</h1>
    </div>
    <div class="body">
      <div class="field">
        <div class="label">Name</div>
        <div class="value">{{ $senderName }}</div>
      </div>
      <div class="field">
        <div class="label">Email</div>
        <div class="value">{{ $senderEmail }}</div>
      </div>
      <div class="field">
        <div class="label">Inquiry Type</div>
        <div class="value">{{ $inquiry ?: 'Not specified' }}</div>
      </div>
      <div class="field">
        <div class="label">Message</div>
        <div class="value">{{ $messageBody }}</div>
      </div>
    </div>
    <div class="footer">
      Sent from the contact form on dflzambia.com
    </div>
  </div>
</body>
</html>
