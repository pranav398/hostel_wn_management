<?php
    $title = "Book Machine - HWMM";
    include_once("includes/mheader.php");

    $hn = $_SESSION['hn'];
    $roll = $_SESSION['roll'];

    $wmsql = "SELECT * FROM `wm` WHERE `wm_id` LIKE '{$hn}___'";
    $wmresult = $conn->query($wmsql);
    $wmMap = [];

    while($wmrow = $wmresult->fetch_assoc()){
        $wmMap[] = $wmrow;
    }

    $logsql = "SELECT `wm_id`, `time` FROM `log` WHERE `wm_id` LIKE '{$hn}___' AND `status` = '1' AND DATE(`time`) BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 6 DAY);";
    $logresult = $conn->query($logsql);
    $logMap=[];

    while($logrow = $logresult->fetch_assoc()){
        $wmid = $logrow['wm_id'];
        $slot = date("H:i", strtotime($logrow['time']));
        $date = date("d.m.Y", strtotime($logrow['time']));
        $logMap[$wmid][$date][$slot] = $logrow;
    }

    $timeMap = ['00:00','01:30','03:00','04:30','06:00','07:30','09:00','10:30','12:00','13:30','15:00','16:30','18:00','19:30','21:00','22:30'];
    $msg = "";
    $warn="error";

    if(isset($_POST['confirm']) && $_POST['confirm'] == 'book'){
        // echo "<script>alert('Working');</script>";

        $date = $_POST['step1'];
        $wmid = $_POST['step2'];
        $time = $_POST['step3'];

        $datetime = DateTime::createFromFormat('d.m.Y H:i', "$date $time")->format('Y-m-d H:i:s');

        $sql1 = $conn->prepare("SELECT * FROM `log` WHERE `time` = ? AND `wm_id` = ?");
        $sql1->bind_param("ss", $datetime, $wmid);
        $sql1->execute();

        $result1 = $sql1->get_result();

        if ($result1->num_rows > 0) {
            $msg = "This time slot for your machine is already booked by another user.";
        } else {
            $roll = $_SESSION['roll'];
            $iden = $_SESSION['name'].' ('.$_SESSION['rn'].')';

            $sqlcheck = "SELECT * FROM `log` WHERE `roll` = '$roll' AND `time` = '$datetime' AND `status` = '1'";
            $resultCheck = $conn->query($sqlcheck);

            if($resultCheck->num_rows == 0){
                $sql2 = $conn->prepare("INSERT INTO `log`(`roll`, `wm_id`, `time`, `iden`) VALUES (?, ?, ?, ?)");
                $sql2->bind_param("ssss", $roll, $wmid, $datetime, $iden);

                if($sql2->execute()){
                    $credits = $_SESSION['credits'] - 1;
                    $sql3 = $conn->prepare("UPDATE `user` SET `credits`= ? WHERE `roll`= ?");
                    $sql3->bind_param("ss", $credits, $roll);
                    
                    if($sql3->execute()){
                        $_SESSION['credits'] = $credits;
                        $msg="success";
                        $warn="success";
                    }
                    else{
                        $msg = "Slot reserved successfully!... But something went wrong with credits";
                    }
                }
                else{
                    $msg = "Couldn't Book.. Something went wrong";
                }
            }
            else{
                $msg = "You cannot reserve 2 machines at the same time slot";
                $warn = "warn";
            }
        }

    }
?>

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-extrabold tracking-tight text-slate-900 dark:text-white flex items-center gap-2">
                    <i data-lucide="calendar-plus" class="w-7 h-7 text-blue-600"></i>Book Washing Machine Slot
                </h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Select date, machine location, and time slot to reserve your wash cycle.</p>
            </div>

                <div class="inline-flex items-center gap-2 px-3.5 py-2 rounded-2xl bg-amber-50 dark:bg-amber-950/60 border border-amber-200 dark:border-amber-800 text-amber-900 dark:text-amber-200 text-xs font-semibold">
                <i data-lucide="info" class="w-4 h-4 text-amber-600 shrink-0"></i>
                <span>Fair Use Policy: Maximum 1 active booking allowed per resident.</span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
        
                <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-3">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400">Step 1: Choose Date</label>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3" id="date-picker-grid">
                        <?php
                            $date = new DateTime();
                            $i=1;
                            while($i<=7){
                                $date_ = $date->format('M j, Y');
                                $dateKey = $date->format('d.m.Y');
                                $day_ = $date->format('D');
                                $date->modify('+1 day');
                                $i++;
                        ?>
                                <button onclick="selectDate(this, '<?=$date_?>', '<?=$dateKey?>')" class="date-btn p-3 rounded-2xl border-2 border-blue-600 bg-blue-50 dark:bg-blue-950/50 text-left transition cursor-pointer">
                                    <span class="block text-[10px] font-bold text-blue-600 dark:text-blue-400 uppercase"><?=$day_?></span>
                                    <span class="block text-sm font-extrabold text-slate-900 dark:text-white"><?=$date_?></span>
                                    <!-- <span class="block text-[11px] text-slate-500 mt-1">12 slots open</span> -->
                                </button>
                        <?php
                            }
                        ?>
                    </div>
                </div>

                <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-3">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400">Step 2: Choose Washing Machine</label>
                        <span class="text-xs text-slate-500">Bay Filter: <strong class="text-blue-600"><?=$hostelMap[$_SESSION['hn']]?></strong></span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3" id="machine-picker-grid">

                    <?php
                        foreach($wmMap as $machine){
                            $type = substr($machine['wm_id'],5,1) == '1';
                            $floor = substr($machine['wm_id'],3,2);

                    ?>
                            <button <?=$machine['working'] ? '' : 'disabled'?> onclick="selectMachine(this, '<?=$type ? 'Washing' : 'Drying'?> Machine - <?=$floor?>', '<?=$type ? 'W' : 'D'?>M-<?=$floor?>', 'Floor <?=$floor?>','<?=$machine['wm_id']?>')" class="machine-btn p-3.5 rounded-2xl border border-slate-200 dark:border-slate-800 hover:border-blue-500 text-left transition flex items-center justify-between <?=$machine['working'] ? 'cursor-pointer' : 'cursor-not-allowed'?>">
                                <div class="flex items-center gap-3">
                                    <div class="<?=$machine['working'] ? 'w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs flex items-center justify-center' : 'w-10 h-10 rounded-xl bg-rose-100 dark:bg-rose-950 text-rose-600 dark:text-rose-300 font-bold text-xs flex items-center justify-center'?>"></div>
                                    <div>
                                        <h4 class="text-xs font-bold text-slate-900 dark:text-white"><?=$type ? 'Washing' : 'Drying'?> Machine - <?=$floor?></h4>
                                        <p class="text-[11px] text-slate-500"><?=$machine['working'] ? 'Available' : 'Under Maintainance'?></p>
                                    </div>
                                </div>
                                <i data-lucide="check-circle" class="w-5 h-5 text-blue-600 opacity-0 check-icon"></i>
                            </button>
                    <?php
                        }
                    ?>

                    </div>
                </div>

                <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-4">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400">Step 3: Select Time Slot</label>

                        <div class="flex items-center gap-3 text-[11px] font-medium">
                            <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> Available</span>
                            <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-slate-300 dark:bg-slate-700"></span> Booked</span>
                            <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span> Selected</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5" id="time-slots-grid">
                        <!-- Buttons Here -->
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xl space-y-6 sticky top-24">
                    <div class="border-b border-slate-100 dark:border-slate-800 pb-4">
                        <span class="px-2.5 py-1 rounded-full bg-blue-100 text-blue-700 dark:bg-blue-950 dark:text-blue-300 text-[10px] font-bold uppercase tracking-wider">Booking Summary</span>
                        <h3 class="text-xl font-extrabold text-slate-900 dark:text-white mt-1">Reservation Details</h3>
                    </div>

                    <div class="space-y-3 text-xs">
                        <div class="flex justify-between py-2 border-b border-slate-100 dark:border-slate-800">
                            <span class="text-slate-500">Date</span>
                            <span id="summary-date" class="font-bold text-slate-900 dark:text-white"></span>
                        </div>

                        <div class="flex justify-between py-2 border-b border-slate-100 dark:border-slate-800">
                            <span class="text-slate-500">Selected Machine</span>
                            <span id="summary-machine" class="font-bold text-slate-900 dark:text-white"></span>
                        </div>

                        <div class="flex justify-between py-2 border-b border-slate-100 dark:border-slate-800">
                            <span class="text-slate-500">Time Window</span>
                            <span id="summary-time" class="font-bold text-blue-600 dark:text-blue-400"></span>
                        </div>

                        <div class="flex justify-between py-2 border-b border-slate-100 dark:border-slate-800">
                            <span class="text-slate-500">Hostel Location</span>
                            <span id="summary-location" class="font-bold text-slate-900 dark:text-white"></span>
                        </div>

                        <div class="flex justify-between py-2 border-b border-slate-100 dark:border-slate-800">
                            <span class="text-slate-500">Wash Credit Cost</span>
                            <span class="font-bold text-emerald-600 dark:text-emerald-400">1 Credit (<?=$_SESSION['credits']?> Remaining)</span>
                        </div>
                    </div>

                    <!-- <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1.5">Preferred Wash Preset</label>
                        <select id="cycle-preset" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-medium text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="Cottons 60°C (45m)">Cottons 60°C (45 Mins)</option>
                            <option value="Quick Eco 30°C (30m)">Quick Eco 30°C (30 Mins)</option>
                            <option value="Heavy Spin + Dry (60m)">Heavy Spin + Softener (60 Mins)</option>
                            <option value="Delicates / Wool (30m)">Delicates / Wool (30 Mins)</option>
                        </select>
                    </div> -->

                    <button id="confirm-btn" <?=$_SESSION['credits'] ? 'onclick="confirmBookingModal()"' : 'disabled'?> class="w-full py-3.5 px-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-2xl text-xs font-bold shadow-lg shadow-blue-500/25 transition-all flex items-center justify-center gap-2 <?=$_SESSION['credits'] ? 'cursor-pointer' : 'cursor-not-allowed'?>">
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span>Confirm Slot Reservation</span>
                    </button>
                </div>
            </div>
        </div>
    </main>
</div>


<div id="booking-modal" class="hidden fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-sm items-center justify-center p-4">
    <div class="bg-white dark:bg-slate-900 w-full max-w-md rounded-3xl p-6 sm:p-8 shadow-2xl border border-slate-200 dark:border-slate-800 space-y-6">
        <div class="text-center">
            <div class="w-14 h-14 rounded-2xl bg-emerald-100 dark:bg-emerald-950 text-emerald-600 dark:text-emerald-400 flex items-center justify-center mx-auto mb-3">
                <i data-lucide="check-circle" class="w-8 h-8"></i>
            </div>
            <h3 class="text-xl font-extrabold text-slate-900 dark:text-white">Confirm Machine Booking</h3>
            <p class="text-xs text-slate-500 mt-1">Please verify your booking details before generating your door pass code.</p>
        </div>

        <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/60 space-y-2 text-xs">
            <div class="flex justify-between">
                <span class="text-slate-500">Machine:</span>
                <span class="font-bold text-slate-900 dark:text-white" id="modal-machine">WM-02 (Ground Bay A)</span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-500">Time Slot:</span>
                <span class="font-bold text-blue-600" id="modal-time">Today, 18:00 - 19:00</span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-500">Resident:</span>
                <span class="font-bold text-slate-900 dark:text-white"><?=$_SESSION['name']?> (<?=$_SESSION['rn']?>)</span>
            </div>
        </div>

        <div class="flex gap-3">
            <button onclick="closeModal('booking-modal')" class="flex-1 py-3 px-4 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 text-slate-700 dark:text-slate-300 rounded-2xl text-xs font-bold transition cursor-pointer">Cancel</button>
            <button onclick="finalizeBooking()" class="flex-1 py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl text-xs font-bold shadow-lg shadow-blue-500/25 transition cursor-pointer">Complete Booking</button>
        </div>
    </div>
</div>

<script>
    const logMap = <?= json_encode($logMap) ?>;
    const timeMap = <?= json_encode($timeMap) ?>;
</script>

<script>
    let selectedDateVal = '';
    let selectedDateKey = '';
    let selectedMachineVal = '';
    let selectedWMId = '';
    let selectedSlotKey = '';
    let selectedSlotVal = '';

    updateConfirmButton();

    function selectDate(btn, dateStr, dateKey) {
      document.querySelectorAll('.date-btn').forEach(b => {
        b.className = 'date-btn p-3 rounded-2xl border border-slate-200 dark:border-slate-800 hover:border-blue-500 text-left transition cursor-pointer';
      });
      btn.className = 'date-btn p-3 rounded-2xl border-2 border-blue-600 bg-blue-50 dark:bg-blue-950/50 text-left transition cursor-pointer';
      selectedDateVal = dateStr;
      selectedDateKey = dateKey;
      document.getElementById('summary-date').innerText = dateStr;
      renderSlots();
      updateConfirmButton();
    }

    function selectMachine(btn, id, name, bay,wmId) {
      document.querySelectorAll('.machine-btn').forEach(b => {
        b.className = 'machine-btn p-3.5 rounded-2xl border border-slate-200 dark:border-slate-800 hover:border-blue-500 text-left transition flex items-center justify-between cursor-pointer';
        b.querySelector('.check-icon')?.classList.add('opacity-0');
      });
      btn.className = 'machine-btn p-3.5 rounded-2xl border-2 border-blue-600 bg-blue-50/50 dark:bg-blue-950/40 text-left transition flex items-center justify-between cursor-pointer';
      btn.querySelector('.check-icon')?.classList.remove('opacity-0');
      selectedMachineVal = `${id} (${name})`;
      selectedWMId = wmId;
      document.getElementById('summary-machine').innerText = selectedMachineVal;
      document.getElementById('summary-location').innerText = bay;
      renderSlots();
      updateConfirmButton();
    }

    function renderSlots() {
        if (!selectedDateKey || !selectedWMId) return;

        const grid = document.getElementById("time-slots-grid");
        grid.innerHTML = "";

        timeMap.forEach(time => {
            const booked = logMap[selectedWMId]?.[selectedDateKey]?.[time];

            const today = new Date().toLocaleDateString('en-GB').replace(/\//g, '.');
            const now = new Date().toTimeString().slice(0, 5);

            const completed = (selectedDateKey === today && (new Date(`1970-01-01T${time}:00`).getTime() + 45 * 60000) < new Date(`1970-01-01T${now}:00`).getTime());
            const end = new Date(`1970-01-01T${time}:00`);
            end.setMinutes(end.getMinutes() + 90);

            const endTime =
                end.getHours().toString().padStart(2, '0') +
                ":" +
                end.getMinutes().toString().padStart(2, '0');

            grid.innerHTML += `
                <button
                    ${booked || completed ? "disabled" : `onclick="selectSlot(this, '${time} - ${endTime}', '${time}')"`}

                    class="${booked || completed
                        ? "p-2.5 rounded-xl bg-slate-100 dark:bg-slate-800/50 text-slate-400 cursor-not-allowed text-xs font-semibold flex flex-col items-center justify-center border border-slate-200/50 dark:border-slate-800"
                        : "slot-btn p-2.5 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 hover:bg-emerald-100 text-xs font-semibold flex flex-col items-center justify-center transition cursor-pointer"}">

                    <span>${time} - ${endTime}</span>
                    <span class="text-[9px] uppercase font-bold ${booked || completed ? "text-slate-400" : "text-emerald-600"}">
                        ${completed ? "Completed" : (booked ? "Booked" : "Available")}
                    </span>
                </button>
                `;
        });
    }

    function selectSlot(btn, timeStr, startTime) {
      document.querySelectorAll('.slot-btn').forEach(b => {
        b.className = 'slot-btn p-2.5 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 hover:bg-emerald-100 text-xs font-semibold flex flex-col items-center justify-center transition cursor-pointer';
        const label = b.querySelectorAll('span')[1];
        if (label) {
          label.textContent = 'Available';
          label.className = 'text-[9px] uppercase font-bold text-emerald-600';
        }
      });
      btn.className = 'slot-btn p-2.5 rounded-xl bg-blue-600 text-white font-bold text-xs flex flex-col items-center justify-center border-2 border-blue-600 shadow-md transition cursor-pointer';
      const selectedLabel = btn.querySelectorAll('span')[1];
      if (selectedLabel) {
        selectedLabel.textContent = 'Selected';
        selectedLabel.className = 'text-[9px] uppercase font-bold text-blue-200';
      }
      selectedSlotVal = `${timeStr}`;
      selectedSlotKey = startTime;
      document.getElementById('summary-time').innerText = selectedSlotVal;
      updateConfirmButton();
    }

    function updateConfirmButton() {
        const btn = document.getElementById("confirm-btn");

        if (selectedDateKey && selectedWMId && selectedSlotKey) {
            btn.disabled = false;
            btn.classList.remove("opacity-50", "cursor-not-allowed");
            btn.classList.add("cursor-pointer");
        } else {
            btn.disabled = true;
            btn.classList.add("opacity-50", "cursor-not-allowed");
            btn.classList.remove("cursor-pointer");
        }
    }

    function confirmBookingModal() {
      document.getElementById('modal-machine').innerText = selectedMachineVal;
      document.getElementById('modal-time').innerText = `${selectedDateVal}, ${selectedSlotVal}`;
      openModal('booking-modal');
    }

    function finalizeBooking() {
        const form = document.createElement("form");
        form.method = "POST";
        form.action = "";

        [
            ["step1", selectedDateKey],
            ["step2", selectedWMId],
            ["step3", selectedSlotKey],
            ["confirm", "book"]
        ].forEach(([name, value]) => {
            const input = document.createElement("input");
            input.type = "hidden";
            input.name = name;
            input.value = value;
            form.appendChild(input);
        });

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
                // setTimeout(() => {
                //     window.location.href = 'booking.php';
                // }, 1200);
            </script>";    
        } else{
            echo "<script>
                window.addEventListener('load', function () {
                    if (window.showToast) {
                        showToast('Slot reserved successfully!', 'success', 'Booking Confirmed');
                    }
                });
                setTimeout(() => {
                    window.location.href = 'history.php';
                }, 1200);
            </script>";
        }
    }

    include_once("includes/mfooter.php");
?>