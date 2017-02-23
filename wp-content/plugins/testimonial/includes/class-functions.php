<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access

class class_testimonial_functions{
	
	public function __construct(){
		
		
		}
	
	
	public function media_source(){
		
						$media_source = array(
												array('id'=>'featured_image','title'=>'Featured Image','checked'=>'yes'),
												array('id'=>'empty_thumb','title'=>'Empty thumbnail','checked'=>'yes'),												
											);
											
						$media_source = apply_filters('testimonial_filter_media_source', $media_source);				
											
						return $media_source;
											
		
		}
	
	
	public function layout_items(){
		
		$layout_items = array(
							
							/*Default Post Stuff*/
							'title'=>'Title',
							'content'=>'Content',							
							'read_more'=>'Read more',	
							'thumb'=>'Thumbnail',
							'excerpt'=>'Excerpt',
							'excerpt_read_more'=>'Excerpt with Read more',													
							'post_date'=>'Post date',								
							'author'=>'Author',
							'categories'=>'Categories',							
							'tags'=>'tags',								
							'comments_count'=>'Comments Count',

							'meta_key'=>'Meta Key',	
							
							'zoom'=>'Zoom button',
							'five_star'=>'Five Star',
							'down_arrow'=>'Down Arrow',							
							'up_arrow'=>'Up Arrow',								
														
							'share_button'=>'Share button',
							'hr'=>'Horizontal line',
							

								);
		
		$layout_items = apply_filters('testimonial_filter_layout_items', $layout_items);
		
		return $layout_items;
		}
	
	
	public function layout_content_list(){
		
		$layout_content_list = array(
		
						'flat-conetnt-top'=>array(
								'0'=>array('key'=>'excerpt', 'char_limit'=>'20', 'name'=>'Excerpt', 'css'=>'background: rgb(117, 205, 255) none repeat scroll 0 0;display: block;font-size: 13px;padding: 5px 10px;text-align: left;'),
								'1'=>array('key'=>'down_arrow', 'name'=>'Down Arrow', 'css'=>'display:block;margin-left: 20px;margin-bottom: 10px;'),
								'2'=>array('key'=>'thumb', 'name'=>'Thumbnail', 'css'=>'display: inline-block;font-size: 12px;height: 60px;padding: 0px 0;vertical-align: top;width: 60px;float: left;'),															
								'3'=>array('key'=>'title', 'char_limit'=>'20', 'name'=>'Title', 'css'=>'display: inline-block;font-size: 14px;line-height: normal;padding: 10px;text-align: left;float: left;'),
								'4'=>array('key'=>'five_star', 'name'=>'Five Star', 'css'=>'color: rgb(117, 205, 255);display: inline-block;font-size: 14px;padding: 10px 0;float: left;'),
								
								),
								
						'flat-conetnt-bottom'=>array(
								
								
								'0'=>array('key'=>'thumb', 'name'=>'Thumbnail', 'css'=>'display: inline-block;float: left;font-size: 12px;height: 60px;padding: 0;vertical-align: top;width: 60px;'),															
								'1'=>array('key'=>'title', 'char_limit'=>'20', 'name'=>'Title', 'css'=>'display: inline-block;float: left;font-size: 14px;line-height: normal;padding: 10px;text-align: left;'),
								'2'=>array('key'=>'five_star', 'name'=>'Five Star', 'css'=>'color: rgb(117, 205, 255);display: inline-block;float: left;font-size: 14px;padding: 10px 0;'),
								'3'=>array('key'=>'up_arrow', 'name'=>'Up Arrow', 'css'=>'clear: both;display: block;margin-left: 20px;padding-top: 10px;'),
								'4'=>array('key'=>'excerpt', 'char_limit'=>'20', 'name'=>'Excerpt', 'css'=>'background: rgb(117, 205, 255) none repeat scroll 0 0;display: block;font-size: 13px;padding: 5px 10px;text-align: left;'),
								),								
								
								
									
						'flat-center-content-bottom'=>array(
								'0'=>array('key'=>'thumb', 'name'=>'Thumbnail', 'css'=>'display: inline-block;font-size: 12px;height: 60px;padding: 0px 0;vertical-align: top;width: 60px;'),								
								'1'=>array('key'=>'title', 'char_limit'=>'20', 'name'=>'Title', 'css'=>'display: inline-block;font-size: 21px;line-height: normal;padding: 5px 10px;text-align: center;'),
								'2'=>array('key'=>'up_arrow', 'name'=>'Up Arrow', 'css'=>'font-size:12px;display:block;padding:10px 0;margin-left: 44%;'),
								'3'=>array('key'=>'excerpt', 'char_limit'=>'20', 'name'=>'Excerpt', 'css'=>'background: rgb(117, 205, 255) none repeat scroll 0 0;display: block;font-size: 12px;padding: 5px 10px;text-align: center;'),

									),
									
						'flat-center-content-top'=>array(
								
								'0'=>array('key'=>'excerpt', 'char_limit'=>'20', 'name'=>'Excerpt', 'css'=>'background: rgb(117, 205, 255) none repeat scroll 0 0;display: block;font-size: 12px;padding: 5px 10px;text-align: center;'),
								'1'=>array('key'=>'down_arrow', 'name'=>'Down Arrow', 'css'=>'font-size:12px;display:block;padding:10px 0;margin-left: 44%;'),
								'2'=>array('key'=>'thumb', 'name'=>'Thumbnail', 'css'=>'display: inline-block;font-size: 12px;height: 60px;padding: 0px 0;vertical-align: top;width: 60px;'),								
								'3'=>array('key'=>'title', 'char_limit'=>'20', 'name'=>'Title', 'css'=>'display: inline-block;font-size: 21px;line-height: normal;padding: 5px 10px;text-align: center;'),


									),									
									
									
									

						);
		
		$layout_content_list = apply_filters('testimonial_filter_layout_content_list', $layout_content_list);
		
		
		return $layout_content_list;
		}	
	

	
	public function layout_content($layout){
		
		$layout_content = $this->layout_content_list();
		
		return $layout_content[$layout];
		}	
		
	
	
	public function layout_hover_list(){
		
		$layout_hover_list = array(
									
									
						'flat'=>array(												

								'read_more'=>array('name'=>'Read more', 'css'=>'display: block;font-size: 12px;font-weight: bold;padding: 0 10px;text-align: center;')
									),										
						'flat-center'=>array(												

								'read_more'=>array('name'=>'Read more', 'css'=>'display: block;font-size: 12px;font-weight: bold;padding: 0 10px;text-align: center;')
									),
										
		
						);
		
		$layout_hover_list = apply_filters('testimonial_filter_layout_hover_list', $layout_hover_list);
		
		
		return $layout_hover_list;
		}	
	

	
	public function layout_hover($layout){
		
		$layout_hover = $this->layout_hover_list();
		
		return $layout_hover[$layout];
		}	
	
	
	
	
	public function skins(){
		
		$skins = array(
		
						'flat'=> array(
										'slug'=>'flat',									
										'name'=>'Flat',
										'thumb_url'=>'',
										),		
		

						);
		
		$skins = apply_filters('testimonial_filter_skins', $skins);	
		
		return $skins;
		
		}
	


	}
	
//new class_testimonial_functions();