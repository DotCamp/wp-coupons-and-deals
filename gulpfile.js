const gulp = require('gulp')
const rename = require('gulp-rename')
const cleanCSS = require('gulp-clean-css')
const replace = require('gulp-replace')

// Minified files land one directory deeper (in dist/), so every relative url()
// needs one extra level. Only the leading "../" run inside url() is touched,
// so "../../img/x.png" becomes "../../../img/x.png" and not "../../../../".
const REBASE_URL = /url\((['"]?)((?:\.\.\/)+)/g
const REBASE_TO_DIST = 'url($1../$2'

gulp.task('css-minify', async function () {
    gulp.
        src('./assets/css/*.css')
        .pipe(replace(REBASE_URL, REBASE_TO_DIST))
        .pipe(cleanCSS())
        .pipe(rename({ extname: '.min.css' }))
        .pipe(gulp.dest('./assets/css/dist/'))
});

gulp.task('admin-css-minify', async function () {
    gulp.
        src('./assets/admin/css/*.css')
        .pipe(replace(REBASE_URL, REBASE_TO_DIST))
        .pipe(cleanCSS())
        .pipe(rename({ extname: '.min.css' }))
        .pipe(gulp.dest('./assets/admin/css/dist/'))
});