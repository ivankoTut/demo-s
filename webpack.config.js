var Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('web/build/')
    .setPublicPath('/build')
    .addEntry('scripts', './app/Resources/assets/js/app.js')
    .addStyleEntry('styles', './app/Resources/assets/sass/app.sass')
    .enableSassLoader()
    .autoProvidejQuery()
    .enableSourceMaps(!Encore.isProduction())
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableReactPreset()
;

module.exports = Encore.getWebpackConfig();