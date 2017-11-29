// webpack.config.js
var Encore = require('@symfony/webpack-encore');

Encore

// directory where all compiled assets will be stored
    .setOutputPath('web/build/')

    // what's the public path to this directory (relative to your project's document root dir)
    .setPublicPath('/build')

    .autoProvidejQuery()

    // empty the outputPath dir before each build
    .cleanupOutputBeforeBuild()

    .enableSourceMaps(!Encore.isProduction())

    // create hashed filenames (e.g. app.abc123.css)
    .enableVersioning()

    // allow less files to be processed
    .enableLessLoader(function (loaderOptions) {
        loaderOptions.strictMath = true;
        loaderOptions.relativeUrls = false;
    })

    .createSharedEntry('vendor', [
        'jquery',
        'bootstrap',
    ])

    .addStyleEntry('css/app', './assets/css/app.less')

    .addEntry('js/edit', './assets/js/edit.js')
    .addEntry('js/main', './assets/js/main.js')
;

// export the final configuration
var config = Encore.getWebpackConfig();

module.exports = config;
