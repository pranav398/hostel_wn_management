<?php
    $title = "Settings - HWMM";
    include_once("includes/mheader.php");
?>

<?php
    $roll = $_SESSION['roll'];
    $msg = "";
    $warn="error";

    if(isset($_POST['save_profile'])){
        $newname = $_POST['name'] == $_SESSION['name'] ? '0' : $_POST['name'];
        $newcontact = $_POST['contact'] == $_SESSION['contact'] ? '0' : $_POST['contact'];
        $newhn = $_POST['hn'] == $_SESSION['hn'] ? '0' : $_POST['hn'];
        $newrn = $_POST['rn'] == $_SESSION['rn'] ? '0' : $_POST['rn'];

        if($newname == '0' && $newcontact == '0' && $newhn == '0' && $newrn == '0'){
            $msg = "Nothing was Changed!"; 
            $warn = "warn";
        }
        else{
            $sqlout1 = $conn->prepare("INSERT INTO `update` (`roll`,`name`,`contact`,`hn`,`rn`) VALUES (?, ?, ?, ?, ?)");
            $sqlout1->bind_param("sssss", $roll, $newname, $newcontact, $newhn, $newrn);

            if ($sqlout1->execute()) {
                $msg = "Update Request Sent Successfully!"; 
                $warn="success";
            }
            else {
                $msg = "Something went wrong";
            }
        }
    }

    if(isset($_POST['update_password'])){
        if($_POST['pass'] == $_POST['cpass']){
            $sqlin2 = $conn->prepare("SELECT * FROM `user` WHERE `roll` = '$roll'");
            $sqlin2->execute();
            $resultin2 = $sqlin2->get_result();
            $rowin2 = $resultin2->fetch_assoc();

            if(password_verify($_POST['password'],$rowin2['pass'])){
                if($_POST['password'] == $_POST['pass']){
                    $msg = "Current Password and New Password cannot be identical";
                }
                else{
                    $hpass = password_hash($_POST['pass'], PASSWORD_DEFAULT);

                    $sqlout2 = $conn->prepare("UPDATE `user` SET `pass`= ? WHERE `roll`='$roll'");
                    $sqlout2->bind_param('s',$hpass);
                    if($sqlout2->execute()) {
                        $msg = "Password Updated Successfully!"; 
                        $warn="success";
                    }
                    else {
                        $msg = "Something went wrong";
                    }
                }
            }
            else{
                $msg = "Current Password Incorrect";
            }
        }
        else {
            $msg = "Passwords do not Match";
        }
    }
?>

<div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
    <div class="mb-8 flex flex-col gap-3">
        <div class="inline-flex items-center gap-2 self-start rounded-full border border-blue-200/70 bg-blue-50 px-3 py-1 text-xs font-semibold uppercase tracking-[0.24em] text-blue-700 dark:border-blue-500/30 dark:bg-blue-500/10 dark:text-blue-300">
            <i data-lucide="sliders-horizontal" class="h-3.5 w-3.5"></i>Settings
        </div>
        <div>
            <h1 class="text-2xl font-semibold tracking-tight text-slate-900 dark:text-slate-100 sm:text-3xl">Settings & Preferences</h1>
            <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-600 dark:text-slate-400 sm:text-base">Manage your profile, security, notifications, and personal preferences for the hostel washing machine portal.</p>
        </div>
    </div>

    <?php
        $sqlin1 = "SELECT * FROM `update` WHERE `roll` = '$roll' AND `active` = '1'";
        $resultin1 = $conn->query($sqlin1);
    ?>

    <div class="grid gap-6 xl:grid-cols-[minmax(0,2fr)_minmax(320px,1fr)]">
        <div class="space-y-6">
            <form method="POST" action="" class="space-y-6">
                <section class="rounded-2xl border border-slate-200/80 bg-white/90 p-6 shadow-sm backdrop-blur-sm dark:border-slate-700 dark:bg-slate-900/90">
                    <div class="mb-6 flex items-start justify-between gap-4">
                        <div class="flex items-start gap-3">
                            <div class="mt-0.5 rounded-xl bg-blue-50 p-2 text-blue-600 dark:bg-blue-500/10 dark:text-blue-300">
                                <i data-lucide="user-round-cog" class="h-5 w-5"></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Profile Information</h2>
                                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Keep your contact and hostel details up to date.</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label for="full-name" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Full Name</label>
                            <input id="full-name" name="name" type="text" value="<?=$_SESSION['name']?>" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200" required/>
                        </div>

                        <div>
                            <label for="mobile-number" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Mobile Number</label> 
                            <input id="mobile-number" name="contact" type="tel" value="<?=$_SESSION['contact']?>" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200" required/>
                        </div>

                        <div>
                            <label for="hostel-number" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Hostel</label>
                            <select id="hostel-number" name="hn" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200">
                                <?php
                                    $currentHostel = isset($_SESSION['hn']) ? $_SESSION['hn'] : '';
                                    foreach ($hostelMap as $id => $label) {
                                        $selected = $id == $currentHostel ? 'selected' : '';
                                        echo "<option value=\"" . htmlspecialchars($id) . "\" $selected>" . htmlspecialchars($label) . "</option>\n";
                                    }
                                ?>
                            </select>
                        </div>

                        <div>
                            <label for="room-number" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Room Number</label>
                            <input id="room-number" name="rn" type="text" value="<?=$_SESSION['rn']?>" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200" required/>
                        </div>
                    </div>

                    <?php
                        if($resultin1->num_rows) {
                            $color = 'red';
                            $text = 'You have already requested an update. Please wait for it to get approved.';
                            $att = 'disabled';
                            $btn_class = 'inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800 dark:bg-slate-700 dark:hover:bg-slate-600';
                        } else{
                            $color = 'blue';
                            $text = 'Changes to your profile require administrator approval before they become visible throughout the portal.';
                            $att = '';
                            $btn_class = 'inline-flex items-center justify-center rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500/40';
                        }
                    ?>

                    <div class="mt-6 rounded-xl border border-<?=$color?>-200/80 bg-<?=$color?>-50/80 p-4 dark:border-<?=$color?>-500/20 dark:bg-<?=$color?>-500/10">
                        <div class="flex items-start gap-3">
                            <i data-lucide="info" class="mt-0.5 h-4 w-4 flex-shrink-0 text-<?=$color?>-600 dark:text-<?=$color?>-300"></i>
                            <p class="text-sm leading-6 text-<?=$color?>-800 dark:text-<?=$color?>-200"><?=$text?></p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <button <?=$att?> type="submit" name="save_profile" class="<?=$btn_class?>"><i data-lucide="save" class="mr-2 h-4 w-4"></i>Save Changes</button>
                    </div>
                </section>
            </form>

            <form method="POST" action="" class="space-y-6">
                <section class="rounded-2xl border border-slate-200/80 bg-white/90 p-6 shadow-sm backdrop-blur-sm dark:border-slate-700 dark:bg-slate-900/90">
                    <div class="mb-6 flex items-start gap-3">
                        <div class="mt-0.5 rounded-xl bg-slate-100 p-2 text-slate-600 dark:bg-slate-800 dark:text-slate-300"><i data-lucide="shield-check" class="h-5 w-5"></i></div>
                        <div>
                            <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Security</h2>
                            <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Update your password to keep your account protected.</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label for="current-password" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Current Password</label>
                            <input id="current-password" name="password" type="password" placeholder="Enter your current password" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200" required/>
                        </div>

                        <div>
                            <label for="new-password" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">New Password</label>
                            <input id="new-password" name="pass" type="password" placeholder="Enter a new password" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200" required/>
                        </div>

                        <div>
                            <label for="confirm-password" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Confirm New Password</label>
                            <input id="confirm-password" name="cpass" type="password" placeholder="Re-enter the new password" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200" required/>
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit" name="update_password" class="inline-flex w-full items-center justify-center rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500/40"><i data-lucide="key-round" class="mr-2 h-4 w-4"></i>Update Password</button>
                    </div>
                </section>
            </form>
        </div>

        <div class="space-y-6">
            <?php
                if($resultin1->num_rows){
                    $rowin1 = $resultin1->fetch_assoc();
            ?>
                    <section class="rounded-2xl border border-slate-200/80 bg-white/90 p-6 shadow-sm backdrop-blur-sm dark:border-slate-700 dark:bg-slate-900/90">
                        <div class="mb-5 flex items-start gap-3">
                            <div class="mt-0.5 rounded-xl bg-amber-50 p-2 text-amber-600 dark:bg-amber-500/10 dark:text-amber-300">
                                <i data-lucide="clock-3" class="h-5 w-5"></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Pending Approval</h2>
                                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">A profile update is waiting for admin review.</p>
                            </div>
                        </div>

                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-700 dark:bg-slate-800/70">
                            <div class="flex items-center justify-between gap-3">
                                <div>
                                    <p class="text-sm font-medium text-slate-600 dark:text-slate-400">Requested On</p>
                                    <p class="mt-1 text-sm font-semibold text-slate-900 dark:text-slate-100"><?=date("M j, Y", strtotime($rowin1['time']))?></p>
                                </div>
                                <span class="inline-flex items-center rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-amber-700 dark:bg-amber-500/10 dark:text-amber-300">Awaiting Approval</span>
                            </div>

                            <div class="mt-5 space-y-4">
                                <?php
                                    if($rowin1['name'] != '0'){
                                ?>
                                        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-700 dark:bg-slate-900/80">
                                            <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400"><i data-lucide="user-round" class="h-3.5 w-3.5"></i>Full Name</div>
                                            <div class="mt-3 grid gap-3 sm:grid-cols-2">
                                                <div>
                                                    <p class="text-xs font-medium uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Current</p>
                                                    <p class="mt-1 text-sm font-medium text-slate-800 dark:text-slate-200"><?=$_SESSION['name']?></p>
                                                </div>
                                                <div>
                                                    <p class="text-xs font-medium uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Requested</p>
                                                    <p class="mt-1 text-sm font-medium text-slate-800 dark:text-slate-200"><?=$rowin1['name']?></p>
                                                </div>
                                            </div>
                                        </div>
                                <?php
                                    }
                                ?>
                                <?php
                                    if($rowin1['contact'] != '0'){
                                ?>
                                        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-700 dark:bg-slate-900/80">
                                            <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400"><i data-lucide="smartphone" class="h-3.5 w-3.5"></i>Mobile Number</div>
                                            <div class="mt-3 grid gap-3 sm:grid-cols-2">
                                                <div>
                                                    <p class="text-xs font-medium uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Current</p>
                                                    <p class="mt-1 text-sm font-medium text-slate-800 dark:text-slate-200"><?=$_SESSION['contact']?></p>
                                                </div>
                                                <div>
                                                    <p class="text-xs font-medium uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Requested</p>
                                                    <p class="mt-1 text-sm font-medium text-slate-800 dark:text-slate-200"><?=$rowin1['contact']?></p>
                                                </div>
                                            </div>
                                        </div>
                                <?php
                                    }
                                ?>
                                <?php
                                    if($rowin1['hn'] != '0'){
                                ?>
                                        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-700 dark:bg-slate-900/80">
                                            <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400"><i data-lucide="building-2" class="h-3.5 w-3.5"></i>Hostel</div>
                                            <div class="mt-3 grid gap-3 sm:grid-cols-2">
                                                <div>
                                                    <p class="text-xs font-medium uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Current</p>
                                                    <p class="mt-1 text-sm font-medium text-slate-800 dark:text-slate-200"><?=$hostelMap[$_SESSION['hn']]?></p>
                                                </div>
                                                <div>
                                                    <p class="text-xs font-medium uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Requested</p>
                                                    <p class="mt-1 text-sm font-medium text-slate-800 dark:text-slate-200"><?=$hostelMap[$rowin1['hn']]?></p>
                                                </div>
                                            </div>
                                        </div>
                                <?php
                                    }
                                ?>
                                <?php
                                    if($rowin1['rn'] != '0'){
                                ?>
                                        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-700 dark:bg-slate-900/80">
                                            <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400"><i data-lucide="bed" class="h-3.5 w-3.5"></i>Room Number</div>
                                            <div class="mt-3 grid gap-3 sm:grid-cols-2">
                                                <div>
                                                    <p class="text-xs font-medium uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Current</p>
                                                    <p class="mt-1 text-sm font-medium text-slate-800 dark:text-slate-200"><?=$_SESSION['rn']?></p>
                                                </div>
                                                <div>
                                                    <p class="text-xs font-medium uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Requested</p>
                                                    <p class="mt-1 text-sm font-medium text-slate-800 dark:text-slate-200"><?=$rowin1['rn']?></p>
                                                </div>
                                            </div>
                                        </div>
                                <?php
                                    }
                                ?>
                            </div>
                        </div>
                    </section>
            <?php
                } else{
            ?>
                    <section class="rounded-2xl border border-slate-200/80 bg-white/90 p-6 shadow-sm backdrop-blur-sm dark:border-slate-700 dark:bg-slate-900/90">
                        <div class="mb-5 flex items-start gap-3">
                            <div class="mt-0.5 rounded-xl bg-amber-50 p-2 text-amber-600 dark:bg-amber-500/10 dark:text-amber-300">
                                <i data-lucide="badge-check" class="h-5 w-5"></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">No Pending Approval</h2>
                                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">You may update your  profile if necessary.</p>
                            </div>
                        </div>
                    </section>
            <?php
                }
            ?>

            <section class="rounded-2xl border border-slate-200/80 bg-white/90 p-6 shadow-sm backdrop-blur-sm dark:border-slate-700 dark:bg-slate-900/90">
                <div class="mb-4 flex items-start gap-3">
                    <div class="mt-0.5 rounded-xl bg-slate-100 p-2 text-slate-600 dark:bg-slate-800 dark:text-slate-300"><i data-lucide="sun-moon" class="h-5 w-5"></i></div>
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Appearance</h2>
                        <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Choose the visual theme for this device.</p>
                    </div>
                </div>

                <div class="space-y-3">
                    <label class="flex items-center justify-between rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 transition hover:border-slate-300 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200">
                        <span class="flex items-center gap-3"><i data-lucide="sun" class="h-4 w-4"></i>Light</span>
                        <input type="radio" name="theme" value="light" class="h-4 w-4 border-slate-300 text-blue-600 focus:ring-blue-500" />
                    </label>

                    <label class="flex items-center justify-between rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 transition hover:border-slate-300 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200">
                        <span class="flex items-center gap-3"><i data-lucide="moon" class="h-4 w-4"></i>Dark</span>
                        <input type="radio" name="theme" value="dark" class="h-4 w-4 border-slate-300 text-blue-600 focus:ring-blue-500" checked />
                    </label>

                    <label class="flex items-center justify-between rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 transition hover:border-slate-300 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200">
                        <span class="flex items-center gap-3"><i data-lucide="monitor" class="h-4 w-4"></i>System Default</span>
                        <input type="radio" name="theme" value="system" class="h-4 w-4 border-slate-300 text-blue-600 focus:ring-blue-500" />
                    </label>
                </div>
            </section>

            <!-- <section class="rounded-2xl border border-slate-200/80 bg-white/90 p-6 shadow-sm backdrop-blur-sm dark:border-slate-700 dark:bg-slate-900/90">
                <div class="mb-5 flex items-start gap-3">
                    <div class="mt-0.5 rounded-xl bg-slate-100 p-2 text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                        <i data-lucide="bell-ring" class="h-5 w-5"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">
                            Notifications
                        </h2>
                        <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                            Choose which updates you want to receive.
                        </p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center justify-between rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 dark:border-slate-700 dark:bg-slate-800">
                        <div>
                            <p class="text-sm font-medium text-slate-800 dark:text-slate-200">Booking Confirmation</p>
                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Notify me after a booking is confirmed.</p>
                        </div>
                        <label class="relative inline-flex cursor-pointer items-center">
                            <input type="checkbox" class="peer sr-only" checked />
                            <div class="h-6 w-11 rounded-full bg-slate-200 transition peer-checked:bg-blue-600 dark:bg-slate-700"></div>
                            <div class="absolute left-1 top-1 h-4 w-4 rounded-full bg-white transition peer-checked:translate-x-5"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 dark:border-slate-700 dark:bg-slate-800">
                        <div>
                            <p class="text-sm font-medium text-slate-800 dark:text-slate-200">Booking Cancellation</p>
                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Alert me when a reservation is cancelled.</p>
                        </div>
                        <label class="relative inline-flex cursor-pointer items-center">
                            <input type="checkbox" class="peer sr-only" />
                            <div class="h-6 w-11 rounded-full bg-slate-200 transition peer-checked:bg-blue-600 dark:bg-slate-700"></div>
                            <div class="absolute left-1 top-1 h-4 w-4 rounded-full bg-white transition peer-checked:translate-x-5"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 dark:border-slate-700 dark:bg-slate-800">
                        <div>
                            <p class="text-sm font-medium text-slate-800 dark:text-slate-200">Wash Cycle Reminder</p>
                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">10 minutes before completion.</p>
                        </div>
                        <label class="relative inline-flex cursor-pointer items-center">
                            <input type="checkbox" class="peer sr-only" checked />
                            <div class="h-6 w-11 rounded-full bg-slate-200 transition peer-checked:bg-blue-600 dark:bg-slate-700"></div>
                            <div class="absolute left-1 top-1 h-4 w-4 rounded-full bg-white transition peer-checked:translate-x-5"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 dark:border-slate-700 dark:bg-slate-800">
                        <div>
                            <p class="text-sm font-medium text-slate-800 dark:text-slate-200">Maintenance Announcements</p>
                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Important facility and service updates.</p>
                        </div>
                        <label class="relative inline-flex cursor-pointer items-center">
                            <input type="checkbox" class="peer sr-only" checked />
                            <div class="h-6 w-11 rounded-full bg-slate-200 transition peer-checked:bg-blue-600 dark:bg-slate-700"></div>
                            <div class="absolute left-1 top-1 h-4 w-4 rounded-full bg-white transition peer-checked:translate-x-5"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 dark:border-slate-700 dark:bg-slate-800">
                        <div>
                            <p class="text-sm font-medium text-slate-800 dark:text-slate-200">Machine Report Status Updates</p>
                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Receive alerts when a machine needs attention.</p>
                        </div>
                        <label class="relative inline-flex cursor-pointer items-center">
                            <input type="checkbox" class="peer sr-only" />
                            <div class="h-6 w-11 rounded-full bg-slate-200 transition peer-checked:bg-blue-600 dark:bg-slate-700"></div>
                            <div class="absolute left-1 top-1 h-4 w-4 rounded-full bg-white transition peer-checked:translate-x-5"></div>
                        </label>
                    </div>
                </div>
            </section> -->

            <!-- <section class="rounded-2xl border border-slate-200/80 bg-white/90 p-6 shadow-sm backdrop-blur-sm dark:border-slate-700 dark:bg-slate-900/90">
                <div class="mb-4 flex items-start gap-3">
                    <div class="mt-0.5 rounded-xl bg-emerald-50 p-2 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-300">
                        <i data-lucide="lightbulb" class="h-5 w-5"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">
                            Quick Tips
                        </h2>
                        <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                            Helpful reminders for a smoother experience.
                        </p>
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="flex items-start gap-3 rounded-xl border border-slate-200 bg-slate-50 p-3 dark:border-slate-700 dark:bg-slate-800">
                        <i data-lucide="check-circle-2" class="mt-0.5 h-4 w-4 flex-shrink-0 text-blue-600 dark:text-blue-300"></i>
                        <p class="text-sm leading-6 text-slate-700 dark:text-slate-300">
                            Profile updates require administrator approval before they appear to other users.
                        </p>
                    </div>

                    <div class="flex items-start gap-3 rounded-xl border border-slate-200 bg-slate-50 p-3 dark:border-slate-700 dark:bg-slate-800">
                        <i data-lucide="key-round" class="mt-0.5 h-4 w-4 flex-shrink-0 text-blue-600 dark:text-blue-300"></i>
                        <p class="text-sm leading-6 text-slate-700 dark:text-slate-300">
                            Password changes take effect immediately after you save them.
                        </p>
                    </div>

                    <div class="flex items-start gap-3 rounded-xl border border-slate-200 bg-slate-50 p-3 dark:border-slate-700 dark:bg-slate-800">
                        <i data-lucide="monitor-smartphone" class="mt-0.5 h-4 w-4 flex-shrink-0 text-blue-600 dark:text-blue-300"></i>
                        <p class="text-sm leading-6 text-slate-700 dark:text-slate-300">
                            Theme preference is saved on this device for a consistent experience.
                        </p>
                    </div>

                    <div class="flex items-start gap-3 rounded-xl border border-slate-200 bg-slate-50 p-3 dark:border-slate-700 dark:bg-slate-800">
                        <i data-lucide="alarm-clock" class="mt-0.5 h-4 w-4 flex-shrink-0 text-blue-600 dark:text-blue-300"></i>
                        <p class="text-sm leading-6 text-slate-700 dark:text-slate-300">
                            Enable wash cycle reminders to avoid delaying the next user.
                        </p>
                    </div>
                </div>
            </section> -->

            <section class="rounded-2xl border border-rose-200/80 bg-rose-50/80 p-6 shadow-sm dark:border-rose-500/20 dark:bg-rose-500/10">
                <div class="mb-4 flex items-start gap-3">
                    <div class="mt-0.5 rounded-xl bg-rose-100 p-2 text-rose-600 dark:bg-rose-500/10 dark:text-rose-300">
                        <i data-lucide="trash-2" class="h-5 w-5"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-rose-800 dark:text-rose-200">Importants</h2>
                        <p class="mt-1 text-sm text-rose-700/80 dark:text-rose-300/80">Removes locally stored theme and preference settings from this browser.</p>
                    </div>
                </div>

                <button id="clear-preferences-btn" type="button" class="inline-flex items-center justify-center rounded-xl bg-rose-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-rose-500/40">
                    <i data-lucide="trash-2" class="mr-2 h-4 w-4"></i>Clear Local Preferences
                </button>
            </section>
        </div>
    </div>
</div>

<script>
    if (window.lucide) {
        window.lucide.createIcons();
    } else {
        const script = document.createElement('script');
        script.src = 'https://unpkg.com/lucide@latest';
        script.onload = function () {
            window.lucide.createIcons();
        };
        document.body.appendChild(script);
    }
</script>



<?php
    if (!empty($msg)) {
        if ($msg == "Password Updated Successfully!") {
            echo '<script>window.location.replace("logout.php?run=1");</script>';
            exit();
        }
        else{
            echo "<script>
                window.addEventListener('load', function () {
                    if (window.showToast) {
                        showToast(" . json_encode($msg) . ", " . json_encode($warn) . ");
                    }
                });
            </script>";
        }
    }

    include_once("includes/mfooter.php");
?>
