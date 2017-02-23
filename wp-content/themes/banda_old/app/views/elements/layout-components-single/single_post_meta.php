<?php
class SinglePostMetaLayoutElement extends GummLayoutElement {
    protected $id = '736F8B32-11D1-486E-B4EA-55388596E0F2';
    
    /**
     * @var string
     */
    public $group = 'single';
    
    protected $supports = array();
    
    protected $gridColumns = 12;
    
    public function title() {
        return __('Post Meta', 'gummfw');
    }
    
    protected function _fields() {
        return array(
            'metaFields' => array(
                'type' => 'checkboxes',
                'name' => __('Meta fields', 'gummfw'),
                'inputOptions' => array(
                    'author' => __('Author', 'gummfw'),
                    'date' => __('Date', 'gummfw'),
                    // 'categories' => __('Categories', 'gummfw'),
                    'comments' => __('Comments', 'gummfw'),
                ),
                'value' => array(
                    'author' => 'true',
                    'date' => 'true',
                    // 'categories' => 'true',
                    'comments' => 'true',
                ),
            ),
        );
    }
    
    protected function _render($options) {
        $metaFields = Set::booleanize($this->getParam('metaFields'));
        
        echo '<div class="col-md-12">';
        echo '<div class="meta-line">';
        
        if ($metaFields['date']) {
            echo '<span class="post-date">';
            echo '<i class="icon-calendar"></i>';
            the_date();
            echo '</span>';
        }
        if ($metaFields['comments']) {
            echo '<a href="' . get_permalink() . '#comments' . '" class="more-link">';
            echo '<i class="icon-comment"></i>';
            comments_number(__('No Comments', 'gummfw'), __('1 Comment', 'gummfw'), __('% Comments', 'gummfw'));
            echo '</a>';
        }
        if ($metaFields['author']) {
            $authorLink = get_the_author_meta('url');
            if (!$authorLink) {
                $authorLink = '#';
            }
            
            echo '<a href="' . $authorLink . '" class="more-link"><i class="icon-user"></i>' . get_the_author() . '</a>';
        }
        // echo $this->Html->postDetails($metaFields, array(
        //     'prefixes' => array(
        //         'author' => __('By', 'gummfw'),
        //         'date' => __('/', 'gummfw'),
        //         'comments' => __('/', 'gummfw'),
        //         // 'category' => __('/', 'gummfw'),
        //     ),
        //     'formats' => array(
        //         'date' => 'd F Y',
        //     ),
        // ));
        echo '</div>';
        echo '</div>';
    }
}
?>