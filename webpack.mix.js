const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js("resources/js/app.js", "public/js")
    .postCss("resources/css/app.css", "public/css", [
        require("tailwindcss"),
    ])
    .sass('resources/css/login.scss', "public/css")
    .sass('resources/css/navigation.scss', 'public/css')
    .sass('resources/css/room.scss', 'public/css')
    .sass('resources/css/sidebar-profile-private.scss', 'public/css')
    .js('resources/js/navigation.js', 'public/js')
    .js('resources/js/chat.js', 'public/js')
    .js('resources/js/task.js', 'public/js')


mix.browserSync('127.0.0.1:8000');
