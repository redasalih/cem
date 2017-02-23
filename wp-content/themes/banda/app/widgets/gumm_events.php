<?php
class GummEventsWidget extends GummWidget {
	
	protected $customName = 'Events';

	protected $options = array(
		'classname' => 'gumm_events_calendar',
		'description' => 'Display your latest events.',
	);
	
	protected $supports = array('postsNumber', 'title');
	
	protected $fields = array(
	);
	
	protected function fields() {
	    return array(
	    	'event-category' => array(
	    		'name' => '',
				'type' => 'post-type-categories',
				'inputSettings' => array(
					'postType' => 'event',
				),
	    	),
	    	'displayPastEvents' => array(
                'name' => __('Display past events', 'gummfw'),
                'type' => 'radio',
                'inputOptions' => array(
                    'true' => __('Enable', 'gummfw'),
                    'false' => __('Disable', 'gummfw'),
                ),
                'value' => 'false',
            ),
	    );
	}
	
	public function render($fields) {
		App::import('LayoutElement', 'Event');

		$EventsElement = new EventLayoutElement(array(
			'settings' => array(
				'layout' => 'short',
				'displayParts' => array(
					'rating' => false,
					'link' => true,
				),
				'postsNumber' => $this->getParam('postsNumber'),
				'event-category' => $this->getParam('event-category'),
				'displayPastEvents' => $this->getParam('displayPastEvents'),
				'paged' => 1,
			),
		));
		echo '<div class="row">';
		$EventsElement->render();
		echo '</div>';
?>
<?php
	}
	
}	
?>