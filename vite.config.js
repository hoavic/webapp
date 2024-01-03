import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
/*             input: 'resources/js/app.js', */
            input: [
                'resources/js/app.js',
                'resources/js/guest.js',
                'resources/js/blog.js',
                'resources/css/app.css',
                'resources/css/blog.css',
            ],
/*             ssr: 'resources/js/ssr.js', */
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
});
