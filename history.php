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
                            <th class="p-4">Pass Cost</th>
                            <th class="p-4">Status</th>
                        </tr>
                    </thead>

                    <tbody id="history-table-body" class="divide-y divide-slate-100 dark:divide-slate-800 font-medium">
                    <?php 
                        $roll = $_SESSION['roll'];

                        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
                        $perPage = 7;
                        $offset = ($page - 1) * $perPage;

                        // Total records
                        $sqlCount = "SELECT COUNT(*) AS total FROM `log` WHERE `roll` = '$roll'";
                        $resultCount = $conn->query($sqlCount);
                        $totalRows = $resultCount->fetch_assoc()['total'];
                        $totalPages = max(1, ceil($totalRows / $perPage));

                        // Current page records
                        $sqlh = "SELECT * FROM `log` WHERE `roll` = '$roll' ORDER BY `time` DESC LIMIT $perPage OFFSET $offset";
                        $resulth = $conn->query($sqlh);

                        while ($rowh = $resulth->fetch_assoc()) { 
                            $start = date("Y M j", strtotime($rowh['time']));
                            $from  = date("H:i", strtotime($rowh['time']));
                            $to    = date("H:i", strtotime($rowh['time']) + 90*60);

                            $machine = ((substr($rowh['wm_id'], -1) == '1') ? "WM" : "DM") . " " . substr($rowh['wm_id'], 3, 2);
                            $location = "Floor " . substr($rowh['wm_id'], 3, 2);

                            if($rowh['status'] == 1){
                                $status = (strtotime($rowh['time']) + 90*60 < time()) ? '<span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300 flex items-center gap-1 w-fit">✓ Completed</span>' : '<span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-100 text-blue-700 dark:bg-blue-950 dark:text-blue-300 flex items-center gap-1 w-fit"><span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-ping"></span> In Progress</span>';
                                $value = "1 Credit";
                            }
                            else{
                                    $status = '<span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-100 text-red-700 dark:bg-red-950 dark:text-red-300 flex items-center gap-1 w-fit">✕ Cancelled</span>';
                                    $value = ($rowh['status'] == 0) ? "1 Credit Refunded" : "1 Credit";
                            }

                            $rowhid = date("Ymd") . ((substr($rowh['wm_id'], -1) == '1') ? "WM" : "DM") . substr($rowh['wm_id'], -3, 2) . (($rowh['status'] == 1) ? "V" : "C");
                    ?>

                        <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition">
                            <td class="p-4 pl-6 font-mono font-bold text-blue-600 dark:text-blue-400"><?=$rowhid?></td>

                            <td class="p-4 text-slate-900 dark:text-white">
                                <span class="font-bold block"><?=$start?></span>
                                <span class="text-slate-400 text-[11px]"><?=$from?> - <?=$to?></span>
                            </td>

                            <td class="p-4 text-slate-900 dark:text-white">
                                <span class="font-bold block"><?=$machine?></span>
                                <span class="text-slate-400 text-[11px]"><?=$location?></span>
                            </td>

                            <td class="p-4 font-bold text-slate-900 dark:text-white"><?=$value?></td>

                            <td class="p-4"><?=$status?></td>
                        </tr>
                    <?php
                        }
                    ?>
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-slate-200 dark:border-slate-800 flex items-center justify-between text-xs text-slate-500">
                <span>Showing <?=$totalRows == 0 ? 0 : $offset + 1 ?> to <?= min($offset + $perPage, $totalRows)?> of <?=$totalRows?> booking<?=$totalRows == 1 ? '' : 's'?></span>

                <div class="flex items-center gap-1">

                    <?php if ($page > 1): ?>
                        <a href="?page=<?=$page - 1?>" class="p-1.5 rounded-lg border border-slate-200 dark:border-slate-800 hover:bg-slate-100 dark:hover:bg-slate-800">Previous</a>
                    <?php else: ?>
                        <button disabled class="p-1.5 rounded-lg border border-slate-200 dark:border-slate-800 opacity-50 cursor-not-allowed">Previous</button>
                    <?php endif; ?>

                    <!-- Page Numbers -->
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <?php if ($i == $page): ?>
                            <span class="px-3 py-1 rounded-lg bg-blue-600 text-white font-bold"><?=$i?> </span>
                        <?php else: ?>
                            <a href="?page=<?= $i ?>" class="px-3 py-1 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800"><?=$i?></a>
                        <?php endif; ?>
                    <?php endfor; ?>

                    <!-- Next -->
                    <?php if ($page < $totalPages): ?>
                        <a href="?page=<?= $page + 1 ?>" class="p-1.5 rounded-lg border border-slate-200 dark:border-slate-800 hover:bg-slate-100 dark:hover:bg-slate-800">Next</a>
                    <?php else: ?>
                        <button disabled class="p-1.5 rounded-lg border border-slate-200 dark:border-slate-800 opacity-50 cursor-not-allowed">Next</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
</div>

<?php
    include_once("includes/mfooter.php");
?>