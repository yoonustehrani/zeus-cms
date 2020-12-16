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

// mix.sass(res.sass + 'zeus/zeus.scss', pub.css)
mix.react(res.js + 'tools.js', pub.js);
//     .js(res.js + "components/datepicker.js", pub.js)
//     .js(res.js + "components/date-time-picker.js", pub.js)
//     .js(res.js + "components/timepicker.js", pub.js)
//     .react(res.js + "richText.js", pub.js)
// mix.js(res.js + "tools.js", pub.js)
// react('resources/js/app.js', 'public/js')
//     .sass('resources/sass/app.scss', 'public/css');
