<?php
    date_default_timezone_set('Asia/Kolkata');

    function updateHead(){
        $params = $_GET;
        $params['date'] = date("d.m.Y");

        header("Location: ?" . http_build_query($params));
        exit;
    }

    if (empty($_GET['date'])) updateHead();

    $today = new DateTime('today');
    $maxDate = (clone $today)->modify('+6 days');
    $current = DateTime::createFromFormat('!d.m.Y', $_GET['date']);
    $sqlDate = DateTime::createFromFormat('d.m.Y', $_GET['date'])->format('Y-m-d');
    $selected = DateTime::createFromFormat('!d.m.Y', $_GET['date']);

    if (!preg_match('/^\d{2}\.\d{2}\.\d{4}$/', $_GET['date'])) updateHead();
    if (!$selected || $selected->format('d.m.Y') !== $_GET['date']) updateHead();
    if ($selected < $today || $selected > $maxDate) updateHead();

    $disablePrev = $current == $today;
    $disableNext = $current == $maxDate;

    $title = "Weekly Schedule - HWMM";
    include_once("includes/mheader.php");

    $hn = $_SESSION['hn'];
    $roll = $_SESSION['roll'];

    $wmsql = "SELECT * FROM `wm` WHERE `wm_id` LIKE '{$hn}___'";
    $wmresult = $conn->query($wmsql);
    $wmMap = [];

    while($wmrow = $wmresult->fetch_assoc()){
        $wmMap$[] = $wmrow;
    }

    $logsql = "SELECT * FROM `log` WHERE `wm_id` LIKE '{$hn}___' AND `status` = '1' AND DATE(`time`) = '$sqlDate'";
    $logresult = $conn->query($logsql);
    $logMap=[];

    while($logrow = $logresult->fetch_assoc()){
        $wmid = $logrow['wm_id'];
        $slot = date("H:i", strtotime($logrow['time']));
        $logMap[$wmid][$slot] = $logrow;
    }

    $timeMap = ['00:00','01:30','03:00','04:30','06:00','07:30','09:00','10:30','12:00','13:30','15:00','16:30','18:00','19:30','21:00','22:30'];
?>

        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-extrabold tracking-tight text-slate-900 dark:text-white flex items-center gap-2">
                    <i data-lucide="calendar-days" class="w-7 h-7 text-blue-600"></i>Weekly Machine Schedule
                </h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Live Google Calendar-style timetable across all 8 hostel washing machines.</p>
            </div>

            <div class="flex items-center gap-3 shrink-0">
                <div class="flex items-center bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-1 shadow-xs">
                    <button onclick="changeDate(-1)" <?=$disablePrev ? 'disabled' : ''?> class="p-1.5 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg text-slate-600 dark:text-slate-300">
                        <i data-lucide="chevron-left" class="w-4 h-4"></i>
                    </button>
                    <span class="px-3 text-xs font-bold text-slate-900 dark:text-white"><?=DateTime::createFromFormat('!d.m.Y', $_GET['date'])->format('M j, Y')?></span>
                    <button onclick="changeDate(1)" <?=$disableNext ? 'disabled' : ''?> class="p-1.5 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg text-slate-600 dark:text-slate-300">
                        <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    </button>
                </div>

                <a href="booking.php" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-xs transition flex items-center gap-1.5">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    <span>Book Slot</span>
                </a>
            </div>
        </div>

        <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs flex flex-wrap items-center justify-between gap-4 text-xs font-medium">
            <div class="flex items-center gap-4 flex-wrap">
                <span class="text-slate-400 font-bold uppercase tracking-wider text-[10px]">Legend:</span>
                <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded bg-blue-600 shadow-xs"></span> Your Booking</span>
                <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded bg-indigo-100 dark:bg-indigo-950/80 border border-indigo-300 dark:border-indigo-800 text-indigo-700 dark:text-indigo-300"></span> Other Resident</span>
                <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded bg-amber-100 dark:bg-amber-950/80 border border-amber-300 dark:border-amber-800 text-amber-700 dark:text-amber-300"></span> Maintenance</span>
                <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800"></span> Open Slot</span>
            </div>
        </div>

        <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-sm overflow-x-auto">
            <div class="min-w-[800px]">

                <div class="grid grid-cols-9 border-b border-slate-200 dark:border-slate-800 pb-3 mb-2 text-center">
                    <div class="text-xs font-bold text-slate-400 uppercase tracking-wider text-left pl-2">Time</div>
                    <?php
                        foreach($wmMap as $machine){
                    ?>
                            <div class="text-xs font-extrabold text-<?=$machine['working']?'slate-900 dark:text-white':'amber-600 dark:text-amber-400'?>"><?=substr($machine['wm_id'],-1) == 1 ? 'W' : 'D'?>M-<?=substr($machine['wm_id'],3,2)?> <?=!$machine['working']?'🛠':''?>
                                <span class="block text-[10px] font-normal text-<?=$machine['working']?'slate-4':'amber-5'?>00">Floor <?=substr($machine['wm_id'],3,2)?></span>
                            </div>
                    <?php
                        }
                    ?>
                </div>

                <div class="space-y-2 text-xs">
                    <?php 
                        foreach($timeMap as $start_time){
                            if($disablePrev && 0 < (time() - strtotime($start_time)) && (time() - strtotime($start_time)) < (90*60)){
                                $maindiv = 
                                    '<div class="grid grid-cols-9 items-center gap-2 py-2 bg-blue-50/40 dark:bg-blue-950/20 rounded-2xl border border-blue-200/80 dark:border-blue-900/60 p-1">
                                        <span class="font-mono font-extrabold text-blue-600 dark:text-blue-400 text-xs flex items-center gap-1">
                                            <span class="w-2 h-2 rounded-full bg-blue-500 animate-ping"></span>'.$start_time.' NOW
                                        </span>';
                            } else{
                                $maindiv = 
                                    '<div class="grid grid-cols-9 items-center gap-2 py-1.5 border-b border-slate-100 dark:border-slate-800/60">
                                        <span class="font-mono font-bold text-slate-400 text-xs">'.$start_time.'</span>';
                            }
                    ?>
                            <?=$maindiv?>          
                                <?php
                                    foreach($wmMap as $machine){
                                        if($machine['working'] == 0) {
                                            $att = 'class="p-2 rounded-xl bg-amber-50 dark:bg-amber-950/60 border border-amber-200 dark:border-amber-800 text-amber-900 dark:text-amber-200 font-bold text-[10px] text-center"';
                                            $content = 'Maintainance'; 
                                        } elseif(!isset($logMap[$machine['wm_id']][$start_time]) || $logMap[$machine['wm_id']][$start_time]['status'] != '1'){
                                            $att = 'class="p-2 rounded-xl bg-emerald-50/50 dark:bg-emerald-950/20 border border-emerald-200/50 dark:border-emerald-800/30 text-emerald-700 dark:text-emerald-400 text-center font-bold text-[10px] hover:bg-emerald-100 transition cursor-pointer" onclick="location.href=\'booking.php\'"';
                                            $content = '+ Book';
                                        } elseif($logMap[$machine['wm_id']][$start_time]['roll']==$roll){
                                            $att = 'class="p-2 rounded-xl bg-blue-600 text-white font-extrabold text-[11px] text-center shadow-md border-2 border-blue-400 animate-pulse"';
                                            $content = '★'.explode(' ',$logMap[$machine['wm_id']][$start_time]['iden'])[0].'(Your Wash)'; 
                                        } else{
                                            $att = 'class="p-2 rounded-xl bg-indigo-50 dark:bg-indigo-950/60 border border-indigo-200 dark:border-indigo-800 text-indigo-900 dark:text-indigo-200 text-center font-semibold text-[11px] truncate" title="'.preg_replace('/^(\S+).*?(\([^)]*\))$/', '$1 $2',$logMap[$machine['wm_id']][$start_time]['iden']).'"';
                                            $content = preg_replace('/^(\S+).*?(\([^)]*\))$/', '$1 $2',$logMap[$machine['wm_id']][$start_time]['iden']);
                                        }
                                ?>
                                        <div <?=$att?>><?=$content?></div>
                                <?php
                                    }
                                ?>
                            </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
    function changeDate(days) {
        const url = new URL(window.location);
        const [d, m, y] = url.searchParams.get("date").split(".");
        const date = new Date(y, m - 1, d);

        date.setDate(date.getDate() + days);

        const dd = String(date.getDate()).padStart(2, "0");
        const mm = String(date.getMonth() + 1).padStart(2, "0");
        const yyyy = date.getFullYear();

        url.searchParams.set("date", `${dd}.${mm}.${yyyy}`);
        window.location.href = url;
    }
</script>

<?php
    include_once("includes/mfooter.php");
?>