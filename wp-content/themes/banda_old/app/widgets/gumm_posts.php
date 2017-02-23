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
                'name' => __('Display date, comment, or author info', 'gummfw'),
                'type' => 'checkbox',
                'value' => 'true',
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
	       ),
	    ));
	    
        echo '<div class="row">';
	    $BlogElement->_renderVerticalList(array());
        echo '</div>';
    }
}	
?>