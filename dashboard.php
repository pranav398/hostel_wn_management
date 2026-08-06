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
                        <span>Hostel Washing Machine Management • Freshers '26</span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Hiii, <?=$_SESSION['name']?> 👋</h2>
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
                    <?php
                        $hn = $_SESSION['hn'];
                        $sqlw = "SELECT COUNT(*) AS count FROM (SELECT `wm_id` FROM `log` WHERE `wm_id` LIKE '{$hn}__1' AND `status` = '1' AND `time` BETWEEN DATE_SUB(NOW(), INTERVAL 89 MINUTE) AND NOW() UNION SELECT `wm_id` FROM `wm` WHERE `wm_id` LIKE '{$hn}__1' AND `working` = '0') AS combined;";
                        $resultw = $conn->query($sqlw);
                        $roww = $resultw->fetch_assoc();
                        $ww = $_SESSION['w_no'] - $roww['count'];
                    ?>
                    <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">Available Washing Machines</p>
                    <p class="text-xl font-bold text-slate-900 dark:text-white mt-0.5"><?=$ww?> <span class="text-xs font-normal text-slate-400">/ <?=$_SESSION['w_no']?> total</span></p>
                </div>
            </div>

            <div class="p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-950/80 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0">
                    <i data-lucide="ticket" class="w-6 h-6"></i>
                </div>
                <div>
                    <?php
                        $sqld = "SELECT COUNT(*) AS count FROM (SELECT `wm_id` FROM `log` WHERE `wm_id` LIKE '{$hn}__2' AND `status` = '1' AND `time` BETWEEN DATE_SUB(NOW(), INTERVAL 89 MINUTE) AND NOW() UNION SELECT `wm_id` FROM `wm` WHERE `wm_id` LIKE '{$hn}__2' AND `working` = '0') AS combined;";
                        $resultd = $conn->query($sqld);
                        $rowd = $resultd->fetch_assoc();
                        $wd = $_SESSION['d_no'] - $rowd['count'];
                    ?>
                    <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">Available Dryers</p>
                    <p class="text-xl font-bold text-slate-900 dark:text-white mt-0.5"><?=$wd?> <span class="text-xs font-normal text-slate-400">/ <?=$_SESSION['d_no']?> total</span></p>
                </div>
            </div>

            <div class="p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-amber-50 dark:bg-amber-950/80 text-amber-600 dark:text-amber-400 flex items-center justify-center shrink-0">
                    <i data-lucide="clock" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">Weekly Wash Tokens</p>
                    <p class="text-xl font-bold text-slate-900 dark:text-white mt-0.5"><?=$_SESSION['credits']?> <span class="text-xs font-normal text-slate-400">/ 2 tokens left</span></p>
                </div>
            </div>

            <div class="p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-indigo-50 dark:bg-indigo-950/80 text-indigo-600 dark:text-indigo-400 flex items-center justify-center shrink-0">
                    <i data-lucide="award" class="w-6 h-6"></i>
                </div>
                <div>
                    <?php
                        $roll = $_SESSION['roll'];
                        $sqlh = "SELECT * FROM `log` WHERE `roll` = '$roll' AND `status` = '1' ORDER BY `time` DESC";
                        $resulth = $conn->query($sqlh);
                        $h_no = $resulth->num_rows;
                    ?>
                    <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">We helped you with</p>
                    <p class="text-xl font-bold text-slate-900 dark:text-white mt-0.5"><?=$h_no?> <span class="text-xs font-normal text-slate-400">washes</span></p>
                </div>
            </div>
        </section>

        <section class="p-6 sm:p-8 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-sm relative overflow-hidden">
            <?php
                $sqlp = "SELECT * FROM `log` WHERE `roll` = '$roll' AND `status` = '1' AND `time` BETWEEN DATE_SUB(NOW(), INTERVAL 89 MINUTE) AND NOW()";
                $resultp = $conn->query($sqlp);

                if($resultp->num_rows == 0){
            ?>
                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100 dark:border-slate-800">
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 rounded-full bg-blue-500 animate-ping"></div>
                            <h3 class="font-bold text-base text-slate-900 dark:text-white flex items-center gap-2">No Active Wash Cycle</h3>
                        </div>
                        <a href="booking.php" class="text-xs font-semibold text-blue-600 dark:text-blue-400 hover:underline flex items-center gap-1">
                            <span>Book Now</span>
                            <i data-lucide="chevron-right" class="w-4 h-4"></i>
                        </a>
                    </div>
            <?php
                }
                else{
                    $rowp = $resultp->fetch_assoc();
                    $machine = ((substr($rowp['wm_id'], -1) == '1') ? "WM" : "DM") . " - Floor " . substr($rowp['wm_id'], 3, 2);
                    $left = 90-(round((time() - strtotime($rowp['time'])) / 60));
                    $percent = round((90 - $left) / 90 * 100);
            ?>
                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100 dark:border-slate-800">
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 rounded-full bg-blue-500 animate-ping"></div>
                            <h3 class="font-bold text-base text-slate-900 dark:text-white flex items-center gap-2">Active Wash Cycle
                                <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-blue-100 text-blue-700 dark:bg-blue-950 dark:text-blue-300"><?=$machine?></span>
                            </h3>
                        </div>
                        <a href="machine.php?wp_id=<?=$rowp['wm_id']?>" class="text-xs font-semibold text-blue-600 dark:text-blue-400 hover:underline flex items-center gap-1">
                            <span>Machine Telemetry</span>
                            <i data-lucide="chevron-right" class="w-4 h-4"></i>
                        </a>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-center">
                        <div class="flex items-center gap-6 bg-slate-50 dark:bg-slate-800/50 p-5 rounded-2xl border border-slate-100 dark:border-slate-800">
                            <div class="relative w-24 h-24 shrink-0 flex items-center justify-center bg-slate-200 dark:bg-slate-700 rounded-3xl shadow-inner border-2 border-blue-500">
                                <i data-lucide="disc-3" class="w-14 h-14 text-blue-600 dark:text-blue-400 animate-washer-spin"></i>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <span class="text-[11px] font-black text-slate-900 dark:text-white bg-white/80 dark:bg-slate-900/80 px-1.5 py-0.5 rounded shadow-xs" id="timer"><?=$left?>m</span>
                                </div>
                            </div>

                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Machine <?=$machine?></p>
                                <!-- <h4 class="text-lg font-extrabold text-slate-900 dark:text-white mt-0.5">Heavy Spin + Rinse</h4>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Water Temp: <strong class="text-slate-700 dark:text-slate-200">40°C</strong> • Spin: <strong class="text-slate-700 dark:text-slate-200">1200 RPM</strong></p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">Est. Finish: <strong class="text-blue-600 dark:text-blue-400">16:10 PM</strong></p> -->
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div class="flex justify-between text-xs font-bold text-slate-700 dark:text-slate-300">
                                <span>Time Progress</span>
                                <span id="progressText" class="text-blue-600 dark:text-blue-400"><?= $percent ?>% Time Completed</span>
                            </div>

                            <div class="w-full bg-slate-100 dark:bg-slate-800 h-3 rounded-full overflow-hidden p-0.5">
                                <div id="progressBar" class="bg-gradient-to-r from-blue-600 to-indigo-500 h-full rounded-full transition-all duration-500" style="width: <?= $percent ?>%;"></div>
                            </div>
                        </div>

                        <div class="p-4 rounded-2xl bg-blue-50/80 dark:bg-blue-950/40 border border-blue-100 dark:border-blue-900/60 flex flex-col justify-between h-full space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-blue-900 dark:text-blue-200 flex items-center gap-1.5">
                                    <i data-lucide="key" class="w-4 h-4 text-blue-600"></i>
                                </span>
                                <span class="text-[10px] font-mono font-bold bg-blue-200/80 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-2 py-0.5 rounded">Important</span>
                            </div>

                            <div class="flex items-center justify-center gap-2 py-1">
                                <span class="text-2xl font-mono font-extrabold tracking-widest text-slate-900 dark:text-white bg-white dark:bg-slate-900 px-4 py-1.5 rounded-xl border border-blue-200 dark:border-blue-800 shadow-xs">67</span>
                            </div>

                            <p class="text-[11px] text-center text-blue-800/80 dark:text-blue-300/80">Please collect your clothes from the washing machine within the designated time to facilitate its use by others</p>
                        </div>
                    </div>
            <?php
                }
            ?>
        </section>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="font-bold text-base text-slate-900 dark:text-white flex items-center gap-2">
                        <i data-lucide="washing-machine" class="w-5 h-5 text-blue-600"></i>Machine Availability Overview
                    </h3>
                    <a href="machines.php" class="text-xs font-semibold text-blue-600 dark:text-blue-400 hover:underline">View All <?php echo ($_SESSION['w_no']+$_SESSION['d_no']);?> Machines →</a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3" id="dashboard-machines-grid">

                <?php
                    $sqlmao = "SELECT * FROM `wm` WHERE `wm_id` LIKE '{$hn}___' LIMIT 4";
                    $resultmao = $conn->query($sqlmao);
                    while ($maorow = $resultmao->fetch_assoc()) {
                        $maoid = $maorow['wm_id'];
                        $maomachine = ((substr($maoid, -1) == '1') ? "WM" : "DM") . " - Floor " . substr($maoid, 3, 2);
                        // maostatus index    
                            // 1 - Your Wash
                            // 2 - Operating
                            // 3 - Idle
                            // 4 - Breakdown
                        if($maorow['working'] == 0){ // Senario 4
                            $maostatus = 'Maintainance';
                            $maoclass1 = 'p-3.5 rounded-2xl bg-red-50 dark:bg-red-800/60 border border-red-200 dark:border-red-700/80 flex items-center justify-between';
                            $maoclass2 = 'w-10 h-10 rounded-xl bg-red-100 dark:bg-red-950 text-red-600 dark:text-red-300 flex items-center justify-center font-bold text-xs';
                            $maoclass3 = 'px-2 py-1 rounded-lg text-[10px] font-bold bg-red-100 dark:bg-red-950 text-red-700 dark:text-red-300';
                        }
                        elseif(isset($rowp) && $rowp['wm_id'] == $maoid){ // Senario 1
                            $maostatus = 'Your Wash';
                            $maoclass1 = 'p-3.5 rounded-2xl bg-blue-50 dark:bg-blue-800/60 border border-blue-200 dark:border-blue-700/80 flex items-center justify-between';
                            $maoclass2 = 'w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-950 text-blue-600 dark:text-blue-300 flex items-center justify-center font-bold text-xs';
                            $maoclass3 = 'px-2 py-1 rounded-lg text-[10px] font-bold bg-blue-100 dark:bg-blue-950 text-blue-700 dark:text-blue-300';
                        }
                        else{
                            $sqlmao2 = "SELECT * FROM `log` WHERE `wm_id` = '$maoid' AND `status` = '1' AND `time` BETWEEN DATE_SUB(NOW(), INTERVAL 89 MINUTE) AND NOW()";
                            $resultmao2 = $conn->query($sqlmao2);
                            if($resultmao2->num_rows == 0){
                                $maostatus = 'Idle';
                                $maoclass1 = 'p-3.5 rounded-2xl bg-amber-50 dark:bg-amber-800/60 border border-amber-200 dark:border-amber-700/80 flex items-center justify-between';
                                $maoclass2 = 'w-10 h-10 rounded-xl bg-amber-100 dark:bg-amber-950 text-amber-600 dark:text-amber-300 flex items-center justify-center font-bold text-xs';
                                $maoclass3 = 'px-2 py-1 rounded-lg text-[10px] font-bold bg-amber-100 dark:bg-amber-950 text-amber-700 dark:text-amber-300';
                            }
                            else{
                                $maostatus = 'Operating ';
                                $maoclass1 = 'p-3.5 rounded-2xl bg-green-50 dark:bg-green-800/60 border border-green-200 dark:border-green-700/80 flex items-center justify-between';
                                $maoclass2 = 'w-10 h-10 rounded-xl bg-green-100 dark:bg-green-950 text-green-600 dark:text-green-300 flex items-center justify-center font-bold text-xs';
                                $maoclass3 = 'px-2 py-1 rounded-lg text-[10px] font-bold bg-green-100 dark:bg-green-950 text-green-700 dark:text-green-300';
                            }
                        }
                ?>
                        <div class="<?=$maoclass1?>">
                            <div class="flex items-center gap-3">
                                <div class="<?=$maoclass2?>"></div>
                                <div>
                                    <h4 class="text-xs font-bold text-slate-900 dark:text-white"><?=$maomachine?></h4>
                                    <!-- <p class="text-[11px] text-slate-500">22m left • David K.</p> -->
                                </div>
                            </div>
                            <span class="<?=$maoclass3?>"><?=$maostatus?></span>
                        </div>
                <?php
                    }
                ?>
                </div>
            </div>

            <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-4">
                <h3 class="font-bold text-base text-slate-900 dark:text-white flex items-center gap-2">
                    <i data-lucide="activity" class="w-5 h-5 text-indigo-600"></i>Recent Activity Log
                </h3>

                <div class="space-y-3 relative before:absolute before:inset-0 before:left-3.5 before:w-0.5 before:bg-slate-200 dark:before:bg-slate-800">
                    <?php
                        $count = 1;
                        while ($rowh = $resulth->fetch_assoc()) {
                            if($count == 4) break;
                            if (strtotime($rowh['time']) + 90 * 60 > time()) continue;
                            $machineh = ((substr($rowh['wm_id'], -1) == '1') ? "WM" : "DM") . " - " . substr($rowh['wm_id'], 3, 2);
                            $dateh = date("Y M j, H:i", strtotime($rowh['time'] . " +90 minutes"));
                            $count++;
                    ?>
                            <div class="flex items-start gap-3 relative z-10">
                                <div class="w-7 h-7 rounded-full bg-emerald-600 text-white flex items-center justify-center text-xs shrink-0">
                                    <i data-lucide="check" class="w-3.5 h-3.5"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-900 dark:text-white">Completed Wash Cycle</p>
                                    <p class="text-[11px] text-slate-500"><?=$machineh?> • <?=$dateh?></p>
                                </div>
                            </div>
                    <?php
                        }
                    ?>    
                </div>
            </div>
        </div>
    </main>
</div>

<?php if (isset($left)) : ?>
<script>
    let left = <?= $left ?>;

    function updateUI() {
        document.getElementById("timer").textContent = left + "m";

        const percent = Math.round((90 - left) / 90 * 100);
        document.getElementById("progressText").textContent = percent + "% Completed";
        document.getElementById("progressBar").style.width = percent + "%";
    }

    updateUI();

    setInterval(() => {
        if (left > 0) {
            left--;
            updateUI();

            if (left === 0) {
                setTimeout(() => location.reload(), 60000);
            }
        }
    }, 60000);
</script>
<?php endif; ?>

<?php
    include_once("includes/mfooter.php");
?>