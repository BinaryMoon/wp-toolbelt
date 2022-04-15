# WP Toolbelt

[![Travis build process](https://travis-ci.com/BinaryMoon/wp-toolbelt.svg?branch=master)](https://travis-ci.com/github/BinaryMoon/wp-toolbelt)

A lightweight plugin inspired by Jetpack but designed for privacy, speed, and accessibility.

## Speed?

I want it to be fast. I want to be able to enable any of the features and not have my Google Pagespeed score drop. To be fast it:

* Doesn't use jQuery or any other javascript framework. All javascript is vanilla js, and minified.
* Minifies all assets (JS and CSS)
* Loads all assets inline. They are already small, and loading them directly on the page means there are no server requests.
* Only loads things when they are needed. JS and CSS are only loaded for activated modules.
* Options? There's only one for the database; an array that stores what modules are active.
* Uses the minimum code possible. Minimum Javascript and PHP. Less code means more speed, and fewer bugs.
* All modules are disabled by default. You only enable the ones you need.

## Privacy? GDPR?

To ensure the plugin is as privacy focused as possible it:

* Does not phone out. No data is shared with third parties.
* Does not use standard social sharing javascripts (loaded from social networks servers).
* Does not track your usage of the plugin.
* Does not add generator comments, or secret comments to your site html.

## Features

* [Admin Interface Tweaks](https://github.com/BinaryMoon/wp-toolbelt/wiki/Admin-Tweaks) - Small CSS changes to make the interface nicer to use.
* [Avatars](https://github.com/BinaryMoon/wp-toolbelt/wiki/Avatars) - Algorithmicly generated private avatars that are consistent across websites.
* [Breadcrumbs](https://github.com/BinaryMoon/wp-toolbelt/wiki/Breadcrumbs)
* [Contact Form](https://github.com/BinaryMoon/wp-toolbelt/wiki/Contact-Form) - Gutenberg compatible & private. Supports the spam blocker module.
* [Cookie Banner](https://github.com/BinaryMoon/wp-toolbelt/wiki/Cookie-Banner)
* [CSP Header](https://github.com/BinaryMoon/wp-toolbelt/wiki/CSP-Header)
* [Disable Comment Urls](https://github.com/BinaryMoon/wp-toolbelt/wiki/Disable-Comment-Urls) - Removes comments urls from your site.
* [Enable Customizer](https://github.com/BinaryMoon/wp-toolbelt/wiki/Enable-Customizer) - Make sure the Customizer is active so we can use the Additional CSS addon.
* [Fast 404](https://github.com/BinaryMoon/wp-toolbelt/wiki/Fast-404) - Stops WordPress from loading the full 404 page for images and other content. Reduces server usage.
* [Footnotes](https://github.com/BinaryMoon/wp-toolbelt/wiki/Footnotes)
* [Get Image](https://github.com/BinaryMoon/wp-toolbelt/wiki/Get-Image) - Find a featured image for posts that do not have one assigned.
* [Heading Anchors](https://github.com/BinaryMoon/wp-toolbelt/wiki/Heading-Anchor) - Add anchor names to headings so that they can be linked to.
* [Iframe Privacy Shield](https://github.com/BinaryMoon/wp-toolbelt/wiki/Iframe-Privacy-Shield) - Remove iframes and add a clickable screen so that they load when the user wants to see them.
* [Infinite Scroll](https://github.com/BinaryMoon/wp-toolbelt/wiki/Infinite-Scroll)
* [Jetpack Dev Mode](https://github.com/BinaryMoon/wp-toolbelt/wiki/Jetpack-Dev-Mode) - Disable Jetpacks connection so that only local functions are enabled.
* [Lazy Loading](https://github.com/BinaryMoon/wp-toolbelt/wiki/Lazy-Loading)
* [Layout Grid](https://github.com/BinaryMoon/wp-toolbelt/wiki/Layout-Grid) - A nicer columns block.
* [Markdown](https://github.com/BinaryMoon/wp-toolbelt/wiki/Markdown)
* [Monetization](https://github.com/BinaryMoon/wp-toolbelt/wiki/Monetization) - Enable Coil Web Monetization.
* [OEmbed](https://github.com/BinaryMoon/wp-toolbelt/wiki/OEmbed) - Add additional OEmbed providers.
* [Optimization](https://github.com/BinaryMoon/wp-toolbelt/wiki/Optimization) - Remove WordPress features that are rarely used.
* [Portfolio](https://github.com/BinaryMoon/wp-toolbelt/wiki/Portfolio) - Portfolio custom post type and blocks.
* [Post Category](https://github.com/BinaryMoon/wp-toolbelt/wiki/Post-Category) - A post category block.
* [Random Redirection](https://github.com/BinaryMoon/wp-toolbelt/wiki/Random-Redirect) - Randomly redirect to a blog post.
* [Related Posts](https://github.com/BinaryMoon/wp-toolbelt/wiki/Related-Posts)
* [Remove IP Addresses](https://github.com/BinaryMoon/wp-toolbelt/wiki/Remove-IP-Addresses) - Remove IP addresses from comments for user privacy (spam protection still works).
* [Responsive Videos](https://github.com/BinaryMoon/wp-toolbelt/wiki/Responsive-Videos)
* [Search Redirect](https://github.com/BinaryMoon/wp-toolbelt/wiki/Search-Redirect) - If there's a single search result redirect to it instead of displaying the restuls.
* [Sitemap](https://github.com/BinaryMoon/wp-toolbelt/wiki/Simple-Sitemap) - Sitemap block.
* [Slider](https://github.com/BinaryMoon/wp-toolbelt/wiki/Simple-Slider) - JavaScript free CSS slider block.
* [Social Menu](https://github.com/BinaryMoon/wp-toolbelt/wiki/Social-Menu) - Replace social links with icons in navigation blocks.
* [Spam Blocker](https://github.com/BinaryMoon/wp-toolbelt/wiki/Spam-Blocker) - Privacy focused spam blocker.
* [Static Social Sharing](https://github.com/BinaryMoon/wp-toolbelt/wiki/Static-Social-Sharing) - Link to social sharing pages, and don't load social network content on your site.
* [Stats](https://github.com/BinaryMoon/wp-toolbelt/wiki/Stats) - Enable privacy focused analytics providers like Fathom.
* [Testimonials](https://github.com/BinaryMoon/wp-toolbelt/wiki/Testimonials) - Testimonials Custom post types and blocks.
* [Tidy Notifications](https://github.com/BinaryMoon/wp-toolbelt/wiki/Tidy-Notifications) - Move plugin and theme notifications to a sidebar.
* [Typographic Widows](https://github.com/BinaryMoon/wp-toolbelt/wiki/Typographic-Widows) - Remove widows in post titles.
* [Widget Display](https://github.com/BinaryMoon/wp-toolbelt/wiki/Widget-Display) - Set rules for widget visibility.

## Thanks!

This plugin is heavily inspired by the [Jetpack](https://github.com/automattic/jetpack) and [Machete](https://github.com/nilovelez/machete/) plugins. A lot of the modules use code from these plugins as starting points.
