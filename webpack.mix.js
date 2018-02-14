const { mix } = require('laravel-mix');

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

mix.scripts([
		'node_modules/bootstrap-formhelpers/dist/js/bootstrap-formhelpers.js', 
		'node_modules/x-editable/dist/bootstrap3-editable/js/bootstrap-editable.min.js',
		'node_modules/x-editable/dist/inputs-ext/wysihtml5/bootstrap-wysihtml5-0.0.3/wysihtml5-0.3.0.min.js',
		'node_modules/x-editable/dist/inputs-ext/wysihtml5/bootstrap-wysihtml5-0.0.3/bootstrap-wysihtml5-0.0.3.min.js',
		'node_modules/x-editable/dist/inputs-ext/wysihtml5/wysihtml5-0.0.3.js'
	], 'public/js/all.js')
    .js('resources/assets/js/app.js', 'public/js')
    .extract(['jquery'])
    .sass('resources/assets/sass/app.scss', 'public/css')
    .styles([
        'node_modules/bootstrap-formhelpers/dist/css/bootstrap-formhelpers.css'
    ], 'public/css/all.css');

if (mix.config.inProduction) {
    mix.version();
}

mix.copy('resources/assets/js/pagination.js', 'public/js');