<?php
class SinglePostContentLayoutElement extends GummLayoutElement {
    protected $id = '7E72FD85-AC4D-4065-A652-CAFCDCFB19D5';
    
    /**
     * @var string
     */
    public $group = 'single';
    
    public $supports = array('title');
    
    protected $gridColumns = 12;
    
    public function title() {
        return __('Post Content', 'gummfw');
    }
    
    protected function _fields() {
        return array();
    }
    
    protected function _render($options) {
        echo '<div class="' . $this->Layout->getLayoutColumnsNumberClassName(1) . '">';
        the_content();
        echo '</div>';
    }
}
?>