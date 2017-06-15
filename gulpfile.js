var gulp = require('gulp');
var sass = require('gulp-sass');
var concat = require('gulp-concat');
var watch = require('gulp-watch');
var spritesmith = require('gulp.spritesmith');
var imagemin = require('gulp-imagemin');
var pngquant = require('imagemin-pngquant');



gulp.task('sass', function () {
    return gulp.src('./frontend/web/sass/*.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(concat('style.css'))
        .pipe(gulp.dest('./frontend/web/css/'));
});

gulp.task('image', function () {
    return gulp.src('./frontend/web/images/src/*')
        .pipe(imagemin({
            progressive: true,
            svgoPlugins: [{removeViewBox: false}],
            use: [pngquant()],
            interlaced: true
        }))
        .pipe(gulp.dest('./frontend/web/images'))
});

gulp.task('sprite', function () {
    var spriteData = gulp.src('./frontend/web/images/sprite-icons/*.png').pipe(spritesmith({
        imgName: 'sprite.png',
        cssName: 'sprite.css'
    }));
    return spriteData.pipe(gulp.dest('./frontend/web/images/'));
});

gulp.task('watch', function () {
    gulp.watch('./frontend/web/sass/*.scss', ['sass']);
    gulp.watch('./frontend/web/images/src/*', ['image']);
    gulp.watch('./frontend/web/images/sprite-icons/*.png', ['sprite']);
});



