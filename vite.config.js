import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path'; // 🔧 Required to resolve paths

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    css: {
        preprocessorOptions: {
            scss: {
                // Add paths for SCSS to resolve Bootstrap imports
                includePaths: [
                    path.resolve(__dirname, 'node_modules'),
                ],
            },
        },
    },
});
