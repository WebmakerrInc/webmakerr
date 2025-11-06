import { defineConfig } from 'vite'
import tailwindcss from '@tailwindcss/vite'

export default defineConfig(({ command }) => {
    const isBuild = command === 'build';

    return {
        base: isBuild ? '/wp-content/themes/Webmakerr/build/' : '/',
        server: {
            port: 3000,
            cors: true,
            origin: 'https://webmakerr.test',
        },
        build: {
            manifest: true,
            outDir: 'build',
            rollupOptions: {
                input: [
                    'resources/js/app.js',
                    'resources/css/app.css',
                    'resources/css/editor-style.css'
                ],
                output: {
                    entryFileNames: 'assets/[name].js',
                    chunkFileNames: 'assets/[name].js',
                    assetFileNames: 'assets/[name].[ext]',
                },
            },
        },
        plugins: [
            tailwindcss(),
        ],
    }
});
