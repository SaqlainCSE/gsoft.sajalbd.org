import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/style.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        react(),
    ],
});
