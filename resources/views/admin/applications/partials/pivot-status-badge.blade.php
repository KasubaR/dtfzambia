@php
  $map = [
    'pending'    => 'badge-pending',
    'accepted'   => 'badge-approved',
    'rejected'   => 'badge-rejected',
    'waitlisted' => 'badge-waitlisted',
  ];
  $class = $map[strtolower($status ?? 'pending')] ?? 'badge-pending';
  $label = ucfirst($status ?? 'pending');
@endphp

<span class="badge {{ $class }}">{{ $label }}</span>
