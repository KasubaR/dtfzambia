{{--
  Reusable Action Buttons Component
  Use inside table rows or detail panels.

  Props:
    $type         — 'row-actions' | 'form-actions' | 'approve-reject'
    $viewUrl      — route for View button
    $editUrl      — route for Edit button
    $updateUrl    — route for approve/reject PATCH
    $deleteUrl    — route for delete
    $name         — applicant/record name (for confirm dialogs)
    $status       — current status (hides approve/reject if already processed)
    $cancelUrl    — route for cancel/back
    $submitLabel  — label for submit button (default 'Save')
--}}

@props([
  'type'        => 'row-actions',
  'viewUrl'     => null,
  'editUrl'     => null,
  'updateUrl'   => null,
  'deleteUrl'   => null,
  'name'        => 'this record',
  'status'      => null,
  'cancelUrl'   => null,
  'submitLabel' => 'Save Changes',
])

@if($type === 'row-actions')
  <div style="display:flex;gap:6px">

    @if($viewUrl)
      <a href="{{ $viewUrl }}" class="btn btn-sm btn-outline">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
          <circle cx="12" cy="12" r="3"/>
        </svg>
        View
      </a>
    @endif

    @if($editUrl)
      <a href="{{ $editUrl }}" class="btn btn-sm btn-outline">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
          <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
        </svg>
        Edit
      </a>
    @endif

    @if($deleteUrl)
      <button class="btn btn-sm btn-danger"
              data-action="delete"
              data-url="{{ $deleteUrl }}"
              data-name="{{ $name }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <polyline points="3 6 5 6 21 6"/>
          <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
          <path d="M10 11v6M14 11v6"/>
          <path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/>
        </svg>
      </button>
    @endif

  </div>

@elseif($type === 'approve-reject')
  <div style="display:flex;gap:6px">

    @if($viewUrl)
      <a href="{{ $viewUrl }}" class="btn btn-sm btn-outline">View</a>
    @endif

    @if($updateUrl && $status === 'pending')
      <button class="btn btn-sm btn-success"
              data-action="approve"
              data-url="{{ $updateUrl }}"
              data-name="{{ $name }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
          <path d="M20 6L9 17l-5-5"/>
        </svg>
        Approve
      </button>
      <button class="btn btn-sm btn-danger"
              data-action="reject"
              data-url="{{ $updateUrl }}"
              data-name="{{ $name }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
          <path d="M18 6L6 18M6 6l12 12"/>
        </svg>
        Reject
      </button>
    @endif

  </div>

@elseif($type === 'form-actions')
  <div style="display:flex;gap:10px;align-items:center">

    @if($cancelUrl)
      <a href="{{ $cancelUrl }}" class="btn btn-outline">
        Cancel
      </a>
    @endif

    <button type="submit" class="btn btn-primary">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
        <path d="M20 6L9 17l-5-5"/>
      </svg>
      {{ $submitLabel }}
    </button>

  </div>
@endif
