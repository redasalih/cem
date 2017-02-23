<?php
class GummAudioWidget extends GummWidget {
	
	protected $customName = 'Audio';

	protected $options = array(
		'description' => 'Display audio lising.',
	);
	
	protected $supports = array('postsNumber', 'title');
	
	private $media;
	
	protected function fields() {
        return array(
            'media' => array(
                'name' => __('Select audio files', 'gummfw'),
                'type' => 'media',
                'inputSettings' => array(
                    'type' => 'audio',
                ),
            ),
        );
	}
	
    protected function beforeRender($instance) {
        if (!$this->media = (array) GummRegistry::get('Model', 'Post')->findAttachmentPosts($this->getParam('media'))) {
            return false;
        }
    }
	
	public function render($fields) {

	    
	    echo '<div class="audio-tracks-wrap">';
        foreach ($this->media as $item) {
            View::renderElement('media/audio-player', array(
                'title' => get_the_title($item->ID),
                'src'   => $item->guid
            ));
        }
        echo '</div>';
	}
	
}	
?>