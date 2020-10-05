/* jshint esnext: true */
'use strict';

const { src, dest } = require( 'gulp' );
const sass = require( 'gulp-sass' );
const autoprefixer = require( 'gulp-autoprefixer' );
const cleancss = require( 'gulp-clean-css' );
const change = require( 'gulp-change' );
const size = require( 'gulp-filesize' );
const rename = require( 'gulp-rename' );

const sass_properties = {
	indentType: 'tab',
	indentWidth: 1,
	outputStyle: 'expanded',
	precision: 3,
};


/**
 * Build SASS files.
 */
function process_styles( path = './modules/*/src/sass/**/*.scss' ) {

	return src( path )
		.pipe(
			sass( sass_properties ).on( 'error', sass.logError )
		)
		.pipe(
			autoprefixer(
				{ cascade: false }
			)
		)
		.pipe(
			change( removeComments )
		)
		.pipe(
			cleancss( { level: 2 } )
		)
		.pipe(
			rename(
				path => {
					path.dirname = path.dirname.replace( 'src/sass', '' );
					path.dirname = path.dirname.replace( 'src/block', '' );
					path.extname = '.min.css';
				}
			)
		)
		.pipe( dest( './modules' ) )
		.pipe( size() );

}

export function process_module_styles() {

	return process_styles();

}

export function process_block_styles() {

	return process_styles(
		'./modules/*/src/block/**/*.scss',
		'block'
	);

}


/**
 *
 */
export function process_global_styles() {

	return src( './assets/sass/*.scss' )
		.pipe(
			sass( sass_properties ).on( 'error', sass.logError )
		)
		.pipe(
			autoprefixer(
				{ cascade: false }
			)
		)
		.pipe(
			cleancss( { level: 2 } )
		)
		.pipe( dest( './assets/css/' ) );

}


/**
 * Remove comments from the source so that they can be minified away.
 */
const removeComments = function( content ) {

	content = content.replace( /\/\*\*!/g, '/**' );
	content = content.replace( /\/\*!/g, '/*' );

	return content;

};
