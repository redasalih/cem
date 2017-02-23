<?php
class SingleCommentsLayoutElement extends GummLayoutElement {
    protected $id = '4E357AA0-4B66-4E92-83D1-C3D8D4B693E0';
    
    /**
     * @var string
     */
    public $group = 'single';
    
    protected $supports = array(
        'aspectRatio' => 1,
    );
    
    // public $editable = false;
    
    protected $gridColumns = 12;
    
    public function title() {
        return __('Fiche Entreprise', 'gummfw');
    }
    
    protected function _fields() {
        return array();
    }
    
    protected function _render($options) {
        global $post;
        
        $description1       = $this->Wp->getPostMeta($post->ID, 'postmeta.description1');
        $description2       = $this->Wp->getPostMeta($post->ID, 'postmeta.description2');
        $description3       = $this->Wp->getPostMeta($post->ID, 'postmeta.description3');
        
        $label1       = $this->Wp->getPostMeta($post->ID, 'postmeta.label1');
        $label2       = $this->Wp->getPostMeta($post->ID, 'postmeta.label2');
        $label3       = $this->Wp->getPostMeta($post->ID, 'postmeta.label3');

        if ($description1) {
            $birthMetaString .='<div class="bluebox-heading"><h3>'.$label1.'</h3></div>';    
            $birthMetaString .= '<div class="description">'.$description1.'</div>';
        }
        if ($description2) {
            $birthMetaString .='<br><br><div class="bluebox-heading"><h3>'.$label2.'</h3></div>';    
            $birthMetaString .= '<div class="description">'.$description2.'</div>';
        }
        if ($description3) {
            $birthMetaString .='<br><br><div class="bluebox-heading"><h3>'.$label3.'</h3></div>';    
            $birthMetaString .= '<div class="description">'.$description3.'</div>';
        }
        
        echo '<div class="' . $this->Layout->getLayoutColumnsNumberClassName(1) . '">';
?>
        <div class="rh-info-wrap">
            <?php

                echo '<span class="birthplace">' . trim($birthMetaString, ' / ') . '</span>';
            
            ?>
        </div>
<?php
        echo '</div>';
    }
}
?>