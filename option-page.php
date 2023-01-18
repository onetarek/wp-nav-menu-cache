<?php 
# admin page
require_once dirname( __FILE__ ) . '/class.settings-api.php';

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
		$exclude_theme_locations_opt=array();
		foreach($locations as $key => $val){
			$exclude_theme_locations_opt[$key]=ucfirst($key);
		}
		
		// Get menus
		$menus = wp_get_nav_menus();
		$exclude_menus_opt=array();
		foreach($menus as $menu){
			$exclude_menus_opt[$menu->term_id."|".$menu->slug."|".$menu->name]=$menu->name;	
		}
		
        $settings_fields = array(
            'wp_nav_menu_cache' => array(

                array(
                    'name'    => 'exclude_theme_locations',
                    'label'   => 'Exclude Theme Locations',
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
                array(
                    'name'  => 'individual_url',
                    'label' => 'Cache for Individual URL',
                    'desc'  => 'Enable <br><span style="color:#ff0000">You should not enable this option if you have a huge number of <strong>posts/pages</strong> on your site.<br>This option caches each menu individually <strong>for each post/page or any visited url</strong>.<br>This can result in a <strong>huge number of cached menu files</strong> on your site, which could actually resulted in a <strong>slower site</strong>.<br>It could also cross the <strong>limitation of number of files</strong> in a single directory.</span>',
                    'type'  => 'checkbox'
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
			echo '<hr>';
			echo '<form action="" method="post">'; 
				if(isset($_POST['delete_nav_menu_cache_files']))
				{
					global $WP_Nav_Menu_Cache;
					$WP_Nav_Menu_Cache->delete_cached_files();
					echo '<div style="color:#009900">All menu cache files have been deleted.</div>';
				}			
				echo '<input type="submit" name="delete_nav_menu_cache_files" class="button" value="Delete All Menu Cache Files">';
			echo '</form>';
        echo '</div>';
    }

}
endif;

new WP_Nav_Menu_Cache_Settings();