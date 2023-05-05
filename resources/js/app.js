import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import moment from 'moment/moment';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy);

        app.config.globalProperties.$filters = {
            truncate(value, stop, clamp) {
                return value.slice(0, stop) + (stop < value.length ? clamp || '...' : '')
            },
            localtime(value, format) {
                return moment(value).format(format)
            }
        }

        app.mount(el)
        
        return app
    },
    progress: {
        color: '#4B5563',
    },
});
