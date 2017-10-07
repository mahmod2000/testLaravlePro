let mix = require('laravel-mix');

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

mix.js(['resources/assets/js/app.js','node_modules/popper.js/dist/umd/popper.js'], 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css')
    .styles('node_modules/bootstrap-rtl/dist/css/bootstrap-rtl.min.css', 'public/css/rtl.css');
