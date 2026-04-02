@php
  $map = [
    'pending'    => 'badge-pending',
    'approved'   => 'badge-approved',
    'rejected'   => 'badge-rejected',
    'partial'    => 'badge-partial',
    'active'     => 'badge-active',
    'waitlisted' => 'badge-waitlisted',
  ];
  $class = $map[strtolower($status ?? 'pending')] ?? 'badge-pending';
  $label = ucfirst($status ?? 'pending');
@endphp

<span class="badge {{ $class }}">{{ $label }}</span>
