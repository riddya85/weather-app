var env = process.env.NODE_ENV || 'local';
var gulp = require('gulp'),
    sass = require('gulp-sass'),
    gulpif = require('gulp-if'),
    uglify = require('gulp-uglify'),
    minifycss = require('gulp-clean-css'),
    browserify = require('gulp-browserify'),
    sourcemaps = require('gulp-sourcemaps'),
    autoprefixer = require('gulp-autoprefixer'),
    moduleImporter = require('sass-module-importer'),
    concat = require('gulp-concat'),
    spritesmith = require('gulp.spritesmith'),
    merge = require('merge-stream');


/*
 |--------------------------------------------------------------------------
 | Paths
 |--------------------------------------------------------------------------
 */
var destPath = './public/front';
var paths = {
    task: {
        styles: './resources/assets/front/sass/app.scss',
        scripts: './resources/assets/front/js/app.js'
    },
    watch: {
        styles: ['./resources/assets/front/sass/**/*.scss','./resources/assets/front/css/**/*.css'],
        scripts: './resources/assets/front/js/**/*.js'
    },
    dist: {
        styles: destPath+'/css',
        scripts: destPath+'/js'
    }
};

/*
 |--------------------------------------------------------------------------
 | Watcher
 |--------------------------------------------------------------------------
 */
gulp.task('watch', function() {
    gulp.watch(paths.watch.styles, ['styles']);
    gulp.watch(paths.watch.scripts, ['scripts']);
});


/*
 |--------------------------------------------------------------------------
 | Tasks
 |--------------------------------------------------------------------------
 */
gulp.task('styles', function() {
    gulp.src(paths.task.styles)
        .pipe(gulpif(env == 'local', sourcemaps.init()))
        .pipe(sass({
            //importer: moduleImporter()
        }).on('error',  sass.logError))
        .pipe(autoprefixer({
            browsers: ['> 2%', 'IE 8'],
            cascade: false
        }))
        .pipe(gulpif(env != 'local', minifycss({
            compatibility: 'ie8'
        })))
        .pipe(gulpif(env == 'local', sourcemaps.write()))
        .pipe(gulp.dest(paths.dist.styles))
    ;
});

// compiling our app.js
gulp.task('scripts', function() {
    gulp.src(paths.task.scripts)
        .pipe(gulpif(env == 'local', sourcemaps.init()))
        .pipe(browserify({
            //insertGlobals: true,
            debug: env == 'local'
        }))
        .on('error', function(e) {
            console.error(e);
            this.emit('end');
        })
        .pipe(gulpif(env != 'local', uglify()))
        .on('error', function(e) {
            console.error(e);
            this.emit('end');
        })
        .pipe(gulpif(env == 'local', sourcemaps.write()))
        .pipe(gulp.dest(paths.dist.scripts))
    ;
});

gulp.task('enable-production', function() {
    return env = 'production';
});

/*
 |--------------------------------------------------------------------------
 | Default Task
 |--------------------------------------------------------------------------
 */
gulp.task('default', [
    'stylesWithSprites',
    'scripts',
    'watch'
]);

gulp.task('stylesWithSprites',[
    'styles'
]);

gulp.task('production',['enable-production','default']);