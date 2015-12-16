<?php
/*
Plugin Name: WP Nav Menu Cache
Description: Create cache for dynamically generated navigation menu HTML and serve from a static file. It reduces some MySQL queries and increases page loading speed. 
Plugin URI: http://onetarek.com/my-wordpress-plugins/wp-nav-menu-cache/
Author: oneTarek
Author URI: http://onetarek.com
Version: 1.1
*/


function cached_nav_dir()
{
	$upload_dir = wp_upload_dir();
	return $upload_dir['basedir']."/cached_menu";
}

add_filter("pre_wp_nav_menu", "return_cached_menu", 100,2);

function return_cached_menu($nav_menu, $args = array()){
	$menu_id=$args->menu;
	$menu_id = (int) $menu_id;
	
	$menu_name="menu_first";
	if($menu_id)
	{
	$menu_name="menu_".$menu_id;
	}
	// Get the nav menu based on the requested menu.
	elseif($args->menu !="")
	{
	$menu_name="menu_".$args->menu;
	}
	// Get the nav menu based on the theme_location
	elseif($args->theme_location !="")
	{
	$menu_name="menu_".$args->theme_location;	
	}
	
	$file=cached_nav_dir()."/".$menu_name.".html";
	if(!file_exists($file)){ return $nav_menu;}
	$fp=fopen($file,"r");
	$nav_menu=fread($fp,filesize($file));
	fclose($fp);
	return $nav_menu;
	
}

function update_cached_nav_menu(){
		$dir=cached_nav_dir();	
		if(file_exists($dir))
		{
			$files = glob($dir."/*"); // get all file names
			foreach($files as $file){ // iterate files
			if(is_file($file))
			unlink($file); // delete file
			}
		}
}

function save_cached_nav_menu($nav_menu,$args){
	$dir=cached_nav_dir();
	if(!file_exists($dir))
	{
		mkdir($dir);
	}
	
	$menu_id=$args->menu;
	$menu_id = (int) $menu_id;
	
	$menu_name="menu_first";
	if($menu_id)
	{
	$menu_name="menu_".$menu_id;
	}
	// Get the nav menu based on the requested menu
	elseif($args->menu !="")
	{
	$menu_name="menu_".$args->menu;
	}
	// Get the nav menu based on the theme_location
	elseif($args->theme_location !="")
	{
	$menu_name="menu_".$args->theme_location;	
	}
	
	$file=cached_nav_dir()."/".$menu_name.".html";
	$fp=fopen($file, "w");
	fwrite($fp, $nav_menu);
	fclose($fp);
	return $nav_menu;
}
add_filter("wp_nav_menu", "save_cached_nav_menu", 100, 2);
add_action("wp_update_nav_menu", "update_cached_nav_menu", 100, 1);
//add_action("wp_update_nav_menu_item", "update_cached_nav_menu", 10, 1);
?>