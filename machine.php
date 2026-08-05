<?php
    $title = "Machine Telemetry - HWMM";
    include_once("includes/mheader.php");
?>

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
                    <a href="machines.php" class="hover:underline">Washing Machines</a>
                    <span>/</span>
                    <span class="text-blue-600 font-semibold">WM-03 Telemetry</span>
                </div>
                <h2 class="text-2xl font-extrabold tracking-tight text-slate-900 dark:text-white flex items-center gap-2">Machine 03 (Heavy Duty 12kg)
                    <span class="px-2.5 py-1 rounded-full bg-blue-100 text-blue-700 dark:bg-blue-950 dark:text-blue-300 text-xs font-bold">Ground Bay B</span>
                </h2>
            </div>

            <div class="flex items-center gap-2">
                <button onclick="openModal('report-modal')" class="px-4 py-2 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 text-slate-700 dark:text-slate-300 rounded-xl text-xs font-bold transition flex items-center gap-1.5 cursor-pointer">
                    <i data-lucide="alert-circle" class="w-4 h-4 text-amber-500"></i>
                    <span>Report Issue</span>
                </button>
                <a href="booking.php" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-xs transition flex items-center gap-1.5">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    <span>Book Next Slot</span>
                </a>
            </div>
        </div>

        <section class="p-6 sm:p-8 rounded-3xl bg-gradient-to-br from-slate-900 via-blue-950 to-slate-900 text-white shadow-xl relative overflow-hidden border border-slate-800 space-y-8">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-8">
            
                <div class="flex items-center gap-6">
                    <div class="relative w-32 h-32 sm:w-40 sm:h-40 rounded-full bg-slate-800 border-4 border-blue-500 flex items-center justify-center shadow-2xl shadow-blue-500/20">
                        <div class="w-24 h-24 sm:w-32 sm:h-32 rounded-full border-2 border-dashed border-blue-400 animate-washer-spin flex items-center justify-center">
                            <i data-lucide="waves" class="w-12 h-12 text-blue-400 opacity-60"></i>
                        </div>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span class="text-2xl font-black text-white">14m</span>
                            <span class="text-[10px] font-mono uppercase tracking-widest text-blue-300">Remaining</span>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <span class="px-2.5 py-0.5 rounded-full bg-blue-500/20 text-blue-300 border border-blue-400/30 text-[10px] font-mono uppercase font-bold tracking-widest">Live Sensor Output</span>
                        <h3 class="text-2xl font-extrabold text-white">Heavy Spin Cycle</h3>
                        <p class="text-xs text-slate-300">Resident: <strong class="text-blue-300">Alex Rivera (Room B-304)</strong></p>
                        <p class="text-xs text-slate-400">Security PIN Code: <strong class="text-white font-mono bg-slate-800 px-2 py-0.5 rounded">8492</strong></p>
                    </div>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 w-full lg:w-auto">
                    <div class="p-4 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-md">
                        <p class="text-[10px] uppercase font-bold text-slate-400">Spin Velocity</p>
                        <p class="text-xl font-extrabold text-white mt-1">1200 <span class="text-xs font-normal text-slate-400">RPM</span></p>
                    </div>

                    <div class="p-4 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-md">
                        <p class="text-[10px] uppercase font-bold text-slate-400">Water Temp</p>
                        <p class="text-xl font-extrabold text-white mt-1">40° <span class="text-xs font-normal text-slate-400">Celsius</span></p>
                    </div>

                    <div class="p-4 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-md">
                        <p class="text-[10px] uppercase font-bold text-slate-400">Water Fill</p>
                        <p class="text-xl font-extrabold text-white mt-1">68% <span class="text-xs font-normal text-slate-400">Level</span></p>
                    </div>

                    <div class="p-4 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-md">
                        <p class="text-[10px] uppercase font-bold text-slate-400">Power Rating</p>
                        <p class="text-xl font-extrabold text-white mt-1">1.2 <span class="text-xs font-normal text-slate-400">kW</span></p>
                    </div>
                </div>
            </div>

            <div class="space-y-2 pt-4 border-t border-slate-800">
                <div class="flex justify-between text-xs font-bold text-slate-300">
                    <span>Cycle Stage: High-Speed Extract</span>
                    <span class="text-blue-400">65% Completed</span>
                </div>

                <div class="w-full bg-slate-800 h-3 rounded-full overflow-hidden p-0.5"><div class="bg-gradient-to-r from-blue-500 to-indigo-400 h-full rounded-full w-[65%]"></div></div>

                <div class="grid grid-cols-5 text-[10px] font-bold text-center text-slate-400 pt-1">
                    <span class="text-emerald-400">✓ Pre-Wash</span>
                    <span class="text-emerald-400">✓ Main Wash</span>
                    <span class="text-blue-400 animate-pulse">● High Spin</span>
                    <span>Rinse + Softener</span>
                    <span>Door Unlock</span>
                </div>
            </div>
        </section>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-4">
                <h3 class="font-bold text-base text-slate-900 dark:text-white flex items-center gap-2">
                    <i data-lucide="clock" class="w-5 h-5 text-blue-600"></i>Today's Schedule for Machine 03
                </h3>

                <div class="space-y-3 text-xs">
                    <div class="p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-800/50 flex items-center justify-between">
                        <div>
                            <span class="font-bold text-slate-900 dark:text-white">09:00 AM - 10:00 AM</span>
                            <p class="text-slate-500 text-[11px]">Completed • Cottons 60°C</p>
                        </div>
                        <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold bg-slate-200 dark:bg-slate-700 text-slate-600 dark:text-slate-300">David Kim (B-201)</span>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-blue-50 dark:bg-blue-950/40 border border-blue-200 dark:border-blue-800 flex items-center justify-between">
                        <div>
                            <span class="font-bold text-blue-700 dark:text-blue-300">15:30 PM - 16:30 PM (ACTIVE)</span>
                            <p class="text-blue-600 dark:text-blue-400 text-[11px]">In Progress • Heavy Spin + Dry</p>
                        </div>
                        <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold bg-blue-600 text-white">Alex Rivera (You)</span>
                    </div>

                        <div class="p-3.5 rounded-2xl bg-emerald-50/50 dark:bg-emerald-950/30 border border-emerald-200/50 dark:border-emerald-800/40 flex items-center justify-between">
                        <div>
                            <span class="font-bold text-emerald-800 dark:text-emerald-300">18:00 PM - 19:00 PM</span>
                            <p class="text-emerald-600 text-[11px]">Slot Available for Booking</p>
                        </div>
                        <a href="booking.php" class="px-3 py-1 rounded-lg text-[10px] font-bold bg-emerald-600 text-white">Reserve Slot</a>
                    </div>
                </div>
            </div>

            <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-4">
                <h3 class="font-bold text-base text-slate-900 dark:text-white flex items-center gap-2">
                    <i data-lucide="shield-check" class="w-5 h-5 text-emerald-600"></i>Hardware Health Log
                </h3>

                <div class="space-y-3 text-xs">
                    <div class="flex justify-between py-1.5 border-b border-slate-100 dark:border-slate-800">
                        <span class="text-slate-500">Filter Status</span>
                        <span class="font-bold text-emerald-600">Cleaned 2 days ago</span>
                    </div>
                    <div class="flex justify-between py-1.5 border-b border-slate-100 dark:border-slate-800">
                        <span class="text-slate-500">Motor Health</span>
                        <span class="font-bold text-slate-900 dark:text-white">92% Calibrated</span>
                    </div>
                    <div class="flex justify-between py-1.5 border-b border-slate-100 dark:border-slate-800">
                        <span class="text-slate-500">Lifetime Cycles</span>
                        <span class="font-bold text-slate-900 dark:text-white">1,420 Washes</span>
                    </div>
                    <div class="flex justify-between py-1.5 border-b border-slate-100 dark:border-slate-800">
                        <span class="text-slate-500">Last Maintenance</span>
                        <span class="font-bold text-slate-900 dark:text-white">July 15, 2026</span>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<div id="report-modal" class="hidden fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-sm items-center justify-center p-4">
    <div class="bg-white dark:bg-slate-900 w-full max-w-md rounded-3xl p-6 shadow-2xl border border-slate-200 dark:border-slate-800 space-y-4">
        <h3 class="text-lg font-bold text-slate-900 dark:text-white">Report Machine 03 Issue</h3>
        <p class="text-xs text-slate-500">Submit a ticket directly to the Titanium Hostel Maintenance Warden.</p>

        <div>
            <label class="block text-xs font-semibold text-slate-500 mb-1">Issue Category</label>
            <select class="w-full p-2.5 bg-slate-50 dark:bg-slate-800 border rounded-xl text-xs">
                <option>Drainage / Water Not Pumped Out</option>
                <option>Excessive Vibration / Noise</option>
                <option>Door Lock Sensor Stuck</option>
                <option>Detergent Drawer Clogged</option>
            </select>
        </div>

        <div>
            <label class="block text-xs font-semibold text-slate-500 mb-1">Notes</label>
            <textarea placeholder="Describe issue details..." class="w-full p-2.5 bg-slate-50 dark:bg-slate-800 border rounded-xl text-xs h-20"></textarea>
        </div>

        <div class="flex gap-2">
            <button onclick="closeModal('report-modal')" class="flex-1 py-2.5 bg-slate-100 dark:bg-slate-800 rounded-xl text-xs font-bold">Cancel</button>
            <button onclick="closeModal('report-modal'); showToast('Ticket submitted to warden office', 'success')" class="flex-1 py-2.5 bg-rose-600 text-white rounded-xl text-xs font-bold">Submit Ticket</button>
        </div>
    </div>
</div>

<?php
    include_once("includes/mfooter.php");
?>
