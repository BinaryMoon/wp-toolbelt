# WP Toolbelt

A lightweight plugin inspired by Jetpack but designed for speed, simplicity, and privacy.

## Speed?

Yep - it's super quick. To be fast it:

* Doesn't use jQuery or any other javascript framework. All javascript is vanilla js, and minified.
* Minifies all assets (JS and CSS)
* Loads all assets inline. They are already small, and loading them directly on the page means there are no server requests.
* Only loads things when they are needed. JS and CSS are only loaded for activated modules.
* No options. There's only one database option, and that's an array that stores what modules are active.
* Uses the minimum code possible. Minimum Javascript and PHP. Less code means more speed, and fewer bugs.
* All options are disabled by default. You enable just the ones you need.

## Privacy? GDPR?

To ensure the plugin is as private as possible it:

* Does not phone out. No data is shared with third parties.
* Does not use standard social sharing javascripts (loaded from social networks servers).
* Does not track your usage of the plugin.
* Does not add generator comments, or secret comments to your site html.

# Features

* Portfolio post type
* EU Cookie banner
* Social share buttons
* Breadcrumbs

# Thanks!

This plugin is heavily inspired by the [Jetpack](https://github.com/automattic/jetpack) and [Machete](https://github.com/nilovelez/machete/) plugins. A lot of the modules use code from these plugins as starting points.