/* jshint esnext: true */
'use strict';

// External dependencies.
import { series, parallel, watch } from 'gulp';

import {
	styles_cookie, styles_social,
	styles_related_posts, styles_social_menu,
	styles_breadcrumbs, styles_videos,
	styles_heading_links, styles_infinite_scroll,
	styles_admin_tweaks
} from './gulp/sass';
import {
	scripts_cookieBanner,
	scripts_infiniteScroll
} from './gulp/script';
import compress from './gulp/zip';
import translate from './gulp/pot';

export const buildTranslations = translate;
export const buildZip = compress;

export const build = series(
	parallel(
		styles_cookie,
		styles_social,
		styles_related_posts,
		styles_social_menu,
		styles_breadcrumbs,
		styles_videos,
		styles_heading_links,
		styles_infinite_scroll,
		styles_admin_tweaks,
		scripts_cookieBanner,
		scripts_infiniteScroll,
		translate
	),
	compress
);

export const watchFiles = function( done ) {

	watch(
		'./modules/**/*.scss',
		parallel(
			styles_cookie,
			styles_social,
			styles_related_posts,
			styles_breadcrumbs,
			styles_social_menu,
			styles_heading_links,
			styles_videos,
			styles_infinite_scroll,
			styles_admin_tweaks
		)
	);

	watch(
		[ './modules/**/*.js', '!./modules/**/script.min.js' ],
		parallel(
			scripts_infiniteScroll,
			scripts_cookieBanner
		)
	);

	done();

};

export default series(
	build,
	watchFiles
);

