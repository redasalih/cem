<?php

if ( ! defined('ABSPATH')) exit;



function testimonial_get_all_post_ids($postid)
	{
		
		$testimonial_post_ids = get_post_meta( $postid, 'testimonial_post_ids', true );
		
		
		$return_string = '';
		$return_string .= '<ul style="margin: 0;">';

		$args_product = array(
		'post_type' => array('testimonial'),
		'posts_per_page' => -1,
		);

		$product_query = new WP_Query( $args_product );
	
		if($product_query->have_posts()): while($product_query->have_posts()): $product_query->the_post();
		

	   $return_string .= '<li><label ><input class="testimonial_post_ids" type="checkbox" name="testimonial_post_ids['.get_the_ID().']" value ="'.get_the_ID().'" ';
		
		if ( isset( $testimonial_post_ids[get_the_ID()] ) )
			{
			$return_string .= "checked";
			}

		$return_string .= '/>';

		$return_string .= get_the_title().'</label ></li>';
			
		endwhile; 
		
		else:
		$return_string .= '<span style="color:#f00;">Sorry! No testimonial found.';
		endif; wp_reset_query();
		
		
		$return_string .= '</ul>';
		echo $return_string;
	
	}






function testimonial_get_taxonomy_category($postid)
	{

	$testimonial_taxonomy = array('testimonial_group');
	
	if(empty($testimonial_taxonomy))
		{
			$testimonial_taxonomy= "";
		}
	$testimonial_taxonomy_category = get_post_meta( $postid, 'testimonial_taxonomy_category', true );
	
		
		if(empty($testimonial_taxonomy_category))
			{
			 	$testimonial_taxonomy_category =array('none'); // an empty array when no category element selected
				
			
			}

		
		
		if(!isset($_POST['taxonomy']))
			{
			$taxonomy =$testimonial_taxonomy;
			}
		else
			{
			$taxonomy = $_POST['taxonomy'];
			}
		
		
		$args=array(
		  'orderby' => 'name',
		  'order' => 'ASC',
		  'taxonomy' => $taxonomy,
		  );
	
	$categories = get_categories($args);
	
	
	if(empty($categories))
		{
		echo "<span style='color:#f00;'>No testimonial groups found!</span>";
		}
	
	
		$return_string = '';
		$return_string .= '<ul style="margin: 0;">';
	
	foreach($categories as $category){
		
		if(array_search($category->cat_ID, $testimonial_taxonomy_category))
		{
	   $return_string .= '<li class='.$category->cat_ID.'><label ><input class="testimonial_taxonomy_category" checked type="checkbox" name="testimonial_taxonomy_category['.$category->cat_ID.']" value ="'.$category->cat_ID.'" />'.$category->cat_name.'</label ></li>';
		}
		
		else
			{
				   $return_string .= '<li class='.$category->cat_ID.'><label ><input class="testimonial_taxonomy_category" type="checkbox" name="testimonial_taxonomy_category['.$category->cat_ID.']" value ="'.$category->cat_ID.'" />'.$category->cat_name.'</label ></li>';			
			}
		
		

		
		}
	
		$return_string .= '</ul>';
		
		echo $return_string;
	
	if(isset($_POST['taxonomy']))
		{
			die();
		}
	
		
	}








function testimonial_dark_color($input_color)
	{
		if(empty($input_color))
			{
				return "";
			}
		else
			{
				$input = $input_color;
			  
				$col = Array(
					hexdec(substr($input,1,2)),
					hexdec(substr($input,3,2)),
					hexdec(substr($input,5,2))
				);
				$darker = Array(
					$col[0]/2,
					$col[1]/2,
					$col[2]/2
				);
		
				return "#".sprintf("%02X%02X%02X", $darker[0], $darker[1], $darker[2]);
			}

		
		
	}
	
	
	

	