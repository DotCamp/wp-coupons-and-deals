const gulp = require('gulp')
const rename = require('gulp-rename')
const cleanCSS = require('gulp-clean-css')

gulp.task('css-minify', function () {
    gulp.
        src('./assets/css/*.css')
        .pipe(cleanCSS())
        .pipe(rename({ extname: '.min.css' }))
        .pipe(gulp.dest('./assets/css/dist/'))
});

gulp.task('admin-css-minify', function () {
    gulp.
        src('./assets/admin/css/*.css')
        .pipe(cleanCSS())
        .pipe(rename({ extname: '.min.css' }))
        .pipe(gulp.dest('./assets/admin/css/dist/'))
});