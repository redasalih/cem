<?php
class GalleryLayoutElement extends GummLayoutElement {
    /**
     * @var string
     */
    protected $id = 'B2571A6C-C16F-4C6D-B5C9-CD3DD147C52E';
    
    /**
     * @var string
     */
    public $group = 'posts';
    
    /**
     * @var int
     */
    // protected $gridColumns = 1;
    
    /**
     * @var array
     */
     protected $supports = array(
         'title',
         'postType' => 'gallery',
         'postsNumber' => 20,
         'postColumns' => array(
             'min' => 1,
             'max' => 12,
             'value' => 2,
             'skip' => array(5, 7, 8, 9, 10, 11),
         ),
         'aspectRatio' => 1,
         'thumbnailEffect' => 'magnify',
     );
    
    /**
     * @return string
     */
    public function title() {
        return __('Gallery Layout', 'gummfw');
    }
    
    /**
     * @return array
     */
    protected function _fields() {
        return array(
            'enableLoadMore' => array(
                'name' => __('Display load more button if more galleries available', 'gummfw'),
                'type' => 'radio',
                'inputOptions' => array(
                    'true' => __('Enable', 'gummfw'),
                    'false' => __('Disable', 'gummfw'),
                ),
                'value' => 'true',
            ),
        );
    }
    
    public function beforeRender($options) {
        $this->posts = $this->queryPosts();
        
        if (count($this->posts) < 1) {
            return false;
        }
    }
    
    /**
     * @return void
     */
    protected function _render($options) {
        $columnsNumber = $this->getParam('postColumns');
        $itemClass = $this->Layout->getLayoutColumnsNumberClassName($columnsNumber);
        
        $counter = 0;
        while (have_posts()):
            the_post();
            global $post;
            
            $permalink = get_permalink();
?>
            <div <?php post_class($itemClass); ?>>
                <div class="<?php echo $this->galleryWrapClass(); ?>">
                    <div class="image-wrap">
                        <?php if ($post->Thumbnail): ?>
                        <?php echo $this->thumbnailLinkOpen('image-link'); ?>
                            <?php
                            echo $this->Media->display($post->Thumbnail, array(
                                'ar' => $this->getParam('aspectRatio'),
                                'context' => 'span' . 12/$columnsNumber
                            ), array(
                                'alt' => $post->Thumbnail->post_title,
                            ));
                            ?>
                            <span class="image-details"></span>
                        </a>
                        <?php endif; ?>
                        <div class="gallery-caption">
                            <span class="icone"><?php echo $this->Wp->postTitleLink(); ?></span>
                            <div>
                                <h4><?php echo $this->Wp->postTitleLink(); ?></h4>
                                <span><?php echo $this->captionExtraInfo(); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php
        $counter ++;
        endwhile;
    }
    
    protected function captionExtraInfo() {
        global $post;
        
        $numberPhotos = count($post->Media);
        if (!$numberPhotos && $post->Thumbnail) {
            $numberPhotos = 1;
        }
        
        return $numberPhotos . ' ' . _n('photo', 'photos', $numberPhotos, 'gummfw');
    }
    
    protected function galleryWrapClass() {
        return 'gallery-wrap';
    }

}
?>