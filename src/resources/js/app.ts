import { configureEcho } from '@laravel/echo-vue';
import '../css/app.css';
import './bootstrap';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

// @ts-ignore
const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

configureEcho({
    broadcaster: 'reverb',
    wsHost: window.location.hostname,
    wsPort: 8080,
    forceTLS: false,
    disableStats: true,
    enabledTransports: ['ws'],
});


createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        // @ts-ignore
        resolvePageComponent(
            `./Pages/${name}.vue`,
            // @ts-ignore
            import.meta.glob('./Pages/**/*.vue'),
        ),
    // @ts-ignore
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
