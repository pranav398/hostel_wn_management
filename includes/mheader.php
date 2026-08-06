<?php
    session_start();
    date_default_timezone_set('Asia/Kolkata');
    if (!isset($_SESSION["roll"])) {
        header("Location: index.php");
        exit;
    }

    include "includes/db.php";
?>

<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?=$title?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
        darkMode: 'class'
        }
    </script>

    <link rel="stylesheet" href="./assets/css/style.css" />
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="min-h-screen bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 font-sans antialiased flex flex-col selection:bg-blue-500 selection:text-white">
    <div id="app-header">
        <header class="sticky top-0 z-40 w-full h-16 border-b border-slate-200 dark:border-slate-800 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md px-4 lg:px-8 flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <button id="mobile-sidebar-toggle" class="lg:hidden p-2 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition">
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>
                <a href="dashboard.php" class="flex items-center gap-2.5 group">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-blue-600 via-indigo-600 to-sky-400 flex items-center justify-center text-white shadow-md shadow-blue-500/20 group-hover:scale-105 transition-transform">
                        <i data-lucide="waves" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <span class="font-bold text-base tracking-tight text-slate-900 dark:text-white flex items-center gap-1.5">HWMM
                            <span class="text-[10px] uppercase font-bold tracking-widest px-1.5 py-0.5 rounded bg-blue-100 text-blue-700 dark:bg-blue-950 dark:text-blue-300">Freshers '26</span>
                        </span>
                        <span class="hidden sm:block text-[11px] text-slate-500 dark:text-slate-400 leading-none">Hostel Washing Machine Management Portal</span>
                    </div>
                </a>
            </div>

            <div class="flex items-center gap-2 sm:gap-3">
                <button class="theme-toggle-btn p-2 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition" title="Toggle Theme">
                    <i data-lucide="sun" class="theme-sun-icon w-5 h-5 hidden"></i>
                    <i data-lucide="moon" class="theme-moon-icon w-5 h-5"></i>
                </button>


                <div class="relative">
                    <button onclick="toggleUserMenu()" class="flex items-center gap-2 p-1.5 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition">
                        <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-950 text-blue-600 dark:text-blue-300 flex items-center justify-center text-xs font-bold"><?=substr($_SESSION['name'],0,1)?></div>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 hidden sm:block"></i>
                    </button>

                    <div id="user-dropdown-menu" class="hidden absolute right-0 mt-2 w-56 bg-white dark:bg-slate-900 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-800 p-2 z-50">
                        <div class="px-3 py-2 border-b border-slate-100 dark:border-slate-800 mb-1">
                            <p class="text-xs font-bold text-slate-900 dark:text-white"><?=$_SESSION['name']?></p>
                            <!-- <p class="text-[11px] text-slate-500 dark:text-slate-400">Session profile pending</p> -->
                            <div class="mt-2 flex items-center justify-between px-2 py-1 bg-blue-50 dark:bg-blue-950/50 rounded-lg text-blue-700 dark:text-blue-300 text-[11px] font-semibold">
                                <span>Wash Tokens</span>
                                <span class="px-1.5 py-0.5 bg-blue-600 text-white rounded text-[10px]"><?=$_SESSION['credits']?>/2</span>
                            </div>
                        </div>

                        <a href="profile.php" class="flex items-center gap-2.5 px-3 py-2 text-xs font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition">
                            <i data-lucide="user" class="w-4 h-4 text-slate-400"></i> My Profile
                        </a>
                        <a href="history.php" class="flex items-center gap-2.5 px-3 py-2 text-xs font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition">
                            <i data-lucide="history" class="w-4 h-4 text-slate-400"></i> Booking History
                        </a>
                        <a href="settings.php" class="flex items-center gap-2.5 px-3 py-2 text-xs font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition">
                            <i data-lucide="settings" class="w-4 h-4 text-slate-400"></i> Preferences
                        </a>
                        <a href="about.php" class="flex items-center gap-2.5 px-3 py-2 text-xs font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition">
                            <i data-lucide="help-circle" class="w-4 h-4 text-slate-400"></i> Guidelines & Rules
                        </a>

                        <div class="my-1 border-t border-slate-100 dark:border-slate-800"></div>

                        <a href="logout.php" class="flex items-center gap-2.5 px-3 py-2 text-xs font-medium text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/50 rounded-xl transition">
                            <i data-lucide="log-out" class="w-4 h-4"></i> Sign Out
                        </a>
                    </div>
                </div>
            </div>
        </header>
    </div>

    <div class="flex flex-1 min-h-0">
        <div id="app-sidebar">
            <aside id="sidebar-drawer" class="w-64 bg-slate-50/50 dark:bg-slate-900/50 border-r border-slate-200 dark:border-slate-800 flex flex-col justify-between shrink-0 fixed lg:sticky top-16 z-30 h-[calc(100vh-4rem)] transition-transform duration-300 -translate-x-full lg:translate-x-0">
                <div class="p-4 space-y-1 overflow-y-auto">
                    <div class="px-3 py-2 text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">Navigation</div>
                    <a href="dashboard.php" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all text-slate-600 dark:text-slate-400 hover:bg-slate-200/60 dark:hover:bg-slate-800/60 hover:text-slate-900 dark:hover:text-white">
                        <!-- bg-blue-600 text-white shadow-md shadow-blue-500/25 dark:shadow-blue-600/10 -->
                        <i data-lucide="layout-dashboard" class="w-4 h-4 shrink-0"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="booking.php" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all text-slate-600 dark:text-slate-400 hover:bg-slate-200/60 dark:hover:bg-slate-800/60 hover:text-slate-900 dark:hover:text-white">
                        <i data-lucide="calendar-plus" class="w-4 h-4 shrink-0"></i>
                        <span>Book Slot</span>
                    </a>
                    <a href="schedule.php" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all text-slate-600 dark:text-slate-400 hover:bg-slate-200/60 dark:hover:bg-slate-800/60 hover:text-slate-900 dark:hover:text-white">
                        <i data-lucide="calendar-days" class="w-4 h-4 shrink-0"></i>
                        <span>Weekly Schedule</span>
                    </a>
                    <a href="machines.php" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all text-slate-600 dark:text-slate-400 hover:bg-slate-200/60 dark:hover:bg-slate-800/60 hover:text-slate-900 dark:hover:text-white">
                        <i data-lucide="washing-machine" class="w-4 h-4 shrink-0"></i>
                        <span>Washing Machines</span>
                    </a>
                    <a href="history.php" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all text-slate-600 dark:text-slate-400 hover:bg-slate-200/60 dark:hover:bg-slate-800/60 hover:text-slate-900 dark:hover:text-white">
                        <i data-lucide="history" class="w-4 h-4 shrink-0"></i>
                        <span>Booking History</span>
                    </a>
                    <a href="profile.php" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all text-slate-600 dark:text-slate-400 hover:bg-slate-200/60 dark:hover:bg-slate-800/60 hover:text-slate-900 dark:hover:text-white">
                        <i data-lucide="user" class="w-4 h-4 shrink-0"></i>
                        <span>My profile</span>
                    </a>
                    <a href="settings.php" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all text-slate-600 dark:text-slate-400 hover:bg-slate-200/60 dark:hover:bg-slate-800/60 hover:text-slate-900 dark:hover:text-white">
                        <i data-lucide="sliders" class="w-4 h-4 shrink-0"></i>
                        <span>Settings</span>
                    </a>
                    <a href="about.php" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all text-slate-600 dark:text-slate-400 hover:bg-slate-200/60 dark:hover:bg-slate-800/60 hover:text-slate-900 dark:hover:text-white">
                        <i data-lucide="info" class="w-4 h-4 shrink-0"></i>
                        <span>Guidelines & About</span>
                    </a>
                </div>

                <div class="p-4 border-t border-slate-200/80 dark:border-slate-800">
                    <div class="p-3.5 rounded-2xl bg-gradient-to-br from-blue-500/10 via-indigo-500/5 to-sky-500/10 border border-blue-200/50 dark:border-blue-900/40">
                        <div class="flex items-center justify-between text-xs font-bold text-slate-900 dark:text-slate-100 mb-1">
                            <span class="flex items-center gap-1.5"><i data-lucide="zap" class="w-3.5 h-3.5 text-blue-600 dark:text-blue-400"></i> Tokens</span>
                            <span class="text-blue-600 dark:text-blue-400"><?=$_SESSION['credits']?>/2 Left</span>
                        </div>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400 leading-relaxed mb-2.5">Weekly quota resets every Monday at 00:00 AM.</p>
                        <a href="booking.php" class="w-full inline-flex items-center justify-center gap-1.5 py-2 px-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-semibold shadow-xs transition">
                        <i data-lucide="plus" class="w-3.5 h-3.5"></i> Book Machine
                        </a>
                    </div>
                </div>
            </aside>
        
        </div>

        <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto w-full space-y-6 overflow-visible">