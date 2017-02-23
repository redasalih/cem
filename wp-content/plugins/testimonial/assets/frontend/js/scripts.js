jQuery(document).ready(function($)
	{










		$(document).on('click', '.testimonial .load-more', function()
			{
				
				
				var paged = parseInt($(this).attr('paged'));
				var per_page = parseInt($(this).attr('per_page'));
				var grid_id = parseInt($(this).attr('grid_id'));

						
				$(this).addClass('loading');

				
			$.ajax(
				{
			type: 'POST',
			context: this,
			url:testimonial_ajax.testimonial_ajaxurl,
			data: {"action": "testimonial_ajax_load_more", "grid_id":grid_id,"per_page":per_page,"paged":paged},
			success: function(data)
					{	
					
						//$('.grid-items').append(data);
						var $grid = $('.grid-items').masonry({});				
						
						  // append items to grid
							$grid.append( data )
							// add and lay out newly appended items
							.masonry( 'appended', data );
							$grid.masonry( 'reloadItems' );
							$grid.masonry( 'layout' );


						$(this).attr('paged',(paged+1));
						
						if($(this).hasClass('loading'))
							{
								$(this).removeClass('loading');
							}
						
					}
				});

				//alert(per_page);
			})

		
		

	});	






