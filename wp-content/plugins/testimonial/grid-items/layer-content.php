<?php
/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access

	$class_testimonial_functions = new class_testimonial_functions();
	
	$testimonial_layout_content = get_option( 'testimonial_layout_content' );
	
	if(empty($testimonial_layout_content)){
		$layout = $class_testimonial_functions->layout_content($layout_content);
		}
	else{
		$layout = $testimonial_layout_content[$layout_content];
		
		}
	
	//$layout = $class_testimonial_functions->layout_content($layout_content);
	
	
	

	

	$html.='<div class="layer-content">';	
	
	foreach($layout as $item_id=>$item_info){
		
		$item_key = $item_info['key'];
		
		if(!empty($item_info['char_limit'])){
			$char_limit = $item_info['char_limit'];	
			}
			
		
		
		if($item_key=='title'){
			$html.='<div class="element element_'.$item_id.' '.$item_key.'" style="" >';
			$html.= wp_trim_words(get_the_title(), $char_limit,'');
			$html.='</div>';
			}
			
		elseif($item_key=='thumb'){
			
			$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );
			$thumb_url = $thumb['0'];
	

			$html.='<div class="element element_'.$item_id.' '.$item_key.'" style="" >';
				$html.= '<img src="'.$thumb_url.'" />';
			$html.='</div>';
			}			
			
			
		elseif($item_key=='down_arrow'){
			$html.='<div class="element element_'.$item_id.' '.$item_key.'" style="" >';				
			$html.='</div>';
			}	
			
		elseif($item_key=='up_arrow'){
			$html.='<div class="element element_'.$item_id.' '.$item_key.'" style="" >';				
			$html.='</div>';
			}			
					
			
			
		elseif($item_key=='excerpt'){
			$html.='<div class="element element_'.$item_id.' '.$item_key.'" style="" >';
				$html.= wp_trim_words(get_the_excerpt(), $char_limit,'');
				
			$html.='<span class="testimonial-arrow"></span>';				
			$html.='</div>';
			}

		elseif($item_key=='read_more'){

				$html.= '<a class="element element_'.$item_id.' '.$item_key.'" style="" class="read-more" href="'.get_permalink().'">'.__('Read more.', testimonial_textdomain).'</a>';

			}			
	
		elseif($item_key=='excerpt_read_more'){
			$html.='<div class="element element_'.$item_id.' '.$item_key.'" style="" >';
				$html.= wp_trim_words(get_the_excerpt(), $char_limit,'').' <a class="read-more" href="'.get_permalink().'">'.__('Read more.', testimonial_textdomain).'</a>';
			$html.='</div>';
			}
			
		elseif($item_key=='post_date'){
			$html.='<div class="element element_'.$item_id.' '.$item_key.'" style="" >';
				$html.= get_the_date();
			$html.='</div>';
			}			
			
		elseif($item_key=='author'){
			$html.='<div class="element element_'.$item_id.' '.$item_key.'" style="" >';
				$html.= get_the_author();
			$html.='</div>';
			}	
			
		elseif($item_key=='categories'){
			
			$html.='<div class="element element_'.$item_id.' '.$item_key.'" style="" >';
				$categories = get_the_category();
				$separator = ' ';
				$output = '';
				if ( ! empty( $categories ) ) {
					foreach( $categories as $category ) {
						$html .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'View all posts in %s', 'textdomain' ), $category->name ) ) . '">' . esc_html( $category->name ) . '</a>' . $separator;
					}
					$html.= trim( $output, $separator );
				}
			$html.='</div>';
		}					
			
		elseif($item_key=='tags'){
			$html.='<div class="element element_'.$item_id.' '.$item_key.'" style="" >';
				$posttags = get_the_tags();
				if ($posttags) {
				  foreach($posttags as $tag){
					$html.= '<a href="#">'.$tag->name . '</a> , ';
					}
				}
			$html.='</div>';
		}
		
		elseif($item_key=='comments_count'){
			$html.='<div class="element element_'.$item_id.' '.$item_key.'" style="" >';
			
				$comments_number = get_comments_number( get_the_ID() );
				
				if(comments_open()){
					
					if ( $comments_number == 0 ) {
							$html.= __('No Comments',testimonial_textdomain);
						} elseif ( $comments_number > 1 ) {
							$html.= $comments_number . __(' Comments',testimonial_textdomain);
						} else {
							$html.= __('1 Comment',testimonial_textdomain);
						}
		
					}
			$html.='</div>';
		}		

		elseif($item_key=='five_star'){
			$html.='<div class="element element_'.$item_id.' '.$item_key.'" style="" >
			<i class="fa fa-star"></i>
			<i class="fa fa-star"></i>
			<i class="fa fa-star"></i>
			<i class="fa fa-star"></i>
			<i class="fa fa-star"></i>

			
			';
			$html.='</div>';

		}

		
		elseif($item_key=='zoom'){
			$html.='<div class="element element_'.$item_id.' '.$item_key.'" style="" >';
			$html.= '<i class="fa fa-search"></i>';
			$html.='</div>';

		}		
		
		elseif($item_key=='share_button'){
			$html.='<div class="element element_'.$item_id.' '.$item_key.'" style="" >';
			$html.= '
			
			<span class="fb">
				<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u='.get_permalink().'"> </a>
			</span>
			<span class="twitter">
				<a target="_blank" href="https://twitter.com/intent/tweet?url='.get_permalink().'&text='.get_the_title().'"></a>
			</span>
			<span class="gplus">
				<a target="_blank" href="https://plus.google.com/share?url='.get_permalink().'"></a>
			</span>
			
			';
			$html.='</div>';

		}			
		
		elseif($item_key=='hr'){

			$html.= '<hr class="element element_'.$item_id.' '.$item_key.'" style="" />';

		}		
		
		elseif($item_key=='meta_key'){
			
			$meta_value = get_post_meta(get_the_ID(), $item_info['field_id'],true);
			if(!empty($meta_value)){
				
				$html.='<div class="element element_'.$item_id.' '.$item_key.'" style="" >';
				$html.= do_shortcode($meta_value);
				$html.='</div>';
				
				}


		}					
					
			

		}
	
	
	
	
	$html.='</div>'; // .layer-content