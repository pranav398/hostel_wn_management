<?php
    $title = "Dashboard - HWMM";
    include_once("includes/mheader.php");
?>
      
        <section class="p-6 sm:p-8 rounded-3xl bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-950 text-white shadow-xl relative overflow-hidden border border-slate-800">
            <div class="absolute -right-10 -bottom-10 w-72 h-72 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>
        
            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                <div class="space-y-2">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/20 border border-blue-400/30 text-blue-300 text-xs font-semibold backdrop-blur-md">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>Titanium Block Laundry Hub • Ground Floor</span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Good afternoon, Alex 👋</h2>
                    <p class="text-slate-300 text-xs sm:text-sm max-w-xl leading-relaxed">Your heavy spin cycle on <strong class="text-blue-300">Machine 03</strong> is in progress. 14 minutes remaining until collection.</p>
                </div>

                <div class="flex items-center gap-3 shrink-0">
                    <a href="booking.php" class="px-5 py-3 rounded-2xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs shadow-lg shadow-blue-500/30 transition flex items-center gap-2">
                        <i data-lucide="plus-circle" class="w-4 h-4"></i>
                        <span>Book New Slot</span>
                    </a>
                    <a href="schedule.php" class="px-5 py-3 rounded-2xl bg-slate-800/80 hover:bg-slate-800 text-slate-200 border border-slate-700/80 font-bold text-xs backdrop-blur-md transition flex items-center gap-2">
                        <i data-lucide="calendar" class="w-4 h-4"></i>
                        <span>View Timetable</span>
                    </a>
                </div>
            </div>
        </section>

        <section class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 dark:bg-emerald-950/80 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0">
                    <i data-lucide="check-circle-2" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">Available Machines</p>
                    <p class="text-xl font-bold text-slate-900 dark:text-white mt-0.5">3 <span class="text-xs font-normal text-slate-400">/ 8 total</span></p>
                </div>
            </div>

            <div class="p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-950/80 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0">
                    <i data-lucide="ticket" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">Weekly Wash Tokens</p>
                    <p class="text-xl font-bold text-slate-900 dark:text-white mt-0.5">3 <span class="text-xs font-normal text-slate-400">/ 4 left</span></p>
                </div>
            </div>

            <div class="p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-amber-50 dark:bg-amber-950/80 text-amber-600 dark:text-amber-400 flex items-center justify-center shrink-0">
                    <i data-lucide="clock" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">Active Wash Time</p>
                    <p class="text-xl font-bold text-slate-900 dark:text-white mt-0.5">14m <span class="text-xs font-normal text-slate-400">remaining</span></p>
                </div>
            </div>

            <div class="p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-indigo-50 dark:bg-indigo-950/80 text-indigo-600 dark:text-indigo-400 flex items-center justify-center shrink-0">
                    <i data-lucide="award" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">On-Time Pickup Streak</p>
                    <p class="text-xl font-bold text-slate-900 dark:text-white mt-0.5">12 <span class="text-xs font-normal text-slate-400">washes (96.5%)</span></p>
                </div>
            </div>
        </section>

        <section class="p-6 sm:p-8 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-sm relative overflow-hidden">
            <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100 dark:border-slate-800">
                <div class="flex items-center gap-3">
                    <div class="w-3 h-3 rounded-full bg-blue-500 animate-ping"></div>
                    <h3 class="font-bold text-base text-slate-900 dark:text-white flex items-center gap-2">Active Wash Cycle
                        <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-blue-100 text-blue-700 dark:bg-blue-950 dark:text-blue-300">WM-03</span>
                    </h3>
                </div>
                <a href="machine.php" class="text-xs font-semibold text-blue-600 dark:text-blue-400 hover:underline flex items-center gap-1">
                    <span>Machine Telemetry</span>
                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-center">
                <div class="flex items-center gap-6 bg-slate-50 dark:bg-slate-800/50 p-5 rounded-2xl border border-slate-100 dark:border-slate-800">
                    <div class="relative w-24 h-24 shrink-0 flex items-center justify-center bg-slate-200 dark:bg-slate-700 rounded-3xl shadow-inner border-2 border-blue-500">
                        <i data-lucide="disc-3" class="w-14 h-14 text-blue-600 dark:text-blue-400 animate-washer-spin"></i>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-[11px] font-black text-slate-900 dark:text-white bg-white/80 dark:bg-slate-900/80 px-1.5 py-0.5 rounded shadow-xs">14m</span>
                        </div>
                    </div>

                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Machine 03 (Bay B)</p>
                        <h4 class="text-lg font-extrabold text-slate-900 dark:text-white mt-0.5">Heavy Spin + Rinse</h4>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Water Temp: <strong class="text-slate-700 dark:text-slate-200">40°C</strong> • Spin: <strong class="text-slate-700 dark:text-slate-200">1200 RPM</strong></p>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Est. Finish: <strong class="text-blue-600 dark:text-blue-400">16:10 PM</strong></p>
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="flex justify-between text-xs font-bold text-slate-700 dark:text-slate-300">
                        <span>Cycle Progress</span>
                        <span class="text-blue-600 dark:text-blue-400">65% Completed</span>
                    </div>
                
                    <div class="w-full bg-slate-100 dark:bg-slate-800 h-3 rounded-full overflow-hidden p-0.5">
                        <div class="bg-gradient-to-r from-blue-600 to-indigo-500 h-full rounded-full w-[65%] transition-all duration-500"></div>
                    </div>

                    <div class="grid grid-cols-4 gap-1 text-[10px] text-center font-medium text-slate-400 pt-1">
                        <span class="text-emerald-600 dark:text-emerald-400 font-bold">✓ Wash</span>
                        <span class="text-emerald-600 dark:text-emerald-400 font-bold">✓ Rinse</span>
                        <span class="text-blue-600 dark:text-blue-400 font-bold animate-pulse">● Spin</span>
                        <span>Sanitize</span>
                    </div>
                </div>

                <div class="p-4 rounded-2xl bg-blue-50/80 dark:bg-blue-950/40 border border-blue-100 dark:border-blue-900/60 flex flex-col justify-between h-full space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-blue-900 dark:text-blue-200 flex items-center gap-1.5">
                            <i data-lucide="key" class="w-4 h-4 text-blue-600"></i> Unlock Door Passcode
                        </span>
                        <span class="text-[10px] font-mono font-bold bg-blue-200/80 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-2 py-0.5 rounded">One-Time OTP</span>
                    </div>

                    <div class="flex items-center justify-center gap-2 py-1">
                        <span class="text-2xl font-mono font-extrabold tracking-widest text-slate-900 dark:text-white bg-white dark:bg-slate-900 px-4 py-1.5 rounded-xl border border-blue-200 dark:border-blue-800 shadow-xs">8492</span>
                    </div>

                    <p class="text-[11px] text-center text-blue-800/80 dark:text-blue-300/80">Enter this code on Machine 03 keypad when collecting laundry.</p>
                </div>
            </div>
        </section>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="font-bold text-base text-slate-900 dark:text-white flex items-center gap-2">
                        <i data-lucide="washing-machine" class="w-5 h-5 text-blue-600"></i>Machine Availability Overview
                    </h3>
                    <a href="machines.php" class="text-xs font-semibold text-blue-600 dark:text-blue-400 hover:underline">View All 8 Machines →</a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3" id="dashboard-machines-grid">
                    <div class="p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200/80 dark:border-slate-700/80 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-950 text-blue-600 flex items-center justify-center font-bold text-xs">WM-01</div>
                            <div>
                                <h4 class="text-xs font-bold text-slate-900 dark:text-white">Ground Bay A (10kg)</h4>
                                <p class="text-[11px] text-slate-500">22m left • David K.</p>
                            </div>
                        </div>
                        <span class="px-2 py-1 rounded-lg text-[10px] font-bold bg-blue-100 dark:bg-blue-950 text-blue-700 dark:text-blue-300">Operating</span>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-emerald-50/50 dark:bg-emerald-950/20 border border-emerald-200/60 dark:border-emerald-800/40 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-950 text-emerald-600 flex items-center justify-center font-bold text-xs">WM-02</div>
                            <div>
                                <h4 class="text-xs font-bold text-slate-900 dark:text-white">Ground Bay A (10kg)</h4>
                                <p class="text-[11px] text-emerald-600 dark:text-emerald-400 font-semibold">Idle • Ready to book</p>
                            </div>
                        </div>
                        <a href="booking.php" class="px-2.5 py-1 rounded-lg text-[10px] font-bold bg-emerald-600 text-white hover:bg-emerald-700 shadow-xs transition">Book Now</a>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-blue-50/60 dark:bg-blue-950/30 border border-blue-200/80 dark:border-blue-800/60 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center font-bold text-xs">WM-03</div>
                            <div>
                                <h4 class="text-xs font-bold text-slate-900 dark:text-white">Ground Bay B (12kg)</h4>
                                <p class="text-[11px] text-blue-600 dark:text-blue-400 font-semibold">You (Alex R.) • 14m left</p>
                            </div>
                        </div>
                        <span class="px-2 py-1 rounded-lg text-[10px] font-bold bg-blue-600 text-white">Your Wash</span>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-emerald-50/50 dark:bg-emerald-950/20 border border-emerald-200/60 dark:border-emerald-800/40 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-950 text-emerald-600 flex items-center justify-center font-bold text-xs">WM-04</div>
                            <div>
                                <h4 class="text-xs font-bold text-slate-900 dark:text-white">Ground Bay B (10kg)</h4>
                                <p class="text-[11px] text-emerald-600 dark:text-emerald-400 font-semibold">Idle • Ready to book</p>
                            </div>
                        </div>
                        <a href="booking.php" class="px-2.5 py-1 rounded-lg text-[10px] font-bold bg-emerald-600 text-white hover:bg-emerald-700 shadow-xs transition">Book Now</a>
                    </div>
                </div>
            </div>

            <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-4">
                <h3 class="font-bold text-base text-slate-900 dark:text-white flex items-center gap-2">
                    <i data-lucide="activity" class="w-5 h-5 text-indigo-600"></i>Recent Activity Log
                </h3>

                <div class="space-y-3 relative before:absolute before:inset-0 before:left-3.5 before:w-0.5 before:bg-slate-200 dark:before:bg-slate-800">
                    <div class="flex items-start gap-3 relative z-10">
                        <div class="w-7 h-7 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs shrink-0">
                            <i data-lucide="play" class="w-3.5 h-3.5"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-900 dark:text-white">Started Heavy Wash</p>
                            <p class="text-[11px] text-slate-500">WM-03 • Today 15:30 PM</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3 relative z-10">
                        <div class="w-7 h-7 rounded-full bg-emerald-600 text-white flex items-center justify-center text-xs shrink-0">
                            <i data-lucide="check" class="w-3.5 h-3.5"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-900 dark:text-white">Completed Wash Cycle</p>
                            <p class="text-[11px] text-slate-500">WM-01 • Aug 1, 10:00 AM</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3 relative z-10">
                        <div class="w-7 h-7 rounded-full bg-indigo-600 text-white flex items-center justify-center text-xs shrink-0">
                            <i data-lucide="ticket" class="w-3.5 h-3.5"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-900 dark:text-white">Weekly Allowance Allocated</p>
                            <p class="text-[11px] text-slate-500">4 Passes credited • Aug 1, 00:00 AM</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>   

<?php
    include_once("includes/mfooter.php");
?>