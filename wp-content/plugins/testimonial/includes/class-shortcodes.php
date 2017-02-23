<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access

class class_testimonial_shortcodes{
	
	
    public function __construct(){
		
		add_shortcode( 'testimonial', array( $this, 'testimonial_display' ) );

    }
	
	
	
	
	public function testimonial_display($atts, $content = null ) {
			$atts = shortcode_atts(
				array(
					'id' => "",
	
					), $atts);
	
				$html  = '';
				$post_id = $atts['id'];

				include testimonial_plugin_dir.'/grid-items/variables.php';
				include testimonial_plugin_dir.'/grid-items/query.php';
				include testimonial_plugin_dir.'/grid-items/custom-css.php';				



				$html.='<div id="testimonial-'.$post_id.'" class="testimonial">';




				if ( $wp_query->have_posts() ) :
				
				$html.='<div class="grid-nav-top">';	
				include testimonial_plugin_dir.'/grid-items/nav-top.php';							
				$html.='</div>';  // .grid-nav-top	
				
				$html.='<div class="grid-items">';
				while ( $wp_query->have_posts() ) : $wp_query->the_post();

				
				$html.='<div  class="item skin '.$skin.' '.testimonial_term_slug_list(get_the_ID()).'">';

				include testimonial_plugin_dir.'/grid-items/layer-media.php';
				include testimonial_plugin_dir.'/grid-items/layer-content.php';
				include testimonial_plugin_dir.'/grid-items/layer-hover.php';	
				
				$html.='</div>';  // .item		

				endwhile;
				wp_reset_query();
				$html.='</div>';  // .grid-items	
				
				$html.='<div class="grid-nav-bottom">';	
							include testimonial_plugin_dir.'/grid-items/nav-bottom.php';
				$html.='</div>';  // .grid-nav-bottom	
				
				
				else:
				$html.='<div class="item">';
				$html.=__('No Post found',testimonial_textdomain);  // .item	
				$html.='</div>';  // .item					
				
				endif;
				
				include testimonial_plugin_dir.'/grid-items/scripts.php';	
				
				include testimonial_plugin_dir.'/grid-items/slider-scripts.php';	
				
				$html.='</div>';  // .testimonial
	

	
				return $html;
	
	
	}


	
	
	
	}

new class_testimonial_shortcodes();