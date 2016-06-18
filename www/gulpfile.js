var fs = require('fs'),
  path = require('path'),
  gulp = require('gulp'),
  plumber = require('gulp-plumber'),
  sass = require('gulp-sass'),
  autoprefixer = require('gulp-autoprefixer'),
  minify = require('gulp-minify'),
  minifycss = require('gulp-minify-css'),
  rename = require('gulp-rename');


//----------------------------------------------//

gulp.task('default', function() {
  console.log("Run gulp watch to watch changes in css.");
  console.log("");
});

gulp.task('styles', function() {
  /*return gulp.src('css/!**!/!*.scss')
   .pipe(plumber())
   .pipe(sass().on('error', sass.logError))
   .pipe(gulp.dest('css'));
   */

  console.log("Keeping it sassy.");
  return gulp.src('css/scss/app.scss')
    .pipe(plumber())
    .pipe(sass({
      outputStyle: 'expanded'
    }).on('error', sass.logError))
    .pipe(autoprefixer("last 3 version", "safari 5", "ie 8", "ie 9"))
    .pipe(gulp.dest('css/'))
    .pipe(rename({
      suffix: '.min'
    }))
    .pipe(minifycss())
    .pipe(gulp.dest('css/'));
});

gulp.task('watch', function() {
  gulp.watch('css/**/*.{scss,sass}', ['styles']);
});
