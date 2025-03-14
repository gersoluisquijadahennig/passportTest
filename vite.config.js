import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { fileURLToPath } from 'node:url'
import { quasar, transformAssetUrls } from '@quasar/vite-plugin'



export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                //'resources/js/app.js',
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
        quasar({
            sassVariables: fileURLToPath(
              new URL('./resources/sass/quasar-variables.sass', import.meta.url)
            )
          })
    ]
});
