<?php
/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access


	if($nav_top_filter=='yes'){
		
		$html.= '<div class="nav-filter">';
		
		foreach($categories as $category){
			
			$tax_cat = explode(',',$category);
			
			$categories_info[] = array($tax_cat[1],$tax_cat[0]);
			
			}
		
		$html.= '<div class="filter" data-filter="*">'.__('All', testimonial_textdomain).'</div>';
	
		foreach($categories_info as $term_info)
			{
				
				$term = get_term( $term_info[0], $term_info[1] );
				$term_slug = $term->slug;
				$term_name = $term->name;
				$html .= '<div class="filter" terms-id="'.$term_info[0].'" data-filter=".'.$term_slug.'" >'.$term_name.'</div>';
			}
	
		$html.= '</div>';
		
		
		
		
		
			$html .= '<script>
				jQuery(document).ready(function($) {

// init Isotope
var $grid = $(".grid-items").isotope({
	layoutMode: "masonry",
	masonry: { 
		isFitWidth: true 
	  },
	filter: ".post-format-chat" 
  
  });


// filter items on button click
$(".nav-filter").on( "click", ".filter", function() {
var filterValue = $(this).attr("data-filter");
$grid.isotope({ filter: filterValue });
});			

				});		
			</script>';	
		




		
		}
	if($nav_top_search=='yes'){
		
if(isset($_GET['keyword'])){
	
	$keyword = $_GET['keyword'];
	
	}
		
		$html.= '<div class="nav-search">'; 
		$html.= '<input grid_id="'.$post_id.'"  placeholder="start typing..." class="search" type="text" value="'.$keyword.'" name="" />';		
		
		$html.= '</div>';
		}


