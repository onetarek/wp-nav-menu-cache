=== WP Nav Menu Cache ===
Contributors: onetarek
Tags: cache, caching, performance, web performance optimization, wp-cache, page speed, quick cache, cache dynamic menu, navigation menu, wp nav menu, reduce query, static menu, wordpress optimization tool
Requires at least: 3.8.0
Tested up to: 4.1.2
Stable tag: 1.1
License: GPLv2+
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Create cache for dynamically generated navigation menu HTML and serve from a static file. It reduces some MySQL queries and increases page speed.

== Description ==

"**[WP Nav Menu Cache](http://onetarek.com/my-wordpress-plugins/wp-nav-menu-cache/)**" plugin help you to make your WordPress dynamic navigation menu to a static menu. For each page visit WordPress run some MySQL query and complex PHP codes to generate navigation menu that you are using on front-end. Your menu content is not being changed until you change that manually. So why do you need to use your server resource on every page visit to generate a menu? This plugin saves your dynamic menus into some separate static HTML files. When you add, edit or remove any menu item using dashboard then this plugin update its cached files. When a menu is called from website front-end then this plugin stops WordPress to generate that newly and serve from the previous saved static file.This process reduces some MySQL query , saves your server resource and increases page speed.


== Installation ==

= Modern Way: =
1. Go to the WordPress Dashboard "Plugin" section.
2. Search For "WP Nav Menu Cache". 
3. Install, then Activate it.

= Old Way: =
1. Upload the `wp-nav-menu-cache` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress.


= How To Use WP Nav Menu Cache: =
Just install and activate.This plugin does not have any settings page, so nothing to see after installation. To see result see the usages of your server resource from your server control panel like cPanel.

== Changelog ==

= 1.1 =
* Drecrase priority of used filters

= 1.0 =
* Initial release


== Upgrade Notice ==

= 1.1 =
* Drecrase priority of used filters

= 1.0 =
* Initial release