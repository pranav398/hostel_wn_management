/**
 * Main Architecture & Application State Manager
 * Hostel Washing Machine Management System
 */

// -----------------------------------------------------------------------------
// SESSION-ONLY DATA NOTE
// -----------------------------------------------------------------------------
// The old browser-side mock DB (`aurawash_db` in localStorage) has been removed.
// User profile, booking data, and other dashboard state should now come from the
// PHP session or from server-rendered data, not from a client-side localStorage DB.
//
// TODO:
// 1. Replace the placeholder/defaultData object below with data fetched from PHP
//    session variables or an API endpoint that reads from `$_SESSION`.
// 2. If you need to update booking state, send it to the server and refresh the
//    page instead of storing it in the browser.
// 3. Keep only non-sensitive UI preferences in localStorage (for example theme).
// -----------------------------------------------------------------------------

(function initDatabase() {
  // Clear the old browser persistence key so stale user data is not kept in the browser.
  // This is intentionally not a localStorage database anymore.
  if (window.localStorage) {
    window.localStorage.removeItem('aurawash_db');
  }
})();

const defaultData = {
  user: {
    name: 'Alex Rivera',
    studentId: 'STU20268841',
    room: 'B-304',
    block: 'Titanium Block',
    email: 'alex.rivera@hostel.edu',
    phone: '+1 (555) 234-5678',
    avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=250',
    washAllowance: 4,
    allowanceTotal: 4,
    totalWashesCompleted: 28,
    onTimePickupRate: '96.5%'
  },
  machines: [
    { id: 'WM-01', name: 'Machine 01', type: 'Front Load 10kg', status: 'Operating', user: 'David Kim (Room B-201)', timeRemainingMins: 22, cycle: 'Cottons 60°C', health: 98, queueLength: 1, floor: 'Ground Floor - Bay A' },
    { id: 'WM-02', name: 'Machine 02', type: 'Front Load 10kg', status: 'Available', user: 'None', timeRemainingMins: 0, cycle: 'Ready', health: 95, queueLength: 0, floor: 'Ground Floor - Bay A' },
    { id: 'WM-03', name: 'Machine 03', type: 'Heavy Duty 12kg', status: 'Operating', user: 'Alex Rivera (You - B-304)', timeRemainingMins: 14, cycle: 'Delicate / Heavy Spin', health: 92, queueLength: 0, floor: 'Ground Floor - Bay B' },
    { id: 'WM-04', name: 'Machine 04', type: 'Front Load 10kg', status: 'Available', user: 'None', timeRemainingMins: 0, cycle: 'Ready', health: 89, queueLength: 0, floor: 'Ground Floor - Bay B' },
    { id: 'WM-05', name: 'Machine 05', type: 'Steam Care 10kg', status: 'Reserved', user: 'Sarah Chen (Room C-102)', timeRemainingMins: 5, cycle: 'Starting Soon (16:00)', health: 100, queueLength: 2, floor: 'First Floor - Bay C' },
    { id: 'WM-06', name: 'Machine 06', type: 'Front Load 10kg', status: 'Maintenance', user: 'Technician Assigned', timeRemainingMins: 0, cycle: 'Drain Filter Repair', health: 45, queueLength: 0, floor: 'First Floor - Bay C' },
    { id: 'WM-07', name: 'Machine 07', type: 'Heavy Duty 12kg', status: 'Operating', user: 'Marcus Vance (Room A-402)', timeRemainingMins: 38, cycle: 'Eco Wash 40°C', health: 91, queueLength: 1, floor: 'Second Floor - Bay D' },
    { id: 'WM-08', name: 'Machine 08', type: 'Front Load 10kg', status: 'Available', user: 'None', timeRemainingMins: 0, cycle: 'Ready', health: 97, queueLength: 0, floor: 'Second Floor - Bay D' }
  ],
  activeBooking: {
    id: 'BK-9921',
    machineId: 'WM-03',
    machineName: 'Machine 03 (Heavy Duty 12kg)',
    slotDate: new Date().toISOString().split('T')[0],
    slotTime: '15:30 - 16:30',
    cycleType: 'Quick Eco + Softener',
    temperature: '40°C',
    status: 'In Progress',
    startedAt: new Date(Date.now() - 26 * 60 * 1000).toISOString(),
    durationMins: 40,
    pinCode: '8492'
  },
  bookingsHistory: [
    { id: 'BK-9921', date: new Date().toISOString().split('T')[0], time: '15:30 - 16:30', machine: 'WM-03 (Bay B)', status: 'In Progress', cycle: 'Quick Eco', cost: '1 Pass' },
    { id: 'BK-9810', date: '2026-08-01', time: '10:00 - 11:00', machine: 'WM-01 (Bay A)', status: 'Completed', cycle: 'Cottons 60°C', cost: '1 Pass' },
    { id: 'BK-9754', date: '2026-07-25', time: '18:00 - 19:00', machine: 'WM-04 (Bay B)', status: 'Completed', cycle: 'Heavy Wash', cost: '1 Pass' },
    { id: 'BK-9689', date: '2026-07-18', time: '14:00 - 15:00', machine: 'WM-02 (Bay A)', status: 'Cancelled', cycle: 'Delicates', cost: 'Refunded' },
    { id: 'BK-9512', date: '2026-07-11', time: '09:00 - 10:00', machine: 'WM-08 (Bay D)', status: 'Completed', cycle: 'Express 30', cost: '1 Pass' }
  ],
  notifications: [
    { id: 1, title: 'Wash Cycle Halfway Done', message: 'WM-03 has 14 minutes remaining. Get ready to collect your laundry.', time: '10 mins ago', unread: true, type: 'info' },
    { id: 2, title: 'Weekly Allowance Renewed', message: 'You have been allocated 4 wash passes for this week.', time: '2 days ago', unread: false, type: 'success' },
    { id: 3, title: 'Maintenance Notice', message: 'Machine 06 will undergo filter cleaning today from 14:00 to 17:00.', time: '1 day ago', unread: false, type: 'warning' }
  ]
};

// -----------------------------------------------------------------------------
// SESSION-FIRST DATA HELPER
// -----------------------------------------------------------------------------
// This helper intentionally does not use browser localStorage for user state.
// Replace the placeholder object below with data from PHP `$_SESSION` or a
// server endpoint when you are ready to wire the UI to real authenticated data.
//
// Notes for future edits:
//   - `get()` should read the PHP session payload or AJAX response.
//   - `save()` should send updates to the server, not store them in the browser.
//   - Keep theme settings in localStorage only if you still want them to persist.
// -----------------------------------------------------------------------------
window.AuraWashDB = {
  data: defaultData,

  get: function () {
    // TODO: return session-backed data from the server instead of the placeholder.
    return this.data;
  },

  save: function (data) {
    // TODO: send the updated state to the backend instead of saving it locally.
    this.data = data;
  },

  addBooking: function (booking) {
    const db = this.get();
    db.activeBooking = booking;
    db.bookingsHistory.unshift({
      id: booking.id,
      date: booking.slotDate,
      time: booking.slotTime,
      machine: booking.machineName,
      status: 'Confirmed',
      cycle: booking.cycleType,
      cost: '1 Pass'
    });
    db.user.washAllowance = Math.max(0, db.user.washAllowance - 1);
    this.save(db);
  },

  cancelBooking: function () {
    const db = this.get();
    if (db.activeBooking) {
      db.activeBooking.status = 'Cancelled';
      if (db.bookingsHistory.length > 0) {
        db.bookingsHistory[0].status = 'Cancelled';
      }
      db.user.washAllowance = Math.min(db.user.allowanceTotal, db.user.washAllowance + 1);
      db.activeBooking = null;
      this.save(db);
    }
  }
};

// Global Toast System
window.showToast = function (message, type = 'info', title = '') {
    let container = document.getElementById('toast-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toast-container';
        container.className = 'fixed bottom-5 right-5 z-50 flex flex-col gap-2 max-w-sm w-full pointer-events-none px-4 sm:px-0';
        document.body.appendChild(container);
    }

    const toast = document.createElement('div');
    toast.className = `pointer-events-auto flex items-start gap-3 p-4 rounded-xl shadow-lg border text-sm font-medium animate-toast backdrop-blur-md transition-all ${type === 'success'
            ? 'bg-emerald-50 dark:bg-emerald-950/80 text-emerald-900 dark:text-emerald-200 border-emerald-200 dark:border-emerald-800'
            : type === 'warning'
                ? 'bg-amber-50 dark:bg-amber-950/80 text-amber-900 dark:text-amber-200 border-amber-200 dark:border-amber-800'
                : type === 'error'
                    ? 'bg-rose-50 dark:bg-rose-950/80 text-rose-900 dark:text-rose-200 border-rose-200 dark:border-rose-800'
                    : 'bg-slate-900 dark:bg-slate-800 text-white border-slate-700'
        }`;

    const iconName = type === 'success' ? 'check-circle-2' : type === 'warning' ? 'alert-triangle' : type === 'error' ? 'x-circle' : 'info';

    toast.innerHTML = `
    <i data-lucide="${iconName}" class="w-5 h-5 shrink-0 mt-0.5"></i>
    <div class="flex-1">
      ${title ? `<h4 class="font-semibold text-xs uppercase tracking-wider mb-0.5 opacity-90">${title}</h4>` : ''}
      <p class="leading-relaxed">${message}</p>
    </div>
    <button onclick="this.parentElement.remove()" class="text-current opacity-60 hover:opacity-100 p-0.5 rounded">
      <i data-lucide="x" class="w-4 h-4"></i>
    </button>
  `;

    container.appendChild(toast);
    if (window.lucide) lucide.createIcons();

    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(10px)';
        setTimeout(() => toast.remove(), 300);
    }, 4000);
};

// Modal Helper
window.openModal = function (id) {
    const modal = document.getElementById(id);
    if (modal) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.classList.add('overflow-hidden');
    }
};

window.closeModal = function (id) {
    const modal = document.getElementById(id);
    if (modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.classList.remove('overflow-hidden');
    }
};

// Common Layout Injection Engine
document.addEventListener('DOMContentLoaded', () => {
    const path = window.location.pathname;
    const page = path.split('/').pop() || 'index.php';

    // Do not inject main header/sidebar into login page (index.php) or 404 page if standalone
    if (page === 'index.php' || page === '') {
        if (window.lucide) lucide.createIcons();
        return;
    }

    const db = AuraWashDB.get();
    const activeBookingMarkup = db.activeBooking
        ? `
            <a href="machine.php" class="hidden sm:flex items-center gap-2 px-3 py-1.5 rounded-full bg-blue-50 dark:bg-blue-950/60 border border-blue-200 dark:border-blue-800 text-blue-700 dark:text-blue-300 text-xs font-semibold hover:bg-blue-100 transition">
              <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
              </span>
              <span>WM-03 Active (14m left)</span>
            </a>
          `
        : '';

    // 1. Header Layout Injection
    const headerContainer = document.getElementById('app-header');

    // 2. Sidebar Layout Injection
    const sidebarContainer = document.getElementById('app-sidebar');
    if (sidebarContainer) {
        const navItems = [
            { page: 'dashboard.php', label: 'Dashboard', icon: 'layout-dashboard' },
            { page: 'booking.php', label: 'Book Slot', icon: 'calendar-plus' },
            { page: 'schedule.php', label: 'Weekly Schedule', icon: 'calendar-days' },
            { page: 'machines.php', label: 'Washing Machines', icon: 'washing-machine' },
            { page: 'history.php', label: 'Booking History', icon: 'history' },
            { page: 'profile.php', label: 'My Profile', icon: 'user' },
            { page: 'settings.php', label: 'Settings', icon: 'sliders' },
            { page: 'about.php', label: 'Guidelines & About', icon: 'info' }
        ];

        // Bind Mobile Toggle
        const toggleBtn = document.getElementById('mobile-sidebar-toggle');
        const drawer = document.getElementById('sidebar-drawer');
        if (toggleBtn && drawer) {
            toggleBtn.addEventListener('click', () => {
                drawer.classList.toggle('-translate-x-full');
            });
        }
    }

    // 3. Footer Layout Injection
    const footerContainer = document.getElementById('app-footer');

    // 4. Global Search Modal Injection
    if (!document.getElementById('search-modal')) {
        const modalDiv = document.createElement('div');
        modalDiv.id = 'search-modal';
        modalDiv.className = 'hidden fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-sm items-center justify-center p-4';
        modalDiv.innerHTML = `
      <div class="bg-white dark:bg-slate-900 w-full max-w-xl rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-800 overflow-hidden">
        <div class="p-4 border-b border-slate-200 dark:border-slate-800 flex items-center gap-3">
          <i data-lucide="search" class="w-5 h-5 text-slate-400"></i>
          <input id="modal-search-input" type="text" placeholder="Search machines, schedules, user rules..." class="flex-1 bg-transparent text-sm text-slate-900 dark:text-white focus:outline-none" oninput="handleGlobalSearch(this.value)">
          <button onclick="closeModal('search-modal')" class="p-1 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-400">
            <kbd class="text-[10px] font-mono px-1.5 py-0.5 border rounded">ESC</kbd>
          </button>
        </div>
        <div id="search-results" class="p-4 max-h-80 overflow-y-auto space-y-2 text-xs">
          <div class="text-slate-400 text-center py-6">Type to search across washing machines, slot availability, and guidelines.</div>
        </div>
      </div>
    `;
        document.body.appendChild(modalDiv);
    }

    // Global Keybindings (Ctrl+K or Slash to open search)
    document.addEventListener('keydown', (e) => {
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            openModal('search-modal');
            setTimeout(() => document.getElementById('modal-search-input')?.focus(), 100);
        }
        if (e.key === 'Escape') {
            closeModal('search-modal');
        }
    });

    // Re-initialize Lucide Icons across all rendered blocks
    if (window.lucide) lucide.createIcons();
});

// Dropdown Helper Listeners
window.toggleNotifications = function () {
    const menu = document.getElementById('notifications-menu');
    if (menu) menu.classList.toggle('hidden');
};

window.toggleUserMenu = function () {
    const menu = document.getElementById('user-dropdown-menu');
    if (menu) menu.classList.toggle('hidden');
};

window.clearNotifications = function () {
    const db = AuraWashDB.get();
    db.notifications = [];
    AuraWashDB.save(db);
    showToast('All notifications cleared', 'success');
    const menu = document.getElementById('notifications-menu');
    if (menu) menu.classList.add('hidden');
};

// Global Search Logic
window.handleGlobalSearch = function (query) {
    const resultsDiv = document.getElementById('search-results');
    if (!resultsDiv) return;
    if (!query.trim()) {
        resultsDiv.innerHTML = `<div class="text-slate-400 text-center py-6">Type to search across washing machines, slot availability, and guidelines.</div>`;
        return;
    }

    const q = query.toLowerCase();
    const db = AuraWashDB.get();

    const matchedMachines = db.machines.filter((m) => m.name.toLowerCase().includes(q) || m.floor.toLowerCase().includes(q) || m.status.toLowerCase().includes(q));

    const matchedPages = [
        { title: 'Book a Slot', url: 'booking.php', desc: 'Reserve an available machine slot for today or this week.' },
        { title: 'Weekly Timetable', url: 'schedule.php', desc: 'View live color-coded calendar grid of machine usage.' },
        { title: 'Washing Machine Fleet', url: 'machines.php', desc: 'Check health, telemetry, and queue lengths for all 8 machines.' },
        { title: 'Hostel Guidelines & Rules', url: 'about.php', desc: 'Detergent dosages, lost item protocol, and maximum load limits.' }
    ].filter((p) => p.title.toLowerCase().includes(q) || p.desc.toLowerCase().includes(q));

    let html = '';

    if (matchedMachines.length > 0) {
        html += `<div class="font-bold text-[10px] text-slate-400 uppercase tracking-wider mb-1">Washing Machines</div>`;
        html += matchedMachines
            .map(
                (m) => `
      <a href="machine.php" class="flex items-center justify-between p-2.5 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition">
        <div class="flex items-center gap-2">
          <i data-lucide="washing-machine" class="w-4 h-4 text-blue-600"></i>
          <div>
            <p class="font-semibold text-slate-900 dark:text-white">${m.name} (${m.type})</p>
            <p class="text-[11px] text-slate-500">${m.floor}</p>
          </div>
        </div>
        <span class="px-2 py-0.5 rounded text-[10px] font-bold ${m.status === 'Available' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300' : 'bg-blue-100 text-blue-700 dark:bg-blue-950 dark:text-blue-300'
                    }">${m.status}</span>
      </a>
    `
            )
            .join('');
    }

    if (matchedPages.length > 0) {
        html += `<div class="font-bold text-[10px] text-slate-400 uppercase tracking-wider mt-3 mb-1">Quick Links</div>`;
        html += matchedPages
            .map(
                (p) => `
      <a href="${p.url}" class="block p-2.5 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition">
        <p class="font-semibold text-slate-900 dark:text-white">${p.title}</p>
        <p class="text-[11px] text-slate-500">${p.desc}</p>
      </a>
    `
            )
            .join('');
    }

    if (!html) {
        html = `<div class="text-slate-400 text-center py-6">No matching machines or pages found for "${query}".</div>`;
    }

    resultsDiv.innerHTML = html;
    if (window.lucide) lucide.createIcons();
};
