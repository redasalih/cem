<?php
/*
Plugin Name: Testimonial
Plugin URI: http://paratheme.com
Description: Fully responsive and mobile ready testimonial slider for wordpress.
Version: 1.2
Author: paratheme
Author URI: http://paratheme.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! defined('ABSPATH')) exit;

define('testimonial_plugin_url', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );
define('testimonial_plugin_dir', plugin_dir_path( __FILE__ ) );
define('testimonial_wp_url', 'https://wordpress.org/plugins/testimonial/' );
define('testimonial_pro_url', '' );
define('testimonial_demo_url', '' );


require_once( plugin_dir_path( __FILE__ ) . 'includes/testimonial-meta.php');
require_once( plugin_dir_path( __FILE__ ) . 'includes/testimonial-functions.php');


//Themes php files
require_once( plugin_dir_path( __FILE__ ) . 'themes/flat/index.php');
require_once( plugin_dir_path( __FILE__ ) . 'themes/rounded/index.php');


function testimonial_init_scripts()
	{
		wp_enqueue_script('jquery');
		wp_enqueue_script('testimonial_js', plugins_url( '/js/scripts.js' , __FILE__ ) , array( 'jquery' ));
		
		wp_enqueue_style('testimonial_style', testimonial_plugin_url.'css/style.css');

		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'testimonial_color_picker', plugins_url('/js/color-picker.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
		
		wp_enqueue_script('owl.carousel', plugins_url( '/js/owl.carousel.js' , __FILE__ ) , array( 'jquery' ));
		wp_enqueue_style('owl.carousel', testimonial_plugin_url.'css/owl.carousel.css');
		wp_enqueue_style('owl.theme', testimonial_plugin_url.'css/owl.theme.css');
		
		//ParaAdmin
		wp_enqueue_style('ParaAdmin', testimonial_plugin_url.'ParaAdmin/css/ParaAdmin.css');
		//wp_enqueue_style('ParaIcons', accordions_plugin_url.'ParaAdmin/css/ParaIcons.css');		
		wp_enqueue_script('ParaAdmin', plugins_url( 'ParaAdmin/js/ParaAdmin.js' , __FILE__ ) , array( 'jquery' ));
		
		// Style for themes
		wp_enqueue_style('testimonial-style-flat', testimonial_plugin_url.'themes/flat/style.css');	
		wp_enqueue_style('testimonial-style-rounded', testimonial_plugin_url.'themes/rounded/style.css');				
	
	}
add_action("init","testimonial_init_scripts");







register_activation_hook(__FILE__, 'testimonial_activation');


function testimonial_activation()
	{
		$testimonial_version = "1.2";
		update_option('testimonial_version', $testimonial_version); //update plugin version.
		
		$testimonial_customer_type= "free"; //customer_type "free"
		update_option('testimonial_customer_type', $testimonial_customer_type); //update plugin version.
		

		
		
	}


function testimonial_display($atts, $content = null ) {
		$atts = shortcode_atts(
			array(
				'id' => "",

				), $atts);


			$post_id = $atts['id'];

			$testimonial_themes = get_post_meta( $post_id, 'testimonial_themes', true );

			$testimonial_display ="";

			if($testimonial_themes== "flat")
				{
					$testimonial_display.= testimonial_body_flat($post_id);
				}
			else if($testimonial_themes== "rounded")
				{
					$testimonial_display.= testimonial_body_rounded($post_id);
				}
			else if($testimonial_themes== "rounded_vertical")
				{
					$testimonial_display.= testimonial_body_rounded_vertical($post_id);
				}				
			else if($testimonial_themes== "simple")
				{
					$testimonial_display.= testimonial_body_simple($post_id);
				}					
				
return $testimonial_display;



}

add_shortcode('testimonial_sc', 'testimonial_display');





add_action('admin_menu', 'testimonial_menu_init');


	
function testimonial_menu_help(){
	include('testimonial-help.php');	
}


function testimonial_menu_settings(){
	include('testimonial-settings.php');	
}



function testimonial_menu_init()
	{
		//add_submenu_page('edit.php?post_type=testimonial_sc', __('Settings','menu-wpt'), __('Settings','menu-wpt'), 'manage_options', 'testimonial_menu_settings', 'testimonial_menu_settings');	
			
		add_submenu_page('edit.php?post_type=testimonial_sc', __('Help & Upgrade','menu-testimonial'), __('Help & Upgrade','menu-testimonial'), 'manage_options', 'testimonial_menu_help', 'testimonial_menu_help');

	}





?>