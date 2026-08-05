<?php
    $title = "Register - HWMM";
    $login_req = false;
    include_once("includes/header.php");

    $msg = "";
    $warn="error";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = trim($_POST["ldap"]);
        $password = $_POST["pass"];
        $confirm = $_POST["cpass"];
        $name = $_POST["name"];
        $hn = $_POST["hn"];
        $rn = $_POST["rn"];
        $no = $_POST["no"];

        // 1. Password check FIRST
        if ($password !== $confirm) {
            $msg = "Passwords do not match";
        }
        // elseif (strlen($password) < 8) {
        //     $msg = "Password must be at least 8 characters long.";
        // } 
        // elseif (!preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/[0-9]/', $password)) {
        //     $msg = "Password must contain uppercase, lowercase and a number.";
        // } 
        else {
            if (!empty($username) && !empty($password)) {

                // 2. Check username
                $checkUser = $conn->prepare("SELECT `name` FROM `user` WHERE `roll` = ?");
                $checkUser->bind_param("s", $username);
                $checkUser->execute();
                $checkUser->store_result();

                if ($checkUser->num_rows > 0) {
                    $msg = "Username already taken";
                }
                else {
                    // 4. Insert user
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    $stmt = $conn->prepare("INSERT INTO user (roll,name,contact,hn,rn,pass) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("ssssss", $username, $name, $no, $hn, $rn, $hashed_password);

                    if ($stmt->execute()) {
                        $msg = "Account created successfully!"; 
                        $warn="success";
                    }
                    else {
                        $msg = "Something went wrong";
                    }
                }
            }
            else{
                $msg = "All fields are required";
            }
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
                    <h2 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Admin Sign Up</h2>
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
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1.5">Name</label>
                        <div class="relative">
                            <i data-lucide="user" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3"></i>
                            <input type="text" name="name" id="login-user" placeholder="Enter your Full Name" class="w-full pl-10 pr-3.5 py-2.5 bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-medium text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1.5">Hostel</label>
                        <div class="relative">
                            <i data-lucide="user" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3"></i>
                            <input type="number" name="hn" id="login-user" placeholder="Enter your Hostel" class="w-full pl-10 pr-3.5 py-2.5 bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-medium text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1.5">Room Number</label>
                        <div class="relative">
                            <i data-lucide="user" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3"></i>
                            <input type="number" name="rn" id="login-user" placeholder="Enter Your Room Number" class="w-full pl-10 pr-3.5 py-2.5 bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-medium text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1.5">Contact Number</label>
                        <div class="relative">
                            <i data-lucide="user" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3"></i>
                            <input type="number" name="no" id="login-user" placeholder="Enter your 10-digit Mobile Number" class="w-full pl-10 pr-3.5 py-2.5 bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-medium text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition" required>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Password</label>
                        </div>
                        <div class="relative">
                            <i data-lucide="lock" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3"></i>
                            <input type="password" id="login-pass" name="pass" placeholder="Enter password" class="w-full pl-10 pr-3.5 py-2.5 bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-medium text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition" required>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Confirm Password</label>
                        </div>
                        <div class="relative">
                            <i data-lucide="lock" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3"></i>
                            <input type="password" id="login-pass" name="cpass" placeholder="Enter password again" class="w-full pl-10 pr-3.5 py-2.5 bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-medium text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition" required>
                        </div>
                    </div>

                    <button type="submit" name="submit" class="w-full py-3 px-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl text-xs font-bold shadow-lg shadow-blue-500/25 transition-all flex items-center justify-center gap-2 group cursor-pointer">
                        <span>Sign Up to Laundry Dashboard</span>
                        <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </form>
            </div>
        </div>
    </main>

    <script>
        function handleLogin(e) {
            e.preventDefault();
            showToast('Signing in as Alex Rivera...', 'success');
            setTimeout(() => {
                window.location.href = 'dashboard.php';
            }, 800);
        }

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