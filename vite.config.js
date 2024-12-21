import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [laravel({
        input: [
            'resources/css/app.css',
            'resources/js/app.js',
            'resources/js/mentorship_calendar.js', // Assurez-vous qu'il est ici
        ],
        refresh: true,
    })],
});
