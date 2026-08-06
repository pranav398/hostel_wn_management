<?php
    $title = "Hostel Guidelines - HWMM";
    include_once("includes/mheader.php");
?>

        <section class="p-6 sm:p-8 rounded-3xl bg-gradient-to-br from-blue-900 via-indigo-900 to-slate-900 text-white shadow-xl relative overflow-hidden border border-slate-800 space-y-3">
            <span class="px-3 py-1 rounded-full bg-blue-500/20 text-blue-300 text-xs font-bold uppercase tracking-wider border border-blue-400/30">Hostel Washing Machine Administration</span>
            <h2 class="text-3xl font-extrabold tracking-tight">Hostel Laundry Guidelines & Rules</h2>
            <p class="text-xs sm:text-sm text-slate-300 max-w-2xl leading-relaxed">Please follow these operational rules to keep our shared washing machine fleet running reliably, efficiently, and fairly for all hostel residents.</p>
        </section>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-2">
                <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-950 text-blue-600 flex items-center justify-center font-bold text-lg mb-2">1</div>
                <h3 class="font-bold text-sm text-slate-900 dark:text-white">Plan your Booking</h3>
                <p class="text-xs text-slate-500 leading-relaxed">Reserve a machine only after considering your academic timetable and sleep schedule to ensure you can use your booked slot.</p>
            </div>

            <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-2">
                <div class="w-10 h-10 rounded-xl bg-indigo-100 dark:bg-indigo-950 text-indigo-600 flex items-center justify-center font-bold text-lg mb-2">2</div>
                <h3 class="font-bold text-sm text-slate-900 dark:text-white">Check Before You Go</h3>
                <p class="text-xs text-slate-500 leading-relaxed">Always check the portal before heading to the machine to confirm that it is operational and not under maintenance.</p>
            </div>

            <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-2">
                <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-950 text-emerald-600 flex items-center justify-center font-bold text-lg mb-2">3</div>
                <h3 class="font-bold text-sm text-slate-900 dark:text-white">Punctual Collection</h3>
                <p class="text-xs text-slate-500 leading-relaxed">Collect your washed clothes within 10 minutes of your wash cycle ending so that the next resident can begin using the machine on time.</p>
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
                    <p class="text-slate-500 mt-2 leading-relaxed">If you cancel your booking at least 90 minutes before the scheduled start time, your credits will be refunded and the slot will become available for others to book. However, if you cancel within 90 minutes of the scheduled start time, your credits will not be refunded. Even if you are unable to use your booking, you are encouraged to cancel it through the portal so that the slot can be utilized by another resident.</p>
                </details>

                <details class="group p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800 cursor-pointer">
                    <summary class="font-bold text-slate-900 dark:text-white flex justify-between items-center">
                        <span>What should I do if a machine malfunctions during my booked slot?</span>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 group-open:rotate-180 transition-transform"></i>
                    </summary>
                    <p class="text-slate-500 mt-2 leading-relaxed">Click "Report Issue" on the affected machine's telemetry page and inform the hostel administration as soon as possible. If the machine is verified to be malfunctioning, the credits used for that booking will be refunded, allowing you to reserve another available machine.</p>
                </details>

                <details class="group p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800 cursor-pointer">
                    <summary class="font-bold text-slate-900 dark:text-white flex justify-between items-center">
                        <span>Can I reserve a machine for any date?</span>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 group-open:rotate-180 transition-transform"></i>
                    </summary>
                    <p class="text-slate-500 mt-2 leading-relaxed">Bookings can only be made for today and the next six days. This ensures fair access to the machines and keeps the schedule accurate.</p>
                </details>

                <details class="group p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800 cursor-pointer">
                    <summary class="font-bold text-slate-900 dark:text-white flex justify-between items-center">
                        <span>What happens if I don't collect my clothes after the wash cycle ends?</span>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 group-open:rotate-180 transition-transform"></i>
                    </summary>
                    <p class="text-slate-500 mt-2 leading-relaxed">You are strongly encouraged to be present at least 10 minutes before your wash cycle is scheduled to end so that you can collect your clothes promptly and avoid inconveniencing other residents waiting to use the machine.<br><br>If, due to unforeseen circumstances, you are unable to collect your clothes on time, we recommend placing your empty laundry bag or bucket near the machine before starting your wash. This allows the next user to transfer your clothes into your bag or bucket, enabling them to use the machine while ensuring your belongings remain together until you can collect them later.</p>
                </details>
            </div>
        </section>
    </main>
</div>

<?php
    include_once("includes/mfooter.php");
?>
