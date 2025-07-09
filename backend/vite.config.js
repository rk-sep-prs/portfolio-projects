import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'app/Presentation/Assets/css/app.css', 
                'app/Presentation/Assets/js/app.js'
            ],
            refresh: true,
        }),
    ],
});
