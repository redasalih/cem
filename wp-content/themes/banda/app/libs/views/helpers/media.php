<?php
class MediaHelper extends GummHelper {
    
    /**
     * @var array
     */
    public $helpers = array('Wp', 'Html');
    
    /**
     * @var array
     */
    public $wpActions = array(
        'admin_print_footer_scripts' => array('printAjaxUploadJs'),
    );
    
    /**
     * @var array
     */
    public $uploadifySettings = array();
    
    /**
     * @var array
     */
    public $ajaxUploadSettings = array();
    
    /**
     * @param mixed $url
     * @param array $params
     * @param array $attributes
     * @return string
     */
    public function display($attachment, $params=array(), $attributes=array()) {
        $params = array_merge(array(
            'prettyPhotoId' => false
        ), (array) $params);
        
        $result = '';
        if (is_string($attachment)) {
            $result = $this->displayFromUrl($attachment, $params, $attributes);
        } elseif (is_object($attachment)) {
            $MediaModel = GummRegistry::get('Model', 'Media');
            if ($MediaModel->isImage($attachment)) {
                $result = $this->displayFromUrl($attachment->guid, $params, $attributes);
            } elseif ($MediaModel->isVideo($attachment)) {
                $url = $MediaModel->getVideoThumbnail($attachment);
                $playButtonTag = 'span';
                $playButtonAtts = array('class' => 'video-buttons');
                if ($params['prettyPhotoId']) {
                    $playButtonTag = 'a';
                    $playButtonAtts['rel'] = 'prettyPhoto[pp-' . $params['prettyPhotoId'] . ']';
                    $playButtonAtts['href'] = $attachment->permalink;
                }
                $result = '';
                $result .= '<div class="video-container" data-video="' . htmlentities($attachment->guid) . '" data-src-type="embed">';
                $result .= '<' . $playButtonTag . $this->_constructTagAttributes($playButtonAtts) . '>
                                <span class="button button-play play-video" href="#">
                                    <span><i class="icon-play"></i></span>
                                    <span><i class="icon-play"></i></span>
                                </span>
                            </' . $playButtonTag . '>';
                $result .= $this->displayFromUrl($url, $params, $attributes);
                $result .= '</div>';
                
            } elseif ($MediaModel->isSelfHostedVideo($attachment)) {
                $videoAtts = array(
                    'class' => 'video-js vjs-default-skin',
                    'preload' => 'auto',
                    'width' => $params['width'],
                    'height' => $params['height'],
                    'controls' => true
                );
                
                echo '<video' . $this->_constructTagAttributes($videoAtts) . '>';
                echo '<source src="' . $attachment->guid . '" type="' . $attachment->post_mime_type . '" />';
                echo '</video>';
            } elseif ($MediaModel->isAudio($attachment)) {
                // $result = '<div class="icon-play gumm-play-audio" style="font-size:72px;" data-src="' . wp_get_attachment_url($attachment->ID) . '"><div class="the_player"></div></div>';
                $result = '<span class="gumm-audio-player" data-play-pause-button-mode="toggle" data-src="' . wp_get_attachment_url($attachment->ID) . '">
                                <a class="button button-play" href="#">
                                    <span><i class="icon-play"></i></span>
                                </a>
                            </span>';
            } else {
                $result = $this->displayFromUrl($attachment->guid, $params, $attributes);
            }
        }

        return $result;
    }
    
    /**
     * @param mixed $url
     * @param array $params
     * @param array $attributes
     * @return string
     */
    public function displayFromUrl($url, $params=array(), $attributes=array()) {
        $params = array_merge(array(
            'layoutDimensions' => false,
            'width' => null,
            'height' => null,
            'context' => null,
            'ar' => null,
            'crop' => true,
            'exact' => false,
            'suffix' => 'gummcrop',
        ), (array) $params);
        
        if (!$url) return false;
        
        $url = stripslashes(htmlspecialchars_decode($url, ENT_QUOTES));
        // If the ruequested "url" contains <object> or <iframe> tags
        if (strpos($url, '<') !== false) {
            // $width = $params['width'];
            // $height = $params['height'];
            $width = $params['exact'] === true ? $params['width'] : '100%';
            $height = $params['exact'] === true ? $params['height'] : '100%';
            if ($width) $url = preg_replace("'(width=[\'|\"])(\d+[\%]?)([\'|\"])'imsU", '${1}' . $width . '${3}', $url);
            if ($height && $height != 999) $url = preg_replace("'(height=[\'|\"])(\d+[\%]?)([\'|\"])'imsU", '${1}' . $height . '${3}', $url);
            
            
            // Some cleanup
            if (strpos($url, '<object') !== false && strpos($url, 'wmode') === false) {
                $url = preg_replace("'(<object.*)(</object>)'imsU", '${1}<param name="wmode" value="transparent" />${2}', $url);
            } elseif (strpos($url, '<iframe') !== false) {
                if (preg_match_all("'<iframe.*src=\"(.*)\".*></iframe>'imsU", $url, $srcUrl)) {
                    $srcUrl = $srcUrl[1][0];
                    if (strpos($srcUrl, 'wmode') === false) {
                        $srcUrl .= (strpos($srcUrl, '?') === false) ? '?wmode=transparent' : '&amp;wmode=transparent';
                        $url = preg_replace("'(<iframe.*src=\")(.*)(\".*></iframe>)'imsU", '${1}' . $srcUrl . '${3}', $url);
                    }
                    if (strpos($url, 'frameborder') === false) {
                        $url = preg_replace("'(<iframe.*)(>.*</iframe>)'imsU", '${1} frameborder="0"${2}', $url);
                    }
                }
            }
            $url = preg_replace("'<p>.*</p>'imsU", '', $url);
            $styleAttr = '';
            if (isset($params['ar'])) {
                $styleAttr = ' style="padding-bottom:' . 1/$params['ar']*100 . '%"';
            }
            $url = '<div class="embeddedVideoWrapper"' . $styleAttr . '>' . $url . '</div>';
            
            return $url;
        } elseif (strpos($url, gumm_env('HTTP_HOST')) === false) {
            return $this->constructImgTag($url);
        } else {
            App::import('Component', 'MediaHandler');
            $MediaHandler = new MediaHandlerComponent();
            $filepath = $MediaHandler->urlToFilePath($url);
            $aspectRatio = null;
            if ( (extension_loaded('gd')) && ($params['width'] || $params['height'] || $params['ar']) ) {
            
                $whProps = $this->getMediaDimensions($params);
                // $whProps = $this->getMediaDimensionsForClientResolution($params['width'], $params['height'], $params['context']);
                $params = array_merge($params, $whProps);
            
                $clientResolution = $this->getClientResolution();
                
                $originUrl = $url;
                $url = self::mediaUrlPath($url, $params);
                
                $filepath = $MediaHandler->urlToFilePath($url);
                $fileParts = $MediaHandler->urlToRequestParts($url);
                
                $MediaHandler->initialize($fileParts['filename']);
                
                if (!is_file($filepath)) {
                    if (!$MediaHandler->thumbnail($fileParts['width'], $fileParts['height'])) {
                        $url = $originUrl;
                    }
                }
                    
                if ($fileParts['width'] && $fileParts['height']) {
                    $aspectRatio = round($fileParts['width'] / $fileParts['height'], 4);
                }
            } else {
                $MediaHandler->initialize($filepath);
            }
            if (!$aspectRatio) {
                $aspectRatio = round($MediaHandler->info('aspectRatio'), 4);
            }
            
            $attributes['data-aspectratio'] = $aspectRatio;
        }
        
        if (!isset($attributes['id'])) {
            $attributes['id'] = 'img-' . uniqid();
        }
        if (!extension_loaded('gd')) {
            $whProps = $this->getMediaDimensions($params);
            
            $attributes['width'] = $whProps['width'];
        }
        
        
        
        if (!is_admin() && GUMM_THEME_SUPPORTS_IMG_PRELOAD) {
            $attributes = array_merge(array(
                'style' => ''
            ), $attributes);
            
            $attributes['style'] .= 'display:none;';
            $output = '<span class="imgpreload-wrapper" style="display:block; position:relative; padding-top:' . 100/$aspectRatio . '%;">' . $this->constructImgTag($url, $attributes) . '</span>';
            
            $jsPreloadScript = "
            (function($){
                var ele = $('#{$attributes['id']}');
                 var wrapper = ele.parent('.imgpreload-wrapper');
                 wrapper.before(ele);
                 
                 onImagesLoaded(ele, function(){
                     console.log(this);
                 });
                 
                 if (ele.height() === 0) {
                     
                     var height = ele.width() / {$aspectRatio};
                     ele.css({
                         display: '',
                         height: height,
                         opacity: 0
                     }).addClass('gummModHeight').parent().addClass('imgloading');
                     ele.load(function(){
                         $(this).parent().removeClass('imgloading');
                         $(this).animate({
                             opacity: 1
                         }, 350, function(){
                             $(this).css('opacity', '');
                         }).css({
                             height: ''
                         }).removeClass('gummModHeight').next('script.imgpreloaderscript').remove();
                     });
                 } else {
                     console.log(ele.height());
                     ele.css('display', '').next('script.imgpreloaderscript').remove();
                 }
                 wrapper.remove();
            }) (jQuery)";
            
            // $output .= '<script type="text/javascript" class="imgpreloaderscript">' . $jsPreloadScript . '</script>';
        } else {
            $output = $this->constructImgTag($url, $attributes);
        }
        
        
        return $output;
    }
    
    public function url($url, $params=array()) {
        $params = array_merge(array(
            'layoutDimensions' => false,
            'width' => null,
            'height' => null,
            'context' => null,
            'ar' => null,
            'crop' => true,
            'exact' => false,
            'suffix' => 'gummcrop',
        ), (array) $params);
        
        if (!$url) return;
        
        if (strpos($url, gumm_env('HTTP_HOST')) === false) {
            return $url;
        } elseif ( (extension_loaded('gd')) && ($params['width'] || $params['height'] || $params['ar']) ) {
            App::import('Component', 'MediaHandler');
            $MediaHandler = new MediaHandlerComponent();
            $filepath = $MediaHandler->urlToFilePath($url);
        
            $whProps = $this->getMediaDimensions($params);
            // $whProps = $this->getMediaDimensionsForClientResolution($params['width'], $params['height'], $params['context']);
            $params = array_merge($params, $whProps);
        
            $clientResolution = $this->getClientResolution();
            
            $originUrl = $url;
            $url = self::mediaUrlPath($url, $params);
            $filepath = $MediaHandler->urlToFilePath($url);
            $fileParts = $MediaHandler->urlToRequestParts($url);

            $MediaHandler->initialize($fileParts['filename']);
            if (!is_file($filepath)) {
                if (!$MediaHandler->thumbnail($fileParts['width'], $fileParts['height'])) {
                    $url = $originUrl;
                }
            }
        }
        
        return $url;
    }
    
    public function getMediaDimensions($params) {
        $params = array_merge(array(
            'width' => null,
            'height' => null,
            'ar' => null,
            'context' => null,
        ), $params);
        extract($params);
        if (!$context) $context = 'wrap';
        elseif ($context === true) $context = GummRegistry::get('Helper', 'Layout')->getSpanContext();
        
        $dimensions = array('width' => null, 'height' => null);
        if ($params['ar']) {
            
            if ($context === 'wrap') {
                $wrapWidth = GummRegistry::get('Helper', 'Layout')->getContentWidth(false);
                $dimensions['width'] = $wrapWidth;
                $dimensions['width'] -= 40;
                $dimensions['height'] = $dimensions['width'] / $params['ar'];
            } else {
                $clientWidth = $this->getClientResolution();
                $contentWidth = min(GummRegistry::get('Helper', 'Layout')->getContentWidth(false), $clientWidth);

                $percentWidth = Configure::read('resolution.contextProportions.' . $context);
                
                $dimensions['width'] = (($contentWidth * $percentWidth) / 100);
                $dimensions['width'] -= 40;
                $dimensions['height'] = $dimensions['width'] / $params['ar'];
                if ($contentWidth > 768) {
                    $sidebarsNum = GummRegistry::get('Helper', 'Layout')->numSidebars();
                    
                    if ($sidebarsPercent = Configure::read('imageSidebarsResolutionMap.' . $sidebarsNum)) {
                        $dimensions['width'] *= $sidebarsPercent;
                        $dimensions['height'] *= $sidebarsPercent;
                    }
                }
            }
        } else {
            $dimensions = $this->getMediaDimensionsForClientResolution($params['width'], $params['height'], $params['context']);
        }
        
        $pixelRatio = $this->getClientPixelRatio();
        $dimensions['width'] = ceil($pixelRatio * $dimensions['width']);
        $dimensions['height'] = ceil($pixelRatio * $dimensions['height']);
        
        return $dimensions;
    }
    
    /**
     * @param
     */
    public static function mediaUrl($url, array $options=array()) {
        $urlPath = self::mediaUrlPath($url, $options);

        return GummRouter::url(array('admin' => false, 'controller' => 'media', 'action' => 'display', urlencode($urlPath)));
    }
    
    public static function mediaUrlPath($url, array $options=array()) {
        $options = array_merge(array(
            'size' => null,
            'width' => null,
            'height' => null,
        ), $options);
        extract($options, EXTR_SKIP);
        
        $sizeSuffix = $size;
        if ($width && $height) {
            $sizeSuffix = $width . 'x' . $height;
        } elseif ($width && !$height) {
            $sizeSuffix = $width . 'x';
        } elseif (!$width && $height) {
            $sizeSuffix = 'x' . $height;
        }
        
        $safeName = str_replace('/', DS, $url);
        $pi = pathinfo($safeName);
        
        $filename = $pi['filename'] . '-' . $sizeSuffix . '.' . $pi['extension'];
        $urlPath = $pi['dirname'] . '/' . $filename;
        $urlPath = str_replace(DS, '/', $urlPath);
        
        return $urlPath;
    }
    
    /**
     * @param string $layoutSchema
     * @param string $mediaType
     * @return array
     */
    public function getDimensionsForLayout($layoutSchema, $mediaType=null, $postFormat=null) {
        $layout = GummRegistry::get('Model', 'Layout')->findSchemaForLayout();
        $sidebarsNumber = count($layout['sidebars']);

        switch ($sidebarsNumber) {
         case 0:
            $size = Configure::read('imageSizesMap.noSidebars.' . $layoutSchema);
            break;
         case 1:
            $size = Configure::read('imageSizesMap.oneSidebar.' . $layoutSchema);
            break;
         case 2:
            $size = Configure::read('imageSizesMap.twoSidebars.' . $layoutSchema);
            break;
        }
        
        if ($postFormat && isset($size['format-' . $postFormat])) {
            // debug($postFormat);
            $size = $size['format-' . $postFormat];
        } elseif (isset($size['format-all'])) {
            $size = $size['format-all'];
        }
        
        if ($mediaType && isset($size[$mediaType])) $size = $size[$mediaType];
        
        return $size;
    }
    
    /**
     * @param string $layoutSchema
     * @return array
     */
    public function getMediaDimensionsForLayout($layoutSchema) {
        $path = explode('.', $layoutSchema);
        $layout = array_shift($path);
        $layout = GummRegistry::get('Model', 'Layout')->findSchemaForLayout($layout);
        
        $sidebarsNumber = count($layout['sidebars']);
        $sizeMapPath = implode('.', $path);
        
        $defaults = array('width' => null, 'height' => null);
        $size = array();
        switch ($sidebarsNumber) {
         case 0:
            $size = Configure::read('imageSizesMap.noSidebars.' . $sizeMapPath);
            break;
         case 1:
            $size = Configure::read('imageSizesMap.oneSidebar.' . $sizeMapPath);
            break;
         case 2:
            $size = Configure::read('imageSizesMap.twoSidebars.' . $sizeMapPath);
            break;
        }
        $size = array_merge($defaults, $size);
        
        return $size;
    }
    
    /**
     * @param array $options
     * @param array $htmlAttributes
     * @return string
     */
    public function singleUploadButton(array $options = array(), array $htmlAttributes = array()) {
        App::import('Controller', 'Media');
        $options = array_merge(array(
            'textInput' => true,
            'button' => '',
            '_wpnonce' => MediaController::WPNONCE,
            'script' => 'ajaxurl',
            'scriptData' => array(),
            'callbacks' => array(),
            'responseType' => 'json',
        ), $options);
        $options['scriptData']['_wpnonce'] = wp_create_nonce($options['_wpnonce']);
        
        $htmlAttributes = array_merge(array(
            'id' => uniqid(),
        ), $htmlAttributes);
        
        $outputHtml = '';
        $outputHtml .= $options['button'];

        $options['id'] = $htmlAttributes['id'];
        
        $this->ajaxUploadSettings[] = $options;
            
        return $outputHtml;
        
    }
    
    /**
     * Output a uploadify button.
     * 
     * Returns a string, containing javascript and html tags to
     * initialize the button on the page
     * 
     * @param array $options
     * @return string
     */
    public function mediaManager(array $options = array()) {
        global $post;
        
        App::import('Controller', 'Media');
        $options = array_merge(array(
            'id' => 'uploader-' . uniqid(),
            'name' => 'mediaManager',
            'optionId' => '',
            '_wpnonce' => MediaController::WPNONCE,
            'content' => '',
            'buttonCancelImageUrl' => GUMM_THEME_JS_URL . 'uploadify/cancel.png',
            'buttonText' => __('Upload Files', 'gummfw'),
            'buttons' => array('media', 'embed'),
            'type' => 'default',
            'multiple' => true,
        ), $options);
        
        $options['buttons'] = (array) $options['buttons'];
        $options['scriptData']['_wpnonce'] = wp_create_nonce($options['_wpnonce']);
        if ($options['type'] === 'audio') {
            $options['buttons'] = array('media');
        }
        
        extract($options, EXTR_OVERWRITE);
        
        $embedVideoUrl = array('controller' => 'media', 'action' => 'add_embed_video', 'admin' => true, 'ajax' => true);
        if ($options['optionId']) {
            $embedVideoUrl['optionId'] = $options['optionId'];
        }
        
        $outputHtml = '<div id="' . $id . '" class="gumm-media-manager manager-type-' . $options['type'] . '">' . PHP_EOL;
        
        $outputHtml .= '<div class="media-manager-actions">' . PHP_EOL;
        
        if (in_array('media', $options['buttons'])) {
            $managerBrowseType  = null;
            $uploadExtensions   = null;
            $uploadsLayout      = 'default';
            $viewTitle          = __('Insert Media', 'gummfw');
            
            if ($options['type'] === 'audio') {
                $managerBrowseType = 'audio';
                $uploadExtensions = json_encode(array(
                    'title' => __('Audio files', 'gummfw'),
                    'extensions' => implode(',', wp_get_audio_extensions()),
                ));
                $uploadsLayout = 'audio';
                $viewTitle = __('Add Audio Track', 'gummfw');
            }
            
            $outputHtml .= $this->Html->link('<span>' . __('Add Media', 'gummfw') . '</span>', '#', array(
                'class' => 'gumm-insert-media btn btn-success btn-admin-right-bottom',
                'data-editor' => 'gumm',
                'data-option-id' => $optionId,
                'data-file-types' => $managerBrowseType,
                'data-file-extensions' => $uploadExtensions,
                'data-uploads-layout' => $uploadsLayout,
                'data-frame-title' => $viewTitle,
                'data-multiple' => $options['multiple'] ? 'true' : 'false',
            ));
        }
        
        if (in_array('embed', $options['buttons'])) {
            $outputHtml .= $this->Html->link('<span>' . __('Embed Video', 'gummfw') . '</span>',
                $embedVideoUrl,
                array('class' => 'btn embed-video-button btn-success btn-admin-right-bottom')
            );
        }
        $outputHtml .= '<div class="clear"></div>';
        $outputHtml .= '</div>' . PHP_EOL;
        $outputHtml .= '<ul class="media-uploads-container image-upload-container admin-metabox-list media-uploads-' . $options['type'] . '">' . $content . '<li style="clear:both;"></li></ul>' . PHP_EOL;
        
        $outputHtml .= '</div>' . PHP_EOL;
        
        // $instance = new self;
        
        $this->scriptBlockStart();
?>
        $('#<?php echo $id; ?>').find('.media-uploads-container').sortable({
            items: '.media-upload-item',
            cancel: 'a'
        });
<?php
        $this->scriptBlockEnd();
        
        // wp_enqueue_script('gumm-media', false, array('media-editor'), false, true);
        // if (is_admin())
            // add_action('admin_print_footer_scripts', array(&$instance, 'printUploadifyJs'));
        // else
            // add_action('print_footer_scripts', array(&$instance, 'printUploadifyJs'));


        return $outputHtml;
    }
    
    private function constructImgTag($src, $attributes=array()) {
        $attributes = array_merge(array(
            'class' => '',
            'preload' => null,
        ), $attributes);

        $preload = GUMM_THEME_SUPPORTS_IMG_PRELOAD && $attributes['preload'] !== false && $attributes['preload'] !== 'force';
        $forcePreload = GUMM_THEME_SUPPORTS_IMG_PRELOAD && $attributes['preload'] === 'force';
        
        unset($attributes['preload']);
        
        if ($preload) {
            $attributes['class'] .= ' img-preload';
        }
        if ($forcePreload) {
            $attributes['class'] .= ' img-force-preload';
        }
        
        $tag = '<img src="' . $src . '"';
        foreach ($attributes as $k => $v) {
            if (!$v) continue;
            
            $tag .= ' ' . $k . '="' . $v . '"';
        }
        $tag .= ' />';
        
        if ($forcePreload) {
            $tag = '<div style="position: relative;">' . $tag . '<div class="img-loading" style="position:absolute; width: ' . $attributes['width'] . 'px; height: ' . $attributes['height'] . 'px; left:0; top:0;"></div></div>';
        }
        
        return $tag;
    }
    
    // ======= //
    // GETTERS //
    // ======= //
    
    /**
     * @param object $attachmentPost
     * @return array
     */
    public function getMediaFields($attachmentPost) {
        add_filter('attachment_fields_to_edit', array(&$this, 'filterMediaFields'), 10, 2);
        
        return get_attachment_fields_to_edit($attachmentPost);
    }
    
    /**
     * @param int $id
     * @param string $field
     * @return string
     */
    public function getMediaLink($id, $field='url') {
        $link =  get_post_meta($id, '_gumm_attachment_image_link', true);
        if (!is_array($link)) {
            $link = array('url' => $link, 'button' => __('More', 'gummfw'));
        }

        if (is_array($link) && $field != 'all' && isset($link[$field])) {
            return $link[$field];
        } else {
            return $link;
        }
    }
    
    /**
     * Method uses javascript set cookie to determine client device resolution.
     * Returns false if cookie not set
     * 
     * @return mixed array of width and height or false on failure
     */
    public function getClientResolution() {
        $resolution = 1440;
        if (isset($_COOKIE['__gumm_device'])) {
            $resolution = (int) $_COOKIE['__gumm_device']['resolution'];
        }
        
        return $resolution;
    }
    
    /**
     * Method uses javascript set cookie to determine client device pixel ratio.
     * Returns false if cookie not set
     * 
     * @return int
     */
    public function getClientPixelRatio() {
        $ratio = 1;
        if (isset($_COOKIE['__gumm_device'])) {
            $ratio = (int) $_COOKIE['__gumm_device']['pixelRatio'];
        }
        if (!$ratio) $ratio = 1;
        
        return $ratio;
    }
    
    /**
     * @param int $w
     * @param int $h
     * @param string $context
     * @return array
     */
    public function getMediaDimensionsForClientResolution($w, $h, $context=null) {
        $dimensions = array(
            'width' => $w,
            'height' => $h,
        );
        $maxWidth = $this->getClientResolution();
        // $maxWidth = 768;
        if ($resolutionBreakPoints = Configure::read('imageResolutionsBreakPoints')) {
            rsort($resolutionBreakPoints);
            $identifier = reset($resolutionBreakPoints);
            foreach ($resolutionBreakPoints as $breakPoint) { // filter down
                if ($maxWidth <= $breakPoint) {
                    $identifier = $breakPoint;
                }
            }
            
            $percent = Configure::read('imageSizeResolutionMap.' . $identifier);
            if ($context && Configure::read('imageSizeResolutionMap.' . $context . '.' . $identifier)) {
                $percent = Configure::read('imageSizeResolutionMap.' . $context . '.' . $identifier);
            }
            
            $dimensions = array(
                'width' => ceil($w * $percent) * $this->getClientPixelRatio(),
                'height' => ceil($h * $percent) * $this->getClientPixelRatio(),
            );
        }
        
        // If less than 768 -> no sidebars rendered anwyay eh?
        if ($identifier > 768) {
            $sidebarsNum = GummRegistry::get('Helper', 'Layout')->numSidebars();
            $sidebarsMap = Configure::read('imageSidebarsResolutionMap');
            if ($sidebarsPercent = Configure::read('imageSidebarsResolutionMap.' . $sidebarsNum)) {
                $dimensions['width'] *= $sidebarsPercent;
                $dimensions['height'] *= $sidebarsPercent;
            }
        }
        
        $dimensions['width'] = ceil($dimensions['width']);
        $dimensions['height'] = ceil($dimensions['height']);
        
        return $dimensions;
    }
    
    // ========== //
    // WP ACTIONS //
    // ========== //
    
    public function printAjaxUploadJs() {
        if (!$this->ajaxUploadSettings) return;

        foreach ($this->ajaxUploadSettings as $settings) {
            $this->ajaxUploadJs($settings);
        }
        
    }
    
    public function ajaxUploadJs($settings) {
        extract($settings, EXTR_OVERWRITE);
?>
        <script type="text/javascript">
        //<![CDATA[
        jQuery(document).ready(function() {
            
    		new AjaxUpload(jQuery('#<?php echo $id; ?>'), {
    			  action: <?php echo ($script == 'ajaxurl') ? $script : "'$script'"; ?>,
    			  name: 'Filedata',

                  <?php if ($scriptData): ?>
                  // Additional data
                  data: {
                      <?php
                      $scriptDataJsObj = array();
                      foreach ($scriptData as $param => $value) {
                          $scriptDataJsObj[] = $param . ':' . "'$value'";
                      }
                      echo implode(',', $scriptDataJsObj);
                      ?>
                  },
                  <?php endif; ?>

    			  autoSubmit: true,
    			  responseType: <?php echo $responseType == 'json' ? "'json'" : 'false'; ?>,
    			  onChange: function(file, extension){},
    			  onSubmit: function(file, extension) {
    			      <?php if (isset($callbacks['onSubmit'])): ?>
    			      return <?php echo $callbacks['onSubmit'];?>.call(this, {file: file, extension: extension});
    			      <?php endif; ?>
                  },
    			  onComplete: function(file, response) {
    			      <?php if (isset($callbacks['onComplete'])): ?>
    			      <?php echo $callbacks['onComplete'];?>.call(this, {file: file, response: response});
    			      <?php endif; ?>
                  }
		    });

        });
        //]]>
</script>
<?php
    }
    
    
    // ======= //
    // FILTERS //
    // ======= //
    
    /**
     * @param array $form_fields
     * @param object $post
     * @return array
     */
    public function filterMediaFields($form_fields, $post) {
        // d($form_fields);
        $fieldsRequired = array(
            'post_title' => '',
            'image_alt' => '',
            'post_excerpt' => '',
            'post_content' => '',
            // 'url' => '',
        );
        
        $mediaFields = array_intersect_key($form_fields, $fieldsRequired);
        // $mediaFields['link_button'] = array(
        //     'label' => __('Link Button Text', 'gummfw'),
        //     'input' => 'text',
        //     'value' => $this->getMediaLink($post->ID, 'button'),
        // );
        
        if (GummRegistry::get('Model', 'Media')->isAudio($post)) {
            $mediaFields = array_merge(array(
                'postmeta.artist' => array(
                    'label' => __('Artist', 'gummfw'),
                    'type' => 'text',
                    'value' => $this->Wp->getPostMeta($post->ID, 'postmeta.artist'),
                ),
            ), $mediaFields);
            $savedUrls = (array) $this->Wp->getPostMeta($post->ID, 'postmeta.provider');
            if ($providers = $this->Wp->getOption('audio_download_providers')) {
                foreach ($providers as $provider) {
                    $slug = Inflector::slug($provider['title']);
                    $mediaFields['postmeta.provider.' . $slug] = array(
                        'label' => sprintf(__('Download link for %s', 'gummfw'), '<strong>' . $provider['title'] . '</strong>'),
                        'input' => 'text',
                        'value' => isset($savedUrls[$slug]) ? $savedUrls[$slug] : '',
                    );
                }
            }
            $mediaFields['postmeta.label'] = array(
                'label' => __('Label', 'gummfw'),
                'input' => 'text',
                'value' => $this->Wp->getPostMeta($post->ID, 'postmeta.label'),
            );
            $mediaFields['postmeta.date'] = array(
                'label' => __('Date', 'gummfw'),
                'input' => 'date',
                'inputSettings' => array(
                    'time' => false,
                ),
                'value' => $this->Wp->getPostMeta($post->ID, 'postmeta.date'),
            );
            
            $mediaFields['postmeta.thumbnail'] = array(
                'label' => __('Thumbnail for this track', 'gummfw'),
                'input' => 'media',
                'inputSettings' => array(
                    'buttons' => 'media',
                    'multipleMedia' => false,
                ),
                'value' => $this->Wp->getPostMeta($post->ID, 'postmeta.thumbnail'),
            );

        }
        
        foreach ($mediaFields as $fieldName => &$fieldValues) {
            if (!isset($fieldValues['input']) || isset($fieldValues['input']) && $fieldValues['input'] == 'html')
                $fieldValues['type'] = 'text';
            else
                $fieldValues['type'] = $fieldValues['input'];
            
            switch ($fieldName) {
             case 'url':
                $fieldValues['value'] = $this->getMediaLink($post->ID, 'url');
                break;
             case 'post_excerpt':
                $fieldValues['label'] = __('Caption Title', 'gummfw');
                break;
             case 'post_content':
                $fieldValues['label'] = __('Caption', 'gummfw');
                break;
            }

        }

        return $mediaFields;
    }
    
    public function getAudioProvidersFields() {
        $mediaFields = array();
        if ($providers = $this->Wp->getOption('audio_download_providers')) {
            foreach ($providers as $provider) {
                $slug = Inflector::slug($provider['title']);
                $inputId = 'postmeta.provider.' . $slug;
                $mediaFields[] = array(
                    'id'    => GUMM_THEME_PREFIX . '_' . $inputId,
                    'name'  => sprintf(__('Download link for %s', 'gummfw'), '<strong>' . $provider['title'] . '</strong>'),
                );
            }
        }
        return $mediaFields;
    }
}
?>