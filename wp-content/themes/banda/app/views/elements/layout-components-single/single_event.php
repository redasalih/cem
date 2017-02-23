<?php
class SingleEventLayoutElement extends GummLayoutElement {
    protected $id = 'BE72BBA2-AD98-4FD7-92B2-BC13FD541A6F';
    
    /**
     * @var string
     */
    public $group = 'single';
    
    protected $supports = array();
    
    protected $gridColumns = 12;
    
    public $editable = true;
    
    public function title() {
        return __('Single Event Layout', 'gummfw');
    }
    
    protected function _fields() {
        return array(
            'displayRating' => array(
                'name' => __('Display event rating', 'gummfw'),
                'type' => 'radio',
                'inputOptions' => array(
                    'true' => __('Enable', 'gummfw'),
                    'false' => __('Disable', 'gummfw'),
                ),
                'value' => 'true',
            ),
        );
    }
    
    protected function _render($options) {
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
        
        echo '<div class="' . $this->Layout->getLayoutColumnsNumberClassName(1) . '">';
        
        echo '<div class="events-list events-page events-single-page">';
        
        if ($post->Thumbnail) {
            echo $this->Media->display($post->Thumbnail);
        }
?>
        <section class="event <?php echo $eventStatus; ?>">
            <div class="date">
                <strong><?php echo date_i18n('d', strtotime($startDate)); ?></strong>
                <span class="month"><?php echo date_i18n('M', strtotime($startDate)); ?></span>
                <span class="details"></span>
            </div>
            <div class="details">
                <h1><?php the_title(); ?></h1>
                <span>
                    <?php
                    if ($post->PostMeta['event_location_link_to_gmap']) {
                        echo '<a href="https://maps.google.com/maps?f=q&q=' . urlencode($post->PostMeta['event_location']) . '" target="_blank" title="' . sprintf(__('Show %s on Google Maps', 'gummfw'), $post->PostMeta['event_location']) . '"><i class="icon-map-marker"></i></a>';
                    } else {
                        echo '<i class="icon-map-marker"></i>';
                    }
                    echo $post->PostMeta['event_location'] . ' <i class="icon-time"></i>';
                    echo $friendlyStartEndTime;
                    ?>
                </span>
                <div class="buttons">
                    <?php
                    if ($eventButtonHtml) {
                        echo $eventButtonHtml;
                    }
                    ?>
                </div>
                <?php
                if ($this->getParam('displayRating', true)) {
                    View::renderElement('layout-components-parts/event/rating', array(
                        'rating' => (int) $post->PostMeta['event_rating'],
                    ));
                }
                ?>
            </div>
        </section>
<?php
        echo '</div>';
        echo '</div>';
    }
    
    private function getFriendlyStartEndTimeForEvent($event) {
        $start  = $this->Wp->getPostMeta($event->ID, 'event_start_time');
        $end    = $this->Wp->getPostMeta($event->ID, 'event_end_time');
        
        if ($end) {
            $format = get_option('date_format') . ' ' . get_option('time_format');
            $result = date_i18n($format, strtotime($start)) . ' - ' . date_i18n($format, strtotime($end));
            if (date_i18n('Ymd', strtotime($start)) === date_i18n('Ymd', strtotime($end))) {
                $result = date_i18n(get_option('time_format'), strtotime($start)) . ' - ' . date_i18n(get_option('time_format'), strtotime($end));
            }
        } else {
            $result = date_i18n(get_option('time_format'), strtotime($start));
        }
        
        return $result;
    }
}
?>