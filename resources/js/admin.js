/**
 * Digital Future Labs — Admin Panel JS
 * Handles: sidebar toggle, dropdowns, modals, toasts,
 *          table actions, filters, confirm dialogs
 */

'use strict';

/* ══════════════════════════════════════════════════════════════
   SIDEBAR TOGGLE (mobile)
══════════════════════════════════════════════════════════════ */
const sidebar      = document.querySelector('.admin-sidebar');
const sidebarToggle= document.querySelector('[data-sidebar-toggle]');
const sidebarOverlay = (() => {
  const el = document.createElement('div');
  el.className = 'sidebar-overlay';
  el.style.cssText = 'position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:99;display:none';
  document.body.appendChild(el);
  return el;
})();

function openSidebar() {
  sidebar?.classList.add('open');
  sidebarOverlay.style.display = 'block';
  document.body.style.overflow = 'hidden';
}
function closeSidebar() {
  sidebar?.classList.remove('open');
  sidebarOverlay.style.display = 'none';
  document.body.style.overflow = '';
}

sidebarToggle?.addEventListener('click', () => {
  sidebar?.classList.contains('open') ? closeSidebar() : openSidebar();
});
sidebarOverlay.addEventListener('click', closeSidebar);

/* ══════════════════════════════════════════════════════════════
   ACTIVE NAV ITEM (auto-highlight based on URL)
══════════════════════════════════════════════════════════════ */
document.querySelectorAll('.nav-item[href]').forEach(link => {
  if (link.href === window.location.href ||
      window.location.pathname.startsWith(new URL(link.href, location).pathname)) {
    link.classList.add('active');
  }
});

/* ══════════════════════════════════════════════════════════════
   DROPDOWN MENUS
══════════════════════════════════════════════════════════════ */
document.addEventListener('click', e => {
  const trigger = e.target.closest('[data-dropdown]');
  const openDropdowns = document.querySelectorAll('.dropdown.open');

  // Close all open dropdowns unless we clicked the same trigger
  openDropdowns.forEach(d => {
    if (!d.contains(e.target)) d.classList.remove('open');
  });

  if (trigger) {
    const dropdown = trigger.closest('.dropdown');
    dropdown?.classList.toggle('open');
    e.stopPropagation();
  }
});

/* ══════════════════════════════════════════════════════════════
   MODALS
══════════════════════════════════════════════════════════════ */
function openModal(id) {
  const backdrop = document.querySelector(`[data-modal="${id}"]`);
  backdrop?.classList.add('open');
  document.body.style.overflow = 'hidden';
}
function closeModal(id) {
  const backdrop = id
    ? document.querySelector(`[data-modal="${id}"]`)
    : document.querySelector('.modal-backdrop.open');
  backdrop?.classList.remove('open');
  document.body.style.overflow = '';
}

// Open via [data-modal-open="id"]
document.addEventListener('click', e => {
  const opener = e.target.closest('[data-modal-open]');
  if (opener) { openModal(opener.dataset.modalOpen); return; }

  const closer = e.target.closest('[data-modal-close], .modal-close');
  if (closer) { closeModal(closer.dataset.modalClose); return; }

  // Click backdrop to close
  if (e.target.classList.contains('modal-backdrop')) closeModal();
});

// ESC to close
document.addEventListener('keydown', e => {
  if (e.key === 'Escape') closeModal();
});

// Expose globally for Blade usage
window.openModal  = openModal;
window.closeModal = closeModal;

/* ══════════════════════════════════════════════════════════════
   TOAST NOTIFICATIONS
══════════════════════════════════════════════════════════════ */
const ICONS = {
  success: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
    <path d="M20 6L9 17l-5-5"/></svg>`,
  error: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
    <path d="M18 6L6 18M6 6l12 12"/></svg>`,
  warn: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
    <path d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>`,
  info: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
    <circle cx="12" cy="12" r="10"/><path d="M12 16v-4m0-4h.01"/></svg>`,
};

let toastContainer = document.querySelector('.toast-container');
if (!toastContainer) {
  toastContainer = document.createElement('div');
  toastContainer.className = 'toast-container';
  document.body.appendChild(toastContainer);
}

function showToast(type = 'success', title = '', message = '', duration = 4000) {
  const toast = document.createElement('div');
  toast.className = `toast ${type}`;
  toast.innerHTML = `
    <span class="toast-icon">${ICONS[type] || ICONS.info}</span>
    <div class="toast-content">
      ${title   ? `<div class="toast-title">${title}</div>`   : ''}
      ${message ? `<div class="toast-msg">${message}</div>` : ''}
    </div>`;

  toastContainer.appendChild(toast);

  setTimeout(() => {
    toast.classList.add('removing');
    toast.addEventListener('animationend', () => toast.remove(), { once: true });
  }, duration);
}

// Expose globally
window.showToast = showToast;

// Render flash messages from page (data-flash attributes on <body>)
document.addEventListener('DOMContentLoaded', () => {
  const body = document.body;
  ['success','error','warn','info'].forEach(type => {
    const msg = body.dataset[`flash${type.charAt(0).toUpperCase()+type.slice(1)}`];
    if (msg) showToast(type, '', msg);
  });
});

/* ══════════════════════════════════════════════════════════════
   CONFIRM DIALOG (replaces native confirm())
══════════════════════════════════════════════════════════════ */
function createConfirmDialog() {
  const el = document.createElement('div');
  el.className = 'modal-backdrop';
  el.setAttribute('data-modal', '__confirm__');
  el.innerHTML = `
    <div class="modal" style="max-width:400px">
      <div class="modal-header">
        <span class="modal-title" id="__confirm_title__">Confirm Action</span>
        <button class="modal-close" data-modal-close="__confirm__">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
        </button>
      </div>
      <div class="modal-body">
        <p id="__confirm_msg__" style="color:var(--text-muted);font-size:.88rem;line-height:1.6"></p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-outline btn-sm" data-modal-close="__confirm__">Cancel</button>
        <button class="btn btn-danger btn-sm" id="__confirm_ok__">Confirm</button>
      </div>
    </div>`;
  document.body.appendChild(el);
  return el;
}
const confirmDialog = createConfirmDialog();

function adminConfirm({ title = 'Confirm Action', message = 'Are you sure?', confirmText = 'Confirm', danger = true } = {}) {
  return new Promise(resolve => {
    document.getElementById('__confirm_title__').textContent = title;
    document.getElementById('__confirm_msg__').textContent   = message;
    const okBtn = document.getElementById('__confirm_ok__');
    okBtn.textContent = confirmText;
    okBtn.className = `btn btn-sm ${danger ? 'btn-danger' : 'btn-primary'}`;

    openModal('__confirm__');

    const handleOk = () => { cleanup(); closeModal('__confirm__'); resolve(true); };
    const handleCancel = () => { cleanup(); resolve(false); };

    function cleanup() {
      okBtn.removeEventListener('click', handleOk);
      confirmDialog.removeEventListener('click', backdropClick);
    }
    function backdropClick(e) {
      if (e.target === confirmDialog) handleCancel();
    }
    okBtn.addEventListener('click', handleOk, { once: true });
    confirmDialog.addEventListener('click', backdropClick);
  });
}
window.adminConfirm = adminConfirm;

/* ══════════════════════════════════════════════════════════════
   TABLE ACTIONS — Approve / Reject via AJAX or form submit
══════════════════════════════════════════════════════════════ */
document.addEventListener('click', async e => {
  // Approve button
  const approveBtn = e.target.closest('[data-action="approve"]');
  if (approveBtn) {
    const ok = await adminConfirm({
      title: 'Approve Application',
      message: `Approve application for ${approveBtn.dataset.name || 'this applicant'}?`,
      confirmText: 'Approve',
      danger: false,
    });
    if (ok) submitAction(approveBtn.dataset.url, 'approve', approveBtn);
    return;
  }

  // Reject button
  const rejectBtn = e.target.closest('[data-action="reject"]');
  if (rejectBtn) {
    const ok = await adminConfirm({
      title: 'Reject Application',
      message: `Reject application for ${rejectBtn.dataset.name || 'this applicant'}? This cannot be undone.`,
      confirmText: 'Reject',
    });
    if (ok) submitAction(rejectBtn.dataset.url, 'reject', rejectBtn);
    return;
  }

  // Delete button
  const deleteBtn = e.target.closest('[data-action="delete"]');
  if (deleteBtn) {
    const ok = await adminConfirm({
      title: 'Delete Record',
      message: 'This will permanently delete the record. Are you sure?',
      confirmText: 'Delete',
    });
    if (ok) submitAction(deleteBtn.dataset.url, 'delete', deleteBtn);
  }
});

function submitAction(url, action, triggerEl) {
  if (!url) return;

  const form = document.createElement('form');
  form.method = 'POST';
  form.action = url;
  form.style.display = 'none';

  const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';
  form.innerHTML = `
    <input type="hidden" name="_token"  value="${csrf}">
    <input type="hidden" name="_method" value="PATCH">
    <input type="hidden" name="action"  value="${action}">`;

  document.body.appendChild(form);

  // Optimistic UI: update row badge immediately
  const row = triggerEl?.closest('tr');
  if (row) {
    const badge = row.querySelector('.badge');
    if (badge) {
      badge.className = `badge badge-${action === 'approve' ? 'approved' : action === 'reject' ? 'rejected' : 'rejected'}`;
      badge.innerHTML = `${action.charAt(0).toUpperCase() + action.slice(1)}d`;
    }
    // Dim action buttons
    row.querySelectorAll('[data-action]').forEach(b => b.style.opacity = '.4');
  }

  form.submit();
}

/* ══════════════════════════════════════════════════════════════
   LIVE TABLE SEARCH (client-side filter, for small tables)
══════════════════════════════════════════════════════════════ */
document.querySelectorAll('[data-table-search]').forEach(input => {
  const tableId = input.dataset.tableSearch;
  const table = document.getElementById(tableId);
  if (!table) return;

  input.addEventListener('input', () => {
    const q = input.value.toLowerCase().trim();
    table.querySelectorAll('tbody tr').forEach(row => {
      row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
    updateEmptyState(table);
  });
});

function updateEmptyState(table) {
  const tbody = table.querySelector('tbody');
  const visible = [...tbody.querySelectorAll('tr')].filter(r => r.style.display !== 'none');
  let empty = tbody.querySelector('.empty-row');
  if (visible.length === 0 && !empty) {
    empty = document.createElement('tr');
    empty.className = 'empty-row';
    empty.innerHTML = `<td colspan="100%" style="text-align:center;padding:32px;color:var(--text-muted);font-size:.85rem;">No matching records found</td>`;
    tbody.appendChild(empty);
  } else if (visible.length > 0 && empty) {
    empty.remove();
  }
}

/* ══════════════════════════════════════════════════════════════
   STATUS FILTER TABS
══════════════════════════════════════════════════════════════ */
document.querySelectorAll('[data-filter-tab]').forEach(tab => {
  tab.addEventListener('click', () => {
    const group = tab.closest('[data-filter-group]');
    group?.querySelectorAll('[data-filter-tab]').forEach(t => t.classList.remove('active'));
    tab.classList.add('active');

    const status = tab.dataset.filterTab;
    const tableId = group?.dataset.filterGroup;
    const table = document.getElementById(tableId);
    if (!table) return;

    table.querySelectorAll('tbody tr').forEach(row => {
      if (status === 'all') { row.style.display = ''; return; }
      const badge = row.querySelector('.badge');
      const match = badge?.textContent.toLowerCase().includes(status);
      row.style.display = match ? '' : 'none';
    });
  });
});

/* ══════════════════════════════════════════════════════════════
   STAT COUNTER ANIMATION
══════════════════════════════════════════════════════════════ */
function animateCounter(el, target, duration = 1200) {
  const start = performance.now();
  const from  = 0;

  function step(now) {
    const progress = Math.min((now - start) / duration, 1);
    const ease = 1 - Math.pow(1 - progress, 3); // cubic ease-out
    el.textContent = Math.round(from + (target - from) * ease);
    if (progress < 1) requestAnimationFrame(step);
  }
  requestAnimationFrame(step);
}

const observer = new IntersectionObserver(entries => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      const el = entry.target;
      const target = parseInt(el.dataset.count, 10);
      if (!isNaN(target)) {
        animateCounter(el, target);
        observer.unobserve(el);
      }
    }
  });
}, { threshold: 0.3 });

document.querySelectorAll('[data-count]').forEach(el => observer.observe(el));

/* ══════════════════════════════════════════════════════════════
   COPY TO CLIPBOARD
══════════════════════════════════════════════════════════════ */
document.addEventListener('click', e => {
  const btn = e.target.closest('[data-copy]');
  if (!btn) return;
  navigator.clipboard.writeText(btn.dataset.copy).then(() => {
    showToast('success', 'Copied!', 'Text copied to clipboard.', 2000);
  });
});

/* ══════════════════════════════════════════════════════════════
   EXPORT (triggers download or opens export modal)
══════════════════════════════════════════════════════════════ */
document.addEventListener('click', e => {
  const btn = e.target.closest('[data-export]');
  if (!btn) return;
  const format = btn.dataset.export;
  const url    = btn.dataset.exportUrl;
  if (url) {
    window.location.href = `${url}?format=${format}`;
    showToast('info', 'Export started', `Your ${format.toUpperCase()} file is being prepared.`);
  }
});

/* ══════════════════════════════════════════════════════════════
   COLLAPSIBLE SIDEBAR SECTIONS
══════════════════════════════════════════════════════════════ */
document.querySelectorAll('[data-nav-collapse]').forEach(btn => {
  btn.addEventListener('click', () => {
    const section = btn.closest('.nav-section');
    section?.classList.toggle('collapsed');
  });
});
