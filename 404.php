<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Page Not Found (404) | AuraWash Laundry OS</title>
  <!-- Google Font Inter -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <!-- Tailwind CSS & Custom Styles -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      darkMode: 'class'
    }
  </script>
  <link rel="stylesheet" href="./assets/css/style.css" />
  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="h-full bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 font-sans antialiased flex flex-col justify-between selection:bg-blue-500 selection:text-white relative overflow-x-hidden">

  <!-- Shared Header Container -->
  <div id="app-header"></div>

  <!-- Main Error Content -->
  <main class="flex-1 flex items-center justify-center p-6 z-10 relative">
    <div class="w-full max-w-md text-center space-y-6">
      
      <div class="relative w-32 h-32 mx-auto flex items-center justify-center bg-blue-100 dark:bg-blue-950 rounded-full border-4 border-blue-500 shadow-2xl">
        <i data-lucide="disc-3" class="w-20 h-20 text-blue-600 dark:text-blue-400 animate-spin"></i>
        <span class="absolute font-mono font-black text-xl text-slate-900 dark:text-white bg-white/90 dark:bg-slate-900/90 px-2 py-0.5 rounded-lg border">404</span>
      </div>

      <div class="space-y-2">
        <h2 class="text-3xl font-black text-slate-900 dark:text-white">Lost in the Wash Cycle?</h2>
        <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 leading-relaxed max-w-sm mx-auto">
          The page you requested has been washed away or doesn't exist.
        </p>
      </div>

      <div class="flex flex-col sm:flex-row items-center justify-center gap-3 pt-2">
        <a href="dashboard.php" class="w-full sm:w-auto px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl text-xs font-bold shadow-lg shadow-blue-500/25 transition">
          Return to Dashboard
        </a>
        <a href="booking.php" class="w-full sm:w-auto px-6 py-3 bg-slate-200 dark:bg-slate-800 hover:bg-slate-300 text-slate-800 dark:text-slate-200 rounded-2xl text-xs font-bold transition">
          Book Machine
        </a>
      </div>

    </div>
  </main>

  <!-- Shared Footer Container -->
  <div id="app-footer"></div>

  <!-- Scripts -->
  <script src="./assets/js/theme.js"></script>
  <script src="./assets/js/main.js"></script>
</body>
</html>
