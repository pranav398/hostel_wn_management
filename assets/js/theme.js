/**
 * Theme Manager for Hostel Washing Machine Management System
 * Handles light/dark theme persistence via localStorage and seamless toggling.
 */
(function () {
  'use strict';

  function determineSystemTheme() {
    return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
  }

  function getSavedTheme() {
    return localStorage.getItem('aurawash_theme') || 'system';
  }

  function applyTheme(theme, save = true) {
    const isDarkTheme = theme === 'dark' || (theme === 'system' && determineSystemTheme() === 'dark');

    if (isDarkTheme) {
      document.documentElement.classList.add('dark');
    } else {
      document.documentElement.classList.remove('dark');
    }

    if (save) {
      if (theme === 'system') {
        localStorage.removeItem('aurawash_theme');
      } else {
        localStorage.setItem('aurawash_theme', theme);
      }
    }

    updateIcons();
    updateThemeRadios();
  }

  function applySavedTheme() {
    const savedTheme = getSavedTheme();
    applyTheme(savedTheme, false);
  }

  function updateThemeRadios() {
    const themeInputs = document.querySelectorAll('input[name="theme"]');
    const savedTheme = getSavedTheme();

    themeInputs.forEach((input) => {
      input.checked = input.value === savedTheme;
    });
  }


  function updateIcons() {
    const themeButtons = document.querySelectorAll('.theme-toggle-btn');
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

  function toggleTheme() {
    const isDarkNow = document.documentElement.classList.contains('dark');
    applyTheme(isDarkNow ? 'light' : 'dark');

    if (window.showToast) {
      window.showToast(`Switched to ${isDarkNow ? 'Light' : 'Dark'} Mode`, 'info');
    }
  }

  function clearLocalPreferences() {
    localStorage.removeItem('aurawash_theme');
    applyTheme('system', false);

    if (window.showToast) {
      window.showToast('Local preferences cleared. System theme is now active.', 'error');
    }
  }

  function initThemeControls() {
    updateIcons();
    updateThemeRadios();

    const themeInputs = document.querySelectorAll('input[name="theme"]');
    themeInputs.forEach((input) => {
      input.addEventListener('change', () => {
        if (!input.checked) return;
        applyTheme(input.value);

        const label = input.value === 'system' ? 'System Default' : `${input.value[0].toUpperCase()}${input.value.slice(1)}`;
        if (window.showToast) {
          window.showToast(`${label} theme selected.`, 'success');
        }
      });
    });

    const colorSchemeQuery = window.matchMedia('(prefers-color-scheme: dark)');
    if (colorSchemeQuery.addEventListener) {
      colorSchemeQuery.addEventListener('change', () => {
        if (getSavedTheme() === 'system') {
          applyTheme('system', false);
          if (window.showToast) {
            window.showToast('System theme updated to match your OS preference.', 'info');
          }
        }
      });
    } else if (colorSchemeQuery.addListener) {
      colorSchemeQuery.addListener(() => {
        if (getSavedTheme() === 'system') {
          applyTheme('system', false);
          if (window.showToast) {
            window.showToast('System theme updated to match your OS preference.', 'info');
          }
        }
      });
    }

    const themeButton = document.querySelector('.theme-toggle-btn');
    if (themeButton) {
      themeButton.addEventListener('click', (event) => {
        event.preventDefault();
        toggleTheme();
      });
    }

    const clearButton = document.getElementById('clear-preferences-btn');
    if (clearButton) {
      clearButton.addEventListener('click', (event) => {
        event.preventDefault();
        clearLocalPreferences();
      });
    }
  }

  applySavedTheme();
  window.toggleTheme = toggleTheme;

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initThemeControls, { once: true });
  } else {
    initThemeControls();
  }
})();
