// Settings
var gulp = require("gulp"),
    minifyCss = require("gulp-minify-css"),
    uglify = require('gulp-uglify'),
    sass = require("gulp-sass"),
    concat = require('gulp-concat'),
    jsmin = require('gulp-jsmin'),
    sourcemaps = require('gulp-sourcemaps'),
    stripCssComments = require('gulp-strip-css-comments'),
    merge2 = require('merge2'),
    strip = require('gulp-strip-comments'),
    notify = require("gulp-notify"),
    wp_dir = 'wp-content/themes/default/',
    bower_dir = 'wp-content/themes/default/assets/bower_components/';


// CSS
gulp.task('build-css', function() {
    return merge2(
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
    )
        .pipe(sourcemaps.init())
        .pipe(stripCssComments())
        .pipe(concat('app.min.css'))
        .pipe(minifyCss())
        .pipe(sourcemaps.write('../css/'))
        .pipe(gulp.dest(wp_dir +'dist/css/'));
});

// JavaScript
gulp.task('build-js', function() {
    return merge2(
        // Libs
        gulp.src([
            wp_dir +'assets/js/*.js',
            wp_dir +'assets/js/**/*.js',
            bower_dir +'jquery/dist/jquery.min'
        ]),
        // App file
        gulp.src([
            wp_dir +'assets/js/*.js'

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
    )
        .pipe(sourcemaps.write('js/'))
        .pipe(strip())
        //.pipe(stripDebug())
        .pipe(jsmin())
        .pipe(concat('app.min.js'))
        .pipe(gulp.dest(wp_dir +'dist/js/'));
});

// Watcher
gulp.task('watch', function() {
    gulp.watch([
        wp_dir +"assets/scss/*.scss",
        wp_dir +"assets/scss/*/*.scss"
    ], ['build-css']);
    gulp.watch([
        wp_dir +"assets/js/*.js"
    ], ['build-js']);
});

// Tasks
gulp.task('default', ['build-css', 'build-js', 'watch']);
