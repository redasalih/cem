<?php
class SingleAudioLayoutElement extends GummLayoutElement {
    protected $id = '24500EA6-2A09-443E-9F5A-CA64AE8DDC2B';
    
    /**
     * @var string
     */
    public $group = 'single';
    
    public $supports = array('title');
    
    protected $gridColumns = 12;
    
    public function title() {
        return __('Member Tracklist', 'gummfw');
    }
    
    protected function _fields() {
        return array();
    }
    
    public function beforeRender($options) {
        global $post;
        if (!$post->Media) {
            return false;
        }
    }
    
    protected function _render($options) {
        global $post;
        echo '<div class="audio-tracks-wrap audio-page ' . $this->Layout->getLayoutColumnsNumberClassName(1) . '">';
        
        $counter = 1;
        foreach ($post->Media as $item) {
?>
            <div class="plus-number gumm-audio-player">
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