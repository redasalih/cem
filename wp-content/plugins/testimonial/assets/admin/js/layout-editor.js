jQuery(document).ready(function($)
	{

		
		$(document).on('click', '.css-editor .remove', function()
			{
				
				if(confirm('Do you really want to remove ?')){
					$(this).parent().parent().remove();
					}
				
				
				})
		
		$(document).on('click', '.layout-items .item', function()
			{
				var item_key = $(this).attr('item_key');
				var layout = $(this).attr('layout');				
				var unique_id = $.now();				
				
				
				
				$.ajax(
					{
				type: 'POST',
				context: this,
				url:testimonial_ajax.testimonial_ajaxurl,
				data: {"action": "testimonial_layout_add_elements", "item_key":item_key,"unique_id":unique_id,"layout":layout},
				success: function(data)
						{	

							var html = JSON.parse(data)
							$('#layout-container').append(html['item']);
							$('.css-editor').append(html['options']);
							
						
	
						}
					});				
			})			
		
		
			
		$(document).on('keyup', '.custom_css', function()
			{
				var css_style = $(this).val();
				var item_id = $(this).attr('item_id');			
				
				$('.layer-content .item.'+item_id).attr('style',css_style);
			})			
			
			
			
			
			



	});	







