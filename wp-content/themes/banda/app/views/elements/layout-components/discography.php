<?php
class DiscographyLayoutElement extends GummLayoutElement {
    /**
     * @var string
     */
    protected $id = '7E126AF1-6A6E-4C84-A96E-80CB18A894C3';
    
    /**
     * @var string
     */
    public $group = 'posts';

    /**
     * @var array
     */
    protected $supports = array(
        'postColumns' => array(
            'min' => 2,
            'max' => 6,
            'skip' => 5,
        ),
        'postsNumber',
        'categories',
        'paginationLinks',
    );
    
    /**
     * @var string
     */
    protected $queryPostType = 'album';
    
    /**
     * @var string
     */
    protected $postType = 'album';
    

    public function title() {
        return __('Discography', 'gummfw');
    }

    protected function _fields() {
        return array();
    }
    
    public function beforeRender($options) {
        $this->posts = $this->queryPosts();
    }

    protected function _render($options) {
        $columns = $this->getParam('postColumns');
        $divAtts = array(
            'class' => array(
                $this->Layout->getLayoutColumnsNumberClassName($columns),
            ),
        );

        echo '<div class="content-row">';
        
        $counter = 0;
        while(have_posts()):
            the_post();
            global $post;
            
?>
            <div <?php post_class($divAtts['class']); ?>>
                <div class="album-wrap">
                    <?php
                    
                    if ($post->Thumbnail) {
                        echo '<a href="' . get_permalink() . '">';
                        echo $this->Media->display($post->Thumbnail->guid, array(
                            'ar' => 1,
                            'context' => 'span' . 12/$columns,
                        ), array(
                            'alt' => $post->Thumbnail->post_title,
                        ));
                        echo '</a>';
                    }
                    ?>
                    <div class="album-caption">
                        <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                        <span><?php echo $this->Wp->getPostMeta('artist_name'); ?></span>
                    </div>
                    <a href="<?php the_permalink(); ?>" class="tracks-list"></a>
                </div>
            </div>
<?php
            
        endwhile;
        
        echo '</div>';
    }
}
?>