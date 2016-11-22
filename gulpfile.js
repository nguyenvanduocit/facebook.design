var gulp = require('gulp');
var browserSync = require('browser-sync').create();
var sass = require('gulp-sass');
var plumber = require('gulp-plumber');
var autoprefixer = require('gulp-autoprefixer');
var concat = require('gulp-concat'); // Concatenates JS files
var uglify = require('gulp-uglify'); // Minifies JS files
var zip = require('gulp-zip');
var imagemin = require('gulp-imagemin');
var gutil = require('gulp-util');
var rename = require("gulp-rename");
var eslint = require("gulp-eslint");
var replace = require('gulp-replace');
var conventionalChangelog = require('gulp-conventional-changelog');
var bump = require('gulp-bump');
var git = require('gulp-git');
var runSequence = require('run-sequence');
var fs = require('fs');

var config = {
    dev:{
        proxyDomain: 'fd.dev' // Your local domain
    },
    js: {
        lintSrc:[
            'dev/js/**/*.js' // Files to lint
        ],
        src: [ // Files to be merged
            'dev/js/mergable/**/*.js'
        ],
        partialSrc: [ // Files not tobe merged
            'dev/js/*.js'
        ],
        vendorSrc:[
            'dev/lib/jquery.mixitup.min.js'
        ],
        fileName:'script.js',
        vendorFileName:'vendor.js',
        dest:'js'
    },
    style:{
        src: ['dev/scss/**/*.scss'],
        vendorSrc: [],
        vendorFileName:'vendor.css',
        dest:'css' // output directory
    },
    img: {
        src: ['dev/img/*'],
        dest:'img'
    },
    font:{
        src: [
            'dev/fonts/**.{eot,svg,ttf,woff,json}'
        ],
        dest:'fonts'
    },
    zip:{
        src: [
            '**',
            '!gulpfile.js',
            '!package.json',
            '!nightwatch.json',
            '!.*',
            '!.*/**',
            '!*.log',
            '!*.conf.js',
            '!dist',
            '!dist/**',
            '!test',
            '!test/**',
            '!dev',
            '!dev/**',
            '!node_modules',
            '!node_modules/**'
        ],
        docSrc: [
            'dev/documents/**'
        ],
        docFilename:'document.zip',
        fileName:'fbd-v{version}.zip',
        dest:'dist'
    },
    sourceFiles:["**/*.html", "**/*.php"] // http, php, ...
};


var onError = function (err) {
    console.log('An error occurred:', err.message);
    gutil.beep();
    this.emit('end');
};

/**
 * COPY TASKS
 */

gulp.task('copy-js', function () {
    return gulp.src(config.js.partialSrc)
        .pipe(gutil.env.env === 'production' ? uglify() : gutil.noop())
        .pipe(gulp.dest(config.js.dest));
});
gulp.task('copy-img', function () {
    return gulp.src(config.img.src)
        .pipe(gutil.env.env === 'production' ? imagemin() : gutil.noop())
        .pipe(gulp.dest(config.img.dest));
});

gulp.task('copy-font', function () {
    return gulp.src(config.font.src)
        .pipe(gulp.dest(config.font.dest));
});

gulp.task('copy', ['copy-js', 'copy-font', 'copy-img']);

/**
 * STYLE TASKS
 */

gulp.task('sass', function () {
    return gulp.src(config.style.src)
        .pipe(plumber({errorHandler: onError}))
        .pipe(sass({outputStyle: gutil.env.env === 'production' ? 'compressed' : 'nested'}))
        .pipe(autoprefixer())
        .pipe(gulp.dest(config.style.dest))
        .pipe(browserSync.stream());
});

gulp.task('css-vendor', function () {
    return gulp.src(config.style.vendorSrc)
        .pipe(plumber({errorHandler: onError}))
        .pipe(concat(config.style.vendorFileName))
        .pipe(gulp.dest(config.style.dest));
});

/**
 * JS TASKS
 */

gulp.task('js', function () {
    return gulp.src(config.js.src)
        .pipe(plumber({errorHandler: onError}))
        .pipe(concat(config.js.fileName))
        .pipe(gutil.env.env === 'production' ? uglify() : gutil.noop())
        .pipe(gulp.dest(config.js.dest));

});

gulp.task('js-vendor', function () {
    return gulp.src(config.js.vendorSrc)
        .pipe(plumber({errorHandler: onError}))
        .pipe(concat(config.js.vendorFileName))
        .pipe(gutil.env.env === 'production' ? uglify() : gutil.noop())
        .pipe(gulp.dest(config.js.dest));

});

gulp.task('lint', function() {
    return gulp.src(config.js.lintSrc)
        .pipe(eslint())
        .pipe(eslint.format())
        // Brick on failure to be super strict
        .pipe(eslint.failOnError());
});

gulp.task('reload', function (done) {
    browserSync.reload();
    done();
});

gulp.task('js-reload', ['js'], function (done) {
    browserSync.reload();
    done();
});

/**
 * VERSION TASKS
 */

gulp.task('changelog', function () {
    return gulp.src('CHANGELOG.md', { buffer: false})
        .pipe(conventionalChangelog({
            preset: 'angular' // Or to any other commit message convention you use.
        }))
        .pipe(gulp.dest('./'));
});

gulp.task('bump-version', function(done){
    if(typeof gutil.env.version !== 'undefined'){
        gulp.src(['./functions.php'])
            .pipe(replace(/define\('SAFEKID_VERSION', '([\d\.]+)'\);/g, 'define(\'SAFEKID_VERSION\', \'' + gutil.env.version + '\');'))
            .pipe(gulp.dest('./'));

        gulp.src(['./package.json', './style.css'])
            .pipe(plumber({errorHandler: onError}))
            .pipe(bump({version: gutil.env.version}))
            .pipe(gulp.dest('./'));

        done();
    }else{
        done('Missing argument --version=1.0.0');
    }
});

gulp.task('commit-changes', function () {
    return gulp.src('.')
        .pipe(plumber({errorHandler: onError}))
        .pipe(git.add())
        .pipe(git.commit('[Prerelease] Bumped version number'));
});


function getPackageJsonVersion () {
    // We parse the json file instead of using require because require caches
    // multiple calls so the version number won't be updated
    return JSON.parse(fs.readFileSync('./package.json', 'utf8')).version;
}

gulp.task('create-new-tag', function (cb) {
    var version = getPackageJsonVersion();
    git.tag(version, 'Created Tag for version: ' + version, function (error) {
        if (error) {
            return cb(error);
        }
        git.push('origin', 'master', {args: '--tags'}, cb);
    });
});

gulp.task('push-changes', function (cb) {
    git.push('origin', 'master', cb);
});

/**
 * ZIP TASKS
 */

gulp.task('zip-document', function(){
    return gulp.src(config.zip.docSrc)
        .pipe(plumber({errorHandler: onError}))
        .pipe(zip(config.zip.docFilename))
        .pipe(gulp.dest(config.zip.dest));
});

gulp.task('zip', function(){
    var version = (typeof gutil.env.version !== 'undefined')?gutil.env.version:getPackageJsonVersion();
    var fileName = config.zip.fileName.replace('{version}', version);
    return gulp.src(config.zip.src)
        .pipe(zip(fileName))
        .pipe(gulp.dest(config.zip.dest));
});

/**
 * GROUP TASKS
 */

gulp.task('vendor', ['css-vendor', 'js-vendor']);

gulp.task('dev', ['sass', 'js', 'copy', 'vendor'], function () {
    browserSync.init({
        proxy: config.dev.proxyDomain,
        open: false
    });
    gulp.watch(config.js.src, ['js-reload']); //lint
    gulp.watch(config.style.src, ['sass']);
    gulp.watch(config.sourceFiles, ['reload']);
});

gulp.task('build', ['sass', 'js', 'copy', 'vendor', 'zip-document'], function(callback){
    runSequence(
        'zip',
        function (error) {
            if (error) {
                console.log(error.message);
            } else {
                console.log('DONE!');
            }
            callback(error);
        });
});

gulp.task('release', ['sass', 'js', 'copy', 'vendor', 'zip-document', 'bump-version'], function(callback){
    runSequence(
        'changelog',
        'commit-changes',
        //'create-new-tag',
        //'push-changes',
        'zip',
        function (error) {
            if (error) {
                console.log(error.message);
            } else {
                console.log('DONE!');
            }
            callback(error);
        });
});

gulp.task('default', ['sass', 'js', 'copy', 'vendor']);
