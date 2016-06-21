var gulp = require('gulp');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var cleanCSS = require('gulp-clean-css');

/*
 * librerías javascript
 */
gulp.task('js_libs', function () {
    var jquery = 'bower_components/jquery/dist/jquery.js';
    var bootstrap = 'bower_components/bootstrap/dist/js/bootstrap.js';
    var alertify = 'bower_components/alertify.js/dist/js/alertify.js';
    var backToTop = '../public_html/js/back_to_top.js';
    gulp.src([jquery, bootstrap, alertify, backToTop])
        .pipe(concat('libs.js'))
        .pipe(uglify())
        .pipe(gulp.dest('../public_html/dist/'))
});

/*
 * librerías javascript angular
 */
gulp.task('js_nglibs', function () {
    var jquery = 'bower_components/jquery/dist/jquery.js';
    var jqueryui = 'bower_components/jqueryui/jquery-ui.js';
    var bootstrap = 'bower_components/bootstrap/dist/js/bootstrap.js';
    var angular = 'bower_components/angular/angular.js';
    var angularRoute = 'bower_components/angular-route/angular-route.js';
    var alertifyNg = 'bower_components/alertify.js/dist/js/ngAlertify.js';
    var backToTop = '../public_html/js/back_to_top.js';
    var calendar = '../public_html/js/calendar/calendar.js';
    var app = '../public_html/angular2/src/js/*.js';
    gulp.src([jquery, jqueryui, bootstrap, angular, angularRoute, alertifyNg, backToTop, calendar, app])
        .pipe(concat('nglibs.js'))
        .pipe(uglify())
        .pipe(gulp.dest('../public_html/dist/'))
});

gulp.task('default', ['js', 'html']);
