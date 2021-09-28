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

// mix.js("resources/js/app.js", "public/js")
//     .postCss("resources/css/app.css", "public/css", [
//         require("tailwindcss"),
//     ]);

mix.js([
    'resources/js/adminController.js',
    'resources/js/main.js',
    'resources/js/mealsController.js',
    'resources/js/userController.js',
], 'public/js/app.js');
mix.styles([
    'resources/css/admin.css',
    'resources/css/home.css',
    'resources/css/navbar.css',
    'resources/css/style.css',
    'resources/css/login.css',
    'resources/css/register.css',
    'resources/css/tailwind.css',
    'resources/css/userEdit.css',
    'resources/css/welcome.css',
], 'public/css/app.css');
