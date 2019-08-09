<?php
/**
 * @package WordPress
 * @subpackage Bugis
 */
?>

<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>

	<div id="secondary" class="widget-area" role="complementary">
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	</div><!-- end secondary -->

<?php endif; // end sidebar widget area ?>