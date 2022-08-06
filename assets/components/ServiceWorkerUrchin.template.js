/* eslint-env browser */
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        const { log } = console;
        navigator.serviceWorker.register('/serviceWorker.js?v={ gitRevision }').then(
            (registration) => {
                log('ServiceWorker registration successful with scope: ', registration.scope);
            },
            (err) => {
                log('ServiceWorker registration failed: ', err);
            },
        );
    });
}
