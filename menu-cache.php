<?php
/*
Plugin Name: WP Nav Menu Cache
Description: Create cache for dynamically generated navigation menu HTML and serve from a static file. It reduces some MySQL queries and increases page loading speed. 
Plugin URI: http://onetarek.com/my-wordpress-plugins/wp-nav-menu-cache/
Author: oneTarek
Author URI: http://onetarek.com
Version: 2.2
*/


require_once dirname( __FILE__ ) . '/option-page.php';

if(!class_exists('WP_Nav_Menu_Cache')): 
	class WP_Nav_Menu_Cache{
		
		private $_cache_dir; //string of dir path with forward slash
		public  $options;
		 
		public function __construct(){
			
				$upload_dir = wp_upload_dir();
				$this->_cache_dir = $upload_dir['basedir']."/cached_menu/";
				
				if(!file_exists($this->_cache_dir))
				{
					mkdir($this->_cache_dir);
				}
			$this->options =  get_option('wp_nav_menu_cache');
			//action and filters
			add_filter("pre_wp_nav_menu", array($this, "return_cached_menu"), 100,2);

			add_filter("wp_nav_menu", array($this, "save_menu"), 100, 2);
			add_action("wp_update_nav_menu", array($this, "update_cached_nav_menu"), 100, 1);
			//add_action("wp_update_nav_menu_item", "update_cached_nav_menu", 10, 1);
			
			register_activation_hook( __FILE__, array( $this, 'plugin_activate' ) );
		}
		
		/**
		  *Determines and Returns file path of cached file based on given args
		  *@param $args object
		  	$args is an object
			$args has a property $menu , it store different type of data based on when, where and by whom it is assigned.
			$args->menu value is Assigned by 
				1. User in theme file
					is (string) (optional) The menu that is desired; accepts (matching in order) id, slug, name . Default: None 
				2. Custom Menus widget function
				
				
			We receive Value of $args->menu different in called filter
				IN FUNCTION return_cached_menu IN CALL OF pre_wp_nav_menu FILTER
				1. BLANK - When user gave blank or by default none IN function wp_nav_menu() 
				2. STRING - (id, slug, name) When user gave IN function wp_nav_menu() 
				3. OBJECT of WP_Term - When menu is calld by Custom Menu widget
				
				IN FUNCTION save_menu IN CALL OF wp_nav_menu FILTER
				1. OBJECT of WP_Term - When user gave blank or by default none IN function wp_nav_menu()  
				2. STRING - (id, slug, name) When user gave IN function wp_nav_menu() 
				3. OBJECT of WP_Term - When menu is calld by Custom Menu widget
			
			    MENU OBJECT
				[menu] => WP_Term Object
					(
						[term_id] => 2
						[name] => Menu 1
						[slug] => menu-1
						[term_group] => 0
						[term_taxonomy_id] => 2
						[taxonomy] => nav_menu
						[description] => 
						[parent] => 0
						[count] => 4
						[filter] => raw
					)	 

			*** we can not use $args->menu objet data here, because pre_wp_nav_menu filter does not pass this object to detect the file name.
		  */		
			
		private function _get_cached_file_path($args){
			
			#check the theme location is excluded or not 
			if($args->theme_location !="" && isset($this->options['exclude_theme_locations'][$args->theme_location])){ 
			return false;
			}
			
			$menu_id_slug_name="";
			#check $args->menu is object or string
			if(is_object($args->menu))
			{
				#take menu id from object
				$menu_id_slug_name=$args->menu->term_id;
				
				#meke the object to blank string
				$args->menu="";
			
			}
			else
			{
				$menu_id_slug_name=$args->menu;
			}
			
			#if we get $menu_id_slug_name , check is that excluded
			#in optoins excluded memu item strored id , slug and name all together seperated by pipe(|) AS array key and value.  "id|slug|name" = > "id|slug|name"
			if($menu_id_slug_name != "" && isset($this->options['exclude_menus']) && is_array($this->options['exclude_menus']))
			{
				$exclude_menus=$this->options['exclude_menus'];
				foreach($exclude_menus as $key=>$val){
					$ar=explode("|", $key);
					if($ar[0] == $menu_id_slug_name ) return false;
					if($ar[1] == $menu_id_slug_name ) return false;
					if($ar[2] == $menu_id_slug_name ) return false;
				}
			}
			
			#make the filename based on $args
			#chek we want different cache file for different page
			if(isset($this->options['individual_url']) && $this->options['individual_url']=='on')
			{
				$filename = md5( $_SERVER['REQUEST_URI'] . var_export( $args, true ) );
			}
			else
			{
				$filename = md5( var_export( $args, true ) );
			}
									
			return $this->_cache_dir.$filename.".html";
			
		
		}
		
		/**
		  *Returns menu data from saved file
		  *@param $nav_menu string|null  Nav menu output to short-circuit with. Default null.
		  *@param $args object		  
		 **/
		
		public function return_cached_menu($nav_menu, $args ){
			
			$file = $this->_get_cached_file_path($args);
			
			if($file === false) {return $nav_menu;}
			
			if(!file_exists($file)){ return $nav_menu;}
			$fp=fopen($file,"r");
			$nav_menu=fread($fp,filesize($file));
			fclose($fp);
			return $nav_menu;
			
		}	


		
		/**
		  *Save nav menu data to file
		  *@param $nav_menu string
		  *@param $arrgs object
		**/	
		
		public function save_menu($nav_menu,$args){
			
			$file = $this->_get_cached_file_path($args);
			if($file === false) {return $nav_menu;}
			$fp=fopen($file, "w");
			fwrite($fp, "\n<!--Start Nav Menu Served by WP Nav Menu Cache-->\n".$nav_menu."\n<!--End Nav Menu Served by WP Nav Menu Cache-->\n");
			fclose($fp);
			return $nav_menu;
		}	
		
		public function update_cached_nav_menu(){
			$this->delete_cached_files();		
		}
		/**
		 *Delete all cached file
		 **/

		public function delete_cached_files(){
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
		
		public function plugin_activate(){
			$this->delete_cached_files();	
		}	
	
	
	}// end class


endif;

$WP_Nav_Menu_Cache = new WP_Nav_Menu_Cache(); //do not rename this var $WP_Nav_Menu_Cache. it is being used in option page.
