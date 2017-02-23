<?php
/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access
	
	//var_dump($pagination_theme);
	
	
	$html .= '<div class="pagination '.$pagination_theme.'">';
	
		if($slider_pagination=='true'){
			
			$html .= '<div class="paginate">';
			$big = 999999999; // need an unlikely integer
			$html .= paginate_links( array(
				'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format' => '?paged=%#%',
				'current' => max( 1, $paged ),
				'total' => $wp_query->max_num_pages,
				'prev_text'          => __('« Previous', testimonial_textdomain),
				'next_text'          => __('Next »', testimonial_textdomain),
				) );
		
			$html .= '</div >';	
			
			}
	
			
	$html .= '</div >';	