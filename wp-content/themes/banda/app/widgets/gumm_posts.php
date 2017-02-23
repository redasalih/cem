<?php
class GummPostsWidget extends GummWidget {
	
	protected $customName = 'Posts';

	protected $options = array(
		'description' => 'Display list of posts',
	);
	
	protected $supports = array('title', 'postType');
	
	protected function fields() {
        return array(
            'metaFieldsDisplay' => array(
                'name' => __('Post meta data to display', 'gummfw'),
                'type' => 'checkboxes',
                'inputOptions' => array(
                    'date' => __('date', 'gummfw'),
                    'comments' => __('comments count', 'gummfw'),
                    'author' => __('author', 'gummfw'),
                ),
                'value' => array(
                    'date' => true,
                    'comments' => true,
                    'author' => true,
                ),
            ),
        );
	}

    /**
     * @return void
     */
    public function render($fields) {
	    App::import('LayoutElement', 'Blog');
	    
	    $BlogElement = new BlogLayoutElement(array(
	       'settings' => array(
	           'widthRatio' => 0.25,
				'listMetaDisplay' => Set::booleanize($fields['metaFieldsDisplay']),
	       ),
	    ));
	    
        echo '<div class="row">';
	    $BlogElement->_renderVerticalList(array());
        echo '</div>';
    }
}	
?>