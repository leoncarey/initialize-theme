// Imports
var gulp = require("gulp"),
    minifyCss = require("gulp-minify-css"),
    uglify = require('gulp-uglify'),
    sass = require("gulp-sass"),
    concat = require('gulp-concat'),
    jsmin = require('gulp-jsmin'),
    sourcemaps = require('gulp-sourcemaps'),
    stripCssComments = require('gulp-strip-css-comments'),
    strip = require('gulp-strip-comments'),
    notify = require("gulp-notify"),
    wp_dir = 'wp-content/themes/default/',
    vendor_dir = 'node_modules/';

// CSS
gulp.task('build-css', () => {
    return 
        gulp.src([
            wp_dir +'assets/scss/app.scss'
        ])
        .pipe(sass())
        .on("error", notify.onError({
            title: 'Build CSS',
            message: 'Coding error',
            sound: true
        }))
        .on('error', function(error) {
            console.error("Error: "+ error);
            this.emit('end');
        })
        .pipe(notify({
            title: 'Build CSS',
            message: 'Coding success',
            sound: true
        }))
        .pipe(sourcemaps.init())
        .pipe(stripCssComments())
        .pipe(concat('app.min.css'))
        .pipe(minifyCss())
        .pipe(sourcemaps.write('../css/'))
        .pipe(gulp.dest(wp_dir +'dist/css/'));
});

// JavaScript
gulp.task('build-bundle-js', () => {
    return
        gulp.src([
            vendor_dir +'jquery/dist/jquery.min.js'
        ])
        .on("error", notify.onError({
            title: 'Build JS',
            message: 'Coding error',
            sound: true
        }))
        .on("error", function(err) {
            console.log("Error: "+ err);
            this.emit('end');
        })
        .pipe(notify({
            title: 'Build JS',
            message: 'Coding success',
            sound: true
        }))
        .pipe(sourcemaps.write('js/'))
        .pipe(strip())
        //.pipe(stripDebug())
        .pipe(jsmin())
        .pipe(concat('app.min.js'))
        .pipe(gulp.dest(wp_dir +'dist/js/'));
});
gulp.task('build-js', () => {
    return
        gulp.src([
            wp_dir +'assets/js/*.js',
            wp_dir +'assets/js/**/*.js'
        ])
        .on("error", notify.onError({
            title: 'Build JS',
            message: 'Coding error',
            sound: true
        }))
        .on("error", function(err) {
            console.log("Error: "+ err);
            this.emit('end');
        })
        .pipe(notify({
            title: 'Build JS',
            message: 'Coding success',
            sound: true
        }))
        .pipe(sourcemaps.write('js/'))
        .pipe(strip())
        //.pipe(stripDebug())
        .pipe(jsmin())
        .pipe(concat('app.min.js'))
        .pipe(gulp.dest(wp_dir +'dist/js/'));

});

// Watcher
gulp.task('watch', () => {
    gulp.watch([
        wp_dir +"assets/scss/*.scss",
        wp_dir +"assets/scss/*/*.scss"
    ], ['build-css']);
    gulp.watch([
        wp_dir +"assets/js/*.js"
    ], ['build-js']);
});

// Build every bundle
gulp.task('build-bundle', ['build-css', 'build-js', 'build-bundle-js']);

// Tasks
gulp.task('default', ['build-bundle', 'watch']);
