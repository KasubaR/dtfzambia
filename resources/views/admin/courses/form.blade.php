{{--
  Reusable Course Form
  Include in create.blade.php and edit.blade.php
  Props: $course (optional, for edit mode)
--}}

@props(['course' => null])

@php $editing = !is_null($course); @endphp

<div class="grid-2" style="gap:24px;margin-bottom:0">

  {{-- ── Left Column: Core Fields ──────────────────────────── --}}
  <div style="display:flex;flex-direction:column;gap:0">

    {{-- Title --}}
    <div class="form-group">
      <label class="form-label" for="title">
        Course Title
        <span style="color:var(--danger)">*</span>
      </label>
      <input
        type="text"
        id="title"
        name="title"
        class="form-control @error('title') is-error @enderror"
        value="{{ old('title', $course?->title) }}"
        placeholder="e.g. Digital Marketing Masterclass"
        required
        maxlength="255">
      @error('title')
        <span style="color:var(--danger);font-size:.75rem;margin-top:5px;display:block">
          {{ $message }}
        </span>
      @enderror
    </div>

    {{-- Description --}}
    <div class="form-group">
      <label class="form-label" for="description">Description</label>
      <textarea
        id="description"
        name="description"
        class="form-control @error('description') is-error @enderror"
        rows="5"
        placeholder="Brief overview of what students will learn…">{{ old('description', $course?->description) }}</textarea>
      @error('description')
        <span style="color:var(--danger);font-size:.75rem;margin-top:5px;display:block">
          {{ $message }}
        </span>
      @enderror
      <div style="text-align:right;font-size:.72rem;color:var(--text-faint);margin-top:4px">
        <span id="descCount">0</span> / 1000
      </div>
    </div>

    {{-- Duration --}}
    <div class="form-group">
      <label class="form-label" for="duration">
        Duration
        <span style="color:var(--danger)">*</span>
      </label>
      <div style="display:flex;gap:10px">
        <input
          type="text"
          id="duration"
          name="duration"
          class="form-control @error('duration') is-error @enderror"
          value="{{ old('duration', $course?->duration) }}"
          placeholder="e.g. 3 Months"
          required
          style="flex:1">
        {{-- Quick presets --}}
        <div style="display:flex;gap:6px;flex-shrink:0">
          @foreach(['1 Month','3 Months','6 Months','1 Year'] as $preset)
            <button type="button"
                    class="btn btn-outline btn-sm duration-preset"
                    data-value="{{ $preset }}"
                    style="white-space:nowrap">
              {{ $preset }}
            </button>
          @endforeach
        </div>
      </div>
      @error('duration')
        <span style="color:var(--danger);font-size:.75rem;margin-top:5px;display:block">
          {{ $message }}
        </span>
      @enderror
    </div>

  </div>

  {{-- ── Right Column: Mode, Price & Meta ─────────────────── --}}
  <div style="display:flex;flex-direction:column;gap:0">

    {{-- Mode --}}
    <div class="form-group">
      <label class="form-label">
        Delivery Mode
        <span style="color:var(--danger)">*</span>
      </label>

      <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:10px">
        @foreach([
          ['value'=>'hybrid',   'label'=>'Hybrid',   'icon'=>'M8 3H5a2 2 0 00-2 2v3m18 0V5a2 2 0 00-2-2h-3m0 18h3a2 2 0 002-2v-3M3 16v3a2 2 0 002 2h3', 'color'=>'#4f9fff'],
          ['value'=>'online',   'label'=>'Online',   'icon'=>'M9 19V6l12-3v13M9 19c0 1.1-.9 2-2 2s-2-.9-2-2 .9-2 2-2 2 .9 2 2zm12-3c0 1.1-.9 2-2 2s-2-.9-2-2 .9-2 2-2 2 .9 2 2z', 'color'=>'#4fffb0'],
          ['value'=>'physical', 'label'=>'Physical', 'icon'=>'M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z', 'color'=>'#ffb74f'],
        ] as $mode)
          <label class="mode-card" for="mode_{{ $mode['value'] }}"
                 data-mode="{{ $mode['value'] }}"
                 style="--mc:{{ $mode['color'] }}">
            <input type="radio"
                   id="mode_{{ $mode['value'] }}"
                   name="mode"
                   value="{{ $mode['value'] }}"
                   {{ old('mode', $course?->mode) === $mode['value'] ? 'checked' : '' }}
                   style="display:none">
            <div class="mode-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                   style="width:20px;height:20px">
                <path d="{{ $mode['icon'] }}"/>
              </svg>
            </div>
            <span>{{ $mode['label'] }}</span>
          </label>
        @endforeach
      </div>
      @error('mode')
        <span style="color:var(--danger);font-size:.75rem;margin-top:5px;display:block">
          {{ $message }}
        </span>
      @enderror
    </div>

    {{-- Price --}}
    <div class="form-group">
      <label class="form-label" for="price">
        Price (₦)
        <span style="color:var(--danger)">*</span>
      </label>
      <div style="position:relative">
        <span style="position:absolute;left:13px;top:50%;transform:translateY(-50%);
                     color:var(--accent);font-weight:700;font-family:'Syne',sans-serif;
                     font-size:1rem;pointer-events:none">₦</span>
        <input
          type="number"
          id="price"
          name="price"
          class="form-control @error('price') is-error @enderror"
          value="{{ old('price', $course?->price) }}"
          placeholder="0"
          min="0"
          step="500"
          required
          style="padding-left:32px">
      </div>
      @error('price')
        <span style="color:var(--danger);font-size:.75rem;margin-top:5px;display:block">
          {{ $message }}
        </span>
      @enderror
      {{-- Price display --}}
      <div style="margin-top:6px;font-size:.78rem;color:var(--text-muted)">
        Formatted: <strong id="priceDisplay" style="color:var(--accent)">₦0</strong>
      </div>
    </div>

    {{-- Preview Card --}}
    <div style="margin-top:auto;padding-top:12px">
      <p style="font-size:.72rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;
                color:var(--text-faint);margin-bottom:10px">Live Preview</p>
      <div style="background:var(--surface-2);border:1px solid var(--border);
                  border-radius:var(--radius);padding:16px;position:relative;overflow:hidden">
        <div style="position:absolute;inset:0;background:linear-gradient(135deg,transparent 60%,rgba(79,255,176,.04))"></div>
        <div style="font-family:'Syne',sans-serif;font-size:.95rem;font-weight:800;
                    margin-bottom:6px;line-height:1.3" id="previewTitle">
          Course Title
        </div>
        <div style="font-size:.78rem;color:var(--text-muted);margin-bottom:12px;
                    display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden"
             id="previewDesc">Course description will appear here…</div>
        <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap">
          <span style="display:inline-flex;align-items:center;gap:5px;font-size:.75rem;
                       color:var(--text-muted)">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                 style="width:13px;height:13px">
              <circle cx="12" cy="12" r="10"/>
              <polyline points="12 6 12 12 16 14"/>
            </svg>
            <span id="previewDuration">Duration</span>
          </span>
          <span id="previewMode"
                style="display:inline-flex;align-items:center;gap:4px;font-size:.74rem;
                       font-weight:700;padding:2px 9px;border-radius:20px;
                       background:rgba(79,159,255,.12);color:#4f9fff">
            Mode
          </span>
          <span style="margin-left:auto;font-family:'Syne',sans-serif;font-weight:800;
                       color:var(--accent)" id="previewPrice">₦0</span>
        </div>
      </div>
    </div>

  </div>

</div>{{-- /.grid-2 --}}

{{-- ── Form styles (scoped) ──────────────────────────────── --}}
<style>
.mode-card {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 8px;
  padding: 16px 10px;
  border-radius: var(--radius);
  border: 1.5px solid var(--border);
  background: var(--surface-2);
  cursor: pointer;
  font-size: .82rem;
  font-weight: 600;
  color: var(--text-muted);
  transition: all .2s ease;
  text-align: center;
  user-select: none;
}
.mode-card:hover {
  border-color: var(--mc, var(--accent));
  color: var(--mc, var(--accent));
}
.mode-card:has(input:checked) {
  border-color: var(--mc, var(--accent));
  background: color-mix(in srgb, var(--mc, var(--accent)) 10%, transparent);
  color: var(--mc, var(--accent));
  box-shadow: 0 0 0 1px var(--mc, var(--accent));
}
.mode-icon {
  width: 38px; height: 38px;
  border-radius: 8px;
  background: color-mix(in srgb, var(--mc, var(--accent)) 12%, transparent);
  display: grid; place-items: center;
  color: var(--mc, var(--accent));
}
.form-control.is-error { border-color: var(--danger) !important; }
</style>

{{-- ── Form JS ───────────────────────────────────────────── --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
  const titleEl    = document.getElementById('title');
  const descEl     = document.getElementById('description');
  const durationEl = document.getElementById('duration');
  const priceEl    = document.getElementById('price');

  const pvTitle    = document.getElementById('previewTitle');
  const pvDesc     = document.getElementById('previewDesc');
  const pvDuration = document.getElementById('previewDuration');
  const pvMode     = document.getElementById('previewMode');
  const pvPrice    = document.getElementById('previewPrice');
  const priceDisp  = document.getElementById('priceDisplay');
  const descCount  = document.getElementById('descCount');

  const modeColors = {
    hybrid:   { bg: 'rgba(79,159,255,.12)', color: '#4f9fff' },
    online:   { bg: 'rgba(79,255,176,.12)', color: '#4fffb0' },
    physical: { bg: 'rgba(255,183,79,.12)', color: '#ffb74f' },
  };

  function update() {
    // Title
    pvTitle.textContent = titleEl.value || 'Course Title';

    // Description counter
    const dl = descEl.value.length;
    descCount.textContent = dl;
    descCount.style.color = dl > 900 ? 'var(--warn)' : '';
    pvDesc.textContent = descEl.value || 'Course description will appear here…';

    // Duration
    pvDuration.textContent = durationEl.value || 'Duration';

    // Mode
    const checked = document.querySelector('input[name="mode"]:checked');
    if (checked) {
      const mc = modeColors[checked.value] || { bg: 'var(--surface-3)', color: 'var(--text-muted)' };
      pvMode.textContent = checked.value.charAt(0).toUpperCase() + checked.value.slice(1);
      pvMode.style.background = mc.bg;
      pvMode.style.color = mc.color;
    }

    // Price
    const val = parseFloat(priceEl.value) || 0;
    const fmt = '₦' + val.toLocaleString('en-NG');
    pvPrice.textContent = fmt;
    priceDisp.textContent = fmt;
  }

  [titleEl, descEl, durationEl, priceEl].forEach(el => el?.addEventListener('input', update));
  document.querySelectorAll('input[name="mode"]').forEach(r => r.addEventListener('change', update));

  // Duration presets
  document.querySelectorAll('.duration-preset').forEach(btn => {
    btn.addEventListener('click', () => {
      durationEl.value = btn.dataset.value;
      update();
    });
  });

  update(); // initial
});
</script>
