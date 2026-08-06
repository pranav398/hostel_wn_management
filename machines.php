<?php
    $title = "All Washing Machines - HWMM";
    include_once("includes/mheader.php");
?>

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-extrabold tracking-tight text-slate-900 dark:text-white flex items-center gap-2">
                    <i data-lucide="washing-machine" class="w-7 h-7 text-blue-600"></i>Hostel Washing Machines
                </h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Real-time telemetry, availability, queue lengths, and health status for all 8 fleet units.</p>
            </div>

            <div class="flex items-center gap-2">
                <span class="px-3 py-1.5 rounded-xl bg-blue-50 dark:bg-blue-950 text-blue-700 dark:text-blue-300 text-xs font-bold border border-blue-200 dark:border-blue-800">3 Idle • 4 Operating • 1 Maintenance</span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="machines-grid-container">
            <?php
                $hn = $_SESSION['hn'];
                $sql = "SELECT * FROM `wm` WHERE `wm_id` LIKE '{$hn}___'";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    $wm_id = $row['wm_id'];
                    $machine = ((substr($wm_id, -1) == '1') ? "Washing Machine" : "Drying Machine");
                    $floor = "Floor " . substr($wm_id, 3, 2);
                    // Senarios
                        // 1 - Maintainance
                        // 2 - Operating
                        // 3 - Idle
                        if($row['working'] == 0){ // Senario 1
                            $mac = ((substr($wm_id, -1) == '1') ? "WM" : "DM") . " - Floor " . substr($wm_id, 3, 2);
            ?>
                            <div class="machine-card p-6 rounded-3xl bg-slate-50 dark:bg-slate-900/60 border border-amber-300 dark:border-amber-800 shadow-sm space-y-4 opacity-90" data-status="Maintenance" data-bay="First Bay C">
                                <div class="flex items-start justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 rounded-2xl bg-amber-100 dark:bg-amber-950 text-amber-600 flex items-center justify-center font-extrabold text-sm border border-amber-200 dark:border-amber-900"></div>
                                        <div>
                                            <h3 class="font-extrabold text-base text-slate-900 dark:text-white"><?=$machine?></h3>
                                            <p class="text-xs text-slate-500"><?=$floor?></p>
                                        </div>
                                    </div>
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-100 dark:bg-amber-950 text-amber-800 dark:text-amber-200 flex items-center gap-1">
                                        <i data-lucide="wrench" class="w-3 h-3"></i> Maintenance
                                    </span>
                                </div>

                                <div class="p-3.5 rounded-2xl bg-amber-50/60 dark:bg-amber-950/30 border border-amber-200/50 dark:border-amber-900/40 space-y-2 text-xs">
                                    <div class="flex justify-between text-slate-500">
                                        <span>Issue Reported:</span>
                                        <span class="font-bold text-amber-800 dark:text-amber-200">Breakdown</span>
                                    </div>
                                    <div class="flex justify-between text-slate-500">
                                        <span>Assigned Tech:</span>
                                        <span class="font-bold text-slate-900 dark:text-white">N/A</span>
                                    </div>
                                    <div class="flex justify-between text-slate-500">
                                        <span>Est. Service End:</span>
                                        <span class="font-bold text-slate-900 dark:text-white">N/A</span>
                                    </div>
                                </div>

                                <div class="space-y-1">
                                    <div class="flex justify-between text-[11px] font-semibold text-slate-500">
                                        <span>Machine Health</span>
                                        <span class="text-amber-600 font-bold">0% Service Needed</span>
                                    </div>
                                    <div class="w-full bg-slate-100 dark:bg-slate-800 h-2 rounded-full overflow-hidden">
                                        <div class="bg-amber-500 h-full w-[0%]"></div>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between pt-2 border-t border-slate-100 dark:border-slate-800">
                                    <span class="text-[11px] text-amber-600 font-bold">Unavailable</span>
                                    <button onclick="showToast('<?=$mac?> is undergoing maintainance service', 'warning')" class="px-3 py-1.5 bg-slate-200 dark:bg-slate-800 text-slate-500 rounded-xl text-xs font-bold cursor-not-allowed">Offline</button>
                                </div>
                            </div>    
            <?php
                        }
                        else{
                            $sql2 = "SELECT * FROM `log` WHERE `wm_id` = '$wm_id' AND `status` = '1' AND `time` BETWEEN DATE_SUB(NOW(), INTERVAL 89 MINUTE) AND NOW()";
                            $result2 = $conn->query($sql2);
                            if($result2->num_rows == 0){

            ?>
                                <div class="machine-card p-6 rounded-3xl bg-white dark:bg-slate-900 border-2 border-emerald-500/50 dark:border-emerald-500/30 shadow-sm space-y-4 hover:shadow-md transition" data-status="Available" data-bay="Ground Bay A">
                                    <div class="flex items-start justify-between">
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-12 rounded-2xl bg-emerald-100 dark:bg-emerald-950 text-emerald-600 flex items-center justify-center font-extrabold text-sm border border-emerald-200 dark:border-emerald-900"></div>
                                            <div>
                                                <h3 class="font-extrabold text-base text-slate-900 dark:text-white"><?=$machine?></h3>
                                                <p class="text-xs text-slate-500"><?=$floor?></p>
                                            </div>
                                        </div>
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300 flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Available Now</span>
                                    </div>

                                    <div class="p-3.5 rounded-2xl bg-emerald-50/50 dark:bg-emerald-950/30 space-y-2 text-xs border border-emerald-200/50 dark:border-emerald-800/40">
                                        <div class="flex justify-between text-slate-500">
                                            <span>Status:</span>
                                            <span class="font-bold text-emerald-600 dark:text-emerald-400">Idle</span>
                                        </div>
                                        <div class="flex justify-between text-slate-500">
                                            <span>Capacity:</span>
                                            <span class="font-bold text-slate-900 dark:text-white">Standard Load</span>
                                        </div>
                                        <div class="flex justify-between text-slate-500">
                                            <span>Next Slot Open:</span>
                                            <span class="font-bold text-emerald-600"><?=date("H:i", strtotime("today") + (ceil(((time() - strtotime("today")) / 60) / 90) * 90) * 60)?></span>
                                        </div>
                                    </div>

                                    <div class="space-y-1">
                                        <div class="flex justify-between text-[11px] font-semibold text-slate-500">
                                            <span>Machine Health</span>
                                            <span class="text-emerald-600 font-bold">100% Excellent</span>
                                        </div>
                                        <div class="w-full bg-slate-100 dark:bg-slate-800 h-2 rounded-full overflow-hidden">
                                            <div class="bg-emerald-500 h-full w-[100%]"></div>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between pt-2 border-t border-slate-100 dark:border-slate-800">
                                        <span class="text-[11px] text-emerald-600 font-bold">No Waiting Queue</span>
                                        <div class="flex gap-2">
                                            <a href="machine.php?wm_id=<?=$wm_id?>" class="px-3 py-1.5 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 text-slate-700 dark:text-slate-300 rounded-xl text-xs font-bold transition">Details</a>
                                            <a href="booking.php" class="px-4 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow-md transition">Book Now</a>
                                        </div>
                                    </div>
                                </div>
            <?php
                            }
                            else{
                                $row2 = $result2->fetch_assoc();
                                $left = 90-(round((time() - strtotime($row2['time'])) / 60));
                                $endTime = strtotime($row2['time']) + (90 * 60);
            ?>
                                <div class="machine-card p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-sm space-y-4 hover:shadow-md transition" data-status="Operating" data-bay="Ground Bay A">
                                    <div class="flex items-start justify-between">
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-12 rounded-2xl bg-blue-100 dark:bg-blue-950 text-blue-600 flex items-center justify-center font-extrabold text-sm border border-blue-200 dark:border-blue-900"></div>
                                            <div>
                                                <h3 class="font-extrabold text-base text-slate-900 dark:text-white"><?=$machine?></h3>
                                                <p class="text-xs text-slate-500"><?=$floor?></p>
                                            </div>
                                        </div>
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-100 dark:bg-blue-950 text-blue-700 dark:text-blue-300 flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-ping"></span> Operating</span>
                                    </div>

                                    <div class="p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-800/50 space-y-2 text-xs">
                                        <div class="flex justify-between text-slate-500">
                                            <span>Current Resident:</span>
                                            <span class="font-bold text-slate-900 dark:text-white"><?=$row2['iden']?></span>
                                        </div>
                                        <div class="flex justify-between text-slate-500">
                                            <span>Cycle Type:</span>
                                            <span class="font-bold text-slate-900 dark:text-white">N/A</span>
                                        </div>
                                        <div class="flex justify-between text-slate-500">
                                            <span>Time Remaining:</span>
                                            <span class="font-bold text-blue-600 dark:text-blue-400 countdown" data-end="<?=$endTime?>"><?=$left?> minutes</span>
                                        </div>
                                    </div>

                                    <div class="space-y-1">
                                        <div class="flex justify-between text-[11px] font-semibold text-slate-500">
                                            <span>Machine Health</span>
                                            <span class="text-emerald-600 font-bold">100% Excellent</span>
                                        </div>
                                        <div class="w-full bg-slate-100 dark:bg-slate-800 h-2 rounded-full overflow-hidden">
                                            <div class="bg-emerald-500 h-full w-[100%]"></div>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between pt-2 border-t border-slate-100 dark:border-slate-800">
                                        <span class="text-[11px] text-slate-400">Queue: <strong>Check Booking</strong></span>
                                        <div class="flex gap-2">
                                            <a href="machine.php?wm_id=<?=$wm_id?>" class="px-3 py-1.5 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 text-slate-700 dark:text-slate-300 rounded-xl text-xs font-bold transition">Details</a>
                                            <a href="booking.php" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-xs transition">Reserve</a>
                                        </div>
                                    </div>
                                </div>
                    <?php                                
                            }
                        }
                    ?>
            <?php            
                }
            ?>
        </div>
    </main>
</div>

<script>
    const countdowns = document.querySelectorAll(".countdown");

    if (countdowns.length > 0) {

        function updateCountdowns() {
            let shouldRefresh = false;

            countdowns.forEach(el => {
                const end = parseInt(el.dataset.end) * 1000;
                const diff = end - Date.now();

                if (diff > 0) {
                    const mins = Math.floor(diff / 60000);
                    el.textContent = mins + " minutes";
                } else {
                    el.textContent = "0 minutes";

                    if (Date.now() - end >= 60000) {
                        shouldRefresh = true;
                    }
                }
            });

            if (shouldRefresh) {
                location.reload();
            }
        }

        updateCountdowns();
        setInterval(updateCountdowns, 30000);
    }
</script>


<?php
    include_once("includes/mfooter.php");
?>