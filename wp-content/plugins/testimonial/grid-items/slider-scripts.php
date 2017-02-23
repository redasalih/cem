<?php
/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access
		
		
		if($slider_enable == 'true'){
			
			
				$html .='<script>
				jQuery(document).ready(function($)
				{
					$("#testimonial-'.$post_id.' .grid-items").owlCarousel({
						
						items : '.$items_in_desktop.', //10 items above 1000px browser width
						itemsDesktop : [1000,'.$items_in_desktop.'], //5 items between 1000px and 901px
						itemsDesktopSmall : [900,'.$items_in_desktop.'], // betweem 900px and 601px
						itemsTablet: [600,'.$items_in_tablet.'], //2 items between 600 and 0
						itemsMobile : [479,'.$items_in_mobile.'], 
						navigationText : ["",""],
						autoPlay: '.$slider_autoplay.',
						stopOnHover: '.$hover_stop.',
						navigation: '.$slider_navigation.',
						pagination: '.$slider_pagination.',
						paginationNumbers: false,
						slideSpeed: '.$slideSpeed.',
						paginationSpeed: '.$paginationSpeed.',
						rewindSpeed: '.$rewindSpeed.',				
						touchDrag : '.$touchDrag.',
						mouseDrag  : '.$mouseDrag.',
						lazyLoad   : '.$lazyLoad.',
						lazyEffect   : "fade",
					
						';
			
						
				$html .='});';
				
				
			if($navigation_position == 'top-right')
				{
					$html.=  '$("#testimonial-'.$post_id.' .owl-buttons").addClass("top-right");
						$("#testimonial-'.$post_id.' .grid-items").css("padding","40px 0 0 0");				;';
				}
			elseif($navigation_position == 'top-left')
				{
					$html.=  '$("#testimonial-'.$post_id.' .owl-buttons").addClass("top-left");
						$("#testimonial-'.$post_id.' .grid-items").css("padding","40px 0 0 0");';	
				}
			elseif($navigation_position == 'middle')
				{
					$html.=  '$("#testimonial-'.$post_id.' .owl-buttons").addClass("middle");';	
				}



				
				if($navigation_theme=='round'){
					$html.=  '$("#testimonial-'.$post_id.' .owl-buttons").addClass("round");';
					
					}
				
				elseif($navigation_theme=='round-border'){
					$html.=  '$("#testimonial-'.$post_id.' .owl-buttons").addClass("round-border");';
					
					}				
				
				elseif($navigation_theme=='semi-round'){
					$html.=  '$("#testimonial-'.$post_id.' .owl-buttons").addClass("semi-round");';
					
					}					
				elseif($navigation_theme=='square'){
					$html.=  '$("#testimonial-'.$post_id.' .owl-buttons").addClass("square");';
					
					}				
				elseif($navigation_theme=='square-border'){
					
					$html.=  '$("#testimonial-'.$post_id.' .owl-buttons").addClass("square-border");';
					}				
				elseif($navigation_theme=='square-shadow'){
					
					$html.=  '$("#testimonial-'.$post_id.' .owl-buttons").addClass("square-shadow");';
					}	


				if($pagination_theme=='round'){
					$html.=  '$("#testimonial-'.$post_id.' .owl-pagination").addClass("round");';
					
					}
				elseif($pagination_theme=='round-border'){
					$html.=  '$("#testimonial-'.$post_id.' .owl-pagination").addClass("round-border");';
					
					}					
				elseif($pagination_theme=='semi-round'){
					$html.=  '$("#testimonial-'.$post_id.' .owl-pagination").addClass("semi-round");';
					
					}					
				elseif($pagination_theme=='square'){
					$html.=  '$("#testimonial-'.$post_id.' .owl-pagination").addClass("square");';
					
					}
				elseif($pagination_theme=='square-border'){
					$html.=  '$("#testimonial-'.$post_id.' .owl-pagination").addClass("square-border");';
					
					}

				$html .='});';
				
				$html .= '</script>';
			
			
			
			}
		else{
			
				$html .='<script>
				jQuery(document).ready(function($){';
			
			
				$html .= '
				
				myFunction();
				
	
					
				function myFunction() {

					var width = $("#testimonial-'.$post_id.'").width();
					
					var items_in_desktop = width/'.$items_in_desktop.';
					var items_in_tablet = width/'.$items_in_tablet.';
					var items_in_mobile = width/'.$items_in_mobile.';
					
					
					
					
					var margin_left = parseInt($("#testimonial-'.$post_id.' .grid-items .item:first-child").css("margin-left").replace("px", ""));
					var margin_right = parseInt($("#testimonial-'.$post_id.' .grid-items .item:first-child").css("margin-right").replace("px", ""));				
					
					items_in_desktop = items_in_desktop - (margin_left+margin_right);
					items_in_tablet = items_in_tablet - (margin_left+margin_right);				
					items_in_mobile = items_in_mobile - (margin_left+margin_right);	

					//console.log(width);


					if(width>=900){
						$("#testimonial-'.$post_id.' .grid-items .item").css("width",items_in_desktop+"px");
						//console.log("items_in_desktop");
						}
						
					if(width<900 && width>=768){
						$("#testimonial-'.$post_id.' .grid-items .item").css("width",items_in_tablet+"px");
						//console.log("items_in_tablet");
						}						
						
					if(width<768 && width>0){
						$("#testimonial-'.$post_id.' .grid-items .item").css("width",items_in_mobile+"px");
						//console.log("items_in_mobile");
						}

				}
					
					window.addEventListener("resize", myFunction);
					
					
								
				';			
			
				$html .= '})</script>';
			
			
			
			//$items_in_desktop = (100/$items_in_desktop).'';
			//$items_in_tablet = (100/$items_in_tablet).'';
			//$items_in_mobile = (100/$items_in_mobile).'';
			
			
			
			/*
			$html .= '<style type="text/css">';
			$html .= '
			@media only screen and (min-width: 1024px ) {
			#testimonial-'.$post_id.' .item{width:'.$items_in_desktop.'}
			
			}
			
			@media only screen and ( min-width: 768px ) and ( max-width: 1023px ) {
			#testimonial-'.$post_id.' .item{width:'.$items_in_tablet.'}
			}
			
			@media only screen and ( min-width: 320px ) and ( max-width: 767px ) {
			#testimonial-'.$post_id.' .item{width:'.$items_in_mobile.'}
			}

			';

			$html .= '</style>';	
			*/
			
			
			}

		
		
		/*autoHeight: true,*/