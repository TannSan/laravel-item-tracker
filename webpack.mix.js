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

mix.js('resources/assets/js/app.js', 'public/js')
    .js('resources/assets/js/jquery-sortable.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css')
    .scripts(['resources/assets/js/pusher-handler.js', 'resources/assets/js/log.js', 'resources/assets/js/sortable-lists.js'], 'public/js/sortable-lists.js')
    .version();
