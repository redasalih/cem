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
        'fields',
        'categories'
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
        );
    }
    
    public function beforeRender($options) {
        $postsPerPage = -1;
        if ($this->getParam('postsNumber')) {
            $postsPerPage = $this->getParam('postsNumber');
        }
        $args = array(
            'post_type' => 'event',
            'posts_per_page' => $postsPerPage,
            // 'meta_key' => GUMM_THEME_PREFIX . '_event_start_time',
            // 'orderby' => GUMM_THEME_PREFIX . '_event_start_time',
            //'order' => 'DESC',
        );
        
        // if ($this->getParam('displayPastEvents') === 'false') {
        //     $args['order'] = 'ASC';
        //     $args['meta_query'] = array(
        //         array(
        //           'key' => GUMM_THEME_PREFIX . '_event_start_time',
        //           'value' => date_i18n('Y-m-d H:i'),
        //           'compare' => '>=',
        //         ),
        //     );
        // }
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
           $endtDate             = $this->Wp->getPostMeta($post->ID, 'event_end_time');
           $friendlyStartEndTime = $this->getFriendlyStartEndTimeForEvent($post);
           
           $eventButtonHtml = '';
           if ($eventStatus === 'cancelled') {
               $eventButtonHtml = '<span class="label-cancelled">' . __('Cancelled', 'gummfw') . '</span>';
           } elseif($eventStatus === 'soldout') {
               $eventButtonHtml = '<span class="label-sold-out">' . __('Sold Out', 'gummfw') . '</span>';
           } elseif ($post->PostMeta['event_buy_tickets_link']) {
               $eventButtonHtml = '<a class="default" href="' . $post->PostMeta['event_buy_tickets_link'] . '" target="_blank">' . __("Je m'inscris", 'gummfw') . '</a>';
           }
           
           $linkAtts = array(
               'href' => get_permalink(),
           );
           if ($post->PostMeta['event_external_info_link']) {
               $linkAtts['href']   = $post->PostMeta['event_external_info_link'];
               $linkAtts['target'] = '_blank';
           }


           /*
            compare starte and end date 
           */
          $dstart = date_i18n('d', strtotime($startDate));
          $dend =  date_i18n('d', strtotime($endtDate));

          if($dstart != $dend){
              $dateShow =  "<strong class='day3'>Du ".date_i18n('l', strtotime($startDate)) ." ".date_i18n('d', strtotime($startDate)) . ' au <br>'.date_i18n('l', strtotime($endtDate)) .' '.date_i18n('d', strtotime($endtDate))."</strong>";
              // $dateShow =  "<strong class='day3'>".date_i18n('d', strtotime($startDate)) . '-'.date_i18n('d', strtotime($endtDate))."</strong>";
          }
          else{
             $dateShow = "<strong class='day1'>".date_i18n('l', strtotime($startDate))."</strong><strong class='day2'>".date_i18n('d', strtotime($startDate))."</strong>";
          }
           
?>
        <section <?php post_class(array('event', $eventStatus)); ?>>
            <div class="date">
                <?php echo $dateShow; ?>
                <span class="month"><?php echo date_i18n('F', strtotime($startDate)); ?></span>
                <span class="details"></span>
            </div>
          <div class="details">
              <h1><a<?php echo $this->Html->_constructTagAttributes($linkAtts); ?>><?php the_title(); ?></a></h1>
            <span>
                <?php
                if ($post->PostMeta['event_location_link_to_gmap']) {
                    echo '<a href="https://maps.google.com/maps?f=q&q=' . urlencode($post->PostMeta['event_location']) . '" target="_blank" title="' . sprintf(__('Show %s on Google Maps', 'gummfw'), $post->PostMeta['event_location']) . '"><i class="alaa icon-map-marker"></i>' . $post->PostMeta['event_location'] . '</a>';
                } else {
                    echo '<i class="icon-map-marker"></i>' . $post->PostMeta['event_location'];
                }
                if ($this->getParam('layout') !== 'short') {
                    echo ' <i class="icon-time"></i>';
                    echo $friendlyStartEndTime;
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
                echo '<a' . $this->Html->_constructTagAttributes($linkAtts) . '>' . __('Plus de détail +', 'gummfw') . '</a>';
            }
            ?>
          </div>
        </section>
            
<?php            
        endwhile;
        
?>
        </div>
        <a href="http://caravaneemploi.com/la-caravane/les-etapes" class="allEvents"><i class="icon-long-arrow-right"></i>Toutes les étapes</a>
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
        
        $result = date_i18n(get_option('time_format'), strtotime($start)) . ' - ' . date_i18n(get_option('time_format'), strtotime($end));
        
        return $result;
    }
}
?>