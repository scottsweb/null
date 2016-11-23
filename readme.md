![null logo](http://cloud.scott.ee/images/null.png)

# null

* Status: ✖ Inactive
* Contributors: [@scottsweb](http://twitter.com/scottsweb)
* Theme Name: null
* Theme URI: [http://null.scott.ee](http://null.scott.ee)
* Description: null: the tinkerers framework, a HTML5 WordPress starter theme & parent theme
* Author: [Scott Evans](http://scott.ee)
* Author URI: [http://scott.ee](http://scott.ee)
* License: GNU General Public License v2.0
* License URI: [http://www.gnu.org/licenses/gpl-2.0.html](http://www.gnu.org/licenses/gpl-2.0.html)
* Text Domain: null

## About

null is a tinkerers framework with ambitions to be the smartest, fastest and simplest way to build WordPress themes.

null provides a platform for both rapid prototyping and production sites and can be used as either a starter theme or parent theme, the choice is yours!

Things you will love:

* HTML5 - Based on the great work of the <a href="http://html5boilerplate.com/">HTML5 Boilerplate</a>.
* Theme Options - Easily create and customise the default theme options thanks to the <a href="https://github.com/devinsays/options-framework-theme">Theme Options Framework</a>.
* Drop In Widgets, Shortcodes and Post Types - Easily bundle extra functionality with your theme. We include a few to get you started.
* WordPress Setup - After activation of the theme you can choose to setup WordPress with a great set default settings, rewrite rules and htaccess trickery.
* LESS - <a href="http://lesscss.org/">A better way to write CSS</a>. All LESS files are automagically parsed and cached, no extra software required.
* Semantic, responsive grid systems - null makes use of <a href="http://semantic.gs/">semantic.gs</a>.


## Installation

To install this theme:

1. Login to your wp-admin area and visit "Appearance -> Themes". Select the "Install Themes" tab and click on the Upload link at the top of the page. Browse to the null .zip file you have downloaded and hit the "Install Now" button.
1. Alternatively you can unzip the theme folder (.zip). Then, via FTP, upload the "null" folder to your server and place it in the /wp-content/themes/ directory.
1. Login to your wp-admin and visit "Appearance -> Themes". Now click on the null theme to activate it.
1. After activation you will be given the option to setup WordPress with a number of default settings. This is an optional step and should **not** be run if you have already setup WordPress how you like it.
1. Visit "Appearance -> Theme Options" and configure the theme options to your liking.

## Frequently Asked Questions

### Which Open Source projects does null make use of?

Credits go to:

* [Options Framework Theme](https://github.com/devinsays/options-framework-theme) - for simpler theme options.
* [HTML5 Boilerplate](http://html5boilerplate.com) - for many interesting ideas and HTML5 guidance.
* [jQuery & jQuery UI](http://jquery.com) - for making javascript bearable.
* [CSS3 Pie](http://css3pie.com) - for bringing IE upto speed with new CSS features.
* [Selectivizer](http://selectivizr.com) - for making IE understand more advanced CSS selectors.
* [PHPAB](http://phpabtest.com) - for a neat AB testing solution.
* [LESS](http://lesscss.org/) - for smart CSS and quick prototyping.
* [jQuery.HTML5FORM](http://www.matiasmancini.com.ar/jquery-plugin-ajax-form-validation-html5.html) - for making all browsers support HTML5 forms.
* [imgSizer](http://unstoppablerobotninja.com/entry/fluid-images/) - for fluid images in IE.
* [Semantic grid system](http://semantic.gs/) - for fluid, semantic and lovely grids.
* [WP-Less](https://github.com/sanchothefat/wp-less) - for the smart parsing of LESS in WordPress.
* [lessphp](http://leafo.net/lessphp/) - for parsing LESS files automagically.
* [Class admin menu](https://gist.github.com/792b7aa5b695d1092520) - for making it easy to customise WordPress menus.
* [Holmes CSS](https://github.com/redroot/holmes) - for visual markup debugging.
* [Modernizr](http://www.modernizr.com/) - for all sorts of browser shinanigans.
* [TGM Plugin Activation](http://tgmpluginactivation.com/) - The best way to require plugins for WordPress themes

I will do my best to keep this updated as the framework develops - please let me know if I have missed you out.

### Is there a child starter theme available?

Yes. It is called [null-child](https://github.com/scottsweb/null-child).

### What browsers does null support?

Currently null supports IE6+ and all modern browsers. By the time 1.0 launches support for IE6 and IE7 will most likely be removed.

### Does null pass [Theme-Check](http://wordpress.org/extend/plugins/theme-check/)?
Not at the moment but it is close. Most of the errors and warnings are fairly minor. The plan is to improve this over time.

### Contributing

Please submit all bugs, questions and suggestions to the [GitHub Issues](https://github.com/scottsweb/null/issues) queue.

## Changelog

#### 1.0
* IMPORTANT. Removed LESS compiler. You will need a [standalone plugin](https://github.com/roborourke/wp-less) for this now
* IMPORTANT. Removed ACF. You will need a [standalone version of ACF](https://www.advancedcustomfields.com/) now
* Options framework latest
* WordPress 4.0+ fixes
* Loads of other fixes and tweaks - see commit history

So this marks an end to the development of null. I am not doing much theme development these days so this feels like a good chance to wrap it up. If I was to put more time towards developing it there are still lots of improvements to be made, some things on my wish list included:

* Switching from LESS, perhaps use [Jetpack for compilation of styles](https://kovshenin.com/2014/color-options-vs-decisions/)
* Removing .htaccess changes and relying on [plugins instead](https://github.com/roots/wp-h5bp-htaccess/)
* Reduce the number of template files in the parent theme to make child theming simpler
* Introduce some basic styles for post formats and make the default theme a touch nicer to look at
* Add support for [RSS to the Windows tile spec](http://www.buildmypinnedsite.com/) and [shortcuts to the jumplist](https://msdn.microsoft.com/en-us/library/gg491725(v=vs.85).aspx) based on the navigation
* Provide an example home.php template for an interesting blog landing page
* Move more theme options to [the customiser](https://aristath.github.io/kirki/)
* Improve [theme accessibility](https://poststatus.com/how-to-create-accessible-wordpress-themes/)
* Continue to remove polyfills and third party code. Move post types and widgets out of theme
* Improve the gallery shortcode
* Building virtual page templates and grids for use on pages and custom post types

#### 1.0-beta2
* Fix notice is class-admin-menu.php
* Update options framework to 1.6
* Clean transients daily
* Move product post type to [null-child](https://github.com/scottsweb/null-child)
* Add Google fonts to options framework typography option
* Remove WP App Store
* Replace a handful of the_title() calls with the_title_attribute()
* Remove all references to hgroup as it is no longer valid HTML5
* Add filter so child themes can play with content_width
* Set depth on WordPress menus
* Change sidebar registration to use array keys
* Do not cache menus (bad idea)
* Options framework 1.7.1
* Theme supports HTML5
* ACF 4.3.2
* WordPress 3.8 testing, dash icons and visual tweaks
* Add composer.json
* A few other minor things (see commit history)

#### 1.0-beta
* Updated option framework to be compatible with new media uploader
* New settings for Windows 8 pinned sites
* Disabling comments now removes the comments menu
* Updated Google Map shortcode due to changes in the Google API
* Flush rewrite rules when saving theme options and altering the registered post types
* Placeholder text is faded out on focus to improve usability (WebKit)
* Use a hash of the settings to cache bust the CSS - better save performance using theme customiser
* Filter for child themes to adjust cache bust variable and pass it into LESS to cache bust CSS images (handy for WPEngine)
* Allow extension folders (widgets, post types, shortcodes) to be empty
* Advanced Custom Fields 4.1.5.1 and an option to disable/unload in theme options
* [Theme Hook Alliance Compatibility](https://github.com/zamoose/themehookalliance)
* Ensure of_get_option always has default options
* Tested against WordPress 3.6
* Remove last few instances create_function
* Use core jQuery UI
* Updated jQuery UI tabs/accordion shortcode due to changes in the API
* Fix to header meta/RSS options
* Remove performance options in favour of plugins
* New static map shortcode [smap center="loc" size="WxH" zoom="14"]
* New function null_mustache_tags() for passing variables in theme options
* Filter for null_mustache_tags - register your own replacements
* Remove table of contents code - child theme or plugin territory
* Improvements to oEmebed (responsive container and options for default player colours and settings)
* Force TinyMCE editor styles to refresh
* Use editor styles when null is not used as a parent theme
* Move null_less_vars to functions so variables are available in admin (for editor styles) and theme
* Add TinyMCE classes drop down menu to the kitchen sink
* Validate URLs within theme options
* Remove the twitter widget due to twitter API changes
* Remove related posts shortcode as it is not particularly useful and not a good approach
* Add shortcode interface for TinyMCE
* Remove QR shortcode as QR codes are 99% useless
* Move less important shortcodes to [null-child](https://github.com/scottsweb/null-child)
* New social profiles widget

#### 0.99
* Option (on by default) to encode email address in the content editor (tinymce)
* Update retina media queries
* Update Ligature Symbols
* Fix small issue when child theme unsets custom header/background settings
* Update some incorrect uses of site_url() for home_url()
* Fixed Undefined index: WP_Widget_Recent_Comments in theme.php on line 169 when recent comments widget is disabled
* WP App Store now bundled with the framework with option to unload
* Bundled ACF lite when plugin is not available
* No longer require any third party plugins (the nag has been removed), more plugins are recommended as compatible
* Plugin compatibility layer added to better support third party plugins
* Only include the comments_template() when comments are enabled
* Update jQuery UI to 1.10.1
* Update language mo/po files in both null and null-child
* A few more functions can now be overwritten by the child theme
* Added filter (null_excerpt) for excerpt more text - one filter will change all occurrences
* Moved wp_footer() to a more appropriate theme location within footer.php
* First and last classes on WordPress menus
* Update .htaccess rules
* A basic maintenance mode to allow working on your site in private
* Update function null_user_posts_count()

#### 0.98
* Moved IE specific styles into a LESS file for simplicity
* Track downloads and external links in analytics
* Fixed small bug with search post_class
* New deprecated functions file to handle code added to 3.5 and future code removals
* current_url() function to return the full URL of the current page
* Options framework updated to 1.4
* Font options added with Google Fonts API integration
* WordPress 3.5 compatibility
* Embed widget shortcode
* Removed IE6 polyfills - by the time v1.0 comes around all polyfills may be removed
* HiDPI theme image
* Improved compatibility with [null-child theme](https://github.com/scottsweb/null-child)

#### 0.97
* post_class classes moved away from the loops
* Minor bug fix on update script
* Tweak to remove attachment urls from inserted media

#### 0.96
* Automatic updating from Github

#### 0.95
* Uploaded to Github
