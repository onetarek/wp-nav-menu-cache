# wp-nav-menu-cache
WordPress plugin to create cache for dynamically generated navigation menu HTML and serve from a static file. It reduces some MySQL queries and increases page speed.
#Download from WordPress.org 
https://wordpress.org/plugins/wp-nav-menu-cache/

#Description
"WP Nav Menu Cache" plugin help you to make your WordPress dynamic navigation menu to a static menu. For each page visit WordPress run some MySQL query and complex PHP codes to generate navigation menu that you are using on front-end. Your menu content is not being changed until you change that manually. So why do you need to use your server resource on every page visit to generate a menu? This plugin saves your dynamic menus into some separate static HTML files. When you add, edit or remove any menu item using dashboard then this plugin update its cached files. When a menu is called from website front-end then this plugin stops WordPress to generate that newly and serve from the previous saved static file.This process reduces some MySQL query , saves your server resource and increases page speed.

#Features
* Exclude any theme location from caching you don't want to cache any menu of
* Exclude any menu you don't want to cache
* Choose wheather this plugin will cache each menu individually for each post/page or any visited url.
