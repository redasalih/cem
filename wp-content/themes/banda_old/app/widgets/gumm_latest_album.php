<?php
class GummLatestAlbumWidget extends GummWidget {
	
	protected $customName = 'Latest Album';

	protected $options = array(
		'description' => 'Display latest album',
	);
	
	protected $supports = array('title');
	
	protected function fields() {
	    return array(
	        'category' => array(
                'name' => '',
                'type' => 'post-type-categories',
                'inputSettings' => array(
                    'postType' => 'album',
                ),
	        ),
	    );
	}
	
    protected function beforeRender($instance) {
        $this->getInstanceFieldsData($instance);
        
        $this->setParam('post_type', array(
            'post_type' => 'album',
            'posts_number' => 1,
            'album_category' => $this->getParam('category'),
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
            'Discography',
            array(
                'posts' => $this->posts,
                'postColumns' => 1
            ),
        ));
        echo '</div>';
    }
}	
?>