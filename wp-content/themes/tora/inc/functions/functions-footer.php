<?php
/**
 * Footer credits and menu
 *
 * @package Tora
 */


/**
 * Footer menu
 */
function tora_footer_menu() {
	?>
		<nav id="footer-navigation" class="footer-navigation" role="navigation">
			<?php wp_nav_menu( array( 'theme_location' => 'footer', 'menu_id' => 'footer-menu', 'depth' => 1 ) ); ?>
		</nav>
	<?php
}
add_action('tora_footer', 'tora_footer_menu', 7);

/**
 * Go to top button
 */
function tora_go_to_top() {
	echo '<a class="go-top"><i class="tora-icon dslc-icon-ei-arrow_triangle-up"></i></a>';
}
add_action('tora_footer', 'tora_go_to_top', 8);

/**
 * Footer credits
 */
function tora_footer_credits() {
	?>
		<div class="site-info">
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'tora' ) ); ?>"><?php printf( esc_html__( 'Powered by %s', 'tora' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( esc_html__( 'Theme: %s', 'tora' ), '<a href="http://theme.blue/themes/tora" rel="designer">Tora</a>' ); ?>
		</div>
	<?php
}
add_action('tora_footer', 'tora_footer_credits', 9);