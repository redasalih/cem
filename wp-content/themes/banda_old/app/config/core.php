<?php

/**
 * Define build for the theme.
 * 
 * Possible values are 'release' | 'production' | 'development'
 */
Configure::write('build', 'production');

Configure::write('dynamicStylesOptionsMap', array(
    'color_option_1' => array(
        'color' => array(
            'body footer a:hover',
            'body a:hover',
            '.content-wrap .main-container header nav ul li a:hover i',
            '.content-wrap .main-container header nav ul li.current-item>a',
            '.content-wrap .main-container header nav ul li.current-menu-item>a',
            '.content-wrap .main-container header nav ul li.current_page_item>a',
            '.content-wrap .main-container header nav ul li>ul li:hover i.icon-chevron-right',
            '.bb-slider .slider-caption h2 a:hover',
            '.bb-slider .slider-caption .bluebox-info-line a:hover',
            '.bb-slider-2 .slider-caption h2 a:hover',
            '.bluebox-heading a:hover',
            '.bluebox-heading-wrap a:hover',
            '.events-list .event .details h1',
            '.events-list .event .details h1 a',
            '.events-list .event .more-link:hover',
            '.events-page .event .details .rating li.fill',
            '.events-page .event .buttons a.default',
            '.audio-page>div .buttons-wrap a',
            '.album-wrap .album-caption h4 a:hover',
            '.album-info-wrap a.store-buttons',
            '.meta-line a:hover',
            'ol.comment-list li.comment .comment-meta a:hover',
            '.default-button',
            'input[type="submit"]',
            '.bb-button',
            
        ),
        'background-color' => array(
            'ul.news-list.half-image li.sticky:after',
            'header.top-bar .center-info .bg-player .player-button:hover',
            '.event-counter .event-more:hover',
            array(
                'selectors' => array(
                    '.content-wrap .main-container header nav ul li>ul li.current-item>a',
                    '.content-wrap .main-container header nav ul li>ul li.current-menu-item>a',
                    '.content-wrap .main-container header nav ul li>ul li.current_page_item>a',
                ),
                'params' => array(
                    'important' => true,
                ),
            ),
            '.bb-slider-2:hover .arrow-right-link:hover',
            '.bb-slider-2:hover .arrow-left-link:hover',
            'section.featured-post .image-details',
            '.events-list .event .date',
            '.events-page .event .buttons a.default:hover',
            '.audio-tracks-wrap>div .button',
            '.audio-tracks-wrap>div .details .track-progress-bar a span',
            '.audio-page>div .buttons-wrap a:hover',
            '.video-buttons span.button-play:hover',
            '.gallery-wrap .image-wrap a.image-link .image-details',
            '.album-wrap:hover .tracks-list:hover',
            '.member-info-wrap .extra-info ul.social li a:hover',
            '.album-info-wrap a.store-buttons:hover',
            'ul.news-list li a.image-wrap',
            'ul.news-list li a.image-wrap .image-details',
            '.bluebox-pagination li a:hover',
            '.bluebox-pagination li.current a',
            '.categories-list li a:hover',
            '.categories-list li.current a',
            '.bb-image-wrap:hover .arrow-right-link:hover',
            '.bb-image-wrap:hover .arrow-left-link:hover',
            '.default-button:hover',
            'input[type="submit"]:hover',
            '.widget-wrap ul.menu .sub-menu li.current-menu-item a',
            '.social-widget ul li a:hover',
            'footer .social-widget ul li a:hover',
            '.sticky-button-wrap a:hover',
            '.sticky-button-wrap a:hover',
            '.footer-sticky-player .player-wrap .buttons .track-progress span',
            '.footer-sticky-player .player-wrap .buttons .volume a.volume-link:hover',
            '.footer-sticky-player .player-wrap .buttons .volume .volume-bar span',
            '.footer-sticky-player .player-wrap .buttons .buttons-wrap a:hover',
            '.footer-sticky-player .player-wrap .buttons .buttons-wrap a.forward:hover',
            '.footer-sticky-player .player-wrap .buttons .buttons-wrap a.backward:hover',
            '.bb-button:hover',
            '.error-404 p',
            '.error-404 p i',
        ),
        'box-shadow' => array(
            '.content-wrap .main-container header nav ul li a:hover' => array(
                'declaration' => 'inset 0 -1px 0 0 %s',
            ),
            array(
                'selectors' => array(
                    '.content-wrap .main-container header nav ul li.current-item>a',
                    '.content-wrap .main-container header nav ul li.current-menu-item>a',
                    '.content-wrap .main-container header nav ul li.current_page_item>a',
                ),
                'params' => array(
                    'declaration' => 'inset 0 -1px 0 0 %s',
                ),
            ),
            array(
                'selectors' => array(
                    '.events-page .event .buttons a.default',
                    '.events-page .event .buttons a.default:hover',
                    '.audio-page>div .buttons-wrap a',
                    '.audio-page>div .buttons-wrap a:hover',
                    '.album-info-wrap a.store-buttons',
                    '.album-info-wrap a.store-buttons:hover',
                    
                    '.default-button',
                    'input[type="submit"]',
                    '.default-button:hover',
                    'input[type="submit"]:hover',
                    '.bb-button',
                    
                ),
                'params' => array(
                    'declaration' => '0px 0px 0px 1px %s',
                ),
            ),
            array(
                'selectors' => array(
                    'input[type="text"]:focus',
                    '.bluebox-contact textarea:focus',
                ),
                'params' => array(
                    'declaration' => 'inset 0px 0px 0px 1px %s',
                ),
            ),
            '.content-wrap .main-container header nav ul li>ul' => array(
                'declaration' => 'inset 0 1px 0 0 %s, 0px 3px 20px -3px rgba(0,0,0,0.26)',
            ),
            '.gumm-autocomplete-wrapper' => array(
                'declaration' => 'inset 0 1px 0 0 %s, 0px 3px 20px -3px rgba(0,0,0,0.26)',
            )
        ),
        'border' => array(
            '.error-404 p' => array(
                'declaration' => '1px solid %s',
            ),
        ),
        'border-top' => array(
            '.band-member .image-wrap .gallery-caption span' => array(
                'declaration' => '1px solid %s',
            ),
        ),
        'border-bottom' => array(
            '.content-wrap .main-container header nav ul li>ul:after' => array(
                'declaration' => '5px solid %s',
            ),
        ),
        'border-bottom-color' => array(
            '.gumm-autocomplete-wrapper .arrow' => array(
                'important' => true,
            ),
        ),
    ),
));

Configure::write('styleGroups', array(
    'heading_fonts' => array('body h1', 'body h2', 'body h3', 'body h4', 'body h5'),
    'content_wrap' => array('.content-wrap .main-container'),
    'body_background' => array('#bb-background'),
));
Configure::write('themeDefaultColors', array(
    'color_option_1' => 'e74c3c',
    // 'color_option_2' => 'ffffff',
    // 'color_option_3' => '000000',
));

Configure::write('themeSupport', array(
    'skins' => true,
));

Configure::write('customPostTypes', array(
    'gallery' => array(
        'args' => array(
            'labels' => array(
                'name' => _x('Gallery', 'gallery admin labels', 'gummfw'),
                'singular_name' => _x('Gallery', 'gallery admin labels', 'gummfw'),
                'all_items' => _x('All Gallery Items', 'gallery admin labels', 'gummfw'),
                'edit_item' => _x('Edit Gallery', 'gallery admin labels', 'gummfw'),
                'new_item' => _x('New Gallery', 'gallery admin labels', 'gummfw'),
                'view_item' => _x('View Gallery', 'gallery admin labels', 'gummfw'),
                'search_items' => _x('Search Gallery Items', 'gallery admin labels', 'gummfw'),
            ),
            'public' => true,
            'show_ui' => true, 
            'capability_type' => 'post',
            'hierarchical' => false,
            'rewrite' => array('with_front' => false),
            'supports' => array('title', 'editor', 'author', 'excerpt', 'revisions', 'thumbnail', 'page-attributes', 'comments'),
            'taxonomies' => array('post_tag', 'gallery_category'),
            'menu_position' => 5,
        ),
        'columns' => array(
            "cb" => "<input type=\"checkbox\" />",
            'thumbnail' => '',
            "title" => _x("Title", "gallery title column", 'gummfw'),
            "author" => _x("Author", "gallery author column", 'gummfw'),
            "category" => _x("Category", "gallery types column", 'gummfw'),
            "date" => _x("Date", "gallery date column", 'gummfw')
        ),
    ),
    'audio' => array(
        'args' => array(
            'labels' => array(
                'name' => _x('Audio', 'audio admin labels', 'gummfw'),
                'singular_name' => _x('Audio', 'audio admin labels', 'gummfw'),
                'all_items' => _x('All Audio Items', 'audio admin labels', 'gummfw'),
                'edit_item' => _x('Edit Audio Item', 'audio admin labels', 'gummfw'),
                'new_item' => _x('New Audio Item', 'audio admin labels', 'gummfw'),
                'view_item' => _x('View Audio Item', 'audio admin labels', 'gummfw'),
                'search_items' => _x('Search Audio Items', 'audio admin labels', 'gummfw'),
            ),
            'public' => true,
            'show_ui' => true, 
            'capability_type' => 'post',
            'hierarchical' => false,
            'rewrite' => array('with_front' => false),
            'supports' => array('title', 'editor', 'author', 'excerpt', 'revisions', 'thumbnail', 'page-attributes', 'comments'),
            'taxonomies' => array('post_tag', 'audio_category'),
            'menu_position' => 5,
        ),
        'columns' => array(
            "cb" => "<input type=\"checkbox\" />",
            "title" => _x("Title", "video title column", 'gummfw'),
            "author" => _x("Author", "video author column", 'gummfw'),
            "category" => _x("Category", "video types column", 'gummfw'),
            "date" => _x("Date", "video date column", 'gummfw')
        ),
    ),
    'video' => array(
        'args' => array(
            'labels' => array(
                'name' => _x('Video', 'video admin labels', 'gummfw'),
                'singular_name' => _x('Video', 'video admin labels', 'gummfw'),
                'all_items' => _x('All Video Items', 'video admin labels', 'gummfw'),
                'edit_item' => _x('Edit Video', 'video admin labels', 'gummfw'),
                'new_item' => _x('New Video', 'video admin labels', 'gummfw'),
                'view_item' => _x('View Video', 'video admin labels', 'gummfw'),
                'search_items' => _x('Search Video Items', 'video admin labels', 'gummfw'),
            ),
            'public' => true,
            'show_ui' => true, 
            'capability_type' => 'post',
            'hierarchical' => false,
            'rewrite' => array('with_front' => false),
            'supports' => array('title', 'editor', 'author', 'excerpt', 'revisions', 'thumbnail', 'page-attributes', 'comments'),
            'taxonomies' => array('post_tag', 'video_category'),
            'menu_position' => 5,
        ),
        'columns' => array(
            "cb" => "<input type=\"checkbox\" />",
            'thumbnail' => '',
            "title" => _x("Title", "video title column", 'gummfw'),
            "author" => _x("Author", "video author column", 'gummfw'),
            "category" => _x("Category", "video types column", 'gummfw'),
            "date" => _x("Date", "video date column", 'gummfw')
        ),
    ),
    'album' => array(
        'args' => array(
            'labels' => array(
                'name' => _x('Albums', 'gallery admin labels', 'gummfw'),
                'singular_name' => _x('Album', 'album admin labels', 'gummfw'),
                'all_items' => _x('All Albums', 'album admin labels', 'gummfw'),
                'edit_item' => _x('Edit Album', 'album admin labels', 'gummfw'),
                'new_item' => _x('New Album', 'album admin labels', 'gummfw'),
                'view_item' => _x('View Album', 'album admin labels', 'gummfw'),
                'search_items' => _x('Search Albums', 'album admin labels', 'gummfw'),
            ),
            'public' => true,
            'show_ui' => true, 
            'capability_type' => 'post',
            'hierarchical' => false,
            'rewrite' => array('with_front' => false),
            'supports' => array('title', 'editor', 'author', 'excerpt', 'revisions', 'thumbnail', 'page-attributes', 'comments'),
            'taxonomies' => array('post_tag', 'album_category'),
            'menu_position' => 5,
        ),
        'columns' => array(
            "cb" => "<input type=\"checkbox\" />",
            'thumbnail' => '',
            "title" => _x("Title", "album title column", 'gummfw'),
            "author" => _x("Author", "album author column", 'gummfw'),
            "category" => _x("Category", "album types column", 'gummfw'),
            "date" => _x("Date", "album date column", 'gummfw')
        ),
    ),
    'member' => array(
        'args' => array(
            'labels' => array(
                'name' => _x('Members', 'staff admin labels', 'gummfw'),
                'singular_name' => _x('Member', 'staff admin labels', 'gummfw'),
                'all_items' => _x('All Members', 'staff admin labels', 'gummfw'),
                'edit_item' => _x('Edit Member', 'staff admin labels', 'gummfw'),
                'new_item' => _x('New Member', 'staff admin labels', 'gummfw'),
                'view_item' => _x('View Member', 'staff admin labels', 'gummfw'),
                'search_items' => _x('Search Members', 'staff admin labels', 'gummfw'),
            ),
            
            'public' => true,
            'exclude_from_search' => false,
            'publicly_queryable' => true,
            'show_ui' => true, 
            'show_in_nav_menus' => true,
            'capability_type' => 'post',
            'hierarchical' => false,
            'rewrite' => array('with_front' => false),
            'supports' => array('title', 'editor', 'author', 'excerpt', 'revisions', 'thumbnail', 'page-attributes', 'comments'),
            'taxonomies' => array('member_category'),
            'menu_position' => 5,
        ),
        'columns' => array(
            "cb" => "<input type=\"checkbox\" />",
            'thumbnail' => '',
            "title" => _x("Title", "staff title column", 'gummfw'),
            "author" => _x("Author", "staff author column", 'gummfw'),
            "category" => _x("Category", "staff types column", 'gummfw'),
            "date" => _x("Date", "staff date column", 'gummfw')
        ),
    ),
    'event' => array(
        'args' => array(
            'labels' => array(
                'name' => _x('Events', 'gallery admin labels', 'gummfw'),
                'singular_name' => _x('Event', 'gallery admin labels', 'gummfw'),
                'all_items' => _x('All Events', 'gallery admin labels', 'gummfw'),
                'edit_item' => _x('Edit Event', 'gallery admin labels', 'gummfw'),
                'new_item' => _x('New Event', 'gallery admin labels', 'gummfw'),
                'view_item' => _x('View Event', 'gallery admin labels', 'gummfw'),
                'search_items' => _x('Search Events', 'gallery admin labels', 'gummfw'),
            ),
            'public' => true,
            'show_ui' => true, 
            'capability_type' => 'post',
            'hierarchical' => false,
            'rewrite' => array('with_front' => false),
            // 'rewrite' => false,
            'supports' => array('title', 'editor', 'author', 'excerpt', 'revisions', 'thumbnail', 'comments'),
            'taxonomies' => array('event_category', 'post_tag'),
            'menu_position' => 5,
            // 'menu_icon' => get_bloginfo('template_directory') . '/functions/img/icon.png',
        ),
    ),
));

Configure::write('customTaxonomies', array(

));

Configure::write('imageSizesMap', array(
    'noSidebars' => array(
        
    ),
    'oneSidebar' => array(
        
    ),
    'twoSidebars' => array(

    ),
));

Configure::write('excerptLengthMap', array(
    'noSidebars' => array(

    ),
    'oneSidebar' => array(

    ),
    'twoSidebars' => array(
        
    ),
));

Configure::write('layoutStructureMap', array(

));

Configure::write('optionIdStructureMap', array(
    'sidebars' => 'layout.%s.sidebars',
    'layoutSchema' => 'layout.%s.schema',
    'layoutType' => 'layout.%s.type',
    'layoutComponents' => 'layout.%s.layout_components',
));

/**
 * Configuration for default sidebars
 * 
 * This config write should contain the default sidebars by orientation
 * If the theme does support layout manipulation (which it should if it is proper GUMM),
 * use keys for the default orientations, as fall back layout pages will default to these
 * 
 */
Configure::write('sidebars', array(
    'left' => array(
        array(
            'name'          => 'Main Left Sidebar',
            'id'            => 'gumm-default-sidebar-left-1',
            'description'   => __('Left Sidebar on all pages', 'gummfw'),
            'before_widget' => '<div class="widget-wrap">',
            'after_widget'  => '</div>',
            'before_title'  => '<div class="bluebox-heading-wrap"><h3 class="bluebox-heading widget">',
            'after_title'   => '</h3></div>',
        ),
    ),
    'right' => array(
        array(
            'name'          => 'Main Right Sidebar',
            'id'            => 'gumm-default-sidebar-right-1',
            'description'   => __('Right Sidebar on all pages', 'gummfw'),
            'before_widget' => '<div class="widget-wrap">',
            'after_widget'  => '</div>',
            'before_title'  => '<div class="bluebox-heading-wrap"><h3 class="bluebox-heading widget">',
            'after_title'   => '</h3></div>',
        ),
    ),
    'footer' => array(
        array(
            'name'          => 'Footer 1',
            'id'            => 'gumm-footer-sidebar-1',
            'description'   => __('Footer sidebar first column', 'gummfw'),
            'before_widget' => '<div class="widget-wrap">',
            'after_widget'  => '</div>',
            'before_title'  => '<div class="bluebox-heading widget"><h3>',
            'after_title'   => '</h3></div>',
        ),
        array(
            'name'          => 'Footer 2',
            'id'            => 'gumm-footer-sidebar-2',
            'description'   => __('Footer sidebar second column', 'gummfw'),
            'before_widget' => '<div class="widget-wrap">',
            'after_widget'  => '</div>',
            'before_title'  => '<div class="bluebox-heading widget"><h3>',
            'after_title'   => '</h3></div>',
        ),
        array(
            'name'          => 'Footer 3',
            'id'            => 'gumm-footer-sidebar-3',
            'description'   => __('Footer sidebar third column', 'gummfw'),
            'before_widget' => '<div class="widget-wrap">',
            'after_widget'  => '</div>',
            'before_title'  => '<div class="bluebox-heading widget"><h3>',
            'after_title'   => '</h3></div>',
        ),
        array(
            'name'          => 'Footer 4',
            'id'            => 'gumm-footer-sidebar-4',
            'description'   => __('Footer sidebar fourth column', 'gummfw'),
            'before_widget' => '<div class="widget-wrap">',
            'after_widget'  => '</div>',
            'before_title'  => '<div class="bluebox-heading widget"><h3>',
            'after_title'   => '</h3></div>',
        ),
    ),
    
));

Configure::write('widgets', array(
    'GummPostsWidget',
    'GummEventsWidget',
    'GummContactFormWidget',
    'GummSocialNetworksWidget',
    'GummLatestAlbumWidget',
    'GummLatestVideoWidget',
    'GummLatestGalleryWidget',
    'GummAudioWidget',
));

Configure::write('Settings.maxNumCategories', 6);

Configure::write('Skin.customUserSkinId', 'user-custom-skin');

Configure::write('Security.cipherSeed', '598981478357997151979011865');

?>
