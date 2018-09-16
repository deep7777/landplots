var gulp = require('gulp'),
		php = require('gulp-connect-php'),
		concat = require('gulp-concat'),
		order = require('gulp-order'),
    uglify = require('gulp-uglify'),
    rename = require('gulp-rename'),
    sass = require('gulp-ruby-sass'),
    autoprefixer = require('gulp-autoprefixer'),
    browserSync = require('browser-sync').create();
var appPaths = require('./app-paths');
var DEST = 'public/build/';
var path = require('path');


gulp.task('scripts', function() {
	console.log("starting scripts .......");
	return gulp.src('public/js/login/*.js')
		.pipe(concat('login_page.js'))
		.pipe(rename({suffix: '.min'}))
		.pipe(uglify())
		.pipe(gulp.dest(DEST+'/js'));
});

gulp.task('adminScripts', function() {
	console.log("admin scripts .......");
	return gulp.src('public/js/admin/*.js')
		.pipe(concat('admin_scripts.js'))
		.pipe(rename({suffix: '.min'}))
		.pipe(uglify())
		.pipe(gulp.dest(DEST+'/js'));
});

gulp.task('moduleScripts', function() {
	console.log("module scripts .......");
	return gulp.src('public/js/modules/*.js')
		.pipe(concat('modules.js'))
		.pipe(rename({suffix: '.min'}))
		.pipe(uglify())
		.pipe(gulp.dest(DEST+'/js'));
});

gulp.task('plugins', function() {
	console.log("plugins .......");
	return gulp.src('public/js/plugins/*.js')
		.pipe(concat('plugins.js'))
		.pipe(gulp.dest(DEST+'/js'))
		.pipe(gulp.dest(DEST+'/js'))
});

gulp.task('watch', function() {
  gulp.watch('public/js/**/*.js', ['scripts']);
	gulp.watch('public/js/admin/*.js', ['adminScripts']);
	gulp.watch('public/js/modules/*.js', ['moduleScripts']);
});




gulp.task('cssPlugins', function () {
	var cssPlugins = appPaths.cssPlugins;
	console.log(cssPlugins);
	gulp.src(cssPlugins)
		.pipe(concat('css_plugins.css'))
		.pipe(rename({suffix: '.min'}))
		.pipe(gulp.dest(DEST+'/css'));
});

/*
// create a task to serve the app
gulp.task('serve', function() {
    // start the php server
    // make sure we use the public directory since this is Laravel
    php.server({
        base: './public'
    });
});*/

// Default Task
gulp.task('default', ['scripts','plugins','cssPlugins','adminScripts','moduleScripts', 'watch']);
