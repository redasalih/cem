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
        
        echo '<div class="' . $this->Layout->getLayoutColumnsNumberClassName(1) . '">';
        
        echo '<div class="events-list events-page events-single-page">';
        
        if ($post->Thumbnail) {
            echo $this->Media->display($post->Thumbnail);
        }



         /*
            compare starte and end date 
           */
          $dstart = date_i18n('d', strtotime($startDate));
          $dend =  date_i18n('d', strtotime($endtDate));
          $id = get_the_ID();
          if($dstart != $dend){
            $dateShow =  "<strong class='day3'>Du ".date_i18n('l', strtotime($startDate)) ." ".date_i18n('d', strtotime($startDate)) . ' au <br>'.date_i18n('l', strtotime($endtDate)) .' '.date_i18n('d', strtotime($endtDate))."</strong>";
            // $dateShow = "<strong class='day3'>".date_i18n('d', strtotime($startDate)) . '-'.date_i18n('d', strtotime($endtDate))."</strong>";
          }
          else{
             $dateShow = "<strong class='day1'>".date_i18n('l', strtotime($startDate))."</strong><strong class='day2'>".date_i18n('d', strtotime($startDate))."</strong>";
          }
?>
        <section class="event <?php echo $eventStatus; ?>">
            <div class="date">
                <?php echo $dateShow; ?>
                <span class="month"><?php echo date_i18n('F', strtotime($startDate)); ?></span>
                <!-- <span class="year">2016</span> -->
            </div>
            <div class="details">
                <h1><?php the_title(); ?></h1>
                <span>
                    <?php
                    if ($post->PostMeta['event_location_link_to_gmap']) {
                        echo '<a href="https://maps.google.com/maps?f=q&q=' . urlencode($post->PostMeta['event_location']) . '" target="_blank" title="' . sprintf(__('Show %s on Google Maps', 'gummfw'), $post->PostMeta['event_location']) . '"><i class="icon-map-marker"></i>'.$post->PostMeta['event_location'].'</a>';
                    } else {
                        // echo '<i class="icon-map-marker"></i>';
                    }
                    echo ' <i class="icon-time"></i>';
                    // echo $post->PostMeta['event_location'] . ' <i class="icon-time"></i>';
                    
                    echo $friendlyStartEndTime;

                    // if ($id == 402){//==>  Rabat
                    //     echo '<div class="dateEvent" style="display: inline-block;">jeudi 28 mai 2016 </div>';
                    // }else{
                    //     echo '<div class="dateEvent" style="display: inline-block;">jeudi 28 mai 2015 - Vendredi 29 mai 2015 - samedi 30 mai 2015</div>';
                    // }
                    ?>
                </span>
                <div class="buttons">

                    <?php
                    if ($eventButtonHtml) {
                        echo $eventButtonHtml;
                    }
                    // is_page(110)
                    // echo $id;   
                    if ($id == 394){//==>  Rabat
                        // echo '
                        //     <span class="heures" style="
                        //         position: relative;
                        //         top: -26px;
                        //         left: 40px;
                        //         line-height: 29px;
                        //     ">10h à 18h&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;9h30 à 18h <br>Mardi de 18h à 20h réservé aux invitations VIP</span>
                        // ';
                    }
                    if ($id == 390){// ==> Casablanca
                        // echo '<span class="heures">Mardi de 10h à 18h &nbsp; &nbsp; &nbsp; Mercredi de 9h30 à 18h <br>(de18h à 20h réservé aux invitations VIP)</span>';
                        
                        // echo '
                        //     <span class="heures" style="
                        //         position: relative;
                        //         top: -22px;
                        //         left: 217px;
                        //         line-height: 15px;
                        //     ">10h30 à 18h

                        //     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                        //     9h30 à 13h

                        //     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                        //     9h30 à 18h <br>

                        //     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                        //     15h à 18h

                        //     </span>
                        // ';
                    }
                    ?>
                    <span class="horaire">De  09h30  au  18h</span>
                </div>
                <?php
                if ($this->getParam('displayRating', true)) {
                    View::renderElement('layout-components-parts/event/rating', array(
                        'rating' => (int) $post->PostMeta['event_rating'],
                    ));
                }
                if(get_the_ID()=='400'){
                ?>
                    <!-- <img class="part" src="http://caravaneemploi.com/wp-content/uploads/2015/03/Affiche-Marrakech-A2.png" /> -->
                <?php }
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
        
        $result = date_i18n('l j F Y', strtotime($start)) . ' - ' . date_i18n('l j F Y', strtotime($end));
        if (date_i18n('Ymd', strtotime($start)) === date_i18n('Ymd', strtotime($end))) {
            $result = date_i18n(get_option('time_format'), strtotime($start)) . ' - ' . date_i18n(get_option('time_format'), strtotime($end));
        }
        
        return $result;
    }
}
?>