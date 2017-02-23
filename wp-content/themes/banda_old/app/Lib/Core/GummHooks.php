<?php
/**
 * GummHooks class
 * Binding theme generic hooks and filters
 */
class GummHooks extends GummObject {
    public $wpFilters = array(
        'the_title' => array(
            'func' => 'filterTheTitle',
            'priority' => '99',
            'args' => 2,
        ),
        'body_class' => '_filterBodyClass',
        'post_class' => '_filterPostClass',
        'admin_head' => 'baseUrlJs',
        'wp_head' => 'baseUrlJs',
        'wp_insert_post_empty_content' => '_allowEmptyPostInsertion',
        
    );
    
    /**
     * Returns a singleton instance of the Configure class.
     *
     * @return Object instance
     * @access public
     */
    public static function &getInstance() {
        static $instance = array();
        if (!$instance) {
            $_inst = new GummHooks();
            $instance[0] =& $_inst;
        }
        return $instance[0];
    }
    
    /**
     * Initializes the object. The parent class
     * GummObject will pick up hooks and filters integration
     * from class properties
     */
    public static function initialize() {
        self::getInstance();
    }
    
    public function filterTheTitle($title=null, $postId=null) {
        if ($title && $postId) {
            if ($post = get_post($postId)) {
                if (is_object($post)) {
                    if (GummRegistry::get('Model', 'Media')->isAudio($post)) {
                        if ($artist = GUmmRegistry::get('Model', 'PostMeta')->find($post->ID, 'postmeta.artist')) {
                            $title = $artist . ' - ' . $title;
                        }
                    }
                }
            }
        }
        
        return $title;
    }
    
    public function baseUrlJs() {
        echo '
        <script type="text/javascript">
            var gummBaseJsUrl = \'' . GUMM_THEME_JS_URL . '\';
            var gummBaseUrl = \'' . site_url() . '\';
            var gummAdminUrl = \'' . get_admin_url() . '\';
        </script>' . "\n";
    }
    
    /**
     * 
     * @return string
     */
    public function _filterBodyClass($class) {
        $class['gummLayoutSchema'] = $layoutSchema = GummRegistry::get('Model', 'Layout')->findSchemaStringForLayout();
        
        if (is_category()) {
            $class[] = 'blog';
        }
        
        if (GummRegistry::get('Helper', 'Wp')->getOption('enable_pages_smooth_loading') === 'true') {
            $class[] = 'gumm-enable-ajax-content-loading';
        }

        if ($layoutSchema == 'l-c' || $layoutSchema == 'c-r') {
            $class[] = 'one-sidebar';
        } elseif ($layoutSchema == 'l-c-r') {
            $class[] = 'two-sidebars';            
        } elseif ($layoutSchema == 'none') {
            $class[] = 'no-sidebars';
            unset($class['gummLayoutSchema']);
        }

        return array_values($class);
    }
    
    /**
     * @param array $class
     * @return arary
     */
    public function _filterPostClass($class=array()) {
        global $post;
        
        if (!$class && !is_array($class)) $class = array();
        
        if (!isset($post->Media) || !isset($post->Thumbnail)) return $class;
        
        $postMediaTypes = array_unique(Set::classicExtract($post->Media, '{n}.type'));

        if ($post->Thumbnail) $postMediaTypes = array_unique(Set::filter(array_merge(array($post->Thumbnail->type), $postMediaTypes)));
        
        if (!$postMediaTypes) {
            $class[] = 'no-media';
        } else {
            $class[] = 'has-media';
            foreach ($postMediaTypes as $mediaType) {
                 $class[] = 'media-' . $mediaType;
            }
        }
        
        $categories = GummRegistry::get('Helper', 'Wp')->getPostCategories($post);
        foreach ($categories as $catId => $catName) {
            $class[] = 'for-category-' . $catId;
        }

        return $class;
    }
    
    public function _allowEmptyPostInsertion($maybeEmpty) {
        if (isset($this->data) && isset($this->data['GummPostMeta'])) {
            $maybeEmpty = false;
        }
        
        return $maybeEmpty;
    }
    
}
?>