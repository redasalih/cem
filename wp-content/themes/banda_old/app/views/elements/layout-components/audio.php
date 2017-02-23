<?php
class AudioLayoutElement extends GummLayoutElement {
    /**
     * @var string
     */
    protected $id = 'F2C61CB7-606F-439D-8AE3-3F2293273F66';
    
    /**
     * @var string
     */
    public $group = 'audio';
    
    /**
     * @var array
     */
    protected $supports = array(
        'title',
    );
    
    /**
     * @return string
     */
    public function title() {
        return __('Track Listing', 'gummfw');
    }
    
    /**
     * @return array
     */
    protected function _fields() {
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
    
    public function beforeRender($options) {
        
    }
    
    protected function _render($options) {
        if (!$media = $this->getMediaItems()) {
            return '';
        }
        
        echo '<div class="audio-tracks-wrap audio-page ' . $this->Layout->getLayoutColumnsNumberClassName(1) . '">';
        $counter = 1;
        foreach ($media as $item) {
?>
            <div class="plus-number">
                <?php
                View::renderElement('media/audio-player', array(
                    'title' => get_the_title($item->ID),
                    'src'   => $item->guid
                ));
                
                echo '<div class="buttons-wrap">';
                if ($providers = GummRegistry::get('Model', 'Media')->getAudioProvidersForAttachment($item)) {
                    foreach ($providers as $provider) {
                        echo '<a href="' . $this->Html->url($provider['url']) . '" target="_blank">' . $provider['name'] . '</a>';
                    }
                }
                echo '</div>';
                ?>

                <div class="number"><?php echo $counter; ?></div>
            </div>
<?php
            $counter++;
        }
        
        echo '</div>';

    }
}
?>