const mix = require('laravel-mix');

mix.js([
    'resources/js/adminController.js',
    'resources/js/main.js',
    'resources/js/mealsController.js',
    'resources/js/userController.js',
    'resources/js/chart.js',
], 'public/js/app.js');
mix.styles([
    'resources/css/admin.css',
    'resources/css/home.css',
    'resources/css/tableHome.css',
    'resources/css/navbar.css',
    'resources/css/style.css',
    'resources/css/chart.css',
    'resources/css/login.css',
    'resources/css/register.css',
    'resources/css/tailwind.css',
    'resources/css/userEdit.css',
    'resources/css/welcome.css',
], 'public/css/app.css');
