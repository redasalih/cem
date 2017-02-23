jQuery(document).ready(function($)
	{


		$(document).on('click', '.reset-content-layouts', function()
			{
				
				if(confirm("Do you really want to reset ?" )){
					
					jQuery.ajax(
						{
					type: 'POST',
					context: this,
					url: testimonial_ajax.testimonial_ajaxurl,
					data: {"action": "testimonial_reset_content_layouts",},
					success: function(data)
							{	
								$(this).html('Reset Done!');
															
								
							}
						});
					
					}
				
				

				
			})




		$(document).on('change', '.select-layout-hover', function()
			{

				var layout = $(this).val();		
				
				jQuery.ajax(
					{
				type: 'POST',
				url: testimonial_ajax.testimonial_ajaxurl,
				data: {"action": "testimonial_layout_hover_ajax","layout":layout},
				success: function(data)
						{	
							jQuery(".layer-hover").html(data);
														
							
						}
					});
				
			})	

		$(document).on('change', '.select-layout-content', function()
			{
				var layout = $(this).val();		
			
				
				jQuery.ajax(
					{
				type: 'POST',
				url: testimonial_ajax.testimonial_ajaxurl,
				data: {"action": "testimonial_layout_content_ajax","layout":layout},
				success: function(data)
						{	
							//jQuery(".layout-content").html(data);
							jQuery(".layer-content").html(data);
						}
					});
				
			})	

		
		
		$(document).on('click', '.meta-query-list .remove', function()
			{
				
				if(confirm("Do you really want remove ?")){
					$(this).parent().parent().remove();
					}				

				
			})			
		
		$(document).on('click', '.add-meta-query', function()
			{
				
				var key = $.now();
				
				jQuery.ajax(
					{
				type: 'POST',
				url: testimonial_ajax.testimonial_ajaxurl,
				data: {"action": "testimonial_meta_query_add","key":key},
				success: function(data)
						{	

							jQuery(".meta-query-list").append(data);
							
						}
					});
				
			})		
		
		
		
		
		
		
		$(document).on('click', '.post_types', function()
			{
				
				var post_types = $(this).val();
				var post_id = $(this).attr('post_id');	
		
				
				jQuery.ajax(
					{
				type: 'POST',
				url: testimonial_ajax.testimonial_ajaxurl,
				data: {"action": "testimonial_get_categories","post_types":post_types,"post_id":post_id},
				success: function(data)
						{	

							jQuery(".categories-container").html(data);
							
						}
					});
				
			})
		
		
		$(document).on('click', '.categories', function()
			{
				
				var categories = $(this).val();
				
				
				
				jQuery.ajax(
					{
				type: 'POST',
				url: testimonial_ajax.testimonial_ajaxurl,
				data: {"action": "testimonial_active_filter","categories":categories},
				success: function(data)
						{	

							jQuery(".active-filter-container").html(data);
							
						}
					});
				
			})		
	
		
		
		
		
		$(".testimonial_taxonomy").click(function()
			{
				


				var taxonomy = jQuery(this).val();
				
				jQuery(".testimonial_loading_taxonomy_category").css('display','block');

						jQuery.ajax(
							{
						type: 'POST',
						url: testimonial_ajax.testimonial_ajaxurl,
						data: {"action": "testimonial_get_taxonomy_category","taxonomy":taxonomy},
						success: function(data)
								{	
									jQuery(".testimonial_taxonomy_category").html(data);
									jQuery(".testimonial_loading_taxonomy_category").fadeOut('slow');
								}
							});

		
			})
		



	});	







