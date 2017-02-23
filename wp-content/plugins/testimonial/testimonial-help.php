<div class="wrap">
	<?php echo "<h2>".__('Testimonial Help')."</h2>";?>
    <br />

		  
        
        
<h3>Have any issue ?</h3>

<p>Feel free to Contact with any issue for this plugin, Ask any question via forum <a href="http://paratheme.com/qa/">http://paratheme.com/qa/</a> <strong style="color:#139b50;">(its free!)</strong>



</p>

<?php

$testimonial_customer_type = get_option('testimonial_customer_type');
$testimonial_version = get_option('testimonial_version');


?>
<?php
if($testimonial_customer_type=="free")
	{
		echo '<p>You are using <strong> '.$testimonial_customer_type.' version  '.$testimonial_version.'</strong> of <strong>Testimonial</strong>, To get more feature you could try our premium version. ';
		
		echo '<a href="'.testimonial_pro_url.'">'.testimonial_pro_url.'</a></p>';
		
		
	}
elseif($testimonial_customer_type=="pro")
	{
		echo '<p>Thanks for using <strong> '.$testimonial_customer_type.' version  '.$testimonial_version.'</strong> of testimonial </p>';
	}

 ?>




<?php
if($testimonial_customer_type=="free")
	{
?>
<br />
<b>Premium Version Features</b><br />

<ul class="testimonial-pro-features">
	<li>Life Time Automatic Update.</li>
	<li>Life Time Support via forum.</li>
	<li>7 Days Refund.</li>
	<li>Unlimited slider anywhere.</li>    
</ul>



</p>
        
        
        
      <?php
      }
	  
	  ?>  
      
<br /> 
<h3>Please share this plugin with your friends?</h3>
<table>
<tr>
<td width="100px"> 
<!-- Place this tag in your head or just before your close body tag. -->
<script type="text/javascript" src="https://apis.google.com/js/platform.js"></script>

<!-- Place this tag where you want the +1 button to render. -->
<div class="g-plusone" data-size="medium" data-href="https://wordpress.org/plugins/testimonial/"></div>

</td>
<td width="100px">
<iframe src="//www.facebook.com/plugins/like.php?href=https://wordpress.org/plugins/testimonial/&amp;width=100&amp;layout=button_count&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=21&amp;appId=743541755673761" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe>

 </td>
<td width="100px"> 





<a href="https://twitter.com/share" class="twitter-share-button" data-url="https://wordpress.org/plugins/testimonial/" data-text="testimonial – Responsive Testimonial for WordPres">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
</td>

</tr>

</table>
        
        
         
</div>
<style type="text/css">
.testimonial-pro-features{}

.testimonial-pro-features li {
  list-style: disc inside none;
}

</style>