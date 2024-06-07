import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import Icons from 'unplugin-icons/vite'
import IconsResolver from "unplugin-icons/resolver"
import Components from 'unplugin-vue-components/vite'
import federation from "@originjs/vite-plugin-federation";

export default defineConfig({
    plugins: [
        federation({
            name: 'module-plan',
            filename: "modulePlan.js",
            exposes: {
                "./PlanButton", "./Resources/js/Components/Button.vue"
            }
            shared: ['vue']
        })
    ],
});
