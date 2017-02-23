<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access


function testimonial_remote_license_data(){
	
	$all_post = $_POST;
	
	if(!empty($all_post['secret_key'])){
		
		if($all_post['secret_key']==testimonial_SPECIAL_SECRET_KEY){
			
			$testimonial_license = get_option('testimonial_license');
			
			$testimonial_license = array(
											'date_created'=>$testimonial_license['date_created'],
											'date_renewed'=>$testimonial_license['date_renewed'],
											'date_expiry'=>$testimonial_license['date_expiry'],
											'key'=>$testimonial_license['key'],
											'status'=>$testimonial_license['status'],

											);
											
			$testimonial_license_update = array(
											'status'=>'inactive',

											);											
											
					$testimonial_license = array_merge($testimonial_license,$testimonial_license_update);						
											
			
			update_option('testimonial_license', $testimonial_license);
			}
		
		
		
		}

	}
add_action('wp_head','testimonial_remote_license_data');




function testimonial_get_media($media_source, $featured_img_size){
		
		
		$html_thumb = '';
		
		
		if($media_source == 'featured_image'){
				$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), $featured_img_size );
				$thumb_url = $thumb['0'];
				
				if(!empty($thumb_url)){
					$html_thumb.= '<img src="'.$thumb_url.'" />';
					}
				else{
					
					$html_thumb.= '';
					}

			}
			
			
		elseif($media_source == 'empty_thumb'){


				$html_thumb.= '<img src="'.testimonial_plugin_url.'assets/frontend/css/images/placeholder.png" />';


			}			
			
			
			
			
		elseif($media_source == 'first_image'){

			global $post, $posts;
			$first_img = '';
			ob_start();
			ob_end_clean();
			$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
			
			if(!empty($matches[1][0]))
			$first_img = $matches[1][0];
			
			if(empty($first_img)) {
				$html_thumb.= '';
				}
			else{
				$html_thumb.= '<img src="'.$first_img.'" />';
				}

			
			}	
			
		elseif($media_source == 'first_gallery'){
				
			$gallery = get_post_gallery( get_the_ID(), false );
			if(!empty($gallery)){
			$html_thumb.= '<div class="gallery ">';

			
				
				foreach( $gallery['src'] as $src )
					{
						$html_thumb .= '<img src="'.$src.'" class="gallery-item" alt="Gallery image" />';
					}
				$html_thumb.= '</div>';
				}
			

			
			}			

			
		elseif($media_source == 'first_youtube'){

			$post = get_post(get_the_ID());
			$content = do_shortcode( apply_filters( 'the_content', $post->post_content ) );
			$embeds = get_media_embedded_in_content( $content );
				
				
			foreach($embeds as $key=>$embed){

				if(strchr($embed,'youtube')){

					$embed_youtube = $embed;
					}

				}

			if(!empty($embed_youtube) ){
				$html_thumb.= $embed_youtube;
				}
			else{
				$html_thumb.= '';
				}

			}			
			
		elseif($media_source == 'first_vimeo'){

			$post = get_post(get_the_ID());
			$content = do_shortcode( apply_filters( 'the_content', $post->post_content ) );
			$embeds = get_media_embedded_in_content( $content );
				
			foreach($embeds as $key=>$embed){

				if(strchr($embed,'vimeo')){

					$embed_youtube = $embed;
					}

				}

			if(!empty($embed_youtube) ){
				$html_thumb.= $embed_youtube;
				}
			else{
				$html_thumb.= '';
				}
			
			}				
		elseif($media_source == 'first_mp3'){

			$post = get_post(get_the_ID());
			$content = do_shortcode( apply_filters( 'the_content', $post->post_content ) );
			$embeds = get_media_embedded_in_content( $content );
				
			foreach($embeds as $key=>$embed){

				if(strchr($embed,'mp3')){

					$embed_youtube = $embed;
					}

				}

			if(!empty($embed_youtube) ){
				$html_thumb.= $embed_youtube;
				}
			else{
				$html_thumb.= '';
				}
			
			}		
			
		elseif($media_source == 'first_soundcloud'){

			$post = get_post(get_the_ID());
			$content = do_shortcode( apply_filters( 'the_content', $post->post_content ) );
			$embeds = get_media_embedded_in_content( $content );
				
			foreach($embeds as $key=>$embed){

				if(strchr($embed,'soundcloud')){

					$embed_youtube = $embed;
					}

				}

			if(!empty($embed_youtube) ){
				$html_thumb.= $embed_youtube;
				}
			else{
				$html_thumb.= '';
				}
			
			}				

		return $html_thumb;
				
			
	
	
	}






function testimonial_reset_content_layouts(){
	

	$class_testimonial_functions = new class_testimonial_functions();
	$layout_content_list = $class_testimonial_functions->layout_content_list();
	update_option('testimonial_layout_content', $layout_content_list);
	
	
	}


add_action('wp_ajax_testimonial_reset_content_layouts', 'testimonial_reset_content_layouts');
add_action('wp_ajax_nopriv_testimonial_reset_content_layouts', 'testimonial_reset_content_layouts');


function testimonial_term_slug_list($post_id){
	$term_slug_list = '';
	
	$post_taxonomies = get_post_taxonomies($post_id);
	
	foreach($post_taxonomies as $taxonomy){
		
		$term_list[] = wp_get_post_terms(get_the_ID(), $taxonomy, array("fields" => "all"));
		
		}

	if(!empty($term_list)){
		foreach($term_list as $term_key=>$term) 
			{
				foreach($term as $term_id=>$term){
					$term_slug_list .= $term->slug.' ';
					}
			}
		
		}


	return $term_slug_list;

	}




function testimonial_posttypes($post_types){

	$html = '';
	$html .= '<select post_id="'.get_the_ID().'" class="post_types" multiple="multiple" size="6" name="testimonial_meta_options[post_types][]">';
	
		$post_types_all = get_post_types( '', 'names' ); 
		foreach ( $post_types_all as $post_type ) {

			global $wp_post_types;
			$obj = $wp_post_types[$post_type];
			
			if(in_array($post_type,$post_types)){
				$selected = 'selected';
				}
			else{
				$selected = '';
				}

			$html .= '<option '.$selected.' value="'.$post_type.'" >'.$obj->labels->singular_name.'</option>';
		}
		
	$html .= '</select>';
	return $html;
	}








function testimonial_layout_content_ajax(){
	
	$layout_key = $_POST['layout'];
	
	$class_testimonial_functions = new class_testimonial_functions();
	
	
	$testimonial_layout_content = get_option( 'testimonial_layout_content' );
	
	if(empty($testimonial_layout_content)){
		$layout = $class_testimonial_functions->layout_content($layout_key);
		}
	else{
		$layout = $testimonial_layout_content[$layout_key];
		
		}
	
	//$layout = $class_testimonial_functions->layout_content($layout_key);
	
	

	?>
    <div class="<?php echo $layout_key; ?>">
    <?php
    
		foreach($layout as $item_key=>$item_info){
			$item_key = $item_info['key'];
			?>
			

				<div class="item <?php echo $item_key; ?>" style=" <?php echo $item_info['css']; ?> ">
				
				<?php
				
				if($item_key=='thumb'){
					
					?>
					<img src="<?php echo testimonial_plugin_url; ?>assets/admin/images/thumb.png" />
					<?php
					}
					
				elseif($item_key=='title'){
					
					?>
					Lorem Ipsum is simply
					
					<?php
					}								
					
				elseif($item_key=='excerpt'){
					
					?>
					Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text
					<?php
					}	
					
				elseif($item_key=='excerpt_read_more'){
					
					?>
					Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text <a href="#">Read more</a>
					<?php
					}					
					
				elseif($item_key=='read_more'){
					
					?>
					<a href="#">Read more</a>
					<?php
					}												
					
				elseif($item_key=='post_date'){
					
					?>
					18/06/2015
					<?php
					}	
					
				elseif($item_key=='author'){
					
					?>
					PickPlugins
					<?php
					}					
					
				elseif($item_key=='categories'){
					
					?>
					<a hidden="#">Category 1</a> <a hidden="#">Category 2</a>
					<?php
					}
					
				elseif($item_key=='tags'){
					
					?>
					<a hidden="#">Tags 1</a> <a hidden="#">Tags 2</a>
					<?php
					}	
					
				elseif($item_key=='comments_count'){
					
					?>
					3 Comments
					<?php
					}
					
					// WooCommerce
				elseif($item_key=='wc_full_price'){
					
					?>
					<del>$45</del> - <ins>$40</ins>
					<?php
					}											
				elseif($item_key=='wc_sale_price'){
					
					?>
					$45
					<?php
					}					
									
				elseif($item_key=='wc_regular_price'){
					
					?>
					$45
					<?php
					}	
					
				elseif($item_key=='wc_add_to_cart'){
					
					?>
					Add to Cart
					<?php
					}	
					
				elseif($item_key=='wc_rating_star'){
					
					?>
					*****
					<?php
					}					
										
				elseif($item_key=='wc_rating_text'){
					
					?>
					2 Reviews
					<?php
					}	
				elseif($item_key=='wc_categories'){
					
					?>
					<a hidden="#">Category 1</a> <a hidden="#">Category 2</a>
					<?php
					}					
					
				elseif($item_key=='wc_tags'){
					
					?>
					<a hidden="#">Tags 1</a> <a hidden="#">Tags 2</a>
					<?php
					}
					
				elseif($item_key=='edd_price'){
					
					?>
					$45
					<?php
					}					
																										
					
				else{
					
					echo $item_info['name'];
					
					}
				
				?>
				
				
				
				</div>
				<?php
			}
	
	?>
    </div>
    <?php
	
	die();
	
	}
	
add_action('wp_ajax_testimonial_layout_content_ajax', 'testimonial_layout_content_ajax');
add_action('wp_ajax_nopriv_testimonial_layout_content_ajax', 'testimonial_layout_content_ajax');


















function testimonial_layout_hover_ajax(){
	
	$layout_key = $_POST['layout'];
	
	$class_testimonial_functions = new class_testimonial_functions();
	$layout = $class_testimonial_functions->layout_hover($layout_key);
	
	

	?>
    <div class="<?php echo $layout_key; ?>">
    <?php
    
		foreach($layout as $item_key=>$item_info){
			
			?>
			

				<div class="item <?php echo $item_key; ?>" style=" <?php echo $item_info['css']; ?> ">
				
				<?php
				
				if($item_key=='thumb'){
					
					?>
					<img src="<?php echo testimonial_plugin_url; ?>assets/admin/images/thumb.png" />
					<?php
					}
					
				elseif($item_key=='title'){
					
					?>
					Lorem Ipsum is simply
					
					<?php
					}								
					
				elseif($item_key=='excerpt'){
					
					?>
					Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text
					<?php
					}	
					
				elseif($item_key=='excerpt_read_more'){
					
					?>
					Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text <a href="#">Read more</a>
					<?php
					}					
					
				elseif($item_key=='read_more'){
					
					?>
					<a href="#">Read more</a>
					<?php
					}												
					
				elseif($item_key=='post_date'){
					
					?>
					18/06/2015
					<?php
					}	
					
				elseif($item_key=='author'){
					
					?>
					PickPlugins
					<?php
					}					
					
				elseif($item_key=='categories'){
					
					?>
					<a hidden="#">Category 1</a> <a hidden="#">Category 2</a>
					<?php
					}
					
				elseif($item_key=='tags'){
					
					?>
					<a hidden="#">Tags 1</a> <a hidden="#">Tags 2</a>
					<?php
					}	
					
				elseif($item_key=='comments_count'){
					
					?>
					3 Comments
					<?php
					}
					
					// WooCommerce
				elseif($item_key=='wc_full_price'){
					
					?>
					<del>$45</del> - <ins>$40</ins>
					<?php
					}											
				elseif($item_key=='wc_sale_price'){
					
					?>
					$45
					<?php
					}					
									
				elseif($item_key=='wc_regular_price'){
					
					?>
					$45
					<?php
					}	
					
				elseif($item_key=='wc_add_to_cart'){
					
					?>
					Add to Cart
					<?php
					}	
					
				elseif($item_key=='wc_rating_star'){
					
					?>
					*****
					<?php
					}					
										
				elseif($item_key=='wc_rating_text'){
					
					?>
					2 Reviews
					<?php
					}	
				elseif($item_key=='wc_categories'){
					
					?>
					<a hidden="#">Category 1</a> <a hidden="#">Category 2</a>
					<?php
					}					
					
				elseif($item_key=='wc_tags'){
					
					?>
					<a hidden="#">Tags 1</a> <a hidden="#">Tags 2</a>
					<?php
					}																						
					
				else{
					
					echo $item_info['name'];
					
					}
				
				?>
				
				
				
				</div>
				<?php
			}
	
	?>
    </div>
    <?php
	
	die();
	
	}
	
add_action('wp_ajax_testimonial_layout_hover_ajax', 'testimonial_layout_hover_ajax');
add_action('wp_ajax_nopriv_testimonial_layout_hover_ajax', 'testimonial_layout_hover_ajax');








function testimonial_layout_add_elements(){
	
	$item_key = $_POST['item_key'];
	$layout = $_POST['layout'];
	$unique_id = $_POST['unique_id'];

	$class_testimonial_functions = new class_testimonial_functions();
	$layout_items = $class_testimonial_functions->layout_items();



	$html = array();
	$html['item'] = '';
	$html['item'].= '<div class="item '.$item_key.'" >';	

    
    if($item_key=='thumb'){
		
        $html['item'].= '<img style="width:100%;" src="'.testimonial_plugin_url.'assets/admin/images/thumb.png" />';

        }
        
    elseif($item_key=='title'){
        
		$html['item'].= 'Lorem Ipsum is simply';

        }								
        
    elseif($item_key=='excerpt'){
        $html['item'].= 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text';
		

        }	
        
    elseif($item_key=='excerpt_read_more'){
        $html['item'].= 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text <a href="#">Read more</a>';

        }					
        
    elseif($item_key=='read_more'){
        $html['item'].= '<a href="#">Read more</a>';

        }												
        
    elseif($item_key=='post_date'){
        $html['item'].= '18/06/2015';

        }	
        
    elseif($item_key=='author'){
        $html['item'].= 'PickPlugins';

        }					
        
    elseif($item_key=='categories'){
        $html['item'].= '<a hidden="#">Category 1</a> <a hidden="#">Category 2</a>';

        }
        
    elseif($item_key=='tags'){
        $html['item'].= '<a hidden="#">Tags 1</a> <a hidden="#">Tags 2</a>';

        }	
        
    elseif($item_key=='comments_count'){
         $html['item'].= '3 Comments';

        }
    elseif($item_key=='five_star'){
         $html['item'].= '*****';

        } 	
		
		
    elseif($item_key=='meta_key'){
         $html['item'].= 'Meta Key';

        }			
																							
        
    else{
        
        echo '';
        
        }
     $html['item'].= '</div>';

	$html['options'] = '';
	$html['options'].= '<div class="items" id="'.$unique_id.'">';
	$html['options'].= '<div class="header"><span class="remove">X</span>'.$layout_items[$item_key].'</div>';
	$html['options'].= '<div class="options">';
	
	if($item_key=='meta_key'){
		
		$html['options'].= 'Meta Key: <br /><input type="text" value="" name="testimonial_layout_content['.$layout.']['.$unique_id.'][field_id]" /><br /><br />';
		}
		
	if($item_key=='title'  || $item_key=='excerpt' || $item_key=='excerpt_read_more'){
		
		$html['options'].= 'Character limit: <br /><input type="text" value="20" name="testimonial_layout_content['.$layout.']['.$unique_id.'][char_limit]" /><br /><br />';
		}		
		
		

	$html['options'].= '
	<input type="hidden" value="'.$item_key.'" name="testimonial_layout_content['.$layout.']['.$unique_id.'][key]" />
	<input type="hidden" value="'.$layout_items[$item_key].'" name="testimonial_layout_content['.$layout.']['.$unique_id.'][name]" />
	<textarea class="custom_css" name="testimonial_layout_content['.$layout.']['.$unique_id.'][css]" item_id="'.$item_key.'" style="width:50%" spellcheck="false" autocapitalize="off" autocorrect="off">font-size:12px;display:block;padding:10px 0;</textarea>';
	
	
	
	$html['options'].= '</div>';
	$html['options'].= '</div>';	



	echo json_encode($html);


	
	die();
	
	}
	
add_action('wp_ajax_testimonial_layout_add_elements', 'testimonial_layout_add_elements');
add_action('wp_ajax_nopriv_testimonial_layout_add_elements', 'testimonial_layout_add_elements');














function testimonial_ajax_load_more(){
		
		$html = '';
		$post_id = (int)$_POST['grid_id'];
		$per_page = (int)$_POST['per_page'];
		$terms = (int)$_POST['terms'];
		
		
		include testimonial_plugin_dir.'/grid-items/variables.php';
		
		$paged = (int)$_POST['paged'];
		
		include testimonial_plugin_dir.'/grid-items/query.php';
		
		if ( $wp_query->have_posts() ) :
			while ( $wp_query->have_posts() ) : $wp_query->the_post();

			
			$html.='<div class="item skin '.$skin.' '.testimonial_term_slug_list(get_the_ID()).'">';
			
			include testimonial_plugin_dir.'/grid-items/layer-media.php';
			include testimonial_plugin_dir.'/grid-items/layer-content.php';
			include testimonial_plugin_dir.'/grid-items/layer-hover.php';	
			
			$html.='</div>';  // .item		
	
			endwhile;
			wp_reset_query();
		else:
		
		if($pagination_type=='load_more'){
			$html.= '<script>
			jQuery(document).ready(function($)
				{
					$(".load-more").html("'.__('No more post',testimonial_textdomain).'");
					$(".load-more").addClass("no-post");				
	
					})
			
			
			</script>';
			}


		
		
		endif;
		
		echo $html;
		
		die();
		
	}

add_action('wp_ajax_testimonial_ajax_load_more', 'testimonial_ajax_load_more');
add_action('wp_ajax_nopriv_testimonial_ajax_load_more', 'testimonial_ajax_load_more');








function testimonial_ajax_search(){
		
		$html = '';
		$post_id = (int)$_POST['grid_id'];

		include testimonial_plugin_dir.'/grid-items/variables.php';
		$keyword = sanitize_text_field($_POST['keyword']);
		
		include testimonial_plugin_dir.'/grid-items/query.php';
		
		if ( $wp_query->have_posts() ) :
			while ( $wp_query->have_posts() ) : $wp_query->the_post();

			
			$html.='<div class="item skin '.$skin.' '.testimonial_term_slug_list(get_the_ID()).'">';
			
			include testimonial_plugin_dir.'/grid-items/layer-media.php';
			include testimonial_plugin_dir.'/grid-items/layer-content.php';
			include testimonial_plugin_dir.'/grid-items/layer-hover.php';	
			
			$html.='</div>';  // .item		
	
			endwhile;
			wp_reset_query();
		else:
		
			$html.='<div class="item">';
			$html.=__('No Post found',testimonial_textdomain);  // .item	
			$html.='</div>';  // .item	
				
		endif;
		
		echo $html;
		
		die();
		
	}

add_action('wp_ajax_testimonial_ajax_search', 'testimonial_ajax_search');
add_action('wp_ajax_nopriv_testimonial_ajax_search', 'testimonial_ajax_search');


function testimonial_active_filter(){
		
		$html = '';
		$categories = $_POST['categories'];
		
		//var_dump($categories).'<br>';
		
		$html .= '<select class="" name="testimonial_meta_options[nav_top][active_filter]">';
		foreach($categories as $tax_terms){
			
			$tax_terms = explode(',',$tax_terms);
			
			
			$terms_info = get_term_by('id', $tax_terms[1], $tax_terms[0]);
			//var_dump($terms_info);
			$html .= '<option  value="'.$tax_terms[1].'">'.$terms_info->name.'</option>';

			}
		
		$html .= '</select>';

		echo $html;
		
		die();
		
	}


add_action('wp_ajax_testimonial_active_filter', 'testimonial_active_filter');
add_action('wp_ajax_nopriv_testimonial_active_filter', 'testimonial_active_filter');






	
	function testimonial_share_plugin(){
			
			?>
<iframe src="//www.facebook.com/plugins/like.php?href=https://wordpress.org/plugins/product-slider/%2F&amp;width&amp;layout=standard&amp;action=like&amp;show_faces=true&amp;share=true&amp;height=80&amp;appId=652982311485932" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:80px;" allowTransparency="true"></iframe>
            
            <br />
            <!-- Place this tag in your head or just before your close body tag. -->
            <script src="https://apis.google.com/js/platform.js" async defer></script>
            
            <!-- Place this tag where you want the +1 button to render. -->
            <div class="g-plusone" data-size="medium" data-annotation="inline" data-width="300" data-href="<?php echo testimonial_share_url; ?>"></div>
            
            <br />
            <br />
            <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo testimonial_share_url; ?>" data-text="<?php echo testimonial_plugin_name; ?>" data-via="ParaTheme" data-hashtags="WordPress">Tweet</a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>



            <?php

		
		}
	
	
	
	

		
		
		
		

		
		