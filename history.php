<?php
    $title = "Booking History - HWMM";
    include_once("includes/mheader.php");
?>

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-extrabold tracking-tight text-slate-900 dark:text-white flex items-center gap-2">
                    <i data-lucide="history" class="w-7 h-7 text-blue-600"></i>Laundry Booking History
                </h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Audit log of all past, active, and cancelled washing machine reservations.</p>
            </div>
        </div>
        
        <div class="rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 dark:bg-slate-800/60 border-b border-slate-200 dark:border-slate-800 text-slate-400 uppercase tracking-wider font-bold text-[10px]">
                        <tr>
                            <th class="p-4 pl-6">Reference ID</th>
                            <th class="p-4">Date & Time</th>
                            <th class="p-4">Machine & Location</th>
                            <th class="p-4">Preset Cycle</th>
                            <th class="p-4">Pass Cost</th>
                            <th class="p-4">Status</th>
                            <th class="p-4 pr-6 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody id="history-table-body" class="divide-y divide-slate-100 dark:divide-slate-800 font-medium">
                        <tr class="history-row hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition">
                            <td class="p-4 pl-6 font-mono font-bold text-blue-600 dark:text-blue-400">BK-9921</td>
                            <td class="p-4 text-slate-900 dark:text-white">
                                <span class="font-bold block">Today, Aug 4</span>
                                <span class="text-slate-400 text-[11px]">15:30 - 16:30 PM</span>
                            </td>
                            <td class="p-4 text-slate-900 dark:text-white">
                                <span class="font-bold block">Machine 03</span>
                                <span class="text-slate-400 text-[11px]">Ground Floor • Bay B</span>
                            </td>
                            <td class="p-4 text-slate-700 dark:text-slate-300">Delicate / Heavy Spin</td>
                            <td class="p-4 font-bold text-slate-900 dark:text-white">1 Pass</td>
                            <td class="p-4">
                                <span class="status-cell px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-100 text-blue-700 dark:bg-blue-950 dark:text-blue-300 flex items-center gap-1 w-fit">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-ping"></span> In Progress
                                </span>
                            </td>
                            <td class="p-4 pr-6 text-right">
                                <button onclick="showToast('Door Pass Code: 8492', 'info', 'Unlock Code')" class="px-2.5 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-[11px] font-bold transition">View Pass</button>
                            </td>
                        </tr>

                        <tr class="history-row hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition">
                            <td class="p-4 pl-6 font-mono font-bold text-slate-500">BK-9810</td>
                            <td class="p-4 text-slate-900 dark:text-white">
                                <span class="font-bold block">Aug 1, 2026</span>
                                <span class="text-slate-400 text-[11px]">10:00 - 11:00 AM</span>
                            </td>
                            <td class="p-4 text-slate-900 dark:text-white">
                                <span class="font-bold block">Machine 01</span>
                                <span class="text-slate-400 text-[11px]">Ground Floor • Bay A</span>
                            </td>
                            <td class="p-4 text-slate-700 dark:text-slate-300">Cottons 60°C</td>
                            <td class="p-4 font-bold text-slate-900 dark:text-white">1 Pass</td>
                            <td class="p-4">
                                <span class="status-cell px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300 flex items-center gap-1 w-fit">✓ Completed</span>
                            </td>
                            <td class="p-4 pr-6 text-right">
                                <button onclick="showToast('Receipt #BK-9810 downloaded', 'success')" class="text-slate-400 hover:text-blue-600 transition" title="Receipt">
                                    <i data-lucide="file-text" class="w-4 h-4"></i>
                                </button>
                            </td>
                        </tr>

                        <tr class="history-row hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition">
                            <td class="p-4 pl-6 font-mono font-bold text-slate-500">BK-9754</td>
                            <td class="p-4 text-slate-900 dark:text-white">
                                <span class="font-bold block">July 25, 2026</span>
                                <span class="text-slate-400 text-[11px]">18:00 - 19:00 PM</span>
                            </td>
                            <td class="p-4 text-slate-900 dark:text-white">
                                <span class="font-bold block">Machine 04</span>
                                <span class="text-slate-400 text-[11px]">Ground Floor • Bay B</span>
                            </td>
                            <td class="p-4 text-slate-700 dark:text-slate-300">Heavy Wash Preset</td>
                            <td class="p-4 font-bold text-slate-900 dark:text-white">1 Pass</td>
                            <td class="p-4">
                                <span class="status-cell px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300 flex items-center gap-1 w-fit">✓ Completed</span>
                            </td>
                            <td class="p-4 pr-6 text-right">
                                <button onclick="showToast('Receipt #BK-9754 downloaded', 'success')" class="text-slate-400 hover:text-blue-600 transition" title="Receipt">
                                    <i data-lucide="file-text" class="w-4 h-4"></i>
                                </button>
                            </td>
                        </tr>

                        <tr class="history-row hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition">
                            <td class="p-4 pl-6 font-mono font-bold text-slate-400">BK-9689</td>
                            <td class="p-4 text-slate-900 dark:text-white">
                                <span class="font-bold block">July 18, 2026</span>
                                <span class="text-slate-400 text-[11px]">14:00 - 15:00 PM</span>
                            </td>
                            <td class="p-4 text-slate-900 dark:text-white">
                                <span class="font-bold block">Machine 02</span>
                                <span class="text-slate-400 text-[11px]">Ground Floor • Bay A</span>
                            </td>
                            <td class="p-4 text-slate-700 dark:text-slate-300">Delicates 30m</td>
                            <td class="p-4 font-bold text-emerald-600">Refunded</td>
                            <td class="p-4">
                                <span class="status-cell px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-200 text-slate-600 dark:bg-slate-800 dark:text-slate-400 flex items-center gap-1 w-fit">Cancelled</span>
                            </td>
                            <td class="p-4 pr-6 text-right text-slate-400">
                                <span class="text-[11px]">No action</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-slate-200 dark:border-slate-800 flex items-center justify-between text-xs text-slate-500">
                <span>Showing 1 to 4 of 28 bookings</span>
                <div class="flex items-center gap-1">
                    <button disabled class="p-1.5 rounded-lg border border-slate-200 dark:border-slate-800 opacity-50 cursor-not-allowed">Previous</button>
                    <button class="px-3 py-1 rounded-lg bg-blue-600 text-white font-bold">1</button>
                    <button onclick="showToast('Loading page 2', 'info')" class="px-3 py-1 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800">2</button>
                    <button onclick="showToast('Loading page 3', 'info')" class="px-3 py-1 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800">3</button>
                    <button onclick="showToast('Loading page 2', 'info')" class="p-1.5 rounded-lg border border-slate-200 dark:border-slate-800 hover:bg-slate-100 dark:hover:bg-slate-800">Next</button>
                </div>
            </div>
        </div>
    </main>
</div>

<?php
    include_once("includes/mfooter.php");
?>