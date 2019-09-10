/* jshint esnext: true */
'use strict';

// External dependencies.
import { series, parallel, watch } from 'gulp';

import {
	styles_cookie, styles_social,
	styles_related_posts, styles_social_menu,
	styles_breadcrumbs, styles_videos,
	styles_heading_links, styles_infinite_scroll,
} from './gulp/sass';
import {
	scripts_cookieBanner,
	scripts_infiniteScroll
} from './gulp/script';
import compress from './gulp/zip';
import translate from './gulp/pot';

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
		scripts_cookieBanner,
		scripts_infiniteScroll,
		translate
	),
	compress
);

export const watchFiles = function( done ) {
	watch(
		'./**/*.scss',
		parallel(
			styles_cookie,
			styles_social,
			styles_related_posts,
			styles_breadcrumbs,
			styles_social_menu,
			styles_heading_links,
			styles_videos,
			styles_infinite_scroll
		)
	);
	watch(
		[ './**/*.js', '!./**/script.js', '!./**/script.min.js' ],
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

