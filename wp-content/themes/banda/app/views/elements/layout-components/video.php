<?php
class VideoLayoutElement extends GummLayoutElement {
    /**
     * @var string
     */
    protected $id = 'B7DBEF8A-D194-43D9-AA11-996E9B2F972E';
    
    /**
     * @var string
     */
    public $group = 'posts';
    
    /**
     * @var array
     */
     protected $supports = array(
         'title',
         'postsNumber' => 20,
         'postType' => 'video',
         'postColumns' => array(
             'min' => 1,
             'max' => 6,
             'value' => 4,
         ),
         'fields',
         'paginationLinks',
     );
    
    /**
     * @var int
     */
    private $visibleNum = 5;
    
    /**
     * @var string
     */
    // protected $htmlClass = 'slide-element';
    
    /**
     * @return string
     */
    public function title() {
        return __('Video Layout', 'gummfw');
    }
    
    /**
     * @return array
     */
    protected function _fields() {
        return array(
            'lightBox' => array(
                'name' => __('Enable LightBox effect on video play', 'gummfw'),
                'type' => 'radio',
                'inputOptions' => array(
                    'true' => __('Enable', 'gummfw'),
                    'false' => __('Disable', 'gummfw'),
                ),
                'value' => 'false'
            ),
            'postTitles' => array(
                'name' => __('Post titles alignment and display', 'gummfw'),
                'type' => 'select',
                'inputOptions' => array(
					'false' => __('Do not display', 'gummfw'),
                    'left' => __('Left', 'gummfw'),
                    'center' => __('Center', 'gummfw'),
                    'right' => __('Right', 'gummfw'),
                ),
                'value' => 'false'
            ),
        );
    }
    
    public function beforeRender($options) {
        $this->posts = $this->queryPosts();
    }
    
    protected function _render($options) {
        $columns = $this->getParam('postColumns');
        
        while (have_posts()):
            the_post();
            global $post;
            
            if (!$post->Thumbnail || !GummRegistry::get('Model', 'Media')->isVideo($post->Thumbnail)) {
                continue;
            }
            
?>
            <div <?php post_class($this->Layout->getLayoutColumnsNumberClassName($columns)); ?>>
                <div class="video-wrap">
                    <?php
                    echo $this->Media->display($post->Thumbnail, array(
                        'ar' => 1.7,
                        'context' => 'span' . 12/$columns,
                        'prettyPhotoId' => $this->getParam('lightBox', true) ? $this->id() : false,
                    ));
                    ?>
                </div>
				<?php if ($postTitleAlign = $this->getParam('postTitles', true)): ?>
					<h4 style="text-align: <?php echo $postTitleAlign; ?>"><?php the_title(); ?></h4>
				<?php endif; ?>
            </div>
<?php
        endwhile;
    }
}
?>