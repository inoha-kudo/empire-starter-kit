import { createInertiaApp } from '@inertiajs/react';
import createServer from '@inertiajs/react/server';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import ReactDOMServer from 'react-dom/server';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createServer((page) =>
    createInertiaApp({
        page,
        render: ReactDOMServer.renderToString,
        title: (title) => (title ? `${title} - ${appName}` : appName),
        resolve: (name) => {
            if (name.includes('::')) {
                const [module, page] = name.split('::');

                return resolvePageComponent(
                    `../../vendor/empire/${module}/resources/js/pages/${page}.tsx`,
                    import.meta.glob('../../vendor/empire/*/resources/js/pages/**/*.tsx'),
                );
            } else {
                return resolvePageComponent(`./pages/${name}.tsx`, import.meta.glob('./pages/**/*.tsx'));
            }
        },
        setup: ({ App, props }) => <App {...props} />,
    }),
);
