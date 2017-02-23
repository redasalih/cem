<!DOCTYPE html>

<!-- BEGIN html -->
<html <?php language_attributes(); ?>>
<!-- Antoni Sinote Botev design (http://www.antonibotev.com) - Proudly powered by WordPress (http://wordpress.org) -->

<!-- BEGIN head -->
<head>
    <?php global $gummWpHelper, $gummJsHelper, $gummHtmlHelper, $gummLayoutHelper, $GummTemplateBuilder; ?>
    
    <script type="text/javascript">
        if (navigator.cookieEnabled === true) {
            var redirect = false;
            if (document.cookie.match(/__gumm_device\[pixelRatio\]=(\d+)/) === null) redirect = true;
            document.cookie='__gumm_device[resolution]='+Math.max(screen.width,screen.height)+'; path=/';
            document.cookie='__gumm_device[pixelRatio]='+("devicePixelRatio" in window ? devicePixelRatio : "1")+'; path=/';

            // if (redirect) document.location.reload(true);
        }
    </script>
    
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
</head>

<!-- BEGIN body -->
<body <?php body_class(); ?>>
    
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
    <div id="bb-background"></div>
    <?php View::renderElement('header/info-bar'); ?>

    <div class="row top-banner-row">
        <div class="top-banner-area">
            <a id="mobile-menu-button" class="mobile-nav-button" href="#">
                <span></span>
                <span></span>
                <span></span>
            </a>
            <?php
            echo $gummHtmlHelper->displayLogo();
            if ($gummWpHelper->getOption('header_countdown_display') === 'true') {
                View::renderElement('header/event-countdown-timer');
            }
            ?>
        </div>
    </div>

    <div class="content-wrap">
      <div class="main-container">
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
        }
        ?>

        <div class="row">
        <?php
        $gummLayoutHelper->getSidebarForPage('left');
        $gummLayoutHelper->contentTagOpen();
        ?>
        <content>