// webpack.config.js
let Encore = require('@symfony/webpack-encore');

Encore
    // the project directory where all compiled assets will be stored
    .setOutputPath('public/assets/')

    // the public path used by the web server to access the previous directory
    .setPublicPath('/assets')

    // will create web/scss/main.js and web/scss/main.scss
    //.addEntry('main', './assets/js/main.js')
    .addStyleEntry('css/main', ['./assets/scss/main.scss'])

    // allow sass/scss files to be processed
    .enableSassLoader()

    // allow legacy applications to use $/jQuery as a global variable
    .autoProvidejQuery()

    .enableSourceMaps(!Encore.isProduction())

    // empty the outputPath dir before each build
    .cleanupOutputBeforeBuild()

    // show OS notifications when builds finish/fail
    //.enableBuildNotifications()

// create hashed filenames (e.g. app.abc123.scss)
// .enableVersioning()
;

// export the final configuration
module.exports = Encore.getWebpackConfig();
