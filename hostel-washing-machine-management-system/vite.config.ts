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
          main: path.resolve(__dirname, 'index.html'),
          dashboard: path.resolve(__dirname, 'dashboard.html'),
          booking: path.resolve(__dirname, 'booking.html'),
          schedule: path.resolve(__dirname, 'schedule.html'),
          machines: path.resolve(__dirname, 'machines.html'),
          machine: path.resolve(__dirname, 'machine.html'),
          profile: path.resolve(__dirname, 'profile.html'),
          history: path.resolve(__dirname, 'history.html'),
          about: path.resolve(__dirname, 'about.html'),
          settings: path.resolve(__dirname, 'settings.html'),
          notFound: path.resolve(__dirname, '404.html'),
        },
      },
    },
    server: {
      hmr: process.env.DISABLE_HMR !== 'true',
      watch: process.env.DISABLE_HMR === 'true' ? null : {},
    },
  };
});
