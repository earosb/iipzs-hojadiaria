var gulp = require('gulp');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var cleanCSS = require('gulp-clean-css');

/**
 * librerías javascript landing
 */
gulp.task('js_libs', function () {
    console.log('task js_libs');
    var jquery = 'bower_components/jquery/dist/jquery.js';
    var bootstrap = 'bower_components/bootstrap/dist/js/bootstrap.js';
    var alertify = 'bower_components/alertify.js/dist/js/alertify.js';
    var backToTop = 'resources/js/back_to_top.js';
    gulp.src([jquery, bootstrap, alertify, backToTop])
        .pipe(concat('libs.js'))
        .pipe(uglify())
        .pipe(gulp.dest('../public_html/dist/js'));
    console.log('copy [jquery, bootstrap, alertify, backToTop] to dist/js/libs.js');
});

/**
 * librerias css landing
 */
gulp.task('css_libs', function(){
    console.log('task css_libs');
    var bootswatch = 'bower_components/bootswatch/yeti/bootstrap.css';
    var alertify = 'bower_components/alertify.js/dist/css/alertify.css';
    var landing = 'resources/css/landing.css';
    gulp.src([bootswatch, alertify, landing])
        .pipe(concat('styles.css'))
        .pipe(cleanCSS())
        .pipe(gulp.dest('../public_html/dist/css/'));
    console.log('copy [bootswatch, alertify, landing] to dist/css/styles.css');

    // copia glyphicons de bootstrap
    gulp.src(['bower_components/bootstrap/dist/fonts/*'])
        .pipe(gulp.dest('../public_html/dist/fonts/'));
    console.log('copy bootstrap glyphicons dist/fonts/*');
});

/**
 * librerias css angular para /programar
 */
gulp.task('css_nglibs', function(){
    console.log('task css_nglibs');
    var bootswatch = 'bower_components/bootswatch/yeti/bootstrap.css';
    var jqueryui = 'bower_components/jqueryui/themes/smoothness/jquery-ui.css';
    var checkbox = 'bower_components/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css';
    var alertify = 'bower_components/alertify.js/dist/css/alertify.css';
    var landing = 'resources/css/landing.css';
    gulp.src([bootswatch, jqueryui, checkbox, alertify, landing])
        .pipe(concat('ngstyles.css'))
        .pipe(cleanCSS())
        .pipe(gulp.dest('../public_html/dist/css/'));
    console.log('copy [bootswatch, jqueryui, checkbox, alertify, landing] to dist/css/ngstyles.css');

    // copia glyphicons de bootstrap
    gulp.src(['bower_components/jqueryui/themes/smoothness/images/*'])
        .pipe(gulp.dest('../public_html/dist/css/images/'));
    console.log('copy jqueryui images to dist/images/*');
});

/**
 * librerías javascript y angular para /programar
 */
gulp.task('js_nglibs', function () {
    console.log('task js_nglibs');
    var jquery = 'bower_components/jquery/dist/jquery.js';
    var jqueryui = 'bower_components/jqueryui/jquery-ui.js';
    var bootstrap = 'bower_components/bootstrap/dist/js/bootstrap.js';
    var angular = 'bower_components/angular/angular.js';
    var angularRoute = 'bower_components/angular-route/angular-route.js';
    var alertifyNg = 'bower_components/alertify.js/dist/js/ngAlertify.js';
    var backToTop = 'resources/js/back_to_top.js';
    var calendar = 'resources/js/calendar.js';
    var app = 'resources/programar/src/js/*.js';
    gulp.src([jquery, jqueryui, bootstrap, angular, angularRoute, alertifyNg, backToTop, calendar, app])
        .pipe(concat('nglibs.js'))
        .pipe(uglify())
        .pipe(gulp.dest('../public_html/dist/js'));
    console.log('copy [jquery, jqueryui, bootstrap, angular, angularRoute, alertifyNg, backToTop, calendar, app] to dist/js/nglibs.js');
});

/**
 * librerías javascript hoja diaria /hd/*
 */
gulp.task('assets_hoja-diaria', function () {
    console.log('task assets_hoja-diaria');
    var jqueryui = 'bower_components/jqueryui/jquery-ui.js';
    var calendar = 'resources/js/calendar.js';
    var table = 'resources/js/hoja_diaria/table.js';
    var create = 'resources/js/hoja_diaria/create.js';
    var ajaxBlocks = 'resources/js/ajaxBlocks.js';
    gulp.src([jqueryui, calendar, table, create, ajaxBlocks])
        .pipe(concat('hoja-diaria.js'))
        .pipe(uglify())
        .pipe(gulp.dest('../public_html/dist/js/'));
    console.log('copy [jqueryui, calendar, table, create, ajaxBlocks] to dist/js/hoja-diaria.js');
    
    var cssJqueryui = 'bower_components/jqueryui/themes/smoothness/jquery-ui.css';
    var cssHojaDiaria = 'resources/css/hoja-diaria_create.css';
    gulp.src([cssJqueryui, cssHojaDiaria])
        .pipe(concat('hoja-diaria.css'))
        .pipe(cleanCSS())
        .pipe(gulp.dest('../public_html/dist/css/'));
    console.log('copy [cssJqueryui, cssHojaDiaria] to dist/css/hoja-diaria.css');

    gulp.src('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')
        .pipe(gulp.dest('../public_html/dist/css/'));
    console.log('copy [dataTables.bootstrap] to dist/css/dataTables.bootstrap.min.css');

    gulp.src('resources/js/hoja_diaria/index.js')
        .pipe(concat('index_hoja-diaria.js'))
        .pipe(gulp.dest('../public_html/dist/js/'));
    console.log('copy [hoja_diaria/index] to dist/js/index_hoja-diaria.js');
});

/**
 * librerias para /reportes
 */
gulp.task('assets_reportes', function(){
    console.log('task assets_reportes');
    var cssDatatables = 'bower_components/datatables.net-bs/css/dataTables.bootstrap.css';
    var cssReporte = 'resources/css/reporte.css';
    gulp.src([cssDatatables, cssReporte])
        .pipe(concat('reporte.css'))
        .pipe(cleanCSS())
        .pipe(gulp.dest('../public_html/dist/css/'));
    console.log('copy [cssDatatables, cssReporte] to dist/css/reporte.css');

    var jsDatatables = 'bower_components/datatables.net/js/jquery.dataTables.js';
    var jsDatatablesbs = 'bower_components/datatables.net-bs/js/dataTables.bootstrap.js';
    gulp.src([jsDatatables, jsDatatablesbs])
        .pipe(concat('reportes.js'))
        .pipe(uglify())
        .pipe(gulp.dest('../public_html/dist/js/'));
    console.log('copy [jsDatatables, jsDatatablesbs] to dist/js/reportes.js');

    gulp.src('resources/json/Spanish.json')
        .pipe(concat('Spanish.json'))
        .pipe(gulp.dest('../public_html/dist/json/'));
    console.log('copy dataTables spanish to dist/json/Spanish.json');

    var jsJqueryui = 'bower_components/jqueryui/jquery-ui.min.js';
    var datepickerES = 'bower_components/jqueryui/ui/i18n/datepicker-es.js';
    var param = 'resources/js/r.param.js';
    gulp.src([jsJqueryui, datepickerES, param])
        .pipe(concat('reporteparam.js'))
        .pipe(uglify())
        .pipe(gulp.dest('../public_html/dist/js/'));
    console.log('copy [jsJqueryui, datepickerES, param] to dist/js/reporteparam.js');
    
    var deposito = 'resources/js/r.deposito.js';
    gulp.src([jsJqueryui, datepickerES, deposito])
        .pipe(concat('reportedeposito.js'))
        .pipe(uglify())
        .pipe(gulp.dest('../public_html/dist/js/'));
    console.log('copy [jsJqueryui, datepickerES, deposito] to dist/js/reportedeposito.js');

});
/**
 * css
 */
gulp.task('css_pages', function(){
    console.log('task css_pages');
    var abc = 'bower_components/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css';
    gulp.src([abc])
        .pipe(concat('awesome-bootstrap-checkbox.css'))
        .pipe(cleanCSS())
        .pipe(gulp.dest('../public_html/dist/css/'));
    console.log('copy [awesome-bootstrap-checkbox] to dist/css/awesome-bootstrap-checkbox.css');

    gulp.src('bower_components/jqueryui/themes/smoothness/jquery-ui.min.css')
        .pipe(gulp.dest('../public_html/dist/css/'));
    console.log('copy [jqueryui/themes/smoothness] to dist/css/jquery-ui.min.css');

});

/**
 * funciones javascript
 */
gulp.task('js_pages', function () {
    console.log('task js_pages');
    gulp.src('resources/js/ajaxBlocks.js')
        .pipe(concat('ajaxblocks.js'))
        .pipe(uglify())
        .pipe(gulp.dest('../public_html/dist/js/'));
    console.log('copy [resources/js/ajaxBlocks.js] to dist/js/ajaxblocks.js');
    
    gulp.src('resources/js/hoja_diaria/modal/formDesvio.js')
        .pipe(concat('formdesvio.js'))
        .pipe(uglify())
        .pipe(gulp.dest('../public_html/dist/js/'));
    console.log('copy [resources/js/hoja_diaria/modal/formDesvio.js] to dist/js/formdesvio.js');
    
    gulp.src('resources/js/hoja_diaria/modal/formDesviador.js')
        .pipe(concat('formdesviador.js'))
        .pipe(uglify())
        .pipe(gulp.dest('../public_html/dist/js/'));
    console.log('copy [resources/js/hoja_diaria/modal/formDesviador.js] to dist/js/formdesviador.js');
    
    gulp.src('resources/js/hoja_diaria/modal/formMaterialCol.js')
        .pipe(concat('formmaterialcol.js'))
        .pipe(uglify())
        .pipe(gulp.dest('../public_html/dist/js/'));
    console.log('copy [resources/js/hoja_diaria/modal/formMaterialCol.js] to dist/js/formmaterialcol.js');
    
    gulp.src('resources/js/hoja_diaria/modal/formMaterialRet.js')
        .pipe(concat('formmaterialret.js'))
        .pipe(uglify())
        .pipe(gulp.dest('../public_html/dist/js/'));
    console.log('copy [resources/js/hoja_diaria/modal/formMaterialRet.js] to dist/js/formmaterialret.js');

    gulp.src('resources/js/hoja_diaria/modal/formTrabajo.js')
        .pipe(concat('formTrabajo.js'))
        .pipe(uglify())
        .pipe(gulp.dest('../public_html/dist/js/'));
    console.log('copy [resources/js/hoja_diaria/modal/formTrabajo.js] to dist/js/formTrabajo.js');

});

/**
 * html programar
 */
gulp.task('html', function () {
    console.log('task html');
    gulp.src('resources/programar/src/templates/*')
        .pipe(gulp.dest('../public_html/dist/html/'));
    console.log('copy [resources/programar/src/templates/*] to dist/html/*');
});

/**
 * Ejecutar todas las tareas anteriores
 */
gulp.task('default', ['js_libs', 'css_libs', 'css_nglibs', 'js_nglibs', 'assets_hoja-diaria', 'assets_reportes', 'css_pages', 'js_pages', 'html']);
