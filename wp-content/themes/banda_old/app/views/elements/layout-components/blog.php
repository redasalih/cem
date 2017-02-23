<?php
class BlogLayoutElement extends GummLayoutElement {
    /**
     * @var string
     */
    protected $id = '80227A46-2FBC-44DF-A526-1BCBEB1260D7';
    
    /**
     * @var string
     */
    public $group = 'posts';
    
    /**
     * @var int
     */
    // protected $gridColumns = 2;
    
    /**
     * @var array
     */
    protected $supports = array(
        'title',
        'postType' => array(
            'value' => 'post',
            'flickr' => false
        ),
        'postsNumber',
        'excerpt',
        'fields',
        // 'layout' => 'slider',
        // 'postColumns' => array(
        //     'min' => 1
        // ),
        // 'aspectRatio',
        'thumbnailEffect' => 'plus',
        'paginationLinks'
    );
    
    public function __construct($data=array()) {
        parent::__construct($data);
        
        $this->layoutsAvailable['blog-medium-image'] = __('Medium Image Layout', 'gummfw');
    }
    
    /**
     * @return string
     */
    public function title() {
        return __('Blog Layout', 'gummfw');
    }
    
    /**
     * @return array
     */
    protected function _fields() {
        
        return array(
            'layout' => array(
                'name' => __('Element Layout', 'gummfw'),
                'type' => 'tabbed-input',
                'inputOptions' => array(
                    'featured' => __('Horizontal grid', 'gummfw'),
                    'vertical' => __('Vertical list', 'gummfw'),
                ),
                'value' => 'featured',
                'tabs' => array(
                    array_merge($this->_postColumnsFields(array(
                        'min' => 1,
                        'value' => 1,
                    )), array(
                        'featuredMetaDisplay' => array(
                            'name' => __('Display date/author', 'gummfw'),
                            'type' => 'checkbox',
                            'value' => true,
                        ),
                        'featuredReadMoreDisplay' => array(
                            'name' => __('Display "Read More" link', 'gummfw'),
                            'type' => 'checkbox',
                            'value' => true,
                        ),
                    ), $this->_getAspectRatioFields(1.61818181818)),
                    array(
                        'listMetaDisplay' => array(
                            'name' => __('Post meta data to display', 'gummfw'),
                            'type' => 'checkboxes',
                            'inputOptions' => array(
                                'date' => __('date', 'gummfw'),
                                'comments' => __('comments count', 'gummfw'),
                                'author' => __('author', 'gummfw'),
                            ),
                            'value' => array(
                                'date' => true,
                                'comments' => true,
                                'author' => false,
                            ),
                        ),
                    ),
                ),
            ),
            'lightBoxLinkDisplay' => array(
                'name' => __('Display LightBox Link', 'gummfw'),
                'type' => 'radio',
                'value' => 'true',
                'inputOptions' => array(
                    'true' => __('Enable', 'gummfw'),
                    'false' => __('Disable', 'gummfw'),
                ),
            ),
        );
    }
    
    public function beforeRender($options) {
        // if ($this->getParam('layout') === 'featured') {
        //     $this->setParam('postsNumber', 1);
        // }
        
        $this->posts = $this->queryPosts();
        if (count($this->posts) < 1) {
            return false;
        }
    }
    
    protected function _render($options) {
        switch ($this->getParam('layout')) {
         case 'featured':
            $this->_renderFeaturedLayout($options);
            break;
         case 'vertical':
            $this->_renderVerticalList($options);
            break;
        }
    }
    
    public function _renderFeaturedLayout($options) {
        $columns = $this->getParam('postColumns');
        // echo '<div class="row">';
        $counter = 0;
        while (have_posts()):
            the_post();
            global $post;
            
            $permalink = get_permalink();
            
            $sectionAtts = array(
                'class' => array(
                    'featured-post',
                    $this->Layout->getLayoutColumnsNumberClassName($columns),
                ),
            );
            if ($counter > 0 && $counter % $columns === 0) {
                echo '<div class="clear"></div>';
            }
?>
        <section<?php echo $this->Html->_constructTagAttributes($sectionAtts); ?>>
            <?php if ($post->Thumbnail): ?>
            <a class="image-wrap" href="<?php echo $permalink; ?>">
                <?php
                echo $this->Media->display($post->Thumbnail->guid, array(
                    'ar' => $this->getParam('aspectRatio'),
                    'context' => 'span' . 12/$columns,
                ), array(
                    'alt' => $post->Thumbnail->post_title,
                    // 'class' => 'swiper-slide',
                    // 'style' => $counter === 0 ? null : 'display:none;',
                ));
                ?>
                <span class="image-details"></span>
            </a>
            <?php endif; ?>
            <h1><a href="<?php echo $permalink; ?>"><?php the_title(); ?></a></h1>
            <?php $this->renderExcerpt(); ?>
            <div class="bluebox-info-line">
                <?php
                if ($this->getParam('featuredMetaDisplay', true)) {
                    echo '<span class="featured-post-date">' . get_the_date() . '</span>';
                    echo '<span class="featured-post-author">' . get_the_author() . '</span>';
                }
                if ($this->getParam('featuredReadMoreDisplay', true)) {
                    echo '<a class="more-link" href="' . $permalink . '">' . __('Plus de Détail', 'gummfw') . ' +</a>';
                } 
                ?>
            </div>
        </section>
<?php
        $counter++;
        endwhile;
        // echo '</div>';
    }
    
    public function _renderVerticalList($options) {
        
        echo '<div class="' . $this->Layout->getLayoutColumnsNumberClassName(1) . '">' . "\n";
        
        $layoutType = ((float) $this->widthRatio() > 0.5) ? 'largeList' : 'smallList';
        $thumbnailDimensions = array(
            'width' => 100,
            'height' => 100,
        );
        $ulAtts = array(
            'class' => array(
                'news-list',
            ),
        );
        if ($layoutType === 'largeList') {
            $ulAtts['class'][] = 'half-image';
            $thumbnailDimensions = array(
                'width' => 200,
                'height' => 200,
            );
        }
        
        echo '<ul' . $this->Html->_constructTagAttributes($ulAtts) . '>' . "\n";
        while (have_posts()):
            the_post();
            global $post;
            
            $permalink = get_permalink();
?>
        <li <?php post_class(); ?>>
            <?php if ($post->Thumbnail): ?>
            <a href="<?php echo $permalink; ?>" class="image-wrap">
                <?php
                echo $this->Media->display($post->Thumbnail, $thumbnailDimensions, array(
                    'alt' => $post->Thumbnail->post_title,
                    // 'class' => 'swiper-slide',
                    // 'style' => $counter === 0 ? null : 'display:none;',
                ));
                ?>
                <span class="image-details"></span>
            </a>
            <?php endif; ?>
            <h4><a href="<?php echo $permalink; ?>"><?php the_title(); ?></a></h4>
            <?php
            if ($layoutType === 'largeList') {
                $this->renderExcerpt();
            }
            
            $listMetaDisplay = $this->getParam('listMetaDisplay', true);

            $metaStringPartOne = '';
            $metaStringPartTwo = '';
            if ($listMetaDisplay['date']) {
                $metaStringPartOne .= get_the_date('M j, Y') . ' / ';
            }
            if ($listMetaDisplay['comments']) {
                $metaStringPartOne .= $this->Wp->getCommentsNumber() . ' / ';
            }
            if ($listMetaDisplay['author']) {
                $metaStringPartTwo .= get_the_author() . ' / ';
            }
            
            if (($layoutType === 'largeList') && ($metaStringPartOne || $metaStringPartTwo)) {
                $metaString = '<span class="post-date">' . trim($metaStringPartOne, ' / ') . '</span>';
                $metaString .= '<span class="post-author">' . trim($metaStringPartTwo, ' / ') . '</span>';
                $metaString .= '<a class="more-link" href="' . get_permalink() . '">' . __('Read More', 'gummfw') . ' +</a>';
                
                echo '<div class="meta-line">' . $metaString . '</div>';
                
            } elseif ($layoutType === 'smallList') {
                $metaString = $metaStringPartOne . $metaStringPartTwo;

                if ($metaString) {
                    $metaString = trim($metaString, ' / ');
                    echo '<span>' . $metaString . '</span>';
                }
            }
            ?>
        </li>
<?php
        endwhile;
        echo '</ul>' . "\n";
        echo '</div>' . "\n";
    }
    
    
    public function renderVerticalSingleLayout() {
        echo '<div class="blog-1-col">';
        while (have_posts()) {
            the_post();
            global $post;
            View::renderElement('layout-components-parts/post/single-vertical-item', array(
                'lightBoxLinkDisplay' => $this->getParam('lightBoxLinkDisplay') === 'true',
                'elementId' => $this->id(),
            ));
        }
        echo '</div>';
    }
    
    private function _imageLinkAtts() {
        global $post;
        
        $atts = array(
            'href' => get_permalink(),
            'class' => array('image-details-link'),
        );
        
        if ($this->getParam('lightBoxLinkDisplay') === 'true') {
            $atts['class'][] = 'image-wrap-mask';
            if ($post->Thumbnail) {
                $atts['href'] = $post->Thumbnail->permalink;
                $atts['rel'] = 'prettyPhoto[' . $this->htmlElementId . ']';
            }
        }
        
        return $this->Html->_constructTagAttributes($atts);
    }

}
?>