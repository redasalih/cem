<?php
class BandaSliderLayoutElement extends GummLayoutElement {
    /**
    * @var string
    */
    protected $id = '46F54601-5B1E-446C-ABA9-E8DA51CCE409';

    /**
    * @var string
    */
    public $group = 'sliders';

    /**
    * @var int
    */
    protected $layoutPosition = 'all';

    /**
    * @var RevSlider
    */
    private $slides;

    /**
    * @var array
    */
    protected $supports = array(
        'title',
        'aspectRatio' => 1.39
    );

    public function title() {
      return __('Banda Slider', 'gummfw');
    }

    /**
    * @return array
    */
    protected function _fields() {
      return array(
          'layout' => array(
              'name' => __('Slider Layout', 'gummfw'),
              'type' => 'tabbed-input',
              'inputOptions' => array(
                  'dark' => __('Dark Layout', 'gummfw'),
                  'light' => __('Light Layout', 'gummfw'),
              ),
              'value' => 'dark',
              'tabs' => array(
                  'dark' => array(
                      'mainAreaDisplay' => array(
                          'name' => __('Main area displays:', 'gummfw'),
                          'type' => 'checkboxes',
                          'inputOptions' => array(
                              'controlNav' => __('Pagination', 'gummfw'),
                              'bottomArea' => __('Bottom area', 'gummfw'),
                          ),
                          'value' => array(
                             'controlNav' => true,
                             'bottomArea' => true, 
                          ),
                      ),
                      'bottomAreaDisplay' => array(
                          'name' => __('Bottom area displays:', 'gummfw'),
                          'type' => 'checkboxes',
                          'inputOptions' => array(
                              'date' => __('date', 'gummfw'),
                              'comments' => __('comments count', 'gummfw'),
                              'author' => __('author', 'gummfw'),
                              'excerpt' => __('excerpt / slide text content', 'gummfw'),
                              'button' => __('more button', 'gummfw'),
                          ),
                          'value' => array(
                              'date' => true,
                              'comments' => true,
                              'author' => false,
                              'excerpt' => false,
                              'button' => true,
                          ),
                      ),
                  ),
                  'light' => array(
                      'displayDirectionNav' => array(
                          'name' => __('Display direction nav', 'gummfw'),
                          'type' => 'radio',
                          'inputOptions' => array(
                              'true' => __('Enable', 'gummfw'),
                              'false' => __('Disable', 'gummfw'),
                          ),
                          'value' => 'true'
                      ),
                      'displayControlNav' => array(
                          'name' => __('Display control nav', 'gummfw'),
                          'type' => 'radio',
                          'inputOptions' => array(
                              'true' => __('Enable', 'gummfw'),
                              'false' => __('Disable', 'gummfw'),
                          ),
                          'value' => 'true',
                      ),
                      'displayTitle' => array(
                          'name' => __('Display title', 'gummfw'),
                          'type' => 'radio',
                          'inputOptions' => array(
                              'true' => __('Enable', 'gummfw'),
                              'false' => __('Disable', 'gummfw'),
                          ),
                          'value' => 'true'
                      ),
                  ),
              ),
          ),
          'slideSource' => array(
            'name' => __('Slides', 'gummfw'),
            'type' => 'tabbed-input',
            'inputOptions' => array(
                'posts' => __('Existing posts', 'gummfw'),
                'custom' => __('Custom', 'gummfw'),
            ),
            'default' => 'posts',
            'tabs' => array(
                'post' => array_merge($this->_postTypeFields(array(
                    'name' => '',
                    'default' => false,
                )), $this->_postsNumberFields()),
                'custom' => array(
                    'slides' => array(
                        'name' => __('Slides', 'gummfw'),
                        'type' => 'content-tabs',
                        'inputSettings' => array(
                            'contentTypes' => array('text'),
                            'fields' => array('title', 'textarea' => 'plain'),
                            'buttonLabel' => __('Add New Slide', 'gummfw'),
                            'deleteButtonLabel' => __('Delete Current Slide', 'gummfw'),
                            'tabLabel' => __('Slide', 'gummfw'),
                            'additionalInputs' => array(

                                'media' => array(
                                    'name' => '',
                                    'type' => 'media',
                                    'inputSettings' => array(
                                        // 'buttons' => 'media'
                                    ),
                                ),
                                'button' => array(
                                    'name' => __('Button for this slide', 'gummfw'),
                                    'type' => 'button-input',
                                ),
                            ),
                        ),
                    ),
                ),
            ),
          ),
          'autoplay' => array(
              'name' => __('Slider Autoplay', 'gummfw'),
              'type' => 'number',
              'value' => 0,
              'inputSettings' => array(
                  'slider' => array(
                      'min' => 0,
                      'max' => 50,
                      'step' => .5,
                      'numberType' => 's'
                  ),
              ),
          ),
          'loop' => array(
                'name' => __('Slider Loop', 'gummfw'),
                'type' => 'radio',
                'inputOptions' => array(
                    'true' => __('Enable', 'gummfw'),
                    'false' => __('Disable', 'gummfw'),
                ),
                'value' => 'true'
          ),
          'linkSlide' => array(
              'name' => __('Use Links For Slider Images', 'gummfw'),
              'type' => 'radio',
              'inputOptions' => array(
                  'true' => __('Enable', 'gummfw'),
                  'false' => __('Disable', 'gummfw'),
              ),
              'value' => 'false',
          ),
      );
    }

    public function beforeRender($options) {
        if ($this->getParam('slideSource') === 'posts') {
            $this->queryPosts();
            $this->setupSlidesForPostDatSource();
        } else {
            $this->setupSlidesForCustomSource();
        }
        
        if (!$this->slides) {
            return false;
        }
    }

    protected function _render($options) {
        
        echo '<div  class="' . $this->Layout->getLayoutColumnedClassName(12) . '">';
        
        switch ($this->getParam('layout')) {
         case 'dark':
            $this->_renderDarkLayout($options);
            break;
         case 'light':
            $this->_renderLightLayout($options);
            break;
        }
        
        echo '</div>';
        
    }
    
    private function _renderDarkLayout($options) {
        $mainAreaDisplay = $this->getParam('mainAreaDisplay', true);
        $autoplay = (float) $this->getParam('autoplay');
        
        $sliderDivAtts = array(
            'class' => 'slider bluebox-slider bb-slider',
        );
        if ($mainAreaDisplay['controlNav']) {
            $sliderDivAtts['data-control-nav'] = '.slider-control-nav';
        }
        if ($mainAreaDisplay['bottomArea']) {
            $sliderDivAtts['data-caption-container'] = '.slider-caption';
        }
        if ($autoplay > 0) {
            $sliderDivAtts['data-autoplay'] = $autoplay * 1000;
        }
        if ($this->getParam('loop', true)) {
            $sliderDivAtts['data-loop'] = 'true';
        }
        
?>
        <div<?php echo $this->Html->_constructTagAttributes($sliderDivAtts); ?>>
            
            <div class="swiper-container">
                <div class="image-wrap swiper-wrapper">
                    <?php
                    $counter = 0;
                    $divSwiperSlideAtts = array(
                        'class' => 'swiper-slide'
                    );
                    $mediaContext = $this->getLayoutPosition() === 'header' ? 'wrap' : 'span' . $this->getRowSpan();
                    foreach ($this->slides as $slide) {
                        $mediaLink = $this->Media->display($slide['media'], array(
                            'ar' => $this->getParam('aspectRatio'),
                            'context' => $mediaContext,
                        ), array(
                            'alt' => $slide['media']->post_title,
                            'href' => $slide['button']['href'] ? $slide['button']['href'] : '#',
                            'target' => $slide['button']['newWindow'] ? '_blank' : null,
                        ));
                        if ($slide['media']) {
                            $divSwiperSlideAtts['style'] = ($counter === 0) ? null : 'display:none;';
                            echo '<div' . $this->Html->_constructTagAttributes($divSwiperSlideAtts) . '>';
                            if ($this->getParam('linkSlide', true)) {
                                echo '<a href=' . $slide['button']['href'] . '>' . $mediaLink . '</a>';
                            } else {
                                echo '<div>' . $mediaLink . '</div>';
                            }
                            echo '</div>'; 
                        }
                        $counter++;
                    }
                    ?>
                </div>
            </div>
            <?php if ($mainAreaDisplay['controlNav']): ?>
            <div class="bullets-wrap">
                <ul class="slider-control-nav">
                    <?php
                    $counter = 0;
                    foreach ($this->slides as $slide) {
                        $liAtts = array();
                        if ($counter === 0) {
                            $liAtts['class'] = 'current';
                        }
                        echo '<li' . $this->Html->_constructTagAttributes($liAtts) . '><a href="#"></a></li>';
                        $counter++;
                    }
                    ?>
                </ul>
            </div>
            <?php endif; ?>
            <?php if ($mainAreaDisplay['bottomArea']): ?>
            <div class="slider-caption">
                <?php
                $counter = 0;
                foreach ($this->slides as $slide) {
                    $divAtts = array(
                        'class' => 'caption-item '
                    );
                    $aAtts = array(
                        'href' => $slide['button']['href'] ? $slide['button']['href'] : '#',
                        'target' => $slide['button']['newWindow'] ? '_blank' : null,
                    );

                    if ($counter === 0) {
                        $divAtts['class'] .= ' current-slide-caption';
                    }
                    
                    echo '<div' . $this->Html->_constructTagAttributes($divAtts) . '>';
                    
                    if ($slide['title']) {
                        echo '<h2><a' . $this->Html->_constructTagAttributes($aAtts) . '>' . $slide['title'] . '</a></h2>';
                    }
                    
                    if ($slide['text'] || $slide['button']['title']) {
                        echo '<div class="bluebox-info-line">';
                        
                        if ($slide['text']) {
                            echo $slide['text'];
                        }
                        if ($slide['button']['title']) {
                            $aAtts['class'] = 'more-link';
                            echo '<a' . $this->Html->_constructTagAttributes($aAtts) . '><i class="icon-expand-alt"></i>' . $slide['button']['title'] . '</a>';
                        }
                        echo '</div>';
                    }

                    echo '</div>';
                    
                    $counter++;
                }
                ?>
            </div>
            <?php endif; ?>
        </div>
<?php
    }
    
    private function _renderLightLayout($options) {
        $autoplay = (float) $this->getParam('autoplay');
        
        $sliderDivAtts = array(
            'class' => 'bb-slider-2 bluebox-slider',
        );
        if ($this->getParam('displayDirectionNav', true)) {
            $sliderDivAtts['data-direction-nav'] = '.arrow-links-wrap';
        }
        if ($this->getParam('displayControlNav', true)) {
            $sliderDivAtts['data-control-nav'] = '.slider-control-nav';
        }
        if ($autoplay > 0) {
            $sliderDivAtts['data-autoplay'] = $autoplay * 1000;
        }
        if ($this->getParam('loop', true)) {
            $sliderDivAtts['data-loop'] = 'true';
        }
?>
        <div<?php echo $this->Html->_constructTagAttributes($sliderDivAtts); ?>>
            <div class="swiper-container">
                <div class="swiper-wrapper">
                
                    <?php
                    $divSwiperSlideAtts = array(
                        'class' => 'swiper-slide'
                    );
                    $counter = 0;
                    $mediaContext = $this->getLayoutPosition() === 'header' ? 'wrap' : 'span' . $this->getRowSpan();
                    foreach ($this->slides as $slide) {
                        $aAtts = array(
                            'href' => $slide['button']['href'] ? $slide['button']['href'] : '#',
                            'target' => $slide['button']['newWindow'] ? '_blank' : null,
                        );
                        $mediaLinkLight = $this->Media->display($slide['media'], array(
                                    'ar' => $this->getParam('aspectRatio'),
                                    'context' => $mediaContext
                                ), array(
                                    'alt' => $slide['media']->post_title,
                                    // 'class' => 'swiper-slide',
                                    // 'style' => $counter === 0 ? null : 'display:none;',
                                ));
                        if ($slide['media']) {
                            $divSwiperSlideAtts['style'] = ($counter === 0) ? null : 'display:none;';
                            echo '<div' . $this->Html->_constructTagAttributes($divSwiperSlideAtts) . '>';
                            if ($this->getParam('linkSlide', true)) {
                                echo '<a href=' . $slide['button']['href'] . '>' . $mediaLinkLight . '</a>';
                            } else {
                                echo '<div>' . $mediaLinkLight . '</div>';
                            }
                            if ($this->getParam('displayTitle', true)) {
                                echo '<div class="slider-caption">';
                                    echo '<h2><a' . $this->Html->_constructTagAttributes($aAtts) . '><span>' . $slide['title'] . '<span></span></span></a></h2>';
                                echo '</div>';
                            }
                            echo '</div>';
                        }
                
                        $counter++;
                    }
                    ?>
                </div>
            </div>
            <?php if ($this->getParam('displayControlNav', true)): ?>
            <div class="bullets-wrap">
                <ul class="slider-control-nav">
                    <?php
                    $counter = 0;
                    foreach ($this->slides as $slide) {
                        $liAtts = array();
                        if ($counter === 0) {
                            $liAtts['class'] = 'current';
                        }
                        echo '<li' . $this->Html->_constructTagAttributes($liAtts) . '><a href="#"></a></li>';
                        $counter++;
                    }
                    ?>
                </ul>
            </div>
            <?php endif; ?>
            <?php if ($this->getParam('displayDirectionNav', true)): ?>
            <div class="arrow-links-wrap">
                <a href="#" class="arrow-left-link prev">
                    <span></span>
                    <span></span>
                </a>
                <a href="#" class="arrow-right-link next">
                    <span></span>
                    <span></span>
                </a>
            </div>
            <?php endif; ?>
        </div>
<?php
    }
    
    private function setupSlidesForPostDatSource() {
        $this->slides = array();
        
        $bottomAreaDisplay = $this->getParam('bottomAreaDisplay', true);
        
        while (have_posts()): the_post();
            global $post;
            
            if (!$post->Thumbnail) {
                continue;
            }
            
            $text = '';
            
            if ($bottomAreaDisplay['date']) {
                $text .= '<span class="featured-post-date">' . get_the_date() . '</span> / ';
            }
            if ($bottomAreaDisplay['comments']) {
                $text .= '<span class="featured-post-comments">' . $this->Wp->getCommentsNumber() . '</span> / ';
            }
            if ($bottomAreaDisplay['author']) {
                $text .= '<span class="featured-post-author">' . get_the_author() . '</span> / ';
            }
            if ($bottomAreaDisplay['excerpt']) {
                $text .= '<span class="featured-post-excerpt">' . $this->Text->truncate(get_the_excerpt(), 30) . '</span>';
            }
            
            $text = trim($text, ' / ');
            
            $this->slides[] = array(
                'title' => get_the_title(),
                'text' => $text,
                'media' => $post->Thumbnail,
                'button' => array(
                    'title' => sprintf(__('Read More %s', 'gummfw'), '+'),
                    'href' => get_permalink(),
                    'newWindow' => false
                ),
            );
        endwhile;
    }
    
    private function setupSlidesForCustomSource() {
        $this->slides = $this->getParam('slides', true);
        
        $mediaIds = array();
        foreach ($this->slides as $slideId => $slide) {
            if (isset($slide['media']) && $slide['media']) {
                $mediaIds[] = $slide['media'][0];
                $this->slides[$slideId]['media'] = $slide['media'][0];
            } else {
                $this->slides[$slideId]['media'] = false;
            }
        }
        $images = GummRegistry::get('Model', 'Post')->findAttachmentPosts($mediaIds);
        foreach ($this->slides as $slideId => $slide) {
            foreach ($images as $image) {
                if ($image->ID == $slide['media']) {
                    $this->slides[$slideId]['media'] = $image;
                    break;
                }
            }
        }
        foreach ($this->slides as $slideId => $slide) {
            if (!$slide['media']) {
                unset($this->slides[$slideId]);
            }
        }
    }
}
?>