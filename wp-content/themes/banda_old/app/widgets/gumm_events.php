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
	    return array();
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
	       ),
	    ));
	    echo '<div class="row">';
	    $EventsElement->render(array(
            // 'headerStyle' => 'note',
            //             'wrapClass' => '',
	    ));
	    echo '</div>';
?>
<?php
	}
	
}	
?>