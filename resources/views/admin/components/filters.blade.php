{{--
  Reusable Filters Bar Component
  Props:
    $tableId    (string)  — ID of the target <table>
    $statuses   (array)   — ['all', 'pending', 'approved', 'rejected'] — tab options
    $search     (bool)    — show search input (default true)
    $exports    (bool)    — show export buttons (default false)
    $exportUrl  (string)  — base URL for exports
--}}

@props([
  'tableId'   => 'dataTable',
  'statuses'  => ['all', 'pending', 'approved', 'rejected'],
  'search'    => true,
  'exports'   => false,
  'exportUrl' => '',
])

<div class="filters-bar" data-filter-group="{{ $tableId }}">

  {{-- Status Tabs --}}
  <div style="display:flex;gap:6px;flex-wrap:wrap">
    @foreach($statuses as $idx => $status)
      <button
        class="btn btn-sm {{ $idx === 0 ? 'btn-primary' : 'btn-outline' }}"
        data-filter-tab="{{ $status }}">
        {{ ucfirst($status) }}
      </button>
    @endforeach
  </div>

  {{-- Search --}}
  @if($search)
    <div style="margin-left:auto;display:flex;gap:8px;align-items:center">
      <input
        type="text"
        class="filter-input"
        placeholder="Search…"
        data-table-search="{{ $tableId }}"
        style="width:220px">
    </div>
  @endif

  {{-- Export Buttons --}}
  @if($exports && $exportUrl)
    <div class="dropdown" style="{{ $search ? '' : 'margin-left:auto' }}">
      <button class="btn btn-sm btn-outline" data-dropdown>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/>
          <polyline points="7 10 12 15 17 10"/>
          <line x1="12" y1="15" x2="12" y2="3"/>
        </svg>
        Export
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
             style="width:12px;height:12px">
          <polyline points="6 9 12 15 18 9"/>
        </svg>
      </button>
      <div class="dropdown-menu">
        <button class="dropdown-item"
                data-export="csv"
                data-export-url="{{ $exportUrl }}">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
            <polyline points="14 2 14 8 20 8"/>
          </svg>
          Export CSV
        </button>
        <button class="dropdown-item"
                data-export="pdf"
                data-export-url="{{ $exportUrl }}">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
            <polyline points="14 2 14 8 20 8"/>
            <line x1="16" y1="13" x2="8" y2="13"/>
            <line x1="16" y1="17" x2="8" y2="17"/>
          </svg>
          Export PDF
        </button>
      </div>
    </div>
  @endif

</div>
