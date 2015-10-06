
// Gulp Modules
var gulp = require('gulp'),
    uglify = require('gulp-uglify'),
    concat = require('gulp-concat'),
    path = require('path'),
    watch = require('gulp-watch'),
    plumber = require('gulp-plumber'),
    rename = require('gulp-rename'),
    sass = require('gulp-sass');

var defaultTasks = [
    'styles',
    'scripts',
    'watch'
];

var jsFilesApp = [
    'Resources/Private/Src/Js/*.js'
];

gulp.task('styles', stylesTask);

gulp.task('scripts', scriptsTask);

gulp.task('watch', watchTask);

gulp.task('default', defaultTasks);

function watchTask() {
    gulp.watch('Resources/Private/Src/Scss/**/*.scss', ['styles']);
    gulp.watch(jsFilesApp, ['scripts']);
}

function stylesTask() {
    var compileStyles = function (_baseName) {
        gulp.src(['Resources/Private/Src/Scss/' + _baseName + '.scss'])
            .pipe(plumber())
            .pipe(sass({outputStyle: 'expanded'}))
            .pipe(gulp.dest('Resources/Public/Css'))
            .pipe(rename({suffix: '.min'}))
            .pipe(sass({outputStyle: 'compressed'}))
            .pipe(gulp.dest('Resources/Public/Css'));
    };

    compileStyles('main');
}

function scriptsTask() {
    var compileScripts = function (files, targetFile) {
        gulp.src(files)
            .pipe(plumber())
            .pipe(concat(targetFile + '.js'))
            .pipe(gulp.dest('Resources/Public/Js'))
            .pipe(uglify())
            .pipe(rename({suffix: '.min'}))
            .pipe(gulp.dest('Resources/Public/Js'));
    };

    compileScripts(jsFilesApp, 'main');
}

