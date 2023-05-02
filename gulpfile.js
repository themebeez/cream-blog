
const gulp = require('gulp');
const zip = require('gulp-zip');
const sourcemaps = require('gulp-sourcemaps');
const sass = require('gulp-sass')(require('sass'));
const concat = require('gulp-concat');
const uglify = require('gulp-uglify');
const postcss = require('gulp-postcss');
const autoprefixer = require('autoprefixer');
const cssnano = require('cssnano');
const notify = require('gulp-notify');
const plumber = require('gulp-plumber');
const rtlcss = require('gulp-rtlcss');
const rename = require('gulp-rename');
const shell = require('gulp-shell');

/**
 * 
 npm install --save-dev gulp@4.0.2 gulp-zip gulp-sourcemaps gulp-sass sass gulp-concat gulp-uglify gulp-postcss autoprefixer cssnano gulp-notify gulp-plumber gulp-rtlcss gulp-rename gulp-shell
 *
*/

/*
####################
=
= Var 1: varibales to ZIP production files
=
####################
*/

// #1.1 project name 

const output_filename = 'cream-blog.zip';

// #1.2 files & folders to zip
const files_folders = {

    filefolders_src: [

        './*',
        './*/**',

        '!./node_modules/**',
        '!./assets/src/**',
        '!./gulpfile.js',
        '!./.gitignore',
        '!./package.json',
        '!./package-lock.json',
        '!./composer.json',
        '!./composer.lock',
        '!./README.md',
        '!./sftp-config.json'
    ],

    production_zip_file_path: "./",
}

/*
####################
=
= Var 2: varibales for cream static resources 
=
####################
*/

// #2.1 Script files path
const creamScriptPath = {

    cream_cream_scripts_path: [

        './assets/src/js/plugins/*.js',
        './assets/src/js/custom/*.js',
        '!./assets/src/js/conditional/**'
    ],

    cream_script_dist: "./assets/dist/js/",
}
const cream_build_js_file_name = "bundle.js";


// #2.2 Conditional scripts
const creamConditionalScriptsPath = {

    cream_con_scripts_src: [

        './assets/src/js/conditional/*/**.js',
    ],

    cream_con_scripts_dist: "./assets/dist/js/conditional/",
}


// #2.3 SASS/SCSS file path
const creamSassPath = {

    cream_sass_src: ["./assets/src/scss/**/*.scss", "!./assets/src/scss/conditional/**"],
    cream_sass_dist: "./assets/dist/css/",
}
const cream_compiled_sass_css_file_name = "main.css"; // what would you like to name your compiled CSS file


// #2.4 Conditional SASS/SCSS file path 
const creamConditionalSassPath = {

    cream_cond_sass_src: "./assets/src/scss/conditional/**/*.scss",
    cream_cond_sass_dist: "./assets/dist/css/conditional/",
}

// #3.5 LTR & RTL CSS path
const creamRtlCssPath = {

    cream_rtlcss_src: "./assets/dist/css/" + cream_compiled_sass_css_file_name,
    cream_rtlcss_dist: "./assets/dist/css/", // where would you like to save your generated RTL CSS
}


/*
===========================================================
=
= Task 1: Zips production files
=
====================================================
*/

gulp.task('ZipProductionFiles', function () {
    return gulp.src(files_folders.filefolders_src)
        .pipe(zip(output_filename))
        .pipe(gulp.dest(files_folders.production_zip_file_path))
});

/*
===========================================================
=
= Task 2: Compile cream static resources
=
====================================================
*/

gulp.task('creamScriptsTask', function () {
    return gulp.src(creamScriptPath.cream_cream_scripts_path)
        .pipe(concat(cream_build_js_file_name))
        .pipe(rename({ suffix: '.min' }))
        .pipe(uglify())
        .pipe(gulp.dest(creamScriptPath.cream_script_dist));
});

gulp.task('creamConditionalScriptsTask', function () {
    return gulp.src(creamConditionalScriptsPath.cream_con_scripts_src)
        .pipe(rename({ suffix: '.min' }))
        .pipe(uglify())
        .pipe(gulp.dest(creamConditionalScriptsPath.cream_con_scripts_dist));
});

gulp.task('creamSassTask', function () {
    var onError = function (err) {
        notify.onError({
            title: "Gulp",
            subtitle: "Failure!",
            message: "Error: <%= error.message %>",
            sound: "Beep"
        })(err);
        this.emit('end');
    };
    return gulp.src(creamSassPath.cream_sass_src)
        .pipe(sourcemaps.init()) // initialize sourcemaps first
        .pipe(plumber({ errorHandler: onError }))
        .pipe(sass.sync().on('error', sass.logError))
        .pipe(postcss([autoprefixer('last 2 version'), cssnano()])) // PostCSS plugins
        .pipe(concat(cream_compiled_sass_css_file_name))
        .pipe(sourcemaps.write('.')) // write sourcemaps file in current directory
        .pipe(gulp.dest(creamSassPath.cream_sass_dist)); // put final CSS in dist folder
});

gulp.task('creamConditionalSassTask', function () {
    var onError = function (err) {
        notify.onError({
            title: "Gulp",
            subtitle: "Failure!",
            message: "Error: <%= error.message %>",
            sound: "Beep"
        })(err);
        this.emit('end');
    };
    return gulp.src(creamConditionalSassPath.cream_cond_sass_src)
        .pipe(sourcemaps.init()) // initialize sourcemaps first
        .pipe(plumber({ errorHandler: onError }))
        .pipe(sass.sync().on('error', sass.logError))
        .pipe(postcss([autoprefixer('last 2 version'), cssnano()])) // PostCSS plugins
        .pipe(sourcemaps.write('.')) // write sourcemaps file in current directory
        .pipe(gulp.dest(creamConditionalSassPath.cream_cond_sass_dist)); // put final CSS in dist folder
});

// task to convert LTR css to RTL
gulp.task('creamDortlTask', function () {
    return gulp.src(creamRtlCssPath.cream_rtlcss_src)
        .pipe(rtlcss()) // Convert to RTL.
        .pipe(rename({ suffix: '-rtl' })) // Append "-rtl" to the filename.
        .pipe(gulp.dest(creamRtlCssPath.cream_rtlcss_dist)); // Output RTL stylesheets.
});


//=========================================
// = C O M M A N D S                      = 
//=========================================
//
// 1. Command: gulp assets (will compile cream scss, js & watch for the changes)
// 2. Command: gulp zip (zips the production files)
//
//=========================================


gulp.task('default', shell.task(

    'No task specified. Please use one of the following commands: gulp assets, gulp zip',
));

gulp.task('zip', gulp.series('ZipProductionFiles', (done) => {

    done();
}));

gulp.task('assets', gulp.series('creamScriptsTask', 'creamConditionalScriptsTask', 'creamSassTask', 'creamConditionalSassTask', 'creamDortlTask', (done) => {

    gulp.watch(creamScriptPath.cream_cream_scripts_path, gulp.series('creamScriptsTask'));
    gulp.watch(creamConditionalScriptsPath.cream_con_scripts_src, gulp.series('creamConditionalScriptsTask'));
    gulp.watch(creamSassPath.cream_sass_src, gulp.series('creamSassTask'));
    gulp.watch(creamConditionalSassPath.cream_cond_sass_src, gulp.series('creamConditionalSassTask'));
    gulp.watch(creamRtlCssPath.cream_rtlcss_src, gulp.series('creamDortlTask'));
    done();
}));