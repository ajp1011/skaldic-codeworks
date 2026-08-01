import fs from 'fs';
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import tailwindcss from '@tailwindcss/vite';

const keyPath = '/certs/local-key.pem';
const certPath = '/certs/local.pem';
const https =
    fs.existsSync(keyPath) && fs.existsSync(certPath)
        ? { key: fs.readFileSync(keyPath), cert: fs.readFileSync(certPath) }
        : undefined;

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/themes/nordic-minimalism.css',
                'resources/css/themes/forgecraft.css',
                'resources/js/app.ts'
            ],
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
        tailwindcss(),
    ],
    server: {
        host: '0.0.0.0',
        port: 5173,
        https,
        hmr: {
            host: 'localhost',
            protocol: https ? 'wss' : 'ws',
            clientPort: 5173,
        },
    },
});
