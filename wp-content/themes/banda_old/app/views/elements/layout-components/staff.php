<?php
if (!class_exists('GalleryLayoutElement')) {
    App::import('LayoutElement', 'Gallery');
}
class StaffLayoutElement extends GalleryLayoutElement {
    /**
     * @var string
     */
    protected $id = '0D4E47CE-B678-4F10-9340-09CE42C6D463';
    
    
    public function initialize() {
        $this->supports['postType'] = 'member';
        $this->supports['postColumns']['value'] = 3;
        $this->supports[] = 'categoriesFilter';
        $this->supports['thumbnailEffect'] = 'plus';
    }
    
    /**
     * @return string
     */
    public function title() {
        return __('Members', 'gummfw');
    }
    
    protected function captionExtraInfo() {
        global $post;
        
        $info = '';
        if ($date = $this->Wp->getPostMeta($post->ID, 'postmeta.date_of_birth')) {
            $info = date_i18n(get_option('date_format'), strtotime($date));
        }

        return $info;
    }
    
    protected function galleryWrapClass() {
        return parent::galleryWrapClass() . ' band-member';
    }
}
?>