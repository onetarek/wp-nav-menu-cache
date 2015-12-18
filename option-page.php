<?php
# admin page
require_once dirname( __FILE__ ) . '/class.settings-api.php';
#https://github.com/tareq1988/wordpress-settings-api-class
#http://tareq.co/2012/06/wordpress-settings-api-php-class/

if ( !class_exists('WP_Nav_Menu_Cache_Settings' ) ):
class WP_Nav_Menu_Cache_Settings {

    private $settings_api;

    function __construct() {
        $this->settings_api = new WeDevs_Settings_API;

        add_action( 'admin_init', array($this, 'admin_init') );
        add_action( 'admin_menu', array($this, 'admin_menu') );
    }

    function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    function admin_menu() {
        add_options_page( 'WP Nav Menu Cache', 'WP Nav Menu Cache', 'manage_options', 'wp_nav_menu_cache', array($this, 'plugin_page') );
    }

    function get_settings_sections() {
        $sections = array(
            array(
                'id' => 'wp_nav_menu_cache',
                'title' => '', //WP Nav Menu Cache Settings
				'desc' => ""
            ),
        );
        return $sections;
    }

    /**
     * Returns all the settings fields
     *
     * @return array settings fields
     */
    function get_settings_fields() {
		$locations = get_nav_menu_locations();
		
		/*
		$locations = Array
			(
				[location_name] = > currently_assigned_menu_id
				[primary] => 12
				[sidebar] => 2
				[footer] => 0
				
			)
		*/	
		//write_log($locations);
		$exclude_theme_locations_opt=array();
		foreach($locations as $key => $val){
			$exclude_theme_locations_opt[$key]=ucfirst($key);
		}
		
		// Get menus
		$menus = wp_get_nav_menus();
		//write_log($menus);
		$exclude_menus_opt=array();
		foreach($menus as $menu){
			$exclude_menus_opt[$menu->term_id."|".$menu->slug."|".$menu->name]=$menu->name;	
		}
		
        $settings_fields = array(
            'wp_nav_menu_cache' => array(

                array(
                    'name'    => 'exclude_theme_locations',
                    'label'   => 'Exclude Theme Location',
                    'desc'    => "Check theme location you don't want to cache any menu of",
                    'type'    => 'multicheck',
                    'options' => $exclude_theme_locations_opt
                ),
                array(
                    'name'    => 'exclude_menus',
                    'label'   => 'Exclude Menus',
                    'desc'    => "Check wich menu you don't want to cache.<br>You need this if you use Custom Menu widget or if you assign a menu with the call of wp_nav_menu() function in theme files.",
                    'type'    => 'multicheck',
                    'options' => $exclude_menus_opt
                ),				
				

            ),
			
			
        );

        return $settings_fields;
    }

    function plugin_page() {
        echo '<div class="wrap">';
		echo '<h2>WP Nav Menu Cache</h2>';
        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();

        echo '</div>';
    }

}
endif;

new WP_Nav_Menu_Cache_Settings();