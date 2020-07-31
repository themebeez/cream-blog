'use strict';


// include all necessary plugins in gulp file

var gulp = require('gulp');

var concat = require('gulp-concat');

var uglify = require('gulp-uglify');

var rename = require('gulp-rename');

// var cache = require('gulp-cache');

var wpPot = require( 'gulp-wp-pot' );


// SCSS Compiler

var sass = require('gulp-sass');

sass.compiler = require('node-sass');


// CSS properties auto vendor prefixer

var autoprefixer = require( 'gulp-autoprefixer' );


// Constanly watch changes

var watch = require('gulp-watch');


// Task defined for java scripts bundling and minifying

// gulp.task( 'scripts', function() {

//     return gulp.src([
//             'assets/src/js/libraries/*.js',
//             'assets/src/js/custom/*.js',
//         ])
//         .pipe(concat('bundle.js'))
//         .pipe(rename({ suffix: '.min' }))
//         .pipe(uglify())
//         .pipe(gulp.dest('assets/dist/js/'));
// } );

// gulp.task( 'stream', function () {

//   	gulp.watch( 'assets/src/js/**/*.js', gulp.series('scripts') );

// });



gulp.task( 'makepot', function () {

    return gulp.src( ['**/*.php', '!node_modules/**', '!inc/class-tgm-plugin-activation.php', '!inc/plugin-recommendation.php'] )
        .pipe( wpPot( {
            domain: 'cream-blog',
            package: 'Cream Blog'
        } ))
        .pipe( gulp.dest( 'languages/cream-blog.pot' ) );
} );

gulp.task( 'default', gulp.series( 'makepot' ) );



// gulp.task( 'sass', function () {

//   	return gulp.src( 'assets/scss/theme.scss' )
//   		.pipe( sass().on( 'error', sass.logError ) )
//   		.pipe( autoprefixer() )
//   		.pipe( gulp.dest( 'assets/css/' ) );
// });

// gulp.task( 'stream', function () {

//   	gulp.watch( 'assets/scss/**/*.scss', gulp.series('sass') );
// });


// declaring final task and command tasker

// just hit the command "gulp" it will run the following tasks...


// gulp.task( 'default', gulp.series( 'makepot' ) );

// gulp.task( 'default', gulp.series( 'stream' ) );