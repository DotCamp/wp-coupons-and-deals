const gulp = require('gulp')
const rename = require('gulp-rename')
const cleanCSS = require('gulp-clean-css')
const replace = require('gulp-replace')

gulp.task('css-minify', async function () {
    gulp.
        src('./assets/css/*.css')
        .pipe(replace('../', '../../'))
        .pipe(cleanCSS())
        .pipe(rename({ extname: '.min.css' }))
        .pipe(gulp.dest('./assets/css/dist/'))
});

gulp.task('admin-css-minify', async function () {
    gulp.
        src('./assets/admin/css/*.css')
        .pipe(replace('../', '../../'))
        .pipe(cleanCSS())
        .pipe(rename({ extname: '.min.css' }))
        .pipe(gulp.dest('./assets/admin/css/dist/'))
});