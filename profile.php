<?php
    $title = "User Profile - HWMM";
    include_once("includes/mheader.php");
?>
        <section class="p-6 sm:p-8 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-sm relative overflow-hidden">
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
            <!-- <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=250" alt="Alex Rivera" class="w-24 h-24 rounded-3xl object-cover ring-4 ring-blue-500/30 shadow-lg"> -->
            
                <div class="space-y-2 text-center sm:text-left flex-1">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <div>
                            <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white flex items-center justify-center sm:justify-start gap-2">Alex Rivera
                                <span class="px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-700 dark:bg-blue-950 dark:text-blue-300 text-xs font-bold">Resident Student</span>
                            </h2>
                            <p class="text-xs text-slate-500 mt-0.5">Titanium Block • Room B-304 • Student ID STU20268841</p>
                        </div>

                        <a href="settings.php" class="px-4 py-2 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 text-slate-700 dark:text-slate-300 rounded-2xl text-xs font-bold transition flex items-center gap-1.5 justify-center">
                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                            <span>Edit Profile</span>
                        </a>
                    </div>

                    <div class="flex flex-wrap items-center justify-center sm:justify-start gap-4 text-xs text-slate-500 dark:text-slate-400 pt-2 border-t border-slate-100 dark:border-slate-800">
                        <span class="flex items-center gap-1.5"><i data-lucide="mail" class="w-4 h-4 text-blue-600"></i> alex.rivera@hostel.edu</span>
                        <span class="flex items-center gap-1.5"><i data-lucide="phone" class="w-4 h-4 text-blue-600"></i> +1 (555) 234-5678</span>
                        <span class="flex items-center gap-1.5"><i data-lucide="shield" class="w-4 h-4 text-emerald-600"></i> Verified Resident</span>
                    </div>
                </div>
            </div>
        </section>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="p-6 rounded-3xl bg-gradient-to-br from-blue-600 to-indigo-700 text-white shadow-xl space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-blue-200">Weekly Quota</span>
                    <span class="px-2 py-0.5 rounded bg-white/20 text-[10px] font-mono font-bold">Resets Monday 00:00</span>
                </div>

                <div>
                    <h3 class="text-3xl font-black">3 / 4 Tokens</h3>
                    <p class="text-xs text-blue-100 mt-1">1 token deducted for active Machine 03 cycle.</p>
                </div>

                <div class="w-full bg-blue-900/50 h-3 rounded-full overflow-hidden p-0.5 border border-blue-400/30">
                    <div class="bg-white h-full rounded-full w-[75%]"></div>
                </div>

                <p class="text-[11px] text-blue-200">Tokens are automatically refilled by hostel warden office every week.</p>
            </div>

            <div class="lg:col-span-2 grid grid-cols-2 sm:grid-cols-3 gap-4">
                <div class="p-5 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs flex flex-col justify-between">
                    <i data-lucide="washing-machine" class="w-6 h-6 text-blue-600 mb-2"></i>
                    <div>
                        <p class="text-xs text-slate-400 font-medium">Total Washes</p>
                        <p class="text-2xl font-extrabold text-slate-900 dark:text-white mt-0.5">28 <span class="text-xs font-normal text-slate-400">Cycles</span></p>
                    </div>
                </div>

                <div class="p-5 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs flex flex-col justify-between">
                    <i data-lucide="clock" class="w-6 h-6 text-emerald-600 mb-2"></i>
                    <div>
                        <p class="text-xs text-slate-400 font-medium">On-Time Rate</p>
                        <p class="text-2xl font-extrabold text-slate-900 dark:text-white mt-0.5">96.5% <span class="text-xs font-normal text-emerald-600">Punctual</span></p>
                    </div>
                </div>

                <div class="p-5 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs flex flex-col justify-between col-span-2 sm:col-span-1">
                    <i data-lucide="leaf" class="w-6 h-6 text-emerald-500 mb-2"></i>
                    <div>
                        <p class="text-xs text-slate-400 font-medium">Eco Water Saved</p>
                        <p class="text-2xl font-extrabold text-slate-900 dark:text-white mt-0.5">420 <span class="text-xs font-normal text-slate-400">Liters</span></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- <section class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-4">
            <h3 class="font-bold text-base text-slate-900 dark:text-white flex items-center gap-2">
                <i data-lucide="award" class="w-5 h-5 text-amber-500"></i>Resident Achievements & Badges
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="p-4 rounded-2xl bg-amber-50/60 dark:bg-amber-950/30 border border-amber-200/80 dark:border-amber-800/60 flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-amber-100 dark:bg-amber-900 text-amber-600 text-xl flex items-center justify-center shrink-0 shadow-xs">🏆</div>
                    <div>
                        <h4 class="font-bold text-xs text-slate-900 dark:text-white">Punctual Picker</h4>
                        <p class="text-[11px] text-slate-500 mt-0.5">Picked up clothes within 5m 10 times in a row.</p>
                    </div>
                </div>

                <div class="p-4 rounded-2xl bg-emerald-50/60 dark:bg-emerald-950/30 border border-emerald-200/80 dark:border-emerald-800/60 flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 dark:bg-emerald-900 text-emerald-600 text-xl flex items-center justify-center shrink-0 shadow-xs">🌿</div>
                    <div>
                        <h4 class="font-bold text-xs text-slate-900 dark:text-white">Eco Hero</h4>
                        <p class="text-[11px] text-slate-500 mt-0.5">Used 30°C Eco cycle preset 15+ times.</p>
                    </div>
                </div>

                <div class="p-4 rounded-2xl bg-indigo-50/60 dark:bg-indigo-950/30 border border-indigo-200/80 dark:border-indigo-800/60 flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-100 dark:bg-indigo-900 text-indigo-600 text-xl flex items-center justify-center shrink-0 shadow-xs">🌙</div>
                    <div>
                        <h4 class="font-bold text-xs text-slate-900 dark:text-white">Night Owl</h4>
                        <p class="text-[11px] text-slate-500 mt-0.5">Completed 5 quiet late-night washes.</p>
                    </div>
                </div>

                <div class="p-4 rounded-2xl bg-blue-50/60 dark:bg-blue-950/30 border border-blue-200/80 dark:border-blue-800/60 flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-blue-100 dark:bg-blue-900 text-blue-600 text-xl flex items-center justify-center shrink-0 shadow-xs">🥇</div>
                    <div>
                        <h4 class="font-bold text-xs text-slate-900 dark:text-white">Laundry Master</h4>
                        <p class="text-[11px] text-slate-500 mt-0.5">Completed 25+ successful wash cycles.</p>
                    </div>
                </div>
            </div>
        </section> -->
    </main>
</div>

<?php
    include_once("includes/mfooter.php");
?>
