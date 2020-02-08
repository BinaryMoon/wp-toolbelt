=== Toolbelt ===
Contributors: BinaryMoon
Tags: privacy, accessibility, related posts, social sharing, social menu, social-sharing, spam blocking, cookie banner, widget display, markdown, blocks
Requires at least: 5.0
Tested up to: 5.3
Stable tag: trunk
Requires PHP: 5.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Donate link: https://paypal.me/binarymoon

Fast, privacy focused, utilities to improve your website. Includes a Markdown block, spam protection, related posts, cookie banner, and more.

== Description ==

A collection of simple addons that provide every day functionality with privacy and speed. There's very few options, and no unnecessary filler. It does exactly what it needs to do and nothing else.

Toolbelt takes a privacy first approach to adding features. Everything happens on your server. No data is sent to third party servers without your explicit consent. No data is loaded from third parties (for example social sharing scripts).

Taking inspiration from Jetpack I want to rebuild the features I use the most and make them as simple and fast as possible.

Toolbelt has been featured on The WordPress Tavern in [an interview with me](https://wptavern.com/toolbelt-a-new-jetpack-inspired-plugin-with-a-focus-on-speed-and-privacy). You can read more about the creation of the plugin and my desire for a more private internet.

= Gutenberg Blocks =

Some of the Toolbelt modules include blocks to make working with the generated content easier. The available blocks are:

* **Contact Form** - The simplest way to have people get in touch. Works with the spam module.
* **Projects Grid** - to list a collection of projects. These can be filtered by project category.
* **Testimonials Grid** - to list a group of testimonials. Great for showing off! :)
* **Markdown** - for those who like a simpler writing experience.

= All Features =

Toolbelt has a lot of features. The complete list is below.

* [Admin Tweaks](https://github.com/BinaryMoon/wp-toolbelt/wiki/Admin-Tweaks)
* [Breadcrumbs](https://github.com/BinaryMoon/wp-toolbelt/wiki/Breadcrumbs)
* [Cookie Banner](https://github.com/BinaryMoon/wp-toolbelt/wiki/Cookie-Banner)
* [Disable Comment Urls](https://github.com/BinaryMoon/wp-toolbelt/wiki/Disable-Comment-Urls)
* [Fast 404](https://github.com/BinaryMoon/wp-toolbelt/wiki/Fast-404)
* [Featured Attachments](https://github.com/BinaryMoon/wp-toolbelt/wiki/Featured-Attachment)
* [Heading Anchors](https://github.com/BinaryMoon/wp-toolbelt/wiki/Heading-Anchor)
* [Infinite Scroll](https://github.com/BinaryMoon/wp-toolbelt/wiki/Infinite-Scroll)
* [Lazy Loading](https://github.com/BinaryMoon/wp-toolbelt/wiki/Lazy-Loading)
* [Monetization](https://github.com/BinaryMoon/wp-toolbelt/wiki/Monetization)
* [Optimization](https://github.com/BinaryMoon/wp-toolbelt/wiki/Optimization)
* [Portfolio](https://github.com/BinaryMoon/wp-toolbelt/wiki/Portfolio)
* [Random Redirection](https://github.com/BinaryMoon/wp-toolbelt/wiki/Random-Redirect)
* [Related Posts](https://github.com/BinaryMoon/wp-toolbelt/wiki/Related-Posts)
* [Responsive Videos](https://github.com/BinaryMoon/wp-toolbelt/wiki/Responsive-Videos)
* [Social Menu](https://github.com/BinaryMoon/wp-toolbelt/wiki/Social-Menu)
* [Spam Blocker](https://github.com/BinaryMoon/wp-toolbelt/wiki/Spam-Blocker)
* [Static Social Sharing](https://github.com/BinaryMoon/wp-toolbelt/wiki/Static-Social-Sharing)
* [Stats](https://github.com/BinaryMoon/wp-toolbelt/wiki/Stats)
* [Testimonials](https://github.com/BinaryMoon/wp-toolbelt/wiki/Testimonials)
* [Widget Display](https://github.com/BinaryMoon/wp-toolbelt/wiki/Widget-Display)

= Toolbelt is Private =

Every week there's a new story about Facebook tracking people inappropriately, or selling user details. Or some security breach that leaks users passwords or credit card info. Privacy is a big topic and frankly, it's scary how much big corporations like Google, Facebook, and Twitter know.

To ensure Toolbelt is as privacy focused as possible it:

* Does not phone out. No data is shared with third parties.
* Does not use standard social sharing javascripts (loaded from social networks servers).
* Does not track your usage of the plugin.
* Does not add generator comments, or secret promotional comments to your site html.

= Toolbelt is Fast =

Slow websites make me sad. I don't want to add anything to Toolbelt that will impact site load speed. My Google Pagespeed score should not move from 100.

Why? Faster sites are shown to increase conversions and time on site. Google loves fast sites and improves their search rankings. In addition fast sites are great for places with slower internet, and use less resources to generate the page. So many benefits!

To be fast Toolbelt:

* Doesn't use jQuery or any other javascript framework. All javascript is vanilla js, and minified.
* Minifies all assets (JS and CSS)
* Loads all assets inline. They are already small, and loading them directly on the page means there are no server requests.
* Only loads things when they are needed. JS and CSS are only loaded for activated modules.
* Very few options. There's one main database option, an array that stores what modules are active. And another that stores settings for some modules.
* Uses the minimum code possible. Minimum Javascript and PHP. Less code means more speed, and fewer bugs.
* All options are disabled by default. You enable only the ones you need.

= Built for developers =

Toolbelt is built with developers in mind. It has a collection of hooks and filters to enable you to make the modules work the way you want. If you’re intersted to jump in the project, there are opportunities for developers at all levels to help out. [Contribute to Toolbelt on GitHub](https://github.com/BinaryMoon/wp-toolbelt) and join the party. 🎉

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

= 2.5.2 - 8th February 2020 =
* Add a search results redirect if there's only a single result.
* Add additional cleanup rules for more speed!
* Only add css properties when a module is active thast supports them.

= 2.5.1 - 17th December 2019 =
* Fix infinite scroll button. It now hides when we get to the end of the content.
* Update blocklist.

= 2.5 - 14th December 2019 =
* Added a simple Gist block.
* Refactor widget visibility module. You may need to change your display rules. Check the documentation for more info. https://github.com/BinaryMoon/wp-toolbelt/wiki/Widget-Display
* Add new pagechild and 404 display rules to the widget visibility module.
* Add a contact form 'subject' field which we can use to override the default contact form subject.
* Add a custom post type for saving contact form submissions. The feedback gets deleted regularly so that we don't store user data unnecessarily.
* Add contact form custom subject line modifications.
* Stop sending contact form messages that get flagged as spam. They are still saved to the database and readable through the admin.
* Add fix for typographic widows.
* Add list and blockquote as internal block types for the contact form block.
* Ensure the contact form submit button stays in the right place! :)
* Fix issue with settings link appearing when it shouldn't.
* Fix: Only include contact form validation rules when there is a contact form on the page
* Make GDPR requirements of cookie banner clearer.
* Improve module selector design.
* Make the admin style tweaks show in the customizer (most important for the button improvements).
* Simplify portfolio and testimonial block code a little.
* Rename blacklist to blocklist. Language matters!


[Changelog for all versions](https://github.com/BinaryMoon/wp-toolbelt/blob/master/changelog.txt)
