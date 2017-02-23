<!DOCTYPE html>

<!-- BEGIN html -->
<html <?php language_attributes(); ?>>
<!-- Antoni Sinote Botev design (http://www.antonibotev.com) - Proudly powered by WordPress (http://wordpress.org) -->

<!-- BEGIN head -->
<head>
    <style>
        ul.kiwi-logo-carousel.kiwi-logo-carousel-slider{
            margin: 0 !important;
            /*margin-left: -50px !important;*/
        }
        ul.kiwi-logo-carousel.kiwi-logo-carousel-slider li{
            margin: 0 !important;
            position: absolute;
            left: 0;
            z-index: 100
        }
        ul.kiwi-logo-carousel{
            list-style: none;
            margin: 0 !important;
            /*margin-left: -50px !important;*/
        }
        ul.kiwi-logo-carousel li{
            margin: 0 !important;
            /*position: absolute;*/
            left: 0;
        }
    </style>
    <?php global $gummWpHelper, $gummJsHelper, $gummHtmlHelper, $gummLayoutHelper, $GummTemplateBuilder; ?>
    
    <script type="text/javascript">
        if (navigator.cookieEnabled === true) {
            var redirect = false;
            if (document.cookie.match(/__gumm_device\[pixelRatio\]=(\d+)/) === null) redirect = true;
            document.cookie='__gumm_device[resolution]='+Math.max(screen.width,screen.height)+'; path=/';
            document.cookie='__gumm_device[pixelRatio]='+("devicePixelRatio" in window ? devicePixelRatio : "1")+'; path=/';

            if (redirect) document.location.reload(true);
        }
    </script>

        <!-- Go to www.addthis.com/dashboard to customize your tools 
    partage dans les reseaux sociaux     -->
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-56617ea4d1173e4e" async="async"></script>



    <!-- Meta Tags -->
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    
    <!-- Title -->
    <title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
    
    <!-- Favicon -->
    <?php $gummFaviconUrl = ($gummCustomFaviconUrl = $gummWpHelper->getOption('favicon')) ? $gummCustomFaviconUrl : GUMM_THEME_URL . '/images/' . GUMM_THEME_PREFIX . '-favicon.gif'; ?>
    <link rel="shortcut icon" href="<?php echo $gummFaviconUrl ?>" />   
    
    <!-- RSS & Pingbacks -->
    <link rel="alternate" type="application/rss+xml" title="<?php bloginfo( 'name' ); ?> RSS Feed" href="<?php if (get_option(GUMM_THEME_PREFIX . '_feedburner')) { echo get_option(GUMM_THEME_PREFIX . '_feedburner'); } else { bloginfo( 'rss2_url' ); } ?>" />
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    
    <!-- Theme Hook -->
    <?php wp_head(); ?>

    <?php
    $url = get_stylesheet_directory_uri();
    ?>
    


</head>

<!-- BEGIN body -->
<body <?php body_class(); ?>>
    <?php
        // loadin page Home
        $loading_root       =   dirname( __FILE__ ).'/app/css-gears/';
        $loading_url        =   get_template_directory_uri(); 
        $site_url           =   get_template_directory_uri().'/app/css-gears/'; 
        if (is_page(174))
        {
          // $url = get_stylesheet_directory_uri();
            require_once $loading_root.'index.php'; 
        }

    ?>
    <div id="mobile-menu">
        <?php
        $gummHtmlHelper->displayMenu(array(
            'id' => 'prime-nav-mobile',
            'class' => 'prime-nav-mobile-list',
            'walker' => 'GummResponsiveNavMenuWalker',
        ));
        ?>
    </div>
    
    <div id="bb-loadable-content">
    <!-- <div id="bb-background"></div> -->
    <?php View::renderElement('header/info-bar'); ?>


<div class="content-wrap">
    <div class="main-container">
        <div class="row top-banner-row">
            <!-- <div class="Edition">
                <img src="http://caravaneemploi.com/wp-content/uploads/2015/images/4%20eme%20e%CC%81dition.png">
            </div> -->
            <div class="top-banner-area">
                <a id="mobile-menu-button" class="mobile-nav-button" href="#">
                    <span></span>
                    <span></span>
                    <span></span>
                </a>
                <?php
                echo $gummHtmlHelper->displayLogo();
                if ($gummWpHelper->getOption('banda_header_countdown_display') === 'true') {
                    View::renderElement('header/event-countdown-timer');
                }   
                ?>
                <a class="btn_inscription" href="<?=site_url()?>/visiter/je-minscris/">Je m'inscris</a>
                <!-- <div id="swiffycontainer" style="width: 530px; height: 90px;  position: absolute; top: 0; right: 20px;">
                    <a href="http://www.axaservices.ma" target="_blank" style="display: block; height: 90px;position: absolute; top: 0;width: 530px;
                    z-index: 9999;"></a>
                    <div style="position: absolute; width: 100%; height: 100%; overflow: hidden; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); -webkit-user-select: none;"><canvas width="530" height="90" style="width: 530px; height: 90px; position: relative; left: 0px; top: 0px;"></canvas>
                    </div>
                </div> -->
            </div>
        </div>
        <header>
          <nav>
            <?php $gummHtmlHelper->displayMenu(array('class' => 'prime-nav')); ?>
          </nav>
        </header>
        <span class="clear"></span>
        
        <?php
        $gummHeaderElements = (is_page()) ? $GummTemplateBuilder->getTemplateElementsEnabled('header') : null;
        if ($gummHeaderElements) {
            foreach ($gummHeaderElements as $gummHeaderElement) {
                echo '<div class="row header-row">';
                $gummHeaderElement->render();
                echo '</div>';
            }
            echo '<h3><i class="icon-cogs"></i>&nbsp;&nbsp;Les exposants 2015<a class="catShowAll" href="la-caravane/liste-des-exposants/">Tous les exposants +</a></h3>';
        }
        ?>
    </div>
</div>
        <?php
            if(is_front_page())
            { 
        ?>
                <div class="sliderHeader">
                    <!-- <img class="slider" src="http://dev.caravaneemploi.com/wp-content/themes/banda_old/images/slider.jpg"/> -->
                    <div class="content_slider">
                        <div class="content_slider_center"> 
                            <div class="edition content_slider_item">
                                <img src="<?=$url?>/images/edition.png">
                                <img src="<?=$url?>/images/la_croche.png" alt="Un salon ambulant qui vise à accueillir les chercheurs d’emploi et les rapprocher en un seul lieu"/>
                            </div>  
                            <!--
                                <div class="timer content_slider_item">
                                    <span class="etape">Casablanca <span>dans</span></span>
                                    <span class="timer_home">
                                        
                                    </span>
                                </div>  
                            -->
                            <!-- <div class="croche content_slider_item"> <img src="http://www.caravaneemploi.com/wp-content/themes/banda_old/images/la_croche.png" alt="Un salon ambulant qui vise à accueillir les chercheurs d’emploi et les rapprocher en un seul lieu"/></div>   -->
                        </div> 
                    </div>
                    <?php
                        // kw_sc_logo_carousel('slider');
                    ?>
                </div>
<div class="content-wrap">
    <div class="main-container">
        <?php
        echo '<div class="exposants  bluebox-heading"><h3>Les exposants de l\'édition 2016</h3><a class="catShowAll" href="la-caravane/liste-des-exposants/"><i class="icon-plus-sign-alt"></i> Tous les exposants</a>';
        kw_sc_logo_carousel('exposant2016');
        echo '</div>';
        ?>
    </div>
</div>
        <?php 
            }
        ?>
<div class="content-wrap">
    <div class="main-container">
        <div class="row">
        <?php
        $gummLayoutHelper->getSidebarForPage('left');
        $gummLayoutHelper->contentTagOpen();
        ?>
        <content>



