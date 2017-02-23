<?php
class GummLatestGalleryWidget extends GummWidget {
	
	protected $customName = 'Latest Gallery';

	protected $options = array(
		'description' => 'Display latest gallery',
	);
	
	protected $supports = array('title');
	
	protected function fields() {
	    return array(
	        'category' => array(
                'name' => '',
                'type' => 'post-type-categories',
                'inputSettings' => array(
                    'postType' => 'gallery',
                ),
	        ),
	    );
	}
	
    protected function beforeRender($instance) {
        $this->getInstanceFieldsData($instance);
        
        $this->setParam('post_type', array(
            'post_type' => 'gallery',
            'posts_number' => 1,
            'gallery_category' => $this->getParam('category'),
        ));
        
        $this->supports[] = 'postType';
        $this->posts = $this->queryPosts($this->fields);
    }

    /**
     * @return void
     */
    public function render($fields) {
        echo '<div class="row">';
        gumm_request_action(array(
            'controller' => 'layout_elements',
            'action' => 'display',
            'Gallery',
            array(
                'posts' => $this->posts,
                'postColumns' => 1
            ),
        ));
        echo '</div>';
    }
}	
?>