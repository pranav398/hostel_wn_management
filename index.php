<?php
    $title = "Login - HWMM";
    include_once("includes/header.php");

    $msg = "";
    $warn="error";

    if (isset($_POST["submit"])) {
        $username = trim($_POST["ldap"]);
        $password = $_POST["pass"];
        $rem = $_POST['rem'];

        if (!empty($username) && !empty($password)) {
            // 1. Find user by username
            $stmt = $conn->prepare("SELECT * FROM user WHERE roll = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $user = $result->fetch_assoc();

                // 2. Verify password
                if (password_verify($password, $user["pass"])) {
                    $hn = $user["hn"];
                    $roll = $user["roll"];

                    $sqlw = "SELECT COUNT(*) AS count FROM `wm` WHERE `wm_id` LIKE '{$hn}__1'";
                    $resultw = $conn->query($sqlw);
                    $roww = $resultw->fetch_assoc();

                    $sqld = "SELECT COUNT(*) AS count FROM `wm` WHERE `wm_id` LIKE '{$hn}__2'";
                    $resultd = $conn->query($sqld);
                    $rowd = $resultd->fetch_assoc();

                    // 3. Create session
                    $_SESSION["roll"] = $user["roll"];
                    $_SESSION["name"] = $user["name"];
                    $_SESSION["contact"] = $user["contact"];
                    $_SESSION["hn"] = $user["hn"];
                    $_SESSION["rn"] = $user["rn"];
                    $_SESSION["credits"] = $user["credits"];
                    $_SESSION["w_no"] = $roww['count'];
                    $_SESSION["d_no"] = $rowd['count'];

                    $msg = "Successfuly Logged In";
                    $warn = "success";
                } 
                else {
                    if($user["pass"] == '0'){
                        $msg = "Your account is locked due to unauthorized access attempts";
                    }
                    else{
                        $msg = "Incorrect password";
                    }
                }
            } 
            else {
                $msg = "Username not found";
            }
        } 
        else {
            $msg = "All fields are required";
        }
    }
?>

<body class="h-full bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 font-sans antialiased flex flex-col justify-between selection:bg-blue-500 selection:text-white relative overflow-x-hidden">
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0 opacity-40 dark:opacity-20">
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-blue-400 dark:bg-blue-600 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 -right-40 w-96 h-96 bg-indigo-400 dark:bg-indigo-600 rounded-full blur-3xl"></div>
    </div>

    <header class="w-full max-w-7xl mx-auto p-6 flex items-center justify-between z-10 relative">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-blue-600 to-sky-400 flex items-center justify-center text-white shadow-lg shadow-blue-500/25">
                <i data-lucide="waves" class="w-6 h-6"></i>
            </div>
            <div>
                <h1 class="font-extrabold text-lg tracking-tight text-slate-900 dark:text-white flex items-center gap-2">HWMM
                    <span class="text-[10px] font-bold uppercase tracking-widest px-2 py-0.5 rounded-full bg-blue-100 text-blue-700 dark:bg-blue-950 dark:text-blue-300">Freshers '26</span>
                </h1>
                <p class="text-xs text-slate-500 dark:text-slate-400">Hostel Washing Machine Management Portal</p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button class="theme-toggle-btn p-2 text-slate-600 dark:text-slate-300 hover:bg-white dark:hover:bg-slate-800 rounded-xl shadow-xs border border-slate-200/80 dark:border-slate-800 transition" title="Toggle Theme">
                <i data-lucide="sun" class="theme-sun-icon w-5 h-5 hidden"></i>
                <i data-lucide="moon" class="theme-moon-icon w-5 h-5"></i>
            </button>
        </div>
    </header>

    <main class="flex-1 flex items-center justify-center p-4 sm:p-6 z-10 relative">
        <div class="w-full max-w-md">
            <div class="glass-card bg-white/90 dark:bg-slate-900/90 rounded-3xl p-6 sm:p-8 shadow-2xl border border-slate-200/80 dark:border-slate-800 backdrop-blur-xl relative overflow-hidden">
                <div class="text-center mb-8">
                    <div class="w-16 h-16 rounded-2xl bg-blue-50 dark:bg-blue-950/80 border border-blue-100 dark:border-blue-900 mx-auto flex items-center justify-center text-blue-600 dark:text-blue-400 mb-4 shadow-inner">
                        <i data-lucide="washing-machine" class="w-8 h-8 animate-bubble"></i>
                    </div>
                    <h2 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Resident Sign In</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1.5 max-w-xs mx-auto">Access real-time machine status, book slots, and track wash cycles.</p>
                </div>

                <form class="space-y-4" action="" method="POST">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1.5">Roll Number</label>
                        <div class="relative">
                            <i data-lucide="user" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3"></i>
                            <input type="text" name="ldap" id="login-user" placeholder="e.g. 26BXXXX" class="w-full pl-10 pr-3.5 py-2.5 bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-medium text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition" required>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Password</label>
                            <a href="forgotPassword.php" onclick="showToast('Contact hostel warden office to reset PIN', 'warning'); return false;" class="text-[11px] text-blue-600 dark:text-blue-400 hover:underline">Forgot password?</a>
                        </div>
                        <div class="relative">
                            <i data-lucide="lock" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3"></i>
                            <input type="password" id="login-pass" name="pass" placeholder="Enter password" class="w-full pl-10 pr-3.5 py-2.5 bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-medium text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition" required>
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-xs py-1">
                        <label class="flex items-center gap-2 cursor-pointer text-slate-600 dark:text-slate-400">
                            <input type="checkbox" checked name="rem" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                            <span>Remember this device</span>
                        </label>
                    </div>

                    <button type="submit" name="submit" class="w-full py-3 px-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl text-xs font-bold shadow-lg shadow-blue-500/25 transition-all flex items-center justify-center gap-2 group cursor-pointer">
                        <span>Sign In to Laundry Dashboard</span>
                        <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </form>

                <div class="mt-6 pt-6 border-t border-slate-100 dark:border-slate-800 text-center">
                    <p class="text-[11px] text-slate-400 mb-2 font-medium">Quick Preview Access:</p>
                    <button onclick="" class="w-full py-2 px-3 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-xl text-xs font-semibold flex items-center justify-center gap-2 transition cursor-pointer">
                        <span>Continue as Alex Rivera (Room B-304)</span>
                    </button>
                </div>
            </div>
        </div>
    </main>

    <script>


        function quickLogin() {
            showToast('Logging in as Alex Rivera (Titanium Block B-304)...', 'success');
            setTimeout(() => {
                window.location.href = 'dashboard.php';
            }, 600);
        }
    </script>

<?php
    if (!empty($msg)) {
        echo "<script>
            window.addEventListener('load', function () {
                if (window.showToast) {
                    showToast(" . json_encode($msg) . ", " . json_encode($warn) . ");
                    window.location.href='';
                }
            });
        </script>";    
    }

    include_once("includes/footer.php");
?>