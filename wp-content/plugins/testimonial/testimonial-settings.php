<?php	

	if(empty($_POST['testimonial_hidden']))
		{
			$testimonial_ribbons = get_option( 'testimonial_ribbons' );
			
			
		}
	else
		{
					
				
		if($_POST['testimonial_hidden'] == 'Y') {
			//Form data sent

			$testimonial_ribbons = stripslashes_deep($_POST['testimonial_ribbons']);
			update_option('testimonial_ribbons', $testimonial_ribbons);
			
		
			
					

			?>
			<div class="updated"><p><strong><?php _e('Changes Saved.' ); ?></strong></p></div>

			<?php
		} 
	}
?>





<div class="wrap">

	<div id="icon-tools" class="icon32"><br></div><?php echo "<h2>".__('testimonial Settings')."</h2>";?>
		<form  method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	<input type="hidden" name="testimonial_hidden" value="Y">
        <?php settings_fields( 'testimonial_plugin_options' );
				do_settings_sections( 'testimonial_plugin_options' );
			
		?>
        
        
    
        
<table class="form-table">





	<tr valign="top">
        <td style="vertical-align:middle;">
        <strong>Ribbons</strong><br /><br /> 
    	<span style=" color:#22aa5d;font-size: 12px;">You can use your own ribbons icon by inserting ribbon url to text field, image size for ribbons must be same as 90px × 24px</span>
        <table>
        
        	<tr>
            <td>Best</td>
            <td><img title="size - 90px * 24px " src="<?php if(empty($testimonial_ribbons["best"])) echo testimonial_plugin_url."css/ribbons/best.png";  else echo $testimonial_ribbons["best"]; ?>"  /></td>
            <td><input class="testimonial_ribbons" size="50%" name="testimonial_ribbons[best]" type="text" value="<?php if(empty($testimonial_ribbons["best"])) echo testimonial_plugin_url."css/ribbons/best.png";  else echo $testimonial_ribbons["best"]; ?>"  /></td>
            </tr>
          
        </table>
    
    
    
    
        </td>
    </tr>
</table>






<p class="submit">
                    <input class="button button-primary" type="submit" name="Submit" value="<?php _e('Save Changes' ) ?>" />
                </p>
		</form>


</div>
