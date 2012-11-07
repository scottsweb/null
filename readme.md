![null logo](https://dl.dropbox.com/u/3019972/null.png)

# null

* Contributors: [@scottsweb](http://twitter.com/scottsweb)
* Theme Name: null
* Theme URI: [http://scott.ee](http://scott.ee)
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
* [Superfish](http://users.tpg.com.au/j_birch/plugins/superfish/) - for making multi-level menus work on all browsers.
*  [TGM Plugin Activation](http://tgmpluginactivation.com/) - The best way to require plugins for WordPress themes

I will do my best to keep this updated as the framework develops - please let me know if I have missed you out.

### Do you have any documentation?

No yet, but it is planned for version 1.0. When using null as a parent theme there are plenty of hooks and filters to make use of which we need to document, in the meantime browse the code (it is very well commented).

### What are your plans for future versions?

A roadmap of sorts can be found at the top of the functions.php file. Some of the more ambitious features I hope to add at some point include:

* Automatic minification of JavaScript
* Building virtual page templates and grids for use on pages and custom post types
* Improved typographic control
* Further integration with the WordPress theme customiser
* Automatic updates via GitHub

### Is there a child starter theme available?

One is in development. It is called null-child.

### What browsers does null support?

Currently null supports IE6+ and all modern browsers. By the time 1.0 launches support for IE6 and IE7 will most likely be removed.

### Does null pass [Theme-Check](http://wordpress.org/extend/plugins/theme-check/)?
Not at the moment. It may never pass as we require the use of file_put_contents to write the compiled LESS files to the cache folder. The theme-check is also currently not checking .less files for required styles. Most of the errors and warnings are fairly minor. The plan is to improve this over time.

### Contributing 

Please submit all bugs, questions and suggestions to the [GitHub Issues](https://github.com/scottsweb/null/issues) queue.


## Changelog

#### 0.95
* Upload to Github
