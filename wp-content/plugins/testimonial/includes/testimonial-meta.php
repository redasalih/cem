<?php

if ( ! defined('ABSPATH')) exit;


add_action('init', 'testimonial_register');
 
function testimonial_register() {
 
        $labels = array(
                'name' => _x('Testimonial', 'post type general name'),
                'singular_name' => _x('Testimonial', 'post type singular name'),
                'add_new' => _x('Add Testimonial', 'testimonial'),
                'add_new_item' => __('Add Testimonial'),
                'edit_item' => __('Edit Testimonial'),
                'new_item' => __('New Testimonial'),
                'view_item' => __('View Testimonial'),
                'search_items' => __('Search Testimonial'),
                'not_found' =>  __('Nothing found'),
                'not_found_in_trash' => __('Nothing found in Trash'),
                'parent_item_colon' => ''
        );
 
        $args = array(
                'labels' => $labels,
                'public' => true,
                'publicly_queryable' => true,
                'show_ui' => true,
                'query_var' => true,
                'menu_icon' => null,
                'rewrite' => true,
                'capability_type' => 'post',
                'hierarchical' => false,
                'menu_position' => null,
                'supports' => array('title','editor','thumbnail'),
				'menu_icon' => 'dashicons-admin-users',
				

          );
 
        register_post_type( 'testimonial' , $args );

}



// Custom Taxonomy
 
function add_testimonial_taxonomies() {
 
        register_taxonomy('testimonial_group', 'testimonial', array(
                // Hierarchical taxonomy (like categories)
                'hierarchical' => true,
                'show_admin_column' => true,
                // This array of options controls the labels displayed in the WordPress Admin UI
                'labels' => array(
                        'name' => _x( 'Testimonial Group', 'taxonomy general name' ),
                        'singular_name' => _x( 'Testimonial Group', 'taxonomy singular name' ),
                        'search_items' =>  __( 'Search Testimonial Groups' ),
                        'all_items' => __( 'All Testimonial Groups' ),
                        'parent_item' => __( 'Parent Testimonial Group' ),
                        'parent_item_colon' => __( 'Parent Testimonial Group:' ),
                        'edit_item' => __( 'Edit Testimonial Group' ),
                        'update_item' => __( 'Update Testimonial Group' ),
                        'add_new_item' => __( 'Add New Testimonial Group' ),
                        'new_item_name' => __( 'New Testimonial Group Name' ),
                        'menu_name' => __( 'Testimonial Groups' ),

                ),
                // Control the slugs used for this taxonomy
                'rewrite' => array(
                        'slug' => 'testimonial_group', // This controls the base slug that will display before each term
                        'with_front' => false, // Don't display the category base before "/locations/"
                        'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
                ),
        ));
}
add_action( 'init', 'add_testimonial_taxonomies', 0 );









/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function meta_boxes_testimonial()
	{
		$screens = array( 'testimonial' );
		foreach ( $screens as $screen )
			{
				add_meta_box('testimonial_metabox',__( 'Testimonial Options','testimonial' ),'meta_boxes_testimonial_input', $screen);
			}
	}
add_action( 'add_meta_boxes', 'meta_boxes_testimonial' );


function meta_boxes_testimonial_input( $post ) {
	
	global $post;
	wp_nonce_field( 'meta_boxes_testimonial_input', 'meta_boxes_testimonial_input_nonce' );
	
	$testimonial_member_position = get_post_meta( $post->ID, 'testimonial_member_position', true );	
	$testimonial_fb = get_post_meta( $post->ID, 'testimonial_fb', true );
	$testimonial_twitter = get_post_meta( $post->ID, 'testimonial_twitter', true );
	$testimonial_google = get_post_meta( $post->ID, 'testimonial_google', true );		
	$testimonial_pinterest = get_post_meta( $post->ID, 'testimonial_pinterest', true );	





?>




<table class="form-table">



    <tr valign="top">
        <td style="vertical-align:middle;">
        <strong>Clients Position</strong><br /><br /> 
        <input type="text" size="30" placeholder="CEO, Lead Developer, Artist "   name="testimonial_member_position" value="<?php if(!empty($testimonial_member_position)) echo $testimonial_member_position; ?>" />
        </td>
    </tr>




    <tr valign="top">
        <td style="vertical-align:middle;">
        <strong>Facebook Profile url</strong><br /><br /> 
        <input type="text" size="30" placeholder="http://facebook.com/username"   name="testimonial_fb" value="<?php if(!empty($testimonial_fb)) echo $testimonial_fb; ?>" />
        </td>
    </tr>



    <tr valign="top">
        <td style="vertical-align:middle;">
        <strong>Twitter Profile url</strong><br /><br /> 
        <input type="text" size="30" placeholder="http://twitter.com/username"   name="testimonial_twitter" value="<?php if(!empty($testimonial_twitter)) echo $testimonial_twitter; ?>" />
        </td>
    </tr>


    <tr valign="top">
        <td style="vertical-align:middle;">
        <strong>Google Plus Profile url</strong><br /><br /> 
        <input type="text" size="30" placeholder="http://plus.google.com/username"   name="testimonial_google" value="<?php if(!empty($testimonial_google)) echo $testimonial_google; ?>" />
        </td>
    </tr>

    <tr valign="top">
        <td style="vertical-align:middle;">
        <strong>Pinterest Profile url</strong><br /><br /> 
        <input type="text" size="30" placeholder="http://pinterest.com/username"   name="testimonial_pinterest" value="<?php if(!empty($testimonial_pinterest)) echo $testimonial_pinterest; ?>" />
        </td>
    </tr>




</table>





<?php


	
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function meta_boxes_testimonial_save( $post_id ) {

  /*
   * We need to verify this came from the our screen and with proper authorization,
   * because save_post can be triggered at other times.
   */

  // Check if our nonce is set.
  if ( ! isset( $_POST['meta_boxes_testimonial_input_nonce'] ) )
    return $post_id;

  $nonce = $_POST['meta_boxes_testimonial_input_nonce'];

  // Verify that the nonce is valid.
  if ( ! wp_verify_nonce( $nonce, 'meta_boxes_testimonial_input' ) )
      return $post_id;

  // If this is an autosave, our form has not been submitted, so we don't want to do anything.
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return $post_id;



  /* OK, its safe for us to save the data now. */

  // Sanitize user input.
 	$testimonial_member_position = sanitize_text_field( $_POST['testimonial_member_position'] );	 
	$testimonial_fb = sanitize_text_field( $_POST['testimonial_fb'] );	
	$testimonial_twitter = sanitize_text_field( $_POST['testimonial_twitter'] );	
	$testimonial_google = sanitize_text_field( $_POST['testimonial_google'] );
	$testimonial_pinterest = sanitize_text_field( $_POST['testimonial_pinterest'] );	
	
	
			


  // Update the meta field in the database.
	update_post_meta( $post_id, 'testimonial_member_position', $testimonial_member_position );	  
	update_post_meta( $post_id, 'testimonial_fb', $testimonial_fb );	
	update_post_meta( $post_id, 'testimonial_twitter', $testimonial_twitter );
	update_post_meta( $post_id, 'testimonial_google', $testimonial_google );
	update_post_meta( $post_id, 'testimonial_pinterest', $testimonial_pinterest );	

	

}
add_action( 'save_post', 'meta_boxes_testimonial_save' );
























function testimonial_sc_posttype_register() {
 
        $labels = array(
                'name' => _x('Testimonial showcase', 'testimonial_sc'),
                'singular_name' => _x('Testimonial showcase', 'testimonial_sc'),
                'add_new' => _x('New Testimonial showcase', 'testimonial_sc'),
                'add_new_item' => __('New Testimonial showcase'),
                'edit_item' => __('Edit Testimonial showcase'),
                'new_item' => __('New Testimonial showcase'),
                'view_item' => __('View Testimonial showcase'),
                'search_items' => __('Search Testimonial showcase'),
                'not_found' =>  __('Nothing found'),
                'not_found_in_trash' => __('Nothing found in Trash'),
                'parent_item_colon' => ''
        );
 
        $args = array(
                'labels' => $labels,
                'public' => true,
                'publicly_queryable' => true,
                'show_ui' => true,
                'query_var' => true,
                'menu_icon' => null,
                'rewrite' => true,
                'capability_type' => 'post',
                'hierarchical' => false,
                'menu_position' => null,
                'supports' => array('title'),
				'menu_icon' => 'dashicons-groups',
				
          );
 
        register_post_type( 'testimonial_sc' , $args );

}

add_action('init', 'testimonial_sc_posttype_register');





/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function meta_boxes_testimonial_sc()
	{
		$screens = array( 'testimonial_sc' );
		foreach ( $screens as $screen )
			{
				add_meta_box('testimonial_sc_metabox',__( 'Testimonial Showcase Options','testimonial_sc' ),'meta_boxes_testimonial_sc_input', $screen);
			}
	}
add_action( 'add_meta_boxes', 'meta_boxes_testimonial_sc' );


function meta_boxes_testimonial_sc_input( $post ) {
	
	global $post;
	wp_nonce_field( 'meta_boxes_testimonial_sc_input', 'meta_boxes_testimonial_sc_input_nonce' );
	
	
	$testimonial_bg_img = get_post_meta( $post->ID, 'testimonial_bg_img', true );
	$testimonial_themes = get_post_meta( $post->ID, 'testimonial_themes', true );
	$testimonial_total_items = get_post_meta( $post->ID, 'testimonial_total_items', true );	
	
	$testimonial_column_number = get_post_meta( $post->ID, 'testimonial_column_number', true );	
	$testimonial_auto_play = get_post_meta( $post->ID, 'testimonial_auto_play', true );
	$testimonial_stop_on_hover = get_post_meta( $post->ID, 'testimonial_stop_on_hover', true );
	$testimonial_slider_navigation = get_post_meta( $post->ID, 'testimonial_slider_navigation', true );
	$testimonial_slider_navigation_speed = get_post_meta( $post->ID, 'testimonial_slider_navigation_speed', true );
		
	$testimonial_slider_pagination = get_post_meta( $post->ID, 'testimonial_slider_pagination', true );
	$testimonial_pagination_slide_speed = get_post_meta( $post->ID, 'testimonial_pagination_slide_speed', true );
	$testimonial_slider_pagination_count = get_post_meta( $post->ID, 'testimonial_slider_pagination_count', true );
	
	$testimonial_slider_pagination_bg = get_post_meta( $post->ID, 'testimonial_slider_pagination_bg', true );
	$testimonial_slider_pagination_text_color = get_post_meta( $post->ID, 'testimonial_slider_pagination_text_color', true );	
	
	$testimonial_slider_touch_drag = get_post_meta( $post->ID, 'testimonial_slider_touch_drag', true );
	$testimonial_slider_mouse_drag = get_post_meta( $post->ID, 'testimonial_slider_mouse_drag', true );
	
	$testimonial_content_source = get_post_meta( $post->ID, 'testimonial_content_source', true );
	$testimonial_content_year = get_post_meta( $post->ID, 'testimonial_content_year', true );
	$testimonial_content_month = get_post_meta( $post->ID, 'testimonial_content_month', true );
	$testimonial_content_month_year = get_post_meta( $post->ID, 'testimonial_content_month_year', true );	

	$testimonial_taxonomy_category = get_post_meta( $post->ID, 'testimonial_taxonomy_category', true );
	
	$testimonial_post_ids = get_post_meta( $post->ID, 'testimonial_post_ids', true );	

	$testimonial_items_title_color = get_post_meta( $post->ID, 'testimonial_items_title_color', true );	
	$testimonial_items_title_font_size = get_post_meta( $post->ID, 'testimonial_items_title_font_size', true );
	
	$testimonial_items_content_color = get_post_meta( $post->ID, 'testimonial_items_content_color', true );	
	$testimonial_items_content_font_size = get_post_meta( $post->ID, 'testimonial_items_content_font_size', true );		

	$testimonial_items_thumb_size = get_post_meta( $post->ID, 'testimonial_items_thumb_size', true );	
	$testimonial_items_thumb_max_hieght = get_post_meta( $post->ID, 'testimonial_items_thumb_max_hieght', true );	
	


?>

    <div class="para-settings">
        <div class="option-box">
            <p class="option-title">Shortcode</p>
            
            <p class="option-info">Copy this shortcode and paste on page or post where you want to display slider. <br />Use PHP code to your themes file to display slider.</p>
        	<textarea cols="50" rows="1" style="background:#bfefff" onClick="this.select();" >[testimonial_sc <?php echo ' id="'.$post->ID.'"';?> ]</textarea>
        <br /><br />
        PHP Code:<br />
        	<textarea cols="50" rows="1" style="background:#bfefff" onClick="this.select();" ><?php echo '<?php echo do_shortcode("[testimonial_sc id='; echo "'".$post->ID."' ]"; echo '"); ?>'; ?></textarea> 
		</div>
        
        
        <ul class="tab-nav"> 
            <li nav="1" class="nav1 active">Options</li>
            <li nav="2" class="nav2">Style</li>
            <li nav="3" class="nav3">Content</li>
        </ul> <!-- tab-nav end -->
        
		<ul class="box">
            <li style="display: block;" class="box1 tab-box active">
				<div class="option-box">
                    <p class="option-title">Number of post to display.</p>
                    <p class="option-info"></p>
                    <input type="text" placeholder="ex:5 - Number Only"   name="testimonial_total_items" value="<?php if(!empty($testimonial_total_items))echo $testimonial_total_items; else echo 5; ?>" />
                </div>
            
				<div class="option-box">
                    <p class="option-title">Thumbnail Size</p>
                    <p class="option-info"></p>
                    <select name="testimonial_items_thumb_size" >
                    <option value="none" <?php if($testimonial_items_thumb_size=="none")echo "selected"; ?>>None</option>
                    <option value="thumbnail" <?php if($testimonial_items_thumb_size=="thumbnail")echo "selected"; ?>>Thumbnail</option>
                    <option value="medium" <?php if($testimonial_items_thumb_size=="medium")echo "selected"; ?>>Medium</option>
                    <option value="large" <?php if($testimonial_items_thumb_size=="large")echo "selected"; ?>>Large</option>                               
                    <option value="full" <?php if($testimonial_items_thumb_size=="full")echo "selected"; ?>>Full</option>   

                    </select>
                </div>
                
                
				<div class="option-box">
                    <p class="option-title">Thumbnail max hieght(px)</p>
                    <p class="option-info"></p>
                    <input type="text" name="testimonial_items_thumb_max_hieght" placeholder="ex:150px number with px" id="testimonial_items_thumb_max_hieght" value="<?php if(!empty($testimonial_items_thumb_max_hieght)) echo $testimonial_items_thumb_max_hieght; else echo ""; ?>" />
                    
                </div>
                
                
                
				<div class="option-box">
                    <p class="option-title">Slider Column Number.</p>
                    <p class="option-info"></p>
                    <input type="text" size="5"  name="testimonial_column_number" value="<?php if(!empty($testimonial_column_number)) echo $testimonial_column_number; else echo 1; ?>" />
                    
                    
                </div>                
                
                
				<div class="option-box">
                    <p class="option-title">Slider Auto Play.</p>
                    <p class="option-info"></p>
                    <input type="checkbox" id="testimonial_auto_play" name="testimonial_auto_play" value="true" <?php if(($testimonial_auto_play=="true")) echo "checked"; else echo ""; ?> />
                    <?php if(($testimonial_auto_play=="true")) { ?>
                    <label for="testimonial_auto_play" >Active</label>
                    <?php } 
                        
                        else
                            {
                            ?>
                            <label for="testimonial_auto_play" >Inactive</label>
                            <?php
                            }
                    ?> 
                </div>
                                
				<div class="option-box">
                    <p class="option-title">Slider Stop on Hover</p>
                    <p class="option-info"></p>
                    <input type="checkbox" id="testimonial_stop_on_hover" name="testimonial_stop_on_hover" value="true" <?php if(($testimonial_stop_on_hover=="true")) echo "checked"; else echo ""; ?> />
                    <?php if(($testimonial_stop_on_hover=="true")) { ?>
                    <label for="testimonial_stop_on_hover" >Active</label>
                    <?php } 
                        
                        else
                            {
                            ?>
                            <label for="testimonial_stop_on_hover" >Inactive</label>
                            <?php
                            }
                    ?>
                </div>         
				<div class="option-box">
                    <p class="option-title">Slider Navigation at Top</p>
                    <p class="option-info"></p>
                    <input type="checkbox" id="testimonial_slider_navigation" name="testimonial_slider_navigation" value="true" <?php if(($testimonial_slider_navigation=="true")) echo "checked"; else echo ""; ?> />
                    <?php if(($testimonial_slider_navigation=="true")) { ?>
                    <label for="testimonial_slider_navigation" >Active</label>
                    <?php } 
                        
                        else
                            {
                            ?>
                            <label for="testimonial_slider_navigation" >Inactive</label>
                            <?php
                            }
                    ?>
                </div> 
				<div class="option-box">
                    <p class="option-title">Slider Pagination at Bottom</p>
                    <p class="option-info"></p>
                    <input type="checkbox" id="testimonial_slider_pagination" name="testimonial_slider_pagination" value="true" <?php if(($testimonial_slider_pagination=="true")) echo "checked"; else echo ""; ?> />
                    <?php if(($testimonial_slider_pagination=="true")) { ?>
                    <label for="testimonial_slider_pagination" >Active</label>
                    <?php } 
                        
                        else
                            {
                            ?>
                            <label for="testimonial_slider_pagination" >Inactive</label>
                            <?php
                            }
                    ?>
                </div> 
				<div class="option-box">
                    <p class="option-title">Pagination Number Counting</p>
                    <p class="option-info"></p>
                    <input type="checkbox" id="testimonial_slider_pagination_count" name="testimonial_slider_pagination_count" value="true" <?php if(($testimonial_slider_pagination_count=="true")) echo "checked"; else echo ""; ?> />
                    <?php if(($testimonial_slider_pagination_count=="true")) { ?>
                    <label for="testimonial_slider_pagination_count" >Active</label>
                    <?php } 
                        
                    else
                        {
                        ?>
                        <label for="testimonial_slider_pagination_count" >Inactive</label>
                        <?php
                        }
                    ?>
                </div> 
                
				<div class="option-box">
                    <p class="option-title">Slide Speed</p>
                    <p class="option-info"></p> 
                    <input type="text" id="testimonial_slide_speed" name="testimonial_slide_speed" value="<?php if(!empty($testimonial_slide_speed)) echo $testimonial_slide_speed; else echo "1000"; ?>"  />
                </div> 
                
				<div class="option-box">
                    <p class="option-title">Pagination Slide Speed</p>
                    <p class="option-info"></p>
                    <input type="text" id="testimonial_pagination_slide_speed" name="testimonial_pagination_slide_speed" value="<?php if(!empty($testimonial_pagination_slide_speed)) echo $testimonial_pagination_slide_speed; else echo "1000"; ?>"  />
                </div>
                
                
				<div class="option-box">
                    <p class="option-title">Pagination Background Color</p>
                    <p class="option-info"></p>
                    <input type="text" name="testimonial_slider_pagination_bg" id="testimonial_slider_pagination_bg" value="<?php if(!empty($testimonial_slider_pagination_bg)) echo $testimonial_slider_pagination_bg; else echo "#1eb286"; ?>" />
                </div>                
                
                
				<div class="option-box">
                    <p class="option-title">Pagination Text Color</p>
                    <p class="option-info"></p>
                    <input type="text" name="testimonial_slider_pagination_text_color" id="testimonial_slider_pagination_text_color" value="<?php if(!empty($testimonial_slider_pagination_text_color)) echo $testimonial_slider_pagination_text_color; else echo "#fff"; ?>" />
                </div>                
                                
                
                
                
                
                 
                
				<div class="option-box">
                    <p class="option-title">Slider Touch Drag Enabled</p>
                    <p class="option-info"></p>
                    <input type="checkbox" id="testimonial_slider_touch_drag" name="testimonial_slider_touch_drag" value="true" <?php if(($testimonial_slider_touch_drag=="true")) echo "checked"; else echo ""; ?> />
                    <?php if(($testimonial_slider_touch_drag=="true")) { ?>
                    <label for="testimonial_slider_touch_drag" >Active</label>
                    <?php } 
                        
                    else
                        {
                        ?>
                        <label for="testimonial_slider_touch_drag" >Inactive</label>
                        <?php
                        }
                    ?>
                </div>    
				<div class="option-box">
                    <p class="option-title">Slider Mouse Drag Enabled</p>
                    <p class="option-info"></p>
                    <input type="checkbox" id="testimonial_slider_mouse_drag" name="testimonial_slider_mouse_drag" value="true" <?php if(($testimonial_slider_mouse_drag=="true")) echo "checked"; else echo ""; ?> />
                    <?php if(($testimonial_slider_mouse_drag=="true")) { ?>
                    <label for="testimonial_slider_mouse_drag" >Active</label>
                    <?php } 
                        
                    else
                        {
                        ?>
                        <label for="testimonial_slider_mouse_drag" >Inactive</label>
                        <?php
                        }
                    ?>
                </div> 
                
                
            </li>
            <li style="display: none;" class="box2 tab-box ">
				<div class="option-box">
                    <p class="option-title">Themes</p>
                    <p class="option-info"></p>
                    <select name="testimonial_themes"  >
                    <option class="testimonial_themes_flat" value="flat" <?php if($testimonial_themes=="flat")echo "selected"; ?>>Flat</option>
                    <option class="testimonial_themes_rounded" value="rounded" <?php if($testimonial_themes=="rounded")echo "selected"; ?>>Rounded</option>

                    </select>
                    
                    
                </div>
                
				<div class="option-box">
                    <p class="option-title">Background Image</p>
                    <p class="option-info"></p>
					<script>
                    jQuery(document).ready(function(jQuery)
                        {
                                jQuery(".testimonial_bg_img_list li").click(function()
                                    { 	
                                        jQuery('.testimonial_bg_img_list li.bg-selected').removeClass('bg-selected');
                                        jQuery(this).addClass('bg-selected');
                                        
                                        var testimonial_bg_img = jQuery(this).attr('data-url');
                    
                                        jQuery('#testimonial_bg_img').val(testimonial_bg_img);
                                        
                                    })	
                    
                                        
                        })
                    
                    </script> 
                    

            <?php
            
            
            
                $dir_path = testimonial_plugin_dir."css/bg/";
                $filenames=glob($dir_path."*.png*");
            
            
                $testimonial_bg_img = get_post_meta( $post->ID, 'testimonial_bg_img', true );
                
                if(empty($testimonial_bg_img))
                    {
                    $testimonial_bg_img = "";
                    }
            
            
                $count=count($filenames);
                
            
                $i=0;
                echo "<ul class='testimonial_bg_img_list' >";
            
                while($i<$count)
                    {
                        $filelink= str_replace($dir_path,"",$filenames[$i]);
                        
                        $filelink= testimonial_plugin_url."css/bg/".$filelink;
                        
                        
                        if($testimonial_bg_img==$filelink)
                            {
                                echo '<li  class="bg-selected" data-url="'.$filelink.'">';
                            }
                        else
                            {
                                echo '<li   data-url="'.$filelink.'">';
                            }
                        
                        
                        echo "<img  width='70px' height='50px' src='".$filelink."' />";
                        echo "</li>";
                        $i++;
                    }
                    
                echo "</ul>";
                
                echo "<input style='width:100%;' value='".$testimonial_bg_img."'    placeholder='Please select image or left blank' id='testimonial_bg_img' name='testimonial_bg_img'  type='text' />";
            
            
            
            ?>
                    
                    
                    
                </div>                
                
				<div class="option-box">
                    <p class="option-title">Clients Name font Color</p>
                    <p class="option-info"></p>
					<input type="text" name="testimonial_items_title_color" id="testimonial_items_title_color" value="<?php if(!empty($testimonial_items_title_color)) echo $testimonial_items_title_color; else echo "#28c8a8"; ?>" />
                </div>
                
				<div class="option-box">
                    <p class="option-title">Clients Name Font Size</p>
                    <p class="option-info"></p>
                    <input type="text" name="testimonial_items_title_font_size" placeholder="ex:14px number with px" id="testimonial_items_title_font_size" value="<?php if(!empty($testimonial_items_title_font_size)) echo $testimonial_items_title_font_size; else echo "14px"; ?>" />
                </div>                
                
                
				<div class="option-box">
                    <p class="option-title">Clients Comments font Color</p>
                    <p class="option-info"></p>
                    <input type="text" name="testimonial_items_content_color" id="testimonial_items_content_color" value="<?php if(!empty($testimonial_items_content_color)) echo $testimonial_items_content_color; else echo "#fff"; ?>" />
                </div>                
                                
				<div class="option-box">
                    <p class="option-title">Clients Comments font size</p>
                    <p class="option-info"></p>
                    <input type="text" name="testimonial_items_content_font_size" id="testimonial_items_content_font_size" value="<?php if(!empty($testimonial_items_content_font_size)) echo $testimonial_items_content_font_size; else echo "13px"; ?>" />
                </div> 
                
                                
               

            </li>
			<li style="display: none;" class="box3 tab-box ">
				<div class="option-box">
                    <p class="option-title">Filter Testimonial</p>
                    <p class="option-info"></p>
                    
<ul class="content_source_area" >

            <li><input class="testimonial_content_source" name="testimonial_content_source" id="testimonial_content_source_latest" type="radio" value="latest" <?php if($testimonial_content_source=="latest")  echo "checked";?> /> <label for="testimonial_content_source_latest">Display from Latest Published</label>
            <div class="testimonial_content_source_latest content-source-box">testimonial items will query from latest published.</div>
            </li>
            
            <li><input class="testimonial_content_source" name="testimonial_content_source" id="testimonial_content_source_older" type="radio" value="older" <?php if($testimonial_content_source=="older")  echo "checked";?> /> <label for="testimonial_content_source_older">Display from Older Published</label>
            <div class="testimonial_content_source_older content-source-box">testimonial items will query from older published.</div>
            </li>            

            <li><input class="testimonial_content_source" name="testimonial_content_source" id="testimonial_content_source_year" type="radio" value="year" <?php if($testimonial_content_source=="year")  echo "checked";?> /> <label for="testimonial_content_source_year">Display from Only Year</label>
            
            <div class="testimonial_content_source_year content-source-box">testimonial items will query from a year.
            <input type="text" size="7" class="testimonial_content_year" name="testimonial_content_year" value="<?php if(!empty($testimonial_content_year))  echo $testimonial_content_year;?>" placeholder="2014" />
            </div>
            </li>
            
            
            <li><input class="testimonial_content_source" name="testimonial_content_source" id="testimonial_content_source_month" type="radio" value="month" <?php if($testimonial_content_source=="month")  echo "checked";?> /> <label for="testimonial_content_source_month">Display from Month</label>
            
            <div class="testimonial_content_source_month content-source-box">testimonial items will query from Month of a year.		<br />
			<input type="text" size="7" class="testimonial_content_month_year" name="testimonial_content_month_year" value="<?php if(!empty($testimonial_content_month_year))  echo $testimonial_content_month_year;?>" placeholder="2014" />            
			<input type="text" size="7" class="testimonial_content_month" name="testimonial_content_month" value="<?php if(!empty($testimonial_content_month))  echo $testimonial_content_month;?>" placeholder="06" />
            </div>
            </li>            

                       
            
            </ul>
                    
                    
                    
                    
                </div>  
                
                
                
                
                
                
                
                
                
                
                
                
                
            </li>
            
            
            
            
            
            
            
            
            
            
        </ul>
        
        
        
        
    </div>
<?php


	
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function meta_boxes_testimonial_sc_save( $post_id ) {

  /*
   * We need to verify this came from the our screen and with proper authorization,
   * because save_post can be triggered at other times.
   */

  // Check if our nonce is set.
  if ( ! isset( $_POST['meta_boxes_testimonial_sc_input_nonce'] ) )
    return $post_id;

  $nonce = $_POST['meta_boxes_testimonial_sc_input_nonce'];

  // Verify that the nonce is valid.
  if ( ! wp_verify_nonce( $nonce, 'meta_boxes_testimonial_sc_input' ) )
      return $post_id;

  // If this is an autosave, our form has not been submitted, so we don't want to do anything.
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return $post_id;



  /* OK, its safe for us to save the data now. */

  // Sanitize user input.
	$testimonial_bg_img = sanitize_text_field( $_POST['testimonial_bg_img'] );	
	$testimonial_themes = sanitize_text_field( $_POST['testimonial_themes'] );
	$testimonial_total_items = sanitize_text_field( $_POST['testimonial_total_items'] );		

	$testimonial_column_number = sanitize_text_field( $_POST['testimonial_column_number'] );
	$testimonial_auto_play = sanitize_text_field( $_POST['testimonial_auto_play'] );
	$testimonial_stop_on_hover = sanitize_text_field( $_POST['testimonial_stop_on_hover'] );	
	$testimonial_slider_navigation = sanitize_text_field( $_POST['testimonial_slider_navigation'] );
	$testimonial_slide_speed = sanitize_text_field( $_POST['testimonial_slide_speed'] );
	
	$testimonial_slider_pagination = sanitize_text_field( $_POST['testimonial_slider_pagination'] );	
	$testimonial_pagination_slide_speed = sanitize_text_field( $_POST['testimonial_pagination_slide_speed'] );
	$testimonial_slider_pagination_count = sanitize_text_field( $_POST['testimonial_slider_pagination_count'] );
	
	$testimonial_slider_pagination_bg = sanitize_text_field( $_POST['testimonial_slider_pagination_bg'] );
	$testimonial_slider_pagination_text_color = sanitize_text_field( $_POST['testimonial_slider_pagination_text_color'] );	
	
	$testimonial_slider_touch_drag = sanitize_text_field( $_POST['testimonial_slider_touch_drag'] );
	$testimonial_slider_mouse_drag = sanitize_text_field( $_POST['testimonial_slider_mouse_drag'] );	
	
	$testimonial_content_source = sanitize_text_field( $_POST['testimonial_content_source'] );
	$testimonial_content_year = sanitize_text_field( $_POST['testimonial_content_year'] );
	$testimonial_content_month = sanitize_text_field( $_POST['testimonial_content_month'] );
	$testimonial_content_month_year = sanitize_text_field( $_POST['testimonial_content_month_year'] );	

	$testimonial_taxonomy_category = stripslashes_deep( $_POST['testimonial_taxonomy_category'] );
	
	$testimonial_post_ids = stripslashes_deep( $_POST['testimonial_post_ids'] );	

	$testimonial_items_title_color = sanitize_text_field( $_POST['testimonial_items_title_color'] );	
	$testimonial_items_title_font_size = sanitize_text_field( $_POST['testimonial_items_title_font_size'] );	

	$testimonial_items_content_color = sanitize_text_field( $_POST['testimonial_items_content_color'] );	
	$testimonial_items_content_font_size = sanitize_text_field( $_POST['testimonial_items_content_font_size'] );	

	$testimonial_items_thumb_size = sanitize_text_field( $_POST['testimonial_items_thumb_size'] );
	$testimonial_items_thumb_max_hieght = sanitize_text_field( $_POST['testimonial_items_thumb_max_hieght'] );	
	
	
	
			


  // Update the meta field in the database.
	update_post_meta( $post_id, 'testimonial_bg_img', $testimonial_bg_img );	
	update_post_meta( $post_id, 'testimonial_themes', $testimonial_themes );
	update_post_meta( $post_id, 'testimonial_total_items', $testimonial_total_items );	

	update_post_meta( $post_id, 'testimonial_column_number', $testimonial_column_number );	
	update_post_meta( $post_id, 'testimonial_auto_play', $testimonial_auto_play );
	update_post_meta( $post_id, 'testimonial_stop_on_hover', $testimonial_stop_on_hover );	
	update_post_meta( $post_id, 'testimonial_slider_navigation', $testimonial_slider_navigation );
	update_post_meta( $post_id, 'testimonial_slide_speed', $testimonial_slide_speed );
		
	update_post_meta( $post_id, 'testimonial_slider_pagination', $testimonial_slider_pagination );
	update_post_meta( $post_id, 'testimonial_pagination_slide_speed', $testimonial_pagination_slide_speed );
	update_post_meta( $post_id, 'testimonial_slider_pagination_count', $testimonial_slider_pagination_count );
	
	update_post_meta( $post_id, 'testimonial_slider_pagination_bg', $testimonial_slider_pagination_bg );
	update_post_meta( $post_id, 'testimonial_slider_pagination_text_color', $testimonial_slider_pagination_text_color );		
	
	update_post_meta( $post_id, 'testimonial_slider_touch_drag', $testimonial_slider_touch_drag );
	update_post_meta( $post_id, 'testimonial_slider_mouse_drag', $testimonial_slider_mouse_drag );
	
	update_post_meta( $post_id, 'testimonial_content_source', $testimonial_content_source );
	update_post_meta( $post_id, 'testimonial_content_year', $testimonial_content_year );
	update_post_meta( $post_id, 'testimonial_content_month', $testimonial_content_month );
	update_post_meta( $post_id, 'testimonial_content_month_year', $testimonial_content_month_year );	

	update_post_meta( $post_id, 'testimonial_taxonomy_category', $testimonial_taxonomy_category );

	update_post_meta( $post_id, 'testimonial_post_ids', $testimonial_post_ids );	

	update_post_meta( $post_id, 'testimonial_items_title_color', $testimonial_items_title_color );
	update_post_meta( $post_id, 'testimonial_items_title_font_size', $testimonial_items_title_font_size );

	update_post_meta( $post_id, 'testimonial_items_content_color', $testimonial_items_content_color );
	update_post_meta( $post_id, 'testimonial_items_content_font_size', $testimonial_items_content_font_size );

	update_post_meta( $post_id, 'testimonial_items_thumb_size', $testimonial_items_thumb_size );	
	update_post_meta( $post_id, 'testimonial_items_thumb_max_hieght', $testimonial_items_thumb_max_hieght );
	

	

}
add_action( 'save_post', 'meta_boxes_testimonial_sc_save' );
