var gulp = require('gulp');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var templateCache = require('gulp-angular-templatecache');
var htmlmin = require('gulp-htmlmin');

/*
 * Minify JS
 */
gulp.task('js', function () {
    gulp.src('src/js/*.js')
        .pipe(concat('app.js'))
        .pipe(uglify())
        .pipe(gulp.dest('dist/'))
});

/*
 * Minify HTML
 */
gulp.task('html', function () {
    return gulp.src('src/templates/*.html')
        .pipe(templateCache())
        .pipe(gulp.dest('dist'));
});
gulp.task('minify', function () {
    return gulp.src('src/templates/*.html')
        .pipe(htmlmin({collapseWhitespace: true}))
        .pipe(gulp.dest('dist'))
});


gulp.task('default', ['js', 'html']);
