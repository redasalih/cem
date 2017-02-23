<?php
/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access


		
		$html_media = '';

		$is_image = false;
		 foreach($media_source as $source_info){
			 
			$media = testimonial_get_media($source_info['id'], $featured_img_size);
		  	if ( $is_image ) continue;
		  
		  if(!empty($source_info['checked'])){
		  	if(!empty($media)){
   
				$html_media = testimonial_get_media($source_info['id'], $featured_img_size);
				$is_image = true;
			}
		   else $html_media = '';
		  }
		 }


	
	$html.='<div class="layer-media">'.$html_media.'</div>';