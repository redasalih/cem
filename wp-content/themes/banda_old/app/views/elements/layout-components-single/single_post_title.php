<?php
class SinglePostTitleLayoutElement extends GummLayoutElement {
    protected $id = 'E9B19DE8-1F04-499A-96BB-7582B5937508';
    
    /**
     * @var string
     */
    public $group = 'single';
    
    public $supports = array();
    
    protected $gridColumns = 12;
    
    public function title() {
        return __('Post Title', 'gummfw');
    }
    
    protected function _fields() {
        return array(
            'headingTag' => array(
                'name' => __('HTML tag for the title', 'gummfw'),
                'type' => 'text',
                'value' => 'h2',
            ),
        );
    }
    
    protected function _render($options) {
        echo '<div class="' . $this->Layout->getLayoutColumnsNumberClassName(1) . '">';
        
        if ($tag = $this->getParam('headingTag')) {
            echo '<' . $tag . ' class="post-heading">' . get_the_title() . '</' . $tag . '>';
        } else {
            echo get_the_title();
        }
        
        echo '</div>';
    }
}
?>