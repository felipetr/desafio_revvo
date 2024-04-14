const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass')); 
const uglify = require('gulp-uglify'); 
const concat = require('gulp-concat');

gulp.task('styles', function() {
  return gulp.src('src/scss/*.scss') 
    .pipe(sass().on('error', sass.logError))
    .pipe(concat('style.css')) 
    .pipe(gulp.dest('dist/assets/css')); 
});

gulp.task('scripts', function() {
  return gulp.src('src/js/*.js') 
    .pipe(concat('scripts.js')) 
    .pipe(uglify()) 
    .pipe(gulp.dest('dist/assets/js')); 
});

gulp.task('default', gulp.series('styles', 'scripts')); 

gulp.task('watch', function() {
  gulp.watch('src/scss/*.scss', gulp.parallel('styles')); 
  gulp.watch('src/js/*.js', gulp.parallel('scripts')); 
});