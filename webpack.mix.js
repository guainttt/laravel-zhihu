const mix = require('laravel-mix');
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
mix.js('resources/js/app.js', 'public/js')
//1. 打包在 .resources/js/app.js 的所有js(包括任何依赖)到 public/js。
   .sass('resources/sass/app.scss', 'public/css')
//2. 编译sass文件, resources/sass/app.scss 到 public/css
   .styles([
        //'resources/css/select2.min.css',
       'resources/css/select2.css',
        'resources/css/style.css'], 'public/css/all.css')
//3. 合并原生css文件
   .extract(['jquery','vue','bootstrap','axios']).version();
//extract 把不经常修改的包隔离





