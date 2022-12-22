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

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/default.js', 'public/js/default.js')
    .postCss('resources/css/app.css', 'public/css/app.css')
    .postCss('resources/css/default.css', 'public/css/default.css', [
        require('postcss-import'),
        require('tailwindcss'),
        require('autoprefixer'),
    ])
    .js('resources/js/admins.js', 'public/js/admins.js')
    .js('resources/js/front/contactPage.js', 'public/js/front/contactPage.js')
    .js('resources/js/notifications.js', 'public/js/notifications.js')
    .js('resources/js/roles.js', 'public/js/roles.js')
    .js('resources/js/contacts.js', 'public/js/contacts.js')
    .js('resources/js/users.js', 'public/js/users.js')
    .js('resources/js/dashboard.js', 'public/js/dashboard.js')
