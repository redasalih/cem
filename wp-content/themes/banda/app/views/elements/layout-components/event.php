<?php
class EventLayoutElement extends GummLayoutElement {
    /**
     * @var string
     */
    protected $id = '31EFB436-2000-4C9B-8329-2CBB0871067B';
    
    /**
     * @var string
     */
    public $group = 'posts';
    
    /**
     * @var array
     */
    protected $supports = array(
		'title',
        'fields',
        'categories',
		'paginationLinks',
    );
    
    /**
     * @var string
     */
    protected $postType = 'event';
    
    /**
     * @var int
     */
    private $visibleNum = 3;
    
    /**
     * @var string
     */
    private $_currentDate;
    
    /**
     * @var array
     */
    private $_currentEvents = null;
    
    /**
     * @return string
     */
    public function title() {
        return __('Events', 'gummfw');
    }
    
    /**
     * @return array
     */
    protected function _fields() {

        return array(
            'displayParts' => array(
                'name' => __('Event Info To Display', 'gummfw'),
                'type' => 'checkboxes',
                'inputOptions' => array(
                    'rating' => __('Event Rating', 'gummfw'),
                    'link' => __('Event Link', 'gummfw'),
                ),
                'value' => array(
                    'rating' => true,
                    'link' => true,
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
             'postsNumber' => array(
                'name' => __('Number of events to display', 'gummfw'),
                'type' => 'number',
                'inputSettings' => array(
                    'slider' => array(
                        'min' => 1,
                        'max' => 20,
                        'numberType' => ''
                    ),
                ),
               'value' => 4,
            ),
        );
    }
    
    public function beforeRender($options) {
		global $paged;
        $postsPerPage = -1;
        if ($this->getParam('postsNumber')) {
            $postsPerPage = $this->getParam('postsNumber');
        }

		$_paged = $this->getParam('paged');
        $args = array(
            'post_type' => 'event',
            'posts_per_page' => $postsPerPage,
            'meta_key' => GUMM_THEME_PREFIX . '_event_start_time',
            'orderby' => GUMM_THEME_PREFIX . '_event_start_time',
            'order' => 'DESC',
			'paged' => $_paged ? $_paged : $paged,
        );
        
        if ($this->getParam('displayPastEvents') === 'false') {
            $args['order'] = 'ASC';
            $args['meta_query'] = array(
				'relation' => 'OR',
                array(
                  'key' => GUMM_THEME_PREFIX . '_event_start_time',
                  'value' => date_i18n('Y-m-d H:i'),
                  'compare' => '>=',
                ),
                array(
                  'key' => GUMM_THEME_PREFIX . '_event_end_time',
                  'value' => date_i18n('Y-m-d H:i'),
                  'compare' => '>=',
                ),
            );
        }
        $this->posts = $this->queryPosts($args);
    }
    
    /**
     * @return void
     */
    protected function _render($options) {
        // $events = $this->getEvents();
        
        $currentDate = date_i18n('Y/m/d', strtotime($this->getCurrentDate()));
        $currentDateParts = explode('/', $currentDate);

        $firstDOM = date_i18n('Y/m/d', strtotime($currentDateParts[0] . '/' . $currentDateParts[1] . '/' . 01));
        $numDaysForMonth = date_i18n('t', strtotime($this->getCurrentDate()));
        
        $displayParts = $this->getParam('displayParts', true);
?>
        <div class="col-md-12">
        <div class="events-list events-page">
<?php
        while (have_posts()):
           the_post();
           global $post;
           
           $eventStatus          = $post->PostMeta['event_status'];
           $startDate            = $this->Wp->getPostMeta($post->ID, 'event_start_time');
           $friendlyStartEndTime = $this->getFriendlyStartEndTimeForEvent($post);
           
           $eventButtonHtml = '';
           if ($eventStatus === 'cancelled') {
               $eventButtonHtml = '<span class="label-cancelled">' . __('Cancelled', 'gummfw') . '</span>';
           } elseif($eventStatus === 'soldout') {
               $eventButtonHtml = '<span class="label-sold-out">' . __('Sold Out', 'gummfw') . '</span>';
           } elseif ($post->PostMeta['event_buy_tickets_link']) {
               $eventButtonHtml = '<a class="default" href="' . $post->PostMeta['event_buy_tickets_link'] . '" target="_blank">' . __('Buy Tickets', 'gummfw') . '</a>';
           }
		   if (isset($post->PostMeta['event_custom_status_url']) && $post->PostMeta['event_custom_status_url'] && isset($post->PostMeta['event_custom_status_name']) && $post->PostMeta['event_custom_status_name']) {
			   $eventButtonHtml .= '<a class="default" href="' . $this->Html->url($post->PostMeta['event_custom_status_url']) . '" target="_blank">' . $post->PostMeta['event_custom_status_name'] . '</a>';
		   }
           
           $linkAtts = array(
               'href' => get_permalink(),
           );
           if ($post->PostMeta['event_external_info_link']) {
               $linkAtts['href']   = $post->PostMeta['event_external_info_link'];
               $linkAtts['target'] = '_blank';
           }
           
?>
        <section <?php post_class(array('event', $eventStatus)); ?>>
            <div class="date">
                <strong><?php echo date_i18n('d', strtotime($startDate)); ?></strong>
                <span class="month"><?php echo date_i18n('M', strtotime($startDate)); ?></span>
                <span class="details"></span>
            </div>
          <div class="details">
              <h1><a<?php echo $this->Html->_constructTagAttributes($linkAtts); ?>><?php the_title(); ?></a></h1>
            <span>
				<span class="event-location-box">
                <?php
                if ($post->PostMeta['event_location_link_to_gmap']) {
                    echo '<a href="https://maps.google.com/maps?f=q&q=' . urlencode($post->PostMeta['event_location']) . '" target="_blank" title="' . sprintf(__('Show %s on Google Maps', 'gummfw'), $post->PostMeta['event_location']) . '"><i class="icon-map-marker"></i><span class="event-location-text">' . $post->PostMeta['event_location'] . '</span></a>';
                } else {
                    echo '<i class="icon-map-marker"></i><span class="event-location-text">' . $post->PostMeta['event_location'] . '</span>';
                }
				?>
				</span>
				<?php
                if ($this->getParam('layout') !== 'short') {
					echo '<span class="event-time-text">';
                    echo ' <i class="icon-time"></i>';
                    echo $friendlyStartEndTime;
					echo '</span>';
                }
                ?>
            </span>
            <?php if ($this->getParam('layout') !== 'short'): ?>
            <div class="buttons">
                <?php
                if ($eventButtonHtml) {
                    echo $eventButtonHtml;
                }
                ?>
            </div>
            <?php endif; ?>
            <?php
            if ($displayParts['rating']) {
                View::renderElement('layout-components-parts/event/rating', array(
                    'rating' => (int) $post->PostMeta['event_rating'],
                ));
            }
            if ($displayParts['link']) {
                $linkAtts['class'] = 'more-link';
                echo '<a' . $this->Html->_constructTagAttributes($linkAtts) . '>' . __('Read More +', 'gummfw') . '</a>';
            }
            ?>
          </div>
        </section>
            
<?php            
        endwhile;
        
?>
        </div>
        </div>
<?php
    }
    
    public function getCurrentDate() {
        if (!$this->_currentDate) {
            $date = date_i18n('Ymd');
            if (isset($_REQUEST['eventsdate'])) {
                $date = date_i18n('Ymd', strtotime((int) $_REQUEST['eventsdate'] . '01'));
            } elseif ($requestedDate = $this->getParam('date')) {
                $date = date_i18n('Ymd', strtotime((int) $requestedDate));
            }
            $this->_currentDate = $date;
        }
        
        return $this->_currentDate;
    }
    
    private function getNextDate() {
        return date_i18n('Ymd', strtotime($this->getCurrentDate() . ' +1 month'));
    }
    
    private function getPrevDate() {
        return date_i18n('Ymd', strtotime($this->getCurrentDate() . ' -1 month'));
    }
    
    private function getEventTime($datetimeString) {
        $datetimeParts = explode(' ', $datetimeString);

        return $datetimeParts[1] . ' ' . $datetimeParts[2];
    }
    
    public function getPermalink($event, $date=null) {
        $permalink = get_permalink($event->ID);
        if ($date) {
            $date = date_i18n('Ymd', strtotime($date));
            if (strpos($permalink, '?') === false) $permalink .= '?rd=' . $date;
            else $permalink .= '&rd=' . $date;
        }

        return $permalink;
    }
    
    private function getFriendlyStartEndTimeForEvent($event) {
        $start  = $this->Wp->getPostMeta($event->ID, 'event_start_time');
        $end    = $this->Wp->getPostMeta($event->ID, 'event_end_time');
        
        $result = date_i18n(get_option('time_format'), strtotime($start));
        
        if ($end) {
            $result .= ' - ' . date_i18n(get_option('time_format'), strtotime($end));
        }
        
        return $result;
    }
}
?>