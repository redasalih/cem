
jQuery(document).ready(function($)
	{

		$(document).on('click', '.testimonial_content_source', function()
			{	
				var source = $(this).val();
				var source_id = $(this).attr("id");
				
				$(".content-source-box.active").removeClass("active");
				$(".content-source-box."+source_id).addClass("active");
				
			})

 		

	});	
