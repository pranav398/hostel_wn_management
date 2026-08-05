<?php
    $title = "Settings - HWMM";
    include_once("includes/mheader.php");
?>
        <div>
            <h2 class="text-2xl font-extrabold tracking-tight text-slate-900 dark:text-white flex items-center gap-2">
                <i data-lucide="sliders" class="w-7 h-7 text-blue-600"></i>System Settings & Preferences
            </h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Configure theme, notification channels, accessibility, and account preferences.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 space-y-6">
            
                <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-4">
                    <h3 class="font-bold text-sm text-slate-900 dark:text-white flex items-center gap-2 border-b border-slate-100 dark:border-slate-800 pb-3">
                        <i data-lucide="palette" class="w-4 h-4 text-blue-600"></i> Appearance & Interface
                    </h3>

                    <div class="space-y-4 text-xs">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-bold text-slate-900 dark:text-white">Color Mode</p>
                                <p class="text-slate-500 text-[11px]">Switch between crisp Light mode and dark mode.</p>
                            </div>
                            <button onclick="toggleTheme()" class="px-4 py-2 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 text-slate-900 dark:text-white rounded-xl font-bold flex items-center gap-2 transition">
                                <i data-lucide="sun" class="w-4 h-4"></i>
                                <span>Toggle Mode</span>
                            </button>
                        </div>

                        <div class="flex items-center justify-between pt-3 border-t border-slate-100 dark:border-slate-800">
                            <div>
                                <p class="font-bold text-slate-900 dark:text-white">High Contrast UI</p>
                                <p class="text-slate-500 text-[11px]">Enhance borders and text legibility.</p>
                            </div>
                            <input type="checkbox" onchange="showToast('High contrast toggled', 'info')" class="w-4 h-4 text-blue-600 rounded">
                        </div>

                        <div class="flex items-center justify-between pt-3 border-t border-slate-100 dark:border-slate-800">
                            <div>
                                <p class="font-bold text-slate-900 dark:text-white">Reduced Motion & Animations</p>
                                <p class="text-slate-500 text-[11px]">Disable drum spin animations.</p>
                            </div>
                            <input type="checkbox" onchange="showToast('Reduced motion enabled', 'info')" class="w-4 h-4 text-blue-600 rounded">
                        </div>
                    </div>
                </div>

                <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-4">
                    <h3 class="font-bold text-sm text-slate-900 dark:text-white flex items-center gap-2 border-b border-slate-100 dark:border-slate-800 pb-3">
                        <i data-lucide="bell" class="w-4 h-4 text-blue-600"></i> Laundry Alerts & Notifications
                    </h3>

                    <div class="space-y-4 text-xs">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-bold text-slate-900 dark:text-white">SMS Reminder (10 mins before cycle end)</p>
                                <p class="text-slate-500 text-[11px]">Send text alert to +1 (555) 234-5678.</p>
                            </div>
                            <input type="checkbox" checked onchange="showToast('SMS preferences saved', 'success')" class="w-4 h-4 text-blue-600 rounded">
                        </div>

                        <div class="flex items-center justify-between pt-3 border-t border-slate-100 dark:border-slate-800">
                            <div>
                                <p class="font-bold text-slate-900 dark:text-white">Email Booking Confirmation Receipts</p>
                                <p class="text-slate-500 text-[11px]">Send PDF pass code to alex.rivera@hostel.edu.</p>
                            </div>
                            <input type="checkbox" checked onchange="showToast('Email preferences saved', 'success')" class="w-4 h-4 text-blue-600 rounded">
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="p-6 rounded-3xl bg-rose-50/50 dark:bg-rose-950/20 border border-rose-200 dark:border-rose-900 shadow-xs space-y-4">
                    <h3 class="font-bold text-sm text-rose-700 dark:text-rose-400 flex items-center gap-2">
                        <i data-lucide="alert-triangle" class="w-4 h-4"></i> Danger Zone
                    </h3>
                    <p class="text-xs text-rose-600/80 dark:text-rose-300/80">Be careful with these operations.</p>
                    <button onclick="localStorage.clear(); showToast('Local cache cleared! Reloading...', 'warning'); setTimeout(() => location.reload(), 800);" class="w-full py-2.5 px-4 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold transition shadow-xs">Clear Local State Cache</button>
                </div>
            </div>
        </div>
    </main>
</div>

<?php
    include_once("includes/mfooter.php");
?>
