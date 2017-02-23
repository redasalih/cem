<?php
/*
Template Name: Template 2016
author : Alaa Zerroud
*/
get_header(); 
$link = get_stylesheet_directory_uri().'/app/assets/js/jqueryFancybox/fancybox/';
?>

<!--<link rel="stylesheet" type="text/css" href="<?=$link; ?>jquery.fancybox-1.3.4.css" media="screen">
<script src="<?=$link; ?>jquery.fancybox-1.3.4.pack.js" type="text/javascript"></script>-->

<?php if (have_posts()): ?>

    <?php
    while(have_posts()): the_post();
        global $post;
    
        if (post_password_required()) {
            echo '<div class="bluebox-builder-row"><div class="row"><div class="col-md-12">';
            the_content();
            echo '</div></div></div>';
        } else {
            get_template_part('loop', 'builder-elements');
        }
        
    endwhile;
    ?>

    <?php
    
    // if (comments_open()) {
    //     echo '<div class="bluebox-builder-row"><div class="row-fluid bluebox-container">';
    //     comments_template('', true);
    //     echo '</div></div>';
    // }
    
    if ($gummPageLinks = GummRegistry::get('Helper', 'Pagination')->wpLinkPages()) {
        echo '<div class="bluebox-builder-row"><div class="row">';
        echo $gummPageLinks;
        echo '</div></div>';
    }
    
    ?>
    
<?php else: ?>
    <div class="msg error">
        <p><?php _e('No posts were found', 'gummfw'); ?></p>
    </div>
<?php endif; ?>

<?php get_footer(); ?>