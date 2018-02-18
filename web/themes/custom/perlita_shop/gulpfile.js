'use strict';
var gulp = require('gulp');
var sass = require('gulp-sass');
var sourcemaps = require('gulp-sourcemaps');
var autoprefixer = require('gulp-autoprefixer');
var importer = require('node-sass-globbing');
var plumber = require('gulp-plumber');
var cssmin = require('gulp-cssmin');
var stripCssComments = require('gulp-strip-css-comments');
var cssnano = require('gulp-cssnano');
var uglify = require('gulp-uglify');
var livereload = require('gulp-livereload');
var concat = require('gulp-concat');
var sass_config = {
  importer: importer,
  includePaths: [
    'node_modules/breakpoint-sass/stylesheets/',
    'node_modules/singularitygs/stylesheets/',
    'node_modules/modularscale-sass/stylesheets',
    'node_modules/compass-mixins/lib/'
  ]
};

//Uglifies javascript
gulp.task('uglify', function() {
  return gulp.src('js/*.js')
      .pipe(uglify())
      .pipe(gulp.dest('js_min'));
});

//Compiles sass
gulp.task('sass', function () {
  gulp.src('./sass/**/*.scss')
      .pipe(sourcemaps.init())
      .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
      .pipe(autoprefixer('last 2 version'))
      .pipe(sourcemaps.write('./'))
      .pipe(gulp.dest('./css'));
});

//Move css files
gulp.task('css', function() {
  gulp.src('./sass/**/*.css')
      .pipe(gulp.dest('./css'));
});

//Type "gulp" on the command line to watch file changes
gulp.task('default', function(){
  livereload.listen();
  gulp.watch('./sass/**/*.scss', ['sass']);
  gulp.src('./sass/fonts/*').pipe(gulp.dest('./css/fonts'));
  gulp.src('./sass/**/*.css').pipe(gulp.dest('./css'));
  gulp.watch('./js/**/*.js', ['scripts']);
  gulp.watch(['./css/style.css'], function (files){
    livereload.changed(files)
  });
});
