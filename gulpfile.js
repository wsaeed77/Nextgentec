var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass('app.scss')
    .sass('app_inner.scss')
     //.sass('app_inner.scss')
    .scripts([
    	'resources/assets/js/jquery.js',
    	'resources/assets/js/bootstrap.min.js'
    ],'public/js/app.js')
	.scripts([
    	'resources/assets/js/plugins/morris/raphael.min.js',
        'resources/assets/js/plugins/morris/morris.min.js',
	    'resources/assets/js/plugins/morris/morris-data.js'
    ],'public/js/app_inner.js')
    .scripts([
        'resources/assets/js/bootstrap-multiselect.js',
        'resources/assets/js/bootstrap-datepicker.js'
    ],'public/js/form_elements.js')
    .scripts([
        'resources/assets/js/moment.min.js',
        'resources/assets/js/fullcalendar.min.js'
    ],'public/js/calendar.js');
});
