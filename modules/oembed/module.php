<?php
/**
 * Add additional OEmbed providers.
 *
 * @uses https://developer.wordpress.org/reference/functions/wp_oembed_add_provider/
 * @package toolbelt
 */

/**
 * Mesh
 *
 * A retired project from Automattic. Me.sh galleries are still online so no
 * harm adding this in.
 *
 * @see https://me.sh
 */
wp_oembed_add_provider( 'https://me.sh/*', 'https://me.sh/oembed?format=json' );

/**
 * GFYCat
 *
 * @see https://gfycat.com
 * @see https://gfycat.com/opulentimpartialkilldeer-tyrion-lannister-game-of-thrones-no-thank-you
 */
wp_oembed_add_provider( '#https?://(www\.)?gfycat\.com/.*#i', 'https://api.gfycat.com/v1/oembed', true );

/**
 * Wistia
 *
 * @see https://wistia.com
 * @see http://fast.wistia.com/embed/iframe/b0767e8ebb?version=v1&controlsVisibleOnLoad=true&playerColor=aae3d8
 */
wp_oembed_add_provider( '#https?://[^.]+\.(wistia\.com|wi\.st)/(medias|embed)/.*#', 'https://fast.wistia.com/oembed', true );

/**
 * SketchFab
 *
 * @see https://sketchfab.com
 * @see https://sketchfab.com/3d-models/froggy-camp-59fc993ac6b1467c85f46de160438160
 */
wp_oembed_add_provider( '#https?://sketchfab\.com/.*#i', 'https://sketchfab.com/oembed', true );

/**
 * ICloud
 *
 * @see https://icloud.com
 */
wp_oembed_add_provider( '#https?://(www\.)?icloud\.com/keynote/.*#i', 'https://iwmb.icloud.com/iwmb/oembed', true );

/**
 * Odesli
 *
 * @see https://odesli.co
 * @see https://song.link/gb/i/672046422
 */
wp_oembed_add_provider( '#https?://((song|album|artist|pods|playlist)\.link|odesli\.com?|mylink\.page)/.*#', 'https://odesli.co/oembed', true );

/**
 * Loom
 *
 * @see https://loom.com
 * @see https://www.loom.com/share/e3dcec661c37487b818b8e3b8225ec27
 */
wp_oembed_add_provider( '#https?://(www\.)?loom\.com/share/.*#i', 'https://www.loom.com/v1/oembed', true );

/**
 * Codepen
 *
 * @see https://codepen.io
 * @see https://blog.codepen.io/documentation/oembed/
 */
wp_oembed_add_provider( '#https?://codepen.io/([^/]+)/pen/([^/]+)/?#', 'https://codepen.io/api/oembed', true );

/**
 * Flat.io
 *
 * Example URL: https://flat.io/score/5a5268ed41396318cbd7772c-string-quartet-for-rainy-days
 *
 * @see https://flat.io
 * @see https://flat.io/developers/docs/embed/oembed.html
 */
wp_oembed_add_provider( 'https://flat.io/score/*', 'https://flat.io/services/oembed', false );
wp_oembed_add_provider( 'https://*.flat.io/score/*', 'https://flat.io/services/oembed', false );

/**
 * Carto (formerly CartoDB)
 *
 * Example URL: http://osm2.carto.com/viz/08aef918-94da-11e4-ad83-0e0c41326911/public_map
 *
 * possible patterns:
 * [username].carto.com/viz/[map-id]/public_map
 * [username].carto.com/viz/[map-id]/embed_map
 * [username].carto.com/viz/[map-id]/map
 * [organization].carto.com/u/[username]/viz/[map-id]/public_map
 * [organization].carto.com/u/[username]/viz/[map-id]/embed_map
 * [organization].carto.com/u/[username]/viz/[map-id]/map
 *
 * On July 8th, 2016 CartoDB changed its primary domain from cartodb.com to carto.com
 * So this shortcode still supports the cartodb.com domain for oembeds.
 *
 * @see https://carto.com
 */
wp_oembed_add_provider( '#https?://(?:www\.)?[^/^\.]+\.carto(db)?\.com/\S+#i', 'https://services.carto.com/oembed', true );

/**
 * TED Player
 *
 * Examples:
 * http://www.ted.com/talks/view/id/210
 * http://www.ted.com/talks/marc_goodman_a_vision_of_crimes_in_the_future.html
 * [ted id="210" lang="en"]
 * [ted id="http://www.ted.com/talks/view/id/210" lang="en"]
 * [ted id=1539 lang=fr width=560 height=315]
 *
 * @see https://ted.com
 */
wp_oembed_add_provider( '!https?://(www\.)?ted.com/talks/view/id/.+!i', 'https://www.ted.com/talks/oembed.json', true );
wp_oembed_add_provider( '!https?://(www\.)?ted.com/talks/[a-zA-Z\-\_]+\.html!i', 'https://www.ted.com/talks/oembed.json', true );

/**
 * Mixcloud
 *
 * Example URL: http://www.mixcloud.com/oembed/?url=http://www.mixcloud.com/MalibuRum/play-6-kissy-sellouts-winter-sun-house-party-mix/
 *
 * @see https://mixcloud.com
 */
wp_oembed_add_provider( '#https?://(?:www\.)?mixcloud\.com/\S*#i', 'https://www.mixcloud.com/oembed', true );
