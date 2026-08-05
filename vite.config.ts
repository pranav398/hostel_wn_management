import tailwindcss from '@tailwindcss/vite';
import path from 'path';
import {defineConfig} from 'vite';

export default defineConfig(() => {
  return {
    base: './',
    plugins: [tailwindcss()],
    resolve: {
      alias: {
        '@': path.resolve(__dirname, '.'),
      },
    },
    build: {
      rollupOptions: {
        input: {
          main: path.resolve(__dirname, 'index.php'),
          dashboard: path.resolve(__dirname, 'dashboard.php'),
          booking: path.resolve(__dirname, 'booking.php'),
          schedule: path.resolve(__dirname, 'schedule.php'),
          machines: path.resolve(__dirname, 'machines.php'),
          machine: path.resolve(__dirname, 'machine.php'),
          profile: path.resolve(__dirname, 'profile.php'),
          history: path.resolve(__dirname, 'history.php'),
          about: path.resolve(__dirname, 'about.php'),
          settings: path.resolve(__dirname, 'settings.php'),
          notFound: path.resolve(__dirname, '404.php'),
        },
      },
    },
    server: {
      hmr: process.env.DISABLE_HMR !== 'true',
      watch: process.env.DISABLE_HMR === 'true' ? null : {},
    },
  };
});
