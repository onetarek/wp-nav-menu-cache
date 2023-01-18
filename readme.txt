=== WP Nav Menu Cache ===
Contributors: onetarek
Donate link: http://wpadguru.com
Tags: cache, caching, performance, web performance optimization, wp-cache, page speed, quick cache, cache dynamic menu, navigation menu, wp nav menu, reduce query, static menu, wordpress optimization tool
Requires at least: 3.8.0
Tested up to: 6.1.1
Stable tag: 2.2
License: GPLv2+
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Create cache for dynamically generated navigation menu HTML and serve from a static file. It reduces some MySQL queries and increases page speed.

== Description ==

"**[WP Nav Menu Cache](http://onetarek.com/my-wordpress-plugins/wp-nav-menu-cache/)**" plugin help you to make your WordPress dynamic navigation menu to a static menu. For each page visit WordPress run some MySQL query and complex PHP codes to generate navigation menu that you are using on front-end. Your menu content is not being changed until you change that manually. So why do you need to use your server resource on every page visit to generate a menu? This plugin saves your dynamic menus into some separate static HTML files. When you add, edit or remove any menu item using dashboard then this plugin update its cached files. When a menu is called from website front-end then this plugin stops WordPress to generate that newly and serve from the previouly saved static file. This process reduces some MySQL query , saves your server resource and increases page speed.

= Features =
* Exclude any theme location from caching you don't want to cache any menu of
* Exclude any menu you don't want to cache
* Choose wheather this plugin will cache each menu individually for each post/page or any visited url.

== Installation ==

= Modern Way: =
1. Go to the WordPress Dashboard "Plugin" section.
2. Search For "WP Nav Menu Cache". 
3. Install, then Activate it.

= Old Way: =
1. Upload the `wp-nav-menu-cache` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress.


= How To Use WP Nav Menu Cache: =
Just Install and activate. So nothing to see after installation. To see result see the usages of your server resource from your server control panel like cPanel. For advance user this plugin has a settings page. Go to the settings page from dashboard->setting->WP Nav Menu Cache. Choose your options and save those.

== Screenshots ==

1. Settings Page

== Changelog ==
= 2.2 =
* No new change. Just update readme with tested up to WP 4.9.8

= 2.1 =
* Bug Fix: The option "Cache for Individual URL" was getting set automatically on some sites.

= 2.0 =
* Feature Added: A Settings page
* Feature Added: Exclude any theme location from caching you don't want to cache any menu of.
* Feature Added: Exclude any menu you don't want to cache.
* Feature Added: Choose wheather this plugin will cache each menu individually for each post/page or any visited url.
* Feature Added: Delete all cached menu files from setting page. 
* Feature Added: Delete all cached files on plugin activation.

= 1.1 =
* Drecrase priority of used filters

= 1.0 =
* Initial release


== Upgrade Notice ==
= 2.2 =
* No new change. Just update readme with tested up to WP 4.9.8

= 2.1 =
* Bug Fix: The option "Cache for Individual URL" was getting set automatically on some sites.

= 2.0 =
* New Feature Added: (1)A Settings page. (2)Exclude any theme location from caching you don't want to cache any menu of. (3)Exclude any menu you don't want to cache. (4)Feature Added: Choose wheather this plugin will cache each menu individually for each post/page or any visited url. (5)Delete all cached menu files from setting page. (6)Delete all cached files on plugin activation.

= 1.1 =
* Drecrase priority of used filters

= 1.0 =
* Initial release