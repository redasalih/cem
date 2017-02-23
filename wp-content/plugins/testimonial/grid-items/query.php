<?php
/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access





//var_dump($offset);


	$wp_query = new WP_Query(
		array (
			'post_type' => $post_types,
			'post_status' => $post_status,		
			'post__not_in' => $exclude_post_id,					
			'orderby' => $query_orderby,
			'order' => $query_order,
			'posts_per_page' => $posts_per_page,
			'paged' => $paged,	
			//'offset' => $offset,



			) );
			
			
		