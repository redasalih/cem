<?php get_header(); ?>
    
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