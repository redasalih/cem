<?php
class SingleAlbumLayoutElement extends GummLayoutElement {
    protected $id = '4AACC7CA-37E8-486B-98D9-68704CF6218A';
    
    /**
     * @var string
     */
    public $group = 'single';
    
    public $supports = array();
    
    protected $gridColumns = 12;
    
    public function title() {
        return __('Album Post Details', 'gummfw');
    }
    
    protected function _fields() {
        return array();
    }
    
    protected function _render($options) {
        global $post;
        
        $albumMetaFields    = $this->Wp->getOption('album_meta_fields');
        $savedFields        = (array) $this->Wp->getPostMeta($post->ID, 'postmeta.album_fields');
        $savedFields        = Set::filter($albumMetaFields);
        
        echo '<div class="' . $this->Layout->getLayoutColumnsNumberClassName(1) . '">';
        
?>
        <div class="album-info-wrap">
            <h2><?php the_title(); ?></h2>
            <?php if ($artist = $this->Wp->getPostMeta($post->ID, 'artist_name')): ?>
            <span class="band"><i class="icon-group"></i><?php echo $artist; ?></span>
            <?php endif; ?>
            <?php
            if ($providers = $this->Wp->getPostMeta($post->ID, 'postmeta.provider')) {
                if ($providers = (array) Set::filter($providers)) {
                    foreach ($providers as $providerSlug => $providerUrl) {
                        echo '<a href="' . $providerUrl . '" class="store-buttons" target="_blank">' . Inflector::humanize($providerSlug) . '</a>';
                    }
                }
            }
            
            if ($savedFields) {
                
                echo '<div class="extra-info">';
                foreach ($albumMetaFields as $albumMetaField) {
                    $slugged = strtolower(Inflector::slug($albumMetaField['title']));
                    if (isset($post->PostMeta['album_fields']) && isset($post->PostMeta['album_fields'][$slugged]) && $post->PostMeta['album_fields'][$slugged]) {
                        $fieldTitle = $albumMetaField['title'];
                        $fieldValue = $post->PostMeta['album_fields'][$slugged];
                        
                        if (strpos(strtolower($fieldTitle), 'date') !== false) {
                            $fieldValue = date_i18n(get_option('date_format'), strtotime($fieldValue));
                        }
                        echo '<div><span>' . $fieldTitle . ':</span> ' . $fieldValue . '</div>';
                    }
                }
                echo '</div>';
            }
            ?>
            <?php if ($post->Thumbnail): ?>
            <div class="album-cover">
                <?php echo $this->Media->display($post->Thumbnail); ?>
            </div>
            <?php endif; ?>
        </div>
<?php
        echo '</div>';
    }
}
?>