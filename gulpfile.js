//
// Gulp Configuration
//------------------------------------------------------------------------

var onError = function (event) {
    return gulp.src(event.path)
        .pipe(refresh(lrserver));
};

var defaultTasks = [
    'styles',
    'scripts',
    'watch'
];

//
// Include necessary gulp files
// ------------------------------------------------------------------------

var gulp = require('gulp'),
    uglify = require('gulp-uglify'),
    concat = require('gulp-concat'),
    less = require('gulp-less'),
    minifyCSS = require('gulp-minify-css'),
    path = require('path'),
    watch = require('gulp-watch'),
    plumber = require('gulp-plumber'),
    rename = require("gulp-rename");


//
// Compile Less files
//------------------------------------------------------------------------

gulp.task('styles', function () {
    gulp.src('Resources/Public/Src/Less/main.less')
        .pipe(plumber())
        .pipe(less())
        .pipe(minifyCSS())
        .pipe(gulp.dest('Resources/Public/Css/'));
});

//
// Concatenate & Minify Main-JS
// ------------------------------------------------------------------------

gulp.task('scripts', function() {

    gulp.src('Resources/Public/Src/Js/main.js')
        .pipe(plumber())
        .pipe(concat('main.min.js'))
        .pipe(uglify('compress'))
        .pipe(gulp.dest('Resources/Public/Js/'))
});



//
// Watch files for changes
// ------------------------------------------------------------------------

gulp.task('watch', function () {
    gulp.watch('Resources/Public/Src/Less/**/*.less', ['styles'], onError);
    gulp.watch('Resources/Public/Src/Js/*.js', ['scripts']);
});


//
// Run Tasks
//------------------------------------------------------------------------

gulp.task('default', defaultTasks);