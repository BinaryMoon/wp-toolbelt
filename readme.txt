=== Toolbelt ===
Contributors: BinaryMoon
Tags: speed, user experience, UX, optimization, related posts, social sharing, social menu
Requires at least: 5.0
Tested up to: 5.3
Stable tag: trunk
Requires PHP: 5.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Donate link: https://paypal.me/binarymoon

Utilities to make your website betterer.

== Description ==

A collection of simple addons that provide every day functionality with speed and elegance. There's no options, and no unnecessary filler. It does exactly what it needs to do and nothing else.

Taking inspiration from Jetpack I want to rebuild the features I use the most and make them as simple and fast as possible.

= Features =

* [Breadcrumbs](https://github.com/BinaryMoon/wp-toolbelt/wiki/Breadcrumbs)
* [Cookie Banner](https://github.com/BinaryMoon/wp-toolbelt/wiki/Cookie-Banner)
* [Disable Comment Urls](https://github.com/BinaryMoon/wp-toolbelt/wiki/Disable-Comment-Urls)
* [Fast 404](https://github.com/BinaryMoon/wp-toolbelt/wiki/Fast-404)
* [Featured Attachments](https://github.com/BinaryMoon/wp-toolbelt/wiki/Featured-Attachment)
* [Heading Anchors](https://github.com/BinaryMoon/wp-toolbelt/wiki/Heading-Anchor)
* [Lazy Loading](https://github.com/BinaryMoon/wp-toolbelt/wiki/Lazy-Loading)
* [Optimization](https://github.com/BinaryMoon/wp-toolbelt/wiki/Optimization)
* [Portfolio](https://github.com/BinaryMoon/wp-toolbelt/wiki/Portfolio)
* [Random Redirection](https://github.com/BinaryMoon/wp-toolbelt/wiki/Random-Redirect)
* [Related Posts](https://github.com/BinaryMoon/wp-toolbelt/wiki/Related-Posts)
* [Responsive Videos](https://github.com/BinaryMoon/wp-toolbelt/wiki/Responsive-Videos)
* [Social Menu](https://github.com/BinaryMoon/wp-toolbelt/wiki/Social-Menu)
* [Static Social Sharing](https://github.com/BinaryMoon/wp-toolbelt/wiki/Static-Social-Sharing)
* [Widget Display](https://github.com/BinaryMoon/wp-toolbelt/wiki/Widget-Display)

= Fast =

I want it to be fast. I want to be able to enable any of the features and not have my Google Pagespeed score drop. To be fast it:

* Doesn't use jQuery or any other javascript framework. All javascript is vanilla js, and minified.
* Minifies all assets (JS and CSS)
* Loads all assets inline. They are already small, and loading them directly on the page means there are no server requests.
* Only loads things when they are needed. JS and CSS are only loaded for activated modules.
* No options. There's only one database option, and that's an array that stores what modules are active.
* Uses the minimum code possible. Minimum Javascript and PHP. Less code means more speed, and fewer bugs.
* All options are disabled by default. You enable just the ones you need.

= Private =

To ensure the plugin is as privacy focused as possible it:

* Does not phone out. No data is shared with third parties.
* Does not use standard social sharing javascripts (loaded from social networks servers).
* Does not track your usage of the plugin.
* Does not add generator comments, or secret comments to your site html.

= More... =

* The code can be found on [Github](https://github.com/BinaryMoon/wp-toolbelt)
* Documentation with code examples can be found on [the wiki](https://github.com/BinaryMoon/wp-toolbelt/wiki)
* You can reach out to me with questions or problems on [Twitter](https://twitter.com/binarymoon)

== FAQ ==

= Why one plugin and not separate plugins? =

I am making this because it's something I want to use. I like the simplicity of installing Jetpack and letting it do it's thing. But it's not designed for speed or elegance, so I am trying to address that with my own plugin.

I am making the theme as developer friendly as I can. Things can be tweaked using WordPress filters, and I will add more of these as I go.

= Do you have any documentation? =

The [docs are on Github](https://github.com/BinaryMoon/wp-toolbelt/wiki). They are a constant work in progress.

= Can I contribute/ report a problem? =

Yes please! You can [submit issues](https://github.com/BinaryMoon/wp-toolbelt/issues) on Github or add questions to the support forum. I'd be happy to accept pull requests as well.

= What features will you add next? =

I don't know. I'm open to suggestions (ping me on Twitter), but I'll probably just add things as I need them.

== Installation ==

1. Install and Activate the plugin through the plugins page.
2. Done. Everything else is setup automatically.

== Changelog ==

= 2.0 - 16th September 2019 =
* Update page weight numbers.
* Add tools link to active modules on module settings page.
* Add related posts 'clear cache' tool.

= 1.9.1 - 16th September 2019 =
* Fix settings table filters.

= 1.9 - 16th September 2019 =
* Add module filtering to settings page.
* Flush rewrite rules on settings change.
* Add an expiry time for transients so they aren't autoloaded, and so that the cache will be cleared.
* Lots and lots of coding standards fixes. The code should be a lot more reilient now.
* Delete autoloaded related posts transients. This may be causing some slow down/ high memory usage. Update the plugin and visit the module settings to clear the old transients.

= 1.8.1 - 12th September 2019 =
* Tweak the cookie banner font sizes so they can be changed from a single place.
* Add filter for breadcrumbs that allows you to easily disable them.

= 1.8 - 10th September 2019 =
* Add widget display module. This is an early version and subject to change.
* Add infinite scroll module.
* Lots of tidying up coding standards and functionality. Thanks to Viktor Szépe for help here!
* Add missing page weight values.
* Fix incorrect text domains.
* Add pot file for simpler translations.
* Ensure cookie bar is hidden if cookies are accepted.
* Make use of travis build system to ensure good code.
* Add tools link to plugin page.
* Make heading anchors always show on touch devices.

= 1.7.1 - 4th September 2019 =
* Remove test function that makes social sharing buttons display on every page.

= 1.7 - 4th September 2019 =
* Add extra filters for enabling and disabling social sharing on different post types, or with different conditions.
* Change the social sharing options so they only display on blog posts and projects by default.
* Add Text Domain
* Make cookie banner text filterable.
* Don't display social sharing buttons if no url can be found.
* Generate social sharing url from $_SERVER properties if the permalink does not exist for some reason. Also escapes the social sharing url to be sure it's safe.

= 1.6.2 - 3rd September 2019 =
* Fix issue with heading anchors escaping output, which may break other html that has been inserted with filters.

= 1.6.1 - 3rd September 2019 =
* Remove console.log
* Make cookie js work better with older cookies.

= 1.6 - 2nd September 2019 =
* Add new module that disables urls in comment forms.
* Add new module that speeds up 404 pages for static files.
* Add additional features to the cleanup module.
* Change heading anchor priority so that heading anchors get added before other modules that may introduce heading elements.
* Tweak module CSS to improve theme compatability.

= 1.5 - 31st August 2019 =
* Add support for responsive videos.
* Add heading anchor module. This adds anchors to headings in the post/ page, for easy deep linking.
* Add a random redirect module. It allows you to randomly link to a blog post.
* Make the social sharing links load a little later so they stay at the end of the post.

= 1.4 - 29th August 2019 =
* Fix cookie notification padding.
* Call a function when cookies are accepted. We can use an action to output the code this is executed. This allows us to add tracking codes.

= 1.3 - 28th August 2019 =
* Add lazy loading to iframes and avatars as well as post content images.
* Add featured image from attachment module. Reduces the liklihood of missing featured images.
* Improve the settings screen on small screens. You now have the option to see the description and page weight on mobile.

= 1.2 - 26th August 2019 =
* Add a css custom property for setting the spacing in the css. `--toolbelt-spacing`. Change the value in your css to tweak the margins and padding used.
* Include the module css using a single function. This allows the styles to be disabled per module, or globally, without littering the code with filters and conditions.
* Add basic css for breadcrumb styles

= 1.1.2 - 25th August 2019 =
* Improve related posts. Previously the category restriction wasn't working properly. It is now! Results should be more accurate.
* Don't create portfolio post type if jetpack portfolio exists.
* Make sure related posts return the cache even if the posts are empty (ie if there's only 1 post in the category)
* Allow the admin to be disabled with a constant 'TOOLBELT_DISABLE_ADMIN'

= 1.1.1 - 24th August 2019 =
* Ensure the related posts cache is cleared so that the portfolio related posts work properly.

= 1.1 - 23nd August 2019 =
* Add filter for disabling related posts within a theme, and a function for echoing related posts wherever you like.
* Add svg icons for social links.
* Display the page impact of each module on the settings page.
* Add social links menu.
* Ensure related posts exist.
* Allow related posts to work with other post types.
* Add related posts to toolbelt portfolio post type (when it is enabled).
* Add a tool for converting Jetpack portfolio items to Toolbelt portfolio items.

= 1.0 - 20th August 2019 =
* Initial Release
