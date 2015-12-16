<?php
/*
Plugin Name: WP Nav Menu Cache
Description: Create cache for dynamically generated navigation menu HTML and serve from a static file. It reduces some MySQL queries and increases page loading speed. 
Plugin URI: http://onetarek.com/my-wordpress-plugins/wp-nav-menu-cache/
Author: oneTarek
Author URI: http://onetarek.com
Version: 1.2
*/


if(!class_exists('WP_Nav_Menu_Cache')): 
	class WP_Nav_Menu_Cache{
		
		public $settings; // WeDevs_Settings_API object
		private $_cache_dir; //string of dir path with forward slash
		 
		public function __construct(){
			
				$upload_dir = wp_upload_dir();
				$this->_cache_dir = $upload_dir['basedir']."/cached_menu/";
				
				if(!file_exists($this->_cache_dir))
				{
					mkdir($this->_cache_dir);
				}
			
			//action and filters
			add_filter("pre_wp_nav_menu", array($this, "return_cached_menu"), 100,2);

			add_filter("wp_nav_menu", array($this, "save_cached_nav_menu"), 100, 2);
			add_action("wp_update_nav_menu", array($this, "update_cached_nav_menu"), 100, 1);
			//add_action("wp_update_nav_menu_item", "update_cached_nav_menu", 10, 1);
		}
		
		/**
		  *Returns filename of cached filename based on given args
		  *@param $args object
		  	$args is an object
			$args->menu  
			defined by user in theme file
			is (string) (optional) The menu that is desired; accepts (matching in order) id, slug, name . Default: None 
			when user gave blank or by default none then this function receives 
			*** $args->menu is blank
			but with wp_nav_menu filter 
			*** $args->menu is an object of WP_Term
			*** we can not use $args->menu objet data here, because pre_wp_nav_menu filter does not pass this object to detect the file name.
		  */		
			
		private function _get_filename_from_arg($args){
		
			$menu = "";
			$menu_name="menu_first";
			
			if(!is_object($args->menu)){ //when user gave blank or by default none then this function receives $args->menu is an object of WP_Term
			$menu=$args->menu;	
			}
			
			// Get the nav menu based on the requested menu.
			if($menu !="")
			{
			$menu_name="menu_".$args->menu;
			}
			// Get the nav menu based on the theme_location
			elseif($args->theme_location !="")
			{
			$menu_name="menu_".$args->theme_location;	
			}
			
			$filename=$this->_cache_dir.$menu_name.".html";
			return $filename;	
		
		}
		
		/**
		  *Returns menu data from saved file
		  *@param $nav_menu string|null  Nav menu output to short-circuit with. Default null.
		  *@param $args object		  
		 **/
		
		public function return_cached_menu($nav_menu, $args ){
	
		//write_log ( 'return_cached_menu' );
		//write_log ( $args );
			
			$file = $this->_get_filename_from_arg($args);
			
			if($file === false) {return $nav_menu;}
			
			if(!file_exists($file)){ return $nav_menu;}
			$fp=fopen($file,"r");
			$nav_menu=fread($fp,filesize($file));
			fclose($fp);
			return $nav_menu;
			
		}	


		
		/**
		  *Save nave menu data to file
		  *@param $nav_menu string
		  *@param $arrgs object
		**/	
		
		public function save_cached_nav_menu($nav_menu,$args){
		
		
		//write_log ( 'save_cached_nav_menu' );
		//write_log ( $args );
			
			$file = $this->_get_filename_from_arg($args);
			
			if($file === false) {return $nav_menu;}
			
			$fp=fopen($file, "w");
			fwrite($fp, $nav_menu);
			fclose($fp);
			return $nav_menu;
		}	
	
		/**
		 *Delete all cached file
		 **/

		public function update_cached_nav_menu(){
			//write_log ( "update_cached_nav_menu called" );
				$dir=$this->_cache_dir;	
				if(file_exists($dir))
				{
					$files = glob($dir."/*"); // get all file names
					foreach($files as $file){ // iterate files
					if(is_file($file))
					unlink($file); // delete file
					}
				}
		}	
	
	
	}// end class


endif;

$WP_Nav_Menu_Cache = new WP_Nav_Menu_Cache();



?>