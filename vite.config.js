import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'

export default defineConfig({
    server: {
        host: '0.0.0.0', // necesario para docker (expone el server a todos los hosts)
        port: 5173,
        strictPort: true,
        hmr: {
            host: 'localhost', // fuerza uso de IPv4 y evita [::1]
        },
        watch: {
            usePolling: true, // evita problemas de file watching en Docker
        },
    },
    plugins: [
        laravel({
            input: 'resources/js/app.ts',
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
})
