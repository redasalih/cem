<?php
class GummLatestVideoWidget extends GummWidget {
	
	protected $customName = 'Latest Video';

	protected $options = array(
		'description' => 'Display latest video',
	);
	
	protected $supports = array('title');
	
	protected function fields() {
	    return array(
	        'category' => array(
                'name' => '',
                'type' => 'post-type-categories',
                'inputSettings' => array(
                    'postType' => 'video',
                ),
	        ),
	    );
	}
	
    protected function beforeRender($instance) {
        $this->getInstanceFieldsData($instance);
        
        $this->setParam('post_type', array(
            'post_type' => 'video',
            'posts_number' => 1,
            'video_category' => $this->getParam('category'),
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
            'Video',
            array(
                'posts' => $this->posts,
                'postColumns' => 1
            ),
        ));
        echo '</div>';
    }
}	
?>