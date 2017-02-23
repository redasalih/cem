<?php

if ( ! defined('ABSPATH')) exit;


function testimonial_body_rounded($post_id)
	{
		
		
		
		$testimonial_bg_img = get_post_meta( $post_id, 'testimonial_bg_img', true );
		$testimonial_themes = get_post_meta( $post_id, 'testimonial_themes', true );
		$testimonial_item_text_align = get_post_meta( $post_id, 'testimonial_item_text_align', true );
				
		$testimonial_total_items = get_post_meta( $post_id, 'testimonial_total_items', true );		
		$testimonial_column_number = get_post_meta( $post_id, 'testimonial_column_number', true );

		$testimonial_auto_play = get_post_meta( $post_id, 'testimonial_auto_play', true );
		$testimonial_stop_on_hover = get_post_meta( $post_id, 'testimonial_stop_on_hover', true );
		$testimonial_slider_navigation = get_post_meta( $post_id, 'testimonial_slider_navigation', true );
		$testimonial_slide_speed = get_post_meta( $post_id, 'testimonial_slide_speed', true );
				
		$testimonial_slider_pagination = get_post_meta( $post_id, 'testimonial_slider_pagination', true );
		$testimonial_pagination_slide_speed = get_post_meta( $post_id, 'testimonial_pagination_slide_speed', true );
		$testimonial_slider_pagination_count = get_post_meta( $post_id, 'testimonial_slider_pagination_count', true );
		
		$testimonial_slider_pagination_bg = get_post_meta( $post_id, 'testimonial_slider_pagination_bg', true );
		$testimonial_slider_pagination_text_color = get_post_meta( $post_id, 'testimonial_slider_pagination_text_color', true );		
		
		$testimonial_slider_touch_drag = get_post_meta( $post_id, 'testimonial_slider_touch_drag', true );
		$testimonial_slider_mouse_drag = get_post_meta( $post_id, 'testimonial_slider_mouse_drag', true );
		
		$testimonial_content_source = get_post_meta( $post_id, 'testimonial_content_source', true );
		$testimonial_content_year = get_post_meta( $post_id, 'testimonial_content_year', true );
		$testimonial_content_month = get_post_meta( $post_id, 'testimonial_content_month', true );
		$testimonial_content_month_year = get_post_meta( $post_id, 'testimonial_content_month_year', true );
		
		$testimonial_taxonomy = 'testimonial_group';
		$testimonial_taxonomy_category = get_post_meta( $post_id, 'testimonial_taxonomy_category', true );	
		
		$testimonial_posttype = 'testimonial';
		
		
		$testimonial_post_ids = get_post_meta( $post_id, 'testimonial_post_ids', true );




		

		$testimonial_items_title_color = get_post_meta( $post_id, 'testimonial_items_title_color', true );			
		$testimonial_items_title_font_size = get_post_meta( $post_id, 'testimonial_items_title_font_size', true );		

		$testimonial_items_position_color = get_post_meta( $post_id, 'testimonial_items_position_color', true );
		$testimonial_items_position_font_size = get_post_meta( $post_id, 'testimonial_items_position_font_size', true );

		$testimonial_items_content_color = get_post_meta( $post_id, 'testimonial_items_content_color', true );
		$testimonial_items_content_font_size = get_post_meta( $post_id, 'testimonial_items_content_font_size', true );

		
		$testimonial_items_thumb_size = get_post_meta( $post_id, 'testimonial_items_thumb_size', true );
		$testimonial_items_max_width = get_post_meta( $post_id, 'testimonial_items_max_width', true );		
		$testimonial_items_thumb_max_hieght = get_post_meta( $post_id, 'testimonial_items_thumb_max_hieght', true );
		
		
		$testimonial_body = '';
		$testimonial_body = '<style type="text/css"></style>';
		
		
		
		$testimonial_body .= '
		<div  class="testimonial-container" style="background-image:url('.$testimonial_bg_img.')">
		<ul  id="testimonial-'.$post_id.'" class="owl-carousel testimonial-items testimonial-'.$testimonial_themes.'">';
		
		global $wp_query;
		


		
		if(($testimonial_content_source=="latest"))
			{
			
				$wp_query = new WP_Query(
					array (
						'post_type' => $testimonial_posttype,
						'orderby' => 'date',
						'order' => 'DESC',
						'posts_per_page' => $testimonial_total_items,
						
						) );
			
			
			}		
		
		elseif(($testimonial_content_source=="older"))
			{
			
				$wp_query = new WP_Query(
					array (
						'post_type' => $testimonial_posttype,
						'orderby' => 'date',
						'order' => 'ASC',
						'posts_per_page' => $testimonial_total_items,
						
						) );

			}		

		elseif(($testimonial_content_source=="year"))
			{
			
				$wp_query = new WP_Query(
					array (
						'post_type' => $testimonial_posttype,
						'year' => $testimonial_content_year,
						'posts_per_page' => $testimonial_total_items,
						) );

			}

		elseif(($testimonial_content_source=="month"))
			{
			
				$wp_query = new WP_Query(
					array (
						'post_type' => $testimonial_posttype,
						'year' => $testimonial_content_month_year,
						'monthnum' => $testimonial_content_month,
						'posts_per_page' => $testimonial_total_items,
						
						) );

			}

		elseif($testimonial_content_source=="taxonomy")
			{
				$wp_query = new WP_Query(
					array (
						'post_type' => $testimonial_posttype,							
						'posts_per_page' => $testimonial_total_items,
						
						'tax_query' => array(
							array(
								   'taxonomy' => $testimonial_taxonomy,
								   'field' => 'id',
								   'terms' => $testimonial_taxonomy_category,
							)
						)
						
						) );
			}


		
		elseif($testimonial_content_source=="post_id")
			{
			
				$wp_query = new WP_Query(
					array (
						'post__in' => $testimonial_post_ids,
						'post_type' => $testimonial_posttype,
						'posts_per_page' => $testimonial_total_items,
						) );
			
			
			}
			
		else
			{
				$wp_query = new WP_Query(
					array (
						'post_type' => $testimonial_posttype,
						'orderby' => 'date',
						'order' => 'DESC',
						'posts_per_page' => $testimonial_total_items,
						
						) );
			
			}
			

								
		
		if ( $wp_query->have_posts() ) :
		
		
		
		$i=0;
		
		while ( $wp_query->have_posts() ) : $wp_query->the_post();

		$testimonial_thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), $testimonial_items_thumb_size );
		$testimonial_thumb_url = $testimonial_thumb['0'];
		
		
		
		
		if($i%2==0)
			{
				$even_odd = "even";
			}
		else
			{
				$even_odd = "odd";
			}
			
			
		
		$testimonial_body.= '<li style="width:'.$testimonial_items_max_width.'; text-align:'.$testimonial_item_text_align.';" class="testimonial-item '.$even_odd.'" >';
		$testimonial_body.= '<div class="testimonial-post">';		
		
		
		if(!empty($testimonial_thumb_url))
			{
					$testimonial_body.= '
		<div style="max-height:'.$testimonial_items_thumb_max_hieght.';" class="testimonial-thumb">
			<img src="'.$testimonial_thumb_url.'" />
		</div>';
			}


	$testimonial_member_position = get_post_meta(get_the_ID(), 'testimonial_member_position', true );
	$testimonial_fb = get_post_meta(get_the_ID(), 'testimonial_fb', true );
	$testimonial_twitter = get_post_meta( get_the_ID(), 'testimonial_twitter', true );
	$testimonial_google = get_post_meta( get_the_ID(), 'testimonial_google', true );
	$testimonial_pinterest = get_post_meta( get_the_ID(), 'testimonial_pinterest', true );	


	
			


			
			
			
			$testimonial_body.= '<div class="testimonial-content" >';
			
			$testimonial_body.= '
				<div class="testimonial-title" style="color:'.$testimonial_items_title_color.';font-size:'.$testimonial_items_title_font_size.'">'.get_the_title().'
			</div>';


			if(!empty($testimonial_member_position))
				{
					$testimonial_body.= '<div class="testimonial-position" style="color:'.$testimonial_items_position_color.';font-size:'.$testimonial_items_position_font_size.'">'.$testimonial_member_position.'
					</div>';
				}



			$testimonial_body.= '<div class="testimonial-social" >';
			
			if(!empty($testimonial_fb))
				{
					$testimonial_body.= '<span class="fb">
						<a target="_blank" href="'.$testimonial_fb.'"> </a>
					</span>';
				}

			if(!empty($testimonial_twitter))
				{
					$testimonial_body.= '<span class="twitter">
						<a target="_blank" href="'.$testimonial_twitter.'"></a>
					</span>';
				}
				
			if(!empty($testimonial_google))
				{
					$testimonial_body.= '<span class="gplus">
						<a target="_blank" href="'.$testimonial_google .'"></a>
					</span>';
				}
				
			if(!empty($testimonial_pinterest))
				{
					$testimonial_body.= '<span class="pinterest">
						<a target="_blank" href="'.$testimonial_pinterest .'"></a>
					</span>';
				}
			$testimonial_body.= '</div>';
			


			$testimonial_body.= '<p style="color:'.$testimonial_items_content_color.';font-size:'.$testimonial_items_content_font_size.'"><span class="quote"></span>'.get_the_content().'</p></div>			
			
			</div>

		</li>';
		
		
		$i++;
		
		endwhile;
		
		wp_reset_query();
		endif;
		

			
		$testimonial_body .= '</ul></div>';
		

		$testimonial_body .='<script>
		jQuery(document).ready(function($)
		{
			$("#testimonial-'.$post_id.'").owlCarousel({
				
				items : '.$testimonial_column_number.', //10 items above 1000px browser width
				itemsDesktop : [1000,1], //5 items between 1000px and 901px
				itemsDesktopSmall : [900,1], // betweem 900px and 601px
				itemsTablet: [600,1], //2 items between 600 and 0
				itemsMobile : false, 
				navigationText : ["",""],
				';
				
			
		if($testimonial_auto_play=="true")
			{
				
		$testimonial_body .='autoPlay: '.$testimonial_auto_play.',';
		
			}	
		
		if($testimonial_stop_on_hover=="true")
			{
				
		$testimonial_body .='stopOnHover: '.$testimonial_stop_on_hover.',';
		
			}				
				
		if($testimonial_slider_navigation=="true")
			{
				
		$testimonial_body .='navigation: '.$testimonial_slider_navigation.',';
		
			}				
				
		if(!empty($testimonial_slider_pagination))
			{
				
		$testimonial_body .='pagination: '.$testimonial_slider_pagination.',';
		
			}
		else
			{
			$testimonial_body .='pagination: false,';
			}
				
				
		if(!empty($testimonial_slider_pagination_count))
			{
				
		$testimonial_body .='paginationNumbers: true,';
		
			}
		else
			{
			$testimonial_body .='paginationNumbers: false,';
			}				
				
				
				
		if(!empty($testimonial_slide_speed))
			{
				
		$testimonial_body .='slideSpeed: '.$testimonial_slide_speed.',';
		
			}
			
				
		if(!empty($testimonial_pagination_slide_speed))
			{
				
		$testimonial_body .='paginationSpeed: '.$testimonial_pagination_slide_speed.',';
		
			}			
			
			
		if(!empty($testimonial_slider_touch_drag))
			{
				
		$testimonial_body .='touchDrag : true,';
		
			}			
		else
			{
			$testimonial_body .='touchDrag: false,';
			}
			
			
			
		if(!empty($testimonial_slider_mouse_drag ))
			{
				
		$testimonial_body .='mouseDrag  : true,';
		
			}			
		else
			{
			$testimonial_body .='mouseDrag : false,';
			}			
			
			
			
			
							
				
				
				
		$testimonial_body .='});
		
		});</script>';

		
		return $testimonial_body;
		
		    
		
		
		
		
		
		
		
		
		
		
		
		
	}