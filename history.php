<?php
    $title = "Booking History - HWMM";
    date_default_timezone_set('Asia/Kolkata');
    include_once("includes/db.php");

    if (!empty($_POST['canId'])) {
        $canId = $_POST['canId'];

        $sqlin = "SELECT * FROM `log` WHERE `id` = '$canId'";
        $resultin = $conn->query($sqlin);

        if ($resultin->num_rows) {
            $rowin = $resultin->fetch_assoc();

            $time = strtotime($rowin['time']);
            $canDate = date("Y, M j", $time);
            $canTime = date("H:i", $time);
            $canMachine = (substr($rowin['wm_id'], 5, 1) == '1' ? 'W' : 'D').'M - '.substr($rowin['wm_id'], 3, 2);
            $canCredit = ($time - 90 * 60) < time() ? 'No Refund' : '1 Credit';

            echo json_encode([
                'success' => true,
                'date' => $canDate,
                'time' => $canTime,
                'machine' => $canMachine,
                'credit' => $canCredit
            ]);
            exit;
        }
    }

    include_once("includes/mheader.php");

    $msg='';
    $warn='error';

    if(!empty($_POST['cancelId'])) {
        $cancelId = $_POST['cancelId'];
        $cancelRoll=$_SESSION['roll'];

        $sqlout1 = $conn->prepare("SELECT * FROM `log` WHERE `id` = ? AND `roll` = ?");
        $sqlout1->bind_param("ss", $cancelId, $cancelRoll);
        $sqlout1->execute();
        $resultout1 = $sqlout1->get_result();

        if ($resultout1->num_rows == 1) {
            $rowout1 = $resultout1->fetch_assoc();


                

            if((strtotime($rowout1['time'])- 90 * 60) < time()){
                $sqlout3 = $conn->prepare("UPDATE `log` SET `status`= '0' WHERE `id` = ?");
                $sqlout3->bind_param("s", $cancelId);
                if($sqlout3->execute()){
                    $msg = 'success';
                    $warn = 'success';
                }
                else{
                    $msg="Something Went Wrong";
                }
            }
            else{
                $credits = $_SESSION['credits'] + 1;
                $sqlout2 = $conn->prepare("UPDATE `user` SET `credits` = ? WHERE `roll` = ?");
                $sqlout2->bind_param("ss", $credits, $cancelRoll);

                if($sqlout2->execute()){
                    $_SESSION['credits'] = $credits;
                    
                    $sqlout3 = $conn->prepare("UPDATE `log` SET `status`= '0' WHERE `id` = ?");
                    $sqlout3->bind_param("s", $cancelId);
                    if($sqlout3->execute()){
                        $msg = 'success';
                        $warn = 'success';
                    }
                    else{
                        $msg="Something Went Wrong";
                    }
                }
                else{
                    $msg="Something Went Wrong";
                }
            }
        }
        else{
            $msg="Do not try to fuck up with the console!!";
        }
    }
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
                            $start = date("Y, M j", strtotime($rowh['time']));
                            $from  = date("H:i", strtotime($rowh['time']));
                            $to    = date("H:i", strtotime($rowh['time']) + 90*60);

                            $machine = ((substr($rowh['wm_id'], -1) == '1') ? "WM" : "DM") . " " . substr($rowh['wm_id'], 3, 2);
                            $location = "Floor " . substr($rowh['wm_id'], 3, 2);

                            if($rowh['status'] == 1){
                                if(strtotime($rowh['time']) + 90*60 < time()){
                                    $status = '<span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300 flex items-center gap-1 w-fit">✓ Completed</span>';
                                }
                                else{
                                    $status = strtotime($rowh['time']) < time() ? '<span onClick="bookingCancel('.$rowh['id'].')" class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-100 text-blue-700 dark:bg-blue-950 dark:text-blue-300 flex items-center gap-1 w-fit  cursor-pointer"><span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-ping"></span> In Progress</span>' : '<span onClick="bookingCancel('.$rowh['id'].')" class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-yellow-100 text-yellow-700 dark:bg-yellow-950 dark:text-yellow-300 flex items-center gap-1 w-fit cursor-pointer">× Cancel</span>';
                                }
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

<div id="report-modal" class="hidden fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-sm items-center justify-center p-4">
    <div class="bg-white dark:bg-slate-900 w-full max-w-md rounded-3xl p-6 shadow-2xl border border-slate-200 dark:border-slate-800 space-y-4">
        <h3 class="text-lg font-bold text-slate-900 dark:text-white">Cancel Booking??</h3>
        <p class="text-xs text-slate-500">You should cancel your booking if you won't be available there.</p>
        
        <div class="flex justify-between">
            <span class="text-slate-500">Date:</span>
            <span class="font-bold text-slate-900 dark:text-white" id="modal-date"></span>
        </div>

        <div class="flex justify-between">
            <span class="text-slate-500">Time:</span>
            <span class="font-bold text-slate-900 dark:text-white" id="modal-time"></span>
        </div>

        <div class="flex justify-between">
            <span class="text-slate-500">Machine:</span>
            <span class="font-bold text-slate-900 dark:text-white" id="modal-machine"></span>
        </div>

        <div class="flex justify-between">
            <span class="text-slate-500">Credit Refund:</span>
            <span class="font-bold text-slate-900 dark:text-white" id="modal-credit"></span>
        </div>

        <div class="flex gap-2">
            <button onclick="closeModal('report-modal')" class="flex-1 py-2.5 bg-slate-100 dark:bg-slate-800 rounded-xl text-xs font-bold">Cancel</button>
            <button onclick="submitCancel()" class="flex-1 py-2.5 bg-rose-600 text-white rounded-xl text-xs font-bold">Submit Cancel Request</button>
        </div>
    </div>
</div>

<script>
    let caId = null;

    function bookingCancel(id) {
        caId = id;
        fetch(window.location.href, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                canId: id
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('modal-date').textContent = data.date;
                document.getElementById('modal-time').textContent = data.time;
                document.getElementById('modal-machine').textContent = data.machine;
                document.getElementById('modal-credit').textContent = data.credit;

                openModal('report-modal');
            }
        });
    }

    function submitCancel() {
        closeModal('report-modal');
        console.log('called');

        const form = document.createElement("form");
        form.method = "POST";
        form.action = "";

        const input = document.createElement("input");
        input.type = "hidden";
        input.name = "cancelId";
        input.value = caId;
        form.appendChild(input);

        document.body.appendChild(form);
        form.submit();
    }
</script>

<?php
    if (!empty($msg)) {
        if($warn != "success"){
            echo "<script>
                window.addEventListener('load', function () {
                    if (window.showToast) {
                        showToast(" . json_encode($msg) . ", " . json_encode($warn) . ");
                    }
                });
                setTimeout(() => {
                    window.location.href = 'schedule.php';
                }, 1200);
            </script>";    
        } else{
            echo "<script>
                window.addEventListener('load', function () {
                    if (window.showToast) {
                        showToast('Cancel Request Successfully Processed!', 'success', 'Booking Confirmed');
                    }
                });
                // setTimeout(() => {
                //     window.location.href = 'history.php';
                // }, 1200);
            </script>";
        }
    }

    include_once("includes/mfooter.php");
?>