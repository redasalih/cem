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
    wp_link_pages(array(
        'before' => '<ul class="bluebox-pagination"><li>' . __('Pages:', 'gummfw') . '</li><li>',
        'separator' => '</li><li>',
        'after' => '</li></ul>',
    ));
    ?>
        
<?php else: ?>
    <div class="msg error">
        <p><?php _e('No posts were found', 'gummfw'); ?></p>
    </div>
<?php endif; ?>

<?php get_footer(); ?>