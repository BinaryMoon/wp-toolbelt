/* jshint esnext: true */
'use strict';

// External dependencies.
import { series, parallel, watch } from 'gulp';

import {
	process_global_styles,
	styles_cookie, styles_social,
	styles_related_posts, styles_social_menu,
	styles_breadcrumbs, styles_videos,
	styles_heading_links, styles_infinite_scroll,
	styles_testimonials, styles_admin_tweaks,
	styles_portfolio
} from './gulp/sass';
import {
	scripts_cookieBanner,
	scripts_infiniteScroll,
	scripts_spam,
	scripts_testimonials,
	scripts_projects_block
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
		styles_portfolio,
		styles_testimonials,
		scripts_cookieBanner,
		scripts_infiniteScroll,
		scripts_testimonials,
		scripts_projects_block,
		scripts_spam,
		process_global_styles,
		translate
	),
	compress
);

export const watchFiles = function( done ) {

	watch(
		'./modules/*/src/sass/*.scss',
		parallel(
			styles_cookie,
			styles_social,
			styles_related_posts,
			styles_breadcrumbs,
			styles_social_menu,
			styles_heading_links,
			styles_videos,
			styles_infinite_scroll,
			styles_admin_tweaks,
			styles_testimonials,
			styles_portfolio
		)
	);

	watch(
		[ './modules/*/src/*/*.js' ],
		parallel(
			scripts_infiniteScroll,
			scripts_cookieBanner,
			scripts_spam,
			scripts_testimonials,
			scripts_projects_block
		)
	);

	watch(
		[ './assets/sass/*.scss' ],
		process_global_styles
	);

	done();

};

export default series(
	build,
	watchFiles
);

