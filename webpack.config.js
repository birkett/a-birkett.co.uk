let Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('public/assets/')
    .setPublicPath('/assets')

    .enableSassLoader()
    .autoProvidejQuery()
    .enableSourceMaps(!Encore.isProduction())
    .cleanupOutputBeforeBuild()
    .enableVersioning()

    //.addEntry('main', './assets/js/main.js')
    .addStyleEntry('css/main', ['./assets/scss/main.scss'])
;

module.exports = Encore.getWebpackConfig();
