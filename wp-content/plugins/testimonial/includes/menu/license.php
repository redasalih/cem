<?php	


/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access



if(empty($_POST['testimonial_hidden']))
	{



	}
else
	{
		if($_POST['testimonial_hidden'] == 'Y') {

	

			?>
			<div class="updated"><p><strong><?php _e('Changes Saved.', 'testimonial' ); ?></strong></p></div>
	
			<?php
			} 
	}
	
	
	
?>





<div class="wrap">

	<div id="icon-tools" class="icon32"><br></div><?php echo "<h2>".__(testimonial_plugin_name.' License', 'testimonial')."</h2>";?>
		<form  method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	<input type="hidden" name="testimonial_hidden" value="Y">
        <?php settings_fields( 'testimonial_plugin_options' );
				do_settings_sections( 'testimonial_plugin_options' );
			
		?>

    <div class="para-settings testimonial-settings">
    
        <ul class="tab-nav"> 
            <li nav="1" class="nav1 active">Activation</li>       
  
        </ul> <!-- tab-nav end --> 
		<ul class="box">
       		<li style="display: block;" class="box1 tab-box active">
            
				<div class="option-box">
                    <p class="option-title">Activate license</p>

                	<?php

    /*** License activate button was clicked ***/
    if (isset($_REQUEST['activate_license'])) {
        $license_key = $_REQUEST['testimonial_license'];

		if(is_multisite())
			{
				$domain = site_url();
			}
		else
			{
				$domain = $_SERVER['SERVER_NAME'];
			}

        // API query parameters
        $api_params = array(
            'slm_action' => 'slm_activate',
            'secret_key' => testimonial_SPECIAL_SECRET_KEY,
            'license_key' => $license_key,
            'registered_domain' => $domain,
            'item_reference' => urlencode(testimonial_ITEM_REFERENCE),
        );

        // Send query to the license manager server
        $response = wp_remote_get(add_query_arg($api_params, testimonial_LICENSE_SERVER_URL), array('timeout' => 20, 'sslverify' => false));

        // Check for error in the response
        if (is_wp_error($response)){
            echo "Unexpected Error! The query returned with an error.";
        }

        //var_dump($response);//uncomment it if you want to look at the full response
        
        // License data.
        $license_data = json_decode(wp_remote_retrieve_body($response));
        
        // TODO - Do something with it.
        //var_dump($license_data);//uncomment it to look at the data
        
        if($license_data->result == 'success'){//Success was returned for the license activation
            
            //Uncomment the followng line to see the message that returned from the license server
            echo '<br />The following message was returned from the server: <strong class="option-info">'.$license_data->message.'</strong>';
            
            //Save the license key in the options table
			
			//echo '<pre>'.var_export($license_data, true).'</pre>';
			
			$testimonial_license = array(
											'date_created'=>$license_data->date_created,
											'date_renewed'=>$license_data->date_renewed,
											'date_expiry'=>$license_data->date_expiry,
											'key'=>$license_key,
											'status'=>$license_data->status,

											);
			
            update_option('testimonial_license', $testimonial_license); 
        }
        else{
            //Show error to the user. Probably entered incorrect license key.
            
            //Uncomment the followng line to see the message that returned from the license server
            echo '<br />The following message was returned from the server: <strong class="option-info">'.$license_data->message.'</strong>';
        }

    }
    /*** End of license activation ***/
    
    /*** License activate button was clicked ***/
    if (isset($_REQUEST['deactivate_license'])) {
        $license_key = $_REQUEST['testimonial_license'];


		if(is_multisite())
			{
				$domain = site_url();
			}
		else
			{
				$domain = $_SERVER['SERVER_NAME'];
			}

        // API query parameters
        $api_params = array(
            'slm_action' => 'slm_deactivate',
            'secret_key' => testimonial_SPECIAL_SECRET_KEY,
            'license_key' => $license_key,
            'registered_domain' => $domain,
            'item_reference' => urlencode(testimonial_ITEM_REFERENCE),
        );

        // Send query to the license manager server
        $response = wp_remote_get(add_query_arg($api_params, testimonial_LICENSE_SERVER_URL), array('timeout' => 20, 'sslverify' => false));

        // Check for error in the response
        if (is_wp_error($response)){
            echo "Unexpected Error! The query returned with an error.";
        }

        //var_dump($response);//uncomment it if you want to look at the full response
        
        // License data.
        $license_data = json_decode(wp_remote_retrieve_body($response));
        
        // TODO - Do something with it.
        //var_dump($license_data);//uncomment it to look at the data
		
      //  echo '<pre>'.var_export($license_data, true).'</pre>';
		
        if($license_data->result == 'success'){//Success was returned for the license activation
            
            //Uncomment the followng line to see the message that returned from the license server
            echo '<br />The following message was returned from the server: <strong class="option-info">'.$license_data->message.'</strong>';
            
            //Remove the licensse key from the options table. It will need to be activated again.
			
			
			$testimonial_license = array(
											'date_created'=>$license_data->date_created,
											'date_renewed'=>$license_data->date_renewed,
											'date_expiry'=>$license_data->date_expiry,
											'key'=>$license_key,
											'status'=>$license_data->status,

											);
			
			
			
            update_option('testimonial_license', $testimonial_license);
        }
        else{
            //Show error to the user. Probably entered incorrect license key.
            
            //Uncomment the followng line to see the message that returned from the license server
            echo '<br />The following message was returned from the server: <strong class="option-info">'.$license_data->message.'</strong>';
        }
        
    }
    /*** End of sample license deactivation ***/
    
    ?>
    
    
                    
	<?php
    
        $testimonial_license = get_option('testimonial_license');
        

       // var_dump($testimonial_license);
    ?>
    
    
    <p class="option-info">Status: <b><?php if(!empty($testimonial_license['status'])) echo ucfirst($testimonial_license['status']); ?></b></p>
    

<!-- 
    <p class="option-info">Purchase date: <b><?php if(!empty($testimonial_license['date_created'])) echo ucfirst($testimonial_license['date_created']); ?></b></p>
    <p class="option-info">Renew date: <b><?php if(!empty($testimonial_license['date_renewed'])) echo ucfirst($testimonial_license['date_renewed']); ?></b></p>       
    <p class="option-info">Expiry date: <b><?php  if(!empty($testimonial_license['date_expiry'])) echo ucfirst($testimonial_license['date_expiry']); ?></b></p>

--> 
    

    
    <p>Enter the license key for this product to activate it. You were given a license key when you purchased this item. please visit <a href="<?php echo testimonial_LICENSE_KEYS_PAGE; ?>"><?php echo testimonial_LICENSE_KEYS_PAGE; ?></a> after logged-in you will see license key for your purchased product. </p>
    
    <p>If you have any problem regarding license activatin please contact for support <a href="<?php echo testimonial_conatct_url; ?>"><?php echo testimonial_conatct_url; ?></a></p>    
    

        <table class="form-table">
            <tr>
                <th style="width:100px;"><label for="testimonial_license_key">License Key</label></th>
                <td >
                <input class="regular-text" type="text" id="testimonial_license_key" name="testimonial_license"  value="<?php if(!empty($testimonial_license['key'])) echo $testimonial_license['key']; ?>" >

                
                </td>
            </tr>
        </table>



                </div>
            
            </li>
           
        </ul>
    
    
		

        
    </div>






        <p class="submit">
            <input type="submit" name="activate_license" value="Activate" class="button-primary" />
            <input type="submit" name="deactivate_license" value="Deactivate" class="button" />
        </p>
		</form>


</div>
