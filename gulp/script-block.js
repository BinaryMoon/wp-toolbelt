/* jshint esnext: true */
'use strict';

const { src, dest } = require( 'gulp' );
const rename = require( 'gulp-rename' );
const uglify = require( 'gulp-uglify' );
const size = require( 'gulp-filesize' );
const babel = require( 'gulp-babel' );
const include = require( 'gulp-include' );


function process_scripts() {

	const destination = './modules/';
	const source = './modules/**/src/block/block.js';

	return src( source )
		.pipe(
			include(
				{
					includePaths: [
						__dirname + '/../node_modules',
					]
				}
			)
		)
		.pipe(
			babel()
		)
		.pipe(
			rename(
				path => {
					path.dirname = path.dirname.replace( 'src/block', '' );
					path.basename = 'block';
				}
			)
		)
		.pipe( dest( destination ) )
		.pipe(
			uglify()
		)
		.pipe(
			rename(
				path => {
					path.extname = '.min.js';
				}
			)
		)
		.pipe( dest( destination ) )
		.pipe( size() );

}

export function process_block_scripts() {

	return process_scripts();

}
