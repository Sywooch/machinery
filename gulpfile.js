var gulp = require('gulp');
var sass = require('gulp-sass');
var concat = require('gulp-concat');
var watch = require('gulp-watch');
var spritesmith = require('gulp.spritesmith');
var imagemin = require('gulp-imagemin');
var pngquant = require('imagemin-pngquant');
var sourcemaps = require('gulp-sourcemaps');
var autoprefixer = require('gulp-autoprefixer');



gulp.task('sass', function () {
    return gulp.src('./frontend/web/sass/style.scss')
        .pipe(sourcemaps.init())
        .pipe(concat('style.css'))
        .pipe(sass({outputStyle: 'compact'}).on('error', sass.logError))
        .pipe(autoprefixer({
            browsers: ['last 50 versions', '> 1%', 'ie 8']
        }))
        .pipe(sourcemaps.write())
        .pipe(gulp.dest('./frontend/web/css/'))
    ;
});

gulp.task('image', function () {
    return gulp.src('frontend/web/images/src/*')
        .pipe(imagemin({
            progressive: true,
            svgoPlugins: [{removeViewBox: false}],
            use: [pngquant()],
            interlaced: true
        }))
        .pipe(gulp.dest('frontend/web/images'))
});

gulp.task('sprite', function () {
    var spriteData = gulp.src('frontend/web/images/sprite-icons/*.png').pipe(spritesmith({
        imgName: 'sprite.png',
        cssName: '_sprite.scss',
        imgPath: '../images/sprite.png'
    }));
    return spriteData.pipe(gulp.dest('frontend/web/images/'));
});

gulp.task('watch', function () {
    gulp.watch('frontend/web/images/src/*', ['image']);
    gulp.watch('frontend/web/images/sprite-icons/*.png', ['sprite']);
    gulp.watch('frontend/web/sass/*.scss', ['sass']);
});



