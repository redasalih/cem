<?php
/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access

	global $post;
	$testimonial_meta_options = get_post_meta( $post_id, 'testimonial_meta_options', true );
	
	if(!empty($testimonial_meta_options['post_types'])){
		$post_types = $testimonial_meta_options['post_types'];
		}
	else{
		$post_types = array('testimonial');;
		}
	
	



	if(!empty($testimonial_meta_options['post_status'])){
		
		$post_status = $testimonial_meta_options['post_status'];
		}
	else{
		$post_status = array('publish');
		}	
	
		
	
	if(!empty($testimonial_meta_options['offset'])){
		
		$offset = (int)$testimonial_meta_options['offset'];
		}
	else{
		$offset = '';
		}
	
	
	//var_dump($offset);
	
	if(!empty($testimonial_meta_options['posts_per_page'])){
		$posts_per_page = $testimonial_meta_options['posts_per_page'];
		}
	else{
		$posts_per_page = -1;
		}
	
	
	if(!empty($testimonial_meta_options['exclude_post_id'])){
		$exclude_post_id = $testimonial_meta_options['exclude_post_id'];
		}
	else{
		$exclude_post_id = '';
		}
	
	
	if(!empty($testimonial_meta_options['query_order'])){
		$query_order = $testimonial_meta_options['query_order'];
		}
	else{
		$query_order = '';
		}
		
	
	if(!empty($testimonial_meta_options['query_orderby'])){
		$query_orderby = $testimonial_meta_options['query_orderby'];
		}
	else{
		$query_orderby = '';
		}
	
	
	//var_dump($query_orderby);
	$str_orderby = '';
	foreach($query_orderby as $orderby){
		
		$str_orderby.= $orderby.' ';
		
		}
	$query_orderby = $str_orderby;
	//var_dump($query_orderby);
	
	if(!empty($testimonial_meta_options['query_orderby_meta_key'])){
		$query_orderby_meta_key = $testimonial_meta_options['query_orderby_meta_key'];
		}
	else{
		$query_orderby_meta_key = '';
		}
	
	
	
	if(!empty($testimonial_meta_options['layout']['content'])){
		$layout_content = $testimonial_meta_options['layout']['content'];	
		}
	else{
		$layout_content = 'flat-conetnt-top';
		}
	
	
	if(!empty($testimonial_meta_options['layout']['hover'])){
		$layout_hover = $testimonial_meta_options['layout']['hover'];
		}
	else{
		$layout_hover = '';
		}
	
	
	if(!empty($testimonial_meta_options['skin'])){
		$skin = $testimonial_meta_options['skin'];	
		}
	else{
		$skin = 'flat';	
		
		}
	
	if(!empty($testimonial_meta_options['custom_js']))
	$custom_js = $testimonial_meta_options['custom_js'];	
	
	if(!empty($testimonial_meta_options['custom_css']))
	$custom_css = $testimonial_meta_options['custom_css'];
		

	
	if(!empty($testimonial_meta_options['item']['desktop'])){
		
		$items_in_desktop = $testimonial_meta_options['item']['desktop'];
		}
	else{
		$items_in_desktop = '3';
		
		}
		
		
	if(!empty($testimonial_meta_options['item']['tablet'])){
		
		$items_in_tablet = $testimonial_meta_options['item']['tablet'];
		}
	else{
		$items_in_tablet = '5';
		
		}		
		
	if(!empty($testimonial_meta_options['item']['mobile'])){
		
		$items_in_mobile = $testimonial_meta_options['item']['mobile'];
		}
	else{
		$items_in_mobile = '1';
		
		}	
		
		
	if(!empty($testimonial_meta_options['height']['style'])){
		
		$items_height_style = $testimonial_meta_options['height']['style'];
		}
	else{
		$items_height_style = 'auto_height';
		
		}				
			
	if(!empty($testimonial_meta_options['height']['fixed_height'])){
		
		$items_fixed_height = $testimonial_meta_options['height']['fixed_height'];
		}
	else{
		$items_fixed_height = '';
		
		}
		
		
	if(!empty($testimonial_meta_options['media_source'])){
		
		$media_source = $testimonial_meta_options['media_source'];
		}
	else{
		$media_source = array();
		
		}
		
	if(!empty($testimonial_meta_options['featured_img_size'])){
		
		$featured_img_size = $testimonial_meta_options['featured_img_size'];
		}
	else{
		$featured_img_size = 'full';
		
		}		
		
			
			
	if(!empty($testimonial_meta_options['margin'])){
		
		$items_margin = $testimonial_meta_options['margin'];
		}
	else{
		$items_margin = '';
		
		}
		
	if(!empty($testimonial_meta_options['container']['padding'])){
		
		$container_padding = $testimonial_meta_options['container']['padding'];
		}
	else{
		$container_padding = '';
		
		}	
		
	if(!empty($testimonial_meta_options['container']['bg_color'])){
		
		$container_bg_color = $testimonial_meta_options['container']['bg_color'];
		}
	else{
		$container_bg_color = '';
		
		}		
		
		
	if(!empty($testimonial_meta_options['container']['bg_image'])){
		
		$container_bg_image = $testimonial_meta_options['container']['bg_image'];
		}
	else{
		$container_bg_image = '';
		
		}
		
		
	if(!empty($testimonial_meta_options['nav_top']['filter'])){
		
		$nav_top_filter = $testimonial_meta_options['nav_top']['filter'];
		}
	else{
		$nav_top_filter = 'none';
		
		}		
		
		
	if(!empty($testimonial_meta_options['nav_top']['search'])){
		
		$nav_top_search = $testimonial_meta_options['nav_top']['search'];
		}
	else{
		$nav_top_search = 'none';
		
		}		
		
		
	if(!empty($testimonial_meta_options['nav_bottom']['slider_pagination'])){
		
		$slider_pagination = $testimonial_meta_options['nav_bottom']['slider_pagination'];
		}
	else{
		$slider_pagination = 'true';
		
		}		
		
	if(!empty($testimonial_meta_options['nav_bottom']['pagination_theme'])){
		
		$pagination_theme = $testimonial_meta_options['nav_bottom']['pagination_theme'];
		}
	else{
		$pagination_theme = 'round';
		
		}
	
	
	if(!empty($testimonial_meta_options['nav_bottom']['navigation_theme'])){
		
		$navigation_theme = $testimonial_meta_options['nav_bottom']['navigation_theme'];
		}
	else{
		$navigation_theme = 'round';
		
		}
	
	if(!empty($testimonial_meta_options['slider_options']['navigation_bg'])){
		$navigation_bg = $testimonial_meta_options['slider_options']['navigation_bg'];
	}
	else{
		$navigation_bg = '#35a2ff';
	}	
	
	
	if(!empty($testimonial_meta_options['slider_options']['slider_enable'])){
		$slider_enable = $testimonial_meta_options['slider_options']['slider_enable'];
	}
	else{
		$slider_enable = 'true';
	}	
	
	if(!empty($testimonial_meta_options['slider_options']['slider_pagination'])){
		$slider_pagination = $testimonial_meta_options['slider_options']['slider_pagination'];
	}
	else{
		$slider_pagination = 'true';
	}
	
	
	if(!empty($testimonial_meta_options['slider_options']['slider_navigation'])){
		$slider_navigation = $testimonial_meta_options['slider_options']['slider_navigation'];
	}
	else{
		$slider_navigation = 'false';
	}	

	
	if(!empty($testimonial_meta_options['slider_options']['navigation_position'])){
		$navigation_position = $testimonial_meta_options['slider_options']['navigation_position'];
	}
	else{
		$navigation_position = 'middle';
	}	
		
	
	if(!empty($testimonial_meta_options['slider_options']['slider_autoplay'])){
		$slider_autoplay = $testimonial_meta_options['slider_options']['slider_autoplay'];
	}
	else{
		$slider_autoplay = 'true';
	}	
	
	if(!empty($testimonial_meta_options['slider_options']['hover_stop'])){
		$hover_stop = $testimonial_meta_options['slider_options']['hover_stop'];
	}
	else{
		$hover_stop = 'true';
	}	
	
	
	if(!empty($testimonial_meta_options['slider_options']['slideSpeed'])){
		$slideSpeed = $testimonial_meta_options['slider_options']['slideSpeed'];
	}
	else{
		$slideSpeed = '500';
	}	
	
	if(!empty($testimonial_meta_options['slider_options']['paginationSpeed'])){
		$paginationSpeed = $testimonial_meta_options['slider_options']['paginationSpeed'];
	}
	else{
		$paginationSpeed = '500';
	}	
	
	if(!empty($testimonial_meta_options['slider_options']['pagination_bullet_bg'])){
		$pagination_bullet_bg = $testimonial_meta_options['slider_options']['pagination_bullet_bg'];
	}
	else{
		$pagination_bullet_bg = '#35a2ff';
	}	
	
	
	
	if(!empty($testimonial_meta_options['slider_options']['rewindSpeed'])){
		$rewindSpeed = $testimonial_meta_options['slider_options']['rewindSpeed'];
	}
	else{
		$rewindSpeed = '500';
	}	
	
	if(!empty($testimonial_meta_options['slider_options']['paginationNumbers'])){
		$paginationNumbers = $testimonial_meta_options['slider_options']['paginationNumbers'];
	}
	else{
		$paginationNumbers = 'true';
	}		
	
	
	if(!empty($testimonial_meta_options['slider_options']['lazyLoad'])){
		$lazyLoad = $testimonial_meta_options['slider_options']['lazyLoad'];
	}
	else{
		$lazyLoad = 'true';
	}	
	
	if(!empty($testimonial_meta_options['slider_options']['touchDrag'])){
		$touchDrag = $testimonial_meta_options['slider_options']['touchDrag'];
	}
	else{
		$touchDrag = 'true';
	}		
	
	if(!empty($testimonial_meta_options['slider_options']['mouseDrag'])){
		$mouseDrag = $testimonial_meta_options['slider_options']['mouseDrag'];
	}
	else{
		$mouseDrag = 'true';
	}		
	

		
		if(empty($exclude_post_id))
			{
				$exclude_post_id = array();
			}
		else
			{
				$exclude_post_id = explode(',',$exclude_post_id);
			}
		

		
		if ( get_query_var('paged') ) {
		
			$paged = get_query_var('paged');
		
		} elseif ( get_query_var('page') ) {
		
			$paged = get_query_var('page');
		
		} else {
		
			$paged = 1;
		
		}
