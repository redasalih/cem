<?php
class GummSocialNetworksWidget extends GummWidget {
	
	protected $customName = 'Social Networks';

	protected $options = array(
		'description' => 'Display social networks buttons',
	);
	
	protected $supports = array('title');
	
	protected function fields() {
        return array(
            'socialNetworks' => array(
                'name' => __('Social Networks', 'gummfw'),
                'type' => 'checkboxes',
                'value' => array(
                    'facebook' => 'true', 
                    'twitter' => 'true', 
                    'linkedin' => 'false', 
                    'pinterest' => 'false', 
                    'googleplus' => 'true',
                    'youtube' => 'false',
                    'instagram' => 'false',
                    'rss' => 'true'
                
                ),
                'inputOptions' => array(
                    'facebook' => 'Facebook', 
                    'twitter' => 'Twitter', 
                    'linkedin' => 'LinkedIn', 
                    'pinterest' => 'Pinterest', 
                    'googleplus' => 'Google+',
                    'youtube' => 'YouTube',
                    'instagram' => 'Instagram',
                    'rss' => 'RSS',
                ),
            ),
            'mode' => array(
                'name' => __('Social icons link to:', 'gummfw'),
                'type' => 'select',
                'inputOptions' => array(
                    'share' => __('Share current page being viewed', 'gummfw'),
                    'account' => __('Link to the social network account url (where applicable)', 'gummfw'),
                ),
                'value' => 'share',
            ),
        );
	}

    /**
     * @return void
     */
    public function render($fields) {
        $networks = Set::filter(Set::booleanize($this->getParam('socialNetworks')));
        $mode = $this->getParam('mode');
        
        // echo '<div class="bluebox-share-options">';
        //     echo '<span>' . __('Share The Story') . '</span>';
            echo '<div class="bluebox-details-social">';
                View::renderElement('social-links', array(
                    'networks' => $networks,
                    'accountMode' => $mode,
                    'additionalClass' => 'social-link bluebox-shadows',
                ));
            echo '</div>';
        // echo '</div>';
    }
}	
?>