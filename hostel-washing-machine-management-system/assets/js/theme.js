/**
 * Theme Manager for Hostel Washing Machine Management System
 * Handles light/dark theme persistence via localStorage and seamless toggling.
 */
(function () {
  'use strict';

  // Apply saved theme immediately before DOM paint to prevent flash
  const savedTheme = localStorage.getItem('aurawash_theme');
  const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

  if (savedTheme === 'dark' || (!savedTheme && systemPrefersDark)) {
    document.documentElement.classList.add('dark');
  } else {
    document.documentElement.classList.remove('dark');
  }

  // Bind toggle listener once DOM is ready
  document.addEventListener('DOMContentLoaded', () => {
    const themeButtons = document.querySelectorAll('.theme-toggle-btn');

    function updateIcons() {
      const isDark = document.documentElement.classList.contains('dark');
      themeButtons.forEach((btn) => {
        const sunIcon = btn.querySelector('.theme-sun-icon');
        const moonIcon = btn.querySelector('.theme-moon-icon');
        if (sunIcon && moonIcon) {
          if (isDark) {
            sunIcon.classList.remove('hidden');
            moonIcon.classList.add('hidden');
          } else {
            sunIcon.classList.add('hidden');
            moonIcon.classList.remove('hidden');
          }
        }
      });
    }

    updateIcons();

    window.toggleTheme = function () {
      const isDarkNow = document.documentElement.classList.contains('dark');
      if (isDarkNow) {
        document.documentElement.classList.remove('dark');
        localStorage.setItem('aurawash_theme', 'light');
      } else {
        document.documentElement.classList.add('dark');
        localStorage.setItem('aurawash_theme', 'dark');
      }
      updateIcons();
      if (window.showToast) {
        window.showToast(`Switched to ${!isDarkNow ? 'Dark' : 'Light'} Mode`, 'info');
      }
    };

    themeButtons.forEach((btn) => {
      btn.addEventListener('click', window.toggleTheme);
    });
  });
})();
