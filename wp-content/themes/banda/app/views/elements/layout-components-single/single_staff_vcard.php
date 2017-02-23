<?php
class SingleStaffVcardLayoutElement extends GummLayoutElement {
    protected $id = '4AF0AD98-EA75-470D-A3C1-C73751A67C34';
    
    /**
     * @var string
     */
    public $group = 'single';
    
    protected $supports = array(
        'aspectRatio' => 1,
    );
    
    protected $gridColumns = 12;
    
    public $noMargin = true;
    
    // public $editable = false;
    
    public function title() {
        return __('Member vCard', 'gummfw');
    }
    
    protected function _fields() {
        return array(
            'displayTitle' => array(
                'name' => __('Display member name', 'gummfw'),
                'type' => 'radio',
                'inputOptions' => array(
                    'true' => __('Enable', 'gummfw'),
                    'false' => __('Disable', 'gummfw'),
                ),
                'value' => 'true',
            ),
            'displayBirthplace' => array(
                'name' => __('Display birthdate/place meta data', 'gummfw'),
                'type' => 'radio',
                'inputOptions' => array(
                    'true' => __('Enable', 'gummfw'),
                    'false' => __('Disable', 'gummfw'),
                ),
                'value' => 'true',
            ),
            'displayCategories' => array(
                'name' => __('Display categories', 'gummfw'),
                'type' => 'radio',
                'inputOptions' => array(
                    'true' => __('Enable', 'gummfw'),
                    'false' => __('Disable', 'gummfw'),
                ),
                'value' => 'true',
            ),
            'displaySocialLinks' => array(
                'name' => __('Display social networks links', 'gummfw'),
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
        
        $birthDate  = $this->Wp->getPostMeta($post->ID, 'postmeta.date_of_birth');
        $birthPlace = $this->Wp->getPostMeta($post->ID, 'postmeta.location');
        
        $birthMetaString = '';
        if ($birthDate) {
            $birthMetaString .= '<i class="icon-calendar"></i>' . date_i18n(get_option('date_format'), strtotime($birthDate)) . ' / ';
        }
        if ($birthPlace) {
            $birthMetaString .= '<i class="icon-globe"></i>' . $birthPlace;
        }
        
        echo '<div class="' . $this->Layout->getLayoutColumnsNumberClassName(1) . '">';
?>
        <div class="member-info-wrap">
            <?php
            if ($this->getParam('displayTitle', true)) {
                echo '<h2>' . get_the_title() .'</h2>';
            }
            if ($this->getParam('displayBirthplace', true) && $birthMetaString) {
                echo '<span class="birthplace">' . trim($birthMetaString, ' / ') . '</span>';
            }
            
            if ($this->getParam('displayCategories', true) || $this->getParam('displaySocialLinks')) {
                echo '<div class="extra-info">';
                if ($this->getParam('displayCategories', true)) {
                    echo '<div class="tags">' . implode('', $this->Wp->getPostCategories($post, array('withLinks' => true))) . '</div>';
                }
                if ($this->getParam('displaySocialLinks', true)) {
                    $socialNetworks = Set::filter($post->PostMeta['social_networks_url']);
                    if ($socialNetworks) {
                        echo '<ul class="social">';
                        foreach ($socialNetworks as $k => $v) {
                            $networkName = str_replace('_url', '', $k);
                    	    echo '<li><a href="' . $this->Html->url($v) . '" target="_blank">';
                    	        echo '<span><i class="icon-' . $networkName . '"></i></span>';
                    	        echo '<span><i class="icon-' . $networkName . '"></i></span>';
                    	    echo '</a></li>';
                        }
                        echo '</ul>';
                    }
                }
                
                echo '</div>';
            }
            
            if ($post->Thumbnail) {
                echo '<div class="member-pic" style="max-width:' . $this->getParam('aspectRatio') * 250 . 'px;">';
                echo $this->Media->display($post->Thumbnail, array(
                    'ar' => $this->getParam('aspectRatio'),
                    'context' => 'span8',
                    // 'width' => 280,
                    // 'height' => 280,
                    'exact' => true,
                ));
                echo '</div>';
            }
            ?>
        </div>
<?php
        echo '</div>';
    }
}
?>