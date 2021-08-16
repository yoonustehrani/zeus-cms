const mix = require('laravel-mix');
const src = {
    res: {
        js: "resources/js/",
        sass: "resources/sass/"
    },
    pub: {
        js: "public/js/",
        css: "public/css/"
    }
}
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
let { res, pub } = src;
mix.disableNotifications()

// mix.react(res.js + 'app.js', pub.js)
// .js(res.js + 'tools.js', pub.js)
// mix.react(res.js + 'menu_builder.js', pub.js)
// .js(res.js + 'tools.js', pub.js)
// mix.sass(res.sass + 'zeus/zeus.scss', pub.css)
mix.sass(res.sass + 'zeus/files.scss', pub.css);
// .sass(res.sass + 'zeus/zeus.scss', pub.css);

mix.js(res.js + 'files.js', pub.js).react();
mix.js(res.js + 'app.js', pub.js)
    // .js(res.js + 'select2.js', pub.js)
