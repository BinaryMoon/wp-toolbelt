/* jshint esnext: true */
'use strict';

const { src, dest } = require( 'gulp' );
const sass = require( 'gulp-sass' );
const rename = require( 'gulp-rename' );
const autoprefixer = require( 'gulp-autoprefixer' );
const cleancss = require( 'gulp-clean-css' );
const change = require( 'gulp-change' );
const size = require( 'gulp-filesize' );

/**
 * Build SASS files.
 */
function process_styles( slug ) {

	const destination = './modules/' + slug + '/';
	const source = './modules/' + slug + '/src/sass/style.scss';

	/**
	 * Uses node-sass options:
	 * https://github.com/sass/node-sass#options
	 */
	return src( source )
		.pipe(
			sass(
				{
					indentType: 'tab',
					indentWidth: 1,
					outputStyle: 'expanded',
					precision: 3,

				}
			).on( 'error', sass.logError )
		)
		.pipe(
			autoprefixer(
				{
					cascade: false
				}
			)
		)
		// .pipe( dest( destination ) )
		.pipe( rename( 'style.min.css' ) )
		.pipe(
			change( removeComments )
		)
		.pipe(
			cleancss(
				{
					level: 2
				}
			)
		)
		.pipe( dest( destination ) )
		.pipe( size() );

}

export function styles_cookie() {

	return process_styles( 'cookie-banner' );

}

export function styles_social() {

	return process_styles( 'social-sharing' );

}

export function styles_related_posts() {

	return process_styles( 'related-posts' );

}

export function styles_testimonials() {

	return process_styles( 'testimonials' );

}

export function styles_social_menu() {

	return process_styles( 'social-menu' );

}

export function styles_infinite_scroll() {

	return process_styles( 'infinite-scroll' );

}

export function styles_breadcrumbs() {

	return process_styles( 'breadcrumbs' );

}

export function styles_videos() {

	return process_styles( 'responsive-videos' );

}

export function styles_admin_tweaks() {

	return process_styles( 'admin-tweaks' );

}

export function styles_heading_links() {

	return process_styles( 'heading-anchors' );

}

/**
 * Remove comments from the source so that they can be minified away.
 */
const removeComments = function( content ) {

	content = content.replace( /\/\*\*!/g, '/**' );
	content = content.replace( /\/\*!/g, '/*' );

	return content;

}
