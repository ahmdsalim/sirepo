import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/assets/compiled/css/app.css',
                'resources/assets/compiled/css/app-dark.css',
                'resources/js/app.js',
                'resources/js/landing.js',
                'resources/assets/compiled/css/error.css',
                'resources/assets/compiled/css/table-datatable-jquery.css', 
                'resources/assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css'
            ],
            refresh: true,
        }),
    ],
});
