<?php
    $title = "Hostel Guidelines - HWMM";
    include_once("includes/mheader.php");
?>

        <section class="p-6 sm:p-8 rounded-3xl bg-gradient-to-br from-blue-900 via-indigo-900 to-slate-900 text-white shadow-xl relative overflow-hidden border border-slate-800 space-y-3">
            <span class="px-3 py-1 rounded-full bg-blue-500/20 text-blue-300 text-xs font-bold uppercase tracking-wider border border-blue-400/30">Titanium Hostel Administration</span>
            <h2 class="text-3xl font-extrabold tracking-tight">Hostel Laundry Guidelines & Rules</h2>
            <p class="text-xs sm:text-sm text-slate-300 max-w-2xl leading-relaxed">Please follow these operational rules to keep our shared washing machine fleet running reliably, efficiently, and fairly for all hostel residents.</p>
        </section>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-2">
                <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-950 text-blue-600 flex items-center justify-center font-bold text-lg mb-2">1</div>
                <h3 class="font-bold text-sm text-slate-900 dark:text-white">Punctual Collection</h3>
                <p class="text-xs text-slate-500 leading-relaxed">Remove your washed clothes within 10 minutes of cycle completion so the next reserved student can begin on time.</p>
            </div>

            <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-2">
                <div class="w-10 h-10 rounded-xl bg-indigo-100 dark:bg-indigo-950 text-indigo-600 flex items-center justify-center font-bold text-lg mb-2">2</div>
                <h3 class="font-bold text-sm text-slate-900 dark:text-white">Detergent Dosages</h3>
                <p class="text-xs text-slate-500 leading-relaxed">Use liquid detergent or laundry pods. Powder detergents leave residue that clogs the automatic drain pump filters.</p>
            </div>

            <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-2">
                <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-950 text-emerald-600 flex items-center justify-center font-bold text-lg mb-2">3</div>
                <h3 class="font-bold text-sm text-slate-900 dark:text-white">Maximum Weight Limits</h3>
                <p class="text-xs text-slate-500 leading-relaxed">Do not overload machines past 10kg (12kg on Heavy Duty WM-03 & WM-08). Overloading causes drum unbalance errors.</p>
            </div>
        </div>

        <section class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-4">
            <h3 class="font-bold text-base text-slate-900 dark:text-white flex items-center gap-2">
                <i data-lucide="help-circle" class="w-5 h-5 text-blue-600"></i>Frequently Asked Questions
            </h3>

            <div class="space-y-3 text-xs">
                <details class="group p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800 cursor-pointer">
                    <summary class="font-bold text-slate-900 dark:text-white flex justify-between items-center">
                        <span>What happens if I miss my reserved time slot?</span>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 group-open:rotate-180 transition-transform"></i>
                    </summary>
                    <p class="text-slate-500 mt-2 leading-relaxed">Slots have a 15-minute grace period. If you do not unlock the door with your code within 15 minutes, the slot automatically releases back to the public pool and your token is refunded.</p>
                </details>

                <details class="group p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800 cursor-pointer">
                    <summary class="font-bold text-slate-900 dark:text-white flex justify-between items-center">
                        <span>How are weekly wash passes re-credited?</span>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 group-open:rotate-180 transition-transform"></i>
                    </summary>
                    <p class="text-slate-500 mt-2 leading-relaxed">Every resident receives 4 wash tokens automatically every Monday at 00:00 AM. Unused tokens from the previous week do not roll over.</p>
                </details>

                <details class="group p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800 cursor-pointer">
                    <summary class="font-bold text-slate-900 dark:text-white flex justify-between items-center">
                        <span>How do I report a machine error or leak?</span>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 group-open:rotate-180 transition-transform"></i>
                    </summary>
                    <p class="text-slate-500 mt-2 leading-relaxed">Click "Report Issue" on the specific machine's telemetry page or contact the Titanium Block Warden Office directly at +1 (555) 999-8877.</p>
                </details>
            </div>
        </section>
    </main>
</div>

<?php
    include_once("includes/mfooter.php");
?>
