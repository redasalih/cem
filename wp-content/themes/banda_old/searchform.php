<?php
    $gummInputValue = __('Search...', 'gummfw');
	$gummInactiveClassName = 'bluebox-search-input';
	$gummActiveClassName = $gummInactiveClassName . ' active';
?>
	<form method="get" action="<?php echo home_url(); ?>/" class="search-form">
        <i class="icon-search searchform-icon"></i>
		<input class="<?php echo $gummInactiveClassName; ?>" type="text" name="s" value="<?php echo $gummInputValue ?>" onfocus="if(this.value=='<?php echo esc_js($gummInputValue); ?>'){this.value=''; this.className='<?php echo esc_js($gummActiveClassName); ?>';}" onblur="if(this.value==''){this.value='<?php echo esc_js($gummInputValue); ?>'; this.className='<?php echo esc_js($gummInactiveClassName); ?>';}" autocomplete="off" data-view-all-title="<?php _e('Show All Results', 'gummfw'); ?>" />
		<input type="submit" class="submit" value="Search" />
		<div class="search-form-autocomplete active">
		    <div class="search-results-autocomplete">
		        
		    </div>
		</div>
	</form>
