const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));

gulp.task('sass', function () {
  return gulp.src('src/scss/*.scss')
  .pipe(sass({ outputStyle: 'compressed' }))
  .pipe(gulp.dest('assets/css'));
});

gulp.task('watch', function () {
  gulp.watch('src/scss/*.scss', gulp.task('sass'));
});

gulp.task('default', gulp.series('sass'));
