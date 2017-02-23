<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access

class class_testimonial_settings{

	public function __construct(){
		
		add_action('admin_menu', array( $this, 'testimonial_menu_init' ));
		
		}



	
	public function testimonial_menu_settings(){
		include('menu/settings.php');	
	}
	
	public function testimonial_layout_editor(){
		include('menu/layout-editor.php');	
	}	
	
	
	
	public function testimonial_menu_init() {
		
		add_submenu_page('edit.php?post_type=testimonial_showcase', __('Layout Editor','testimonial'), __('Layout Editor','testimonial'), 'manage_options', 'testimonial_layout_editor', array( $this, 'testimonial_layout_editor' ));
		
		add_submenu_page('edit.php?post_type=testimonial_showcase', __('Settings','testimonial'), __('Settings','testimonial'), 'manage_options', 'testimonial_menu_settings', array( $this, 'testimonial_menu_settings' ));	
		

	
	}



	
	
	}
	
new class_testimonial_settings();