 <?php
/**
 * @package WordPress
 * @subpackage Bugis
 */
?>

	</div><!--end main-->
	<div class="clear"></div>

	<footer id="colophon">
			<?php if (has_nav_menu( 'footer' ) ) {
				wp_nav_menu( array('theme_location' => 'footer', 'container' => 'nav', 'depth' => 1 ));}
			?>

		<div id="site-generator">
			<?php
				$options = get_option('bugis_theme_options');
				if($options['custom_footertext'] != '' ){
					echo stripslashes($options['custom_footertext']);
				} else { ?>
					<p>&copy; <?php echo date('Y'); ?> <?php bloginfo(); ?>  | <?php _e('Proudly powered by', 'bugis') ?> <a href="https://wordpress.org/" >WordPress</a><span class="sep"> | </span><?php printf( __( 'Theme: %1$s by %2$s', 'bugis' ), 'Bugis', '<a href="https://www.elmastudio.de/en/">Elmastudio</a>' ); ?></p>
			<?php } ?>
		</div><!-- end site generator -->

		<a href="#header" class="top-btn"><?php _e( 'Top', 'bugis' ); ?></a>
	</footer><!-- end colophon -->
</div><!--end page-->

<?php // Include Tweet button Google+ button scripts if share-post buttons are activated (via theme options page).
$options = get_option('bugis_theme_options');
if($options['sharebtn']) : ?>
<script type="text/javascript" src="https://platform.twitter.com/widgets.js"></script>
<script type="text/javascript">
	(function() {
		var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
		po.src = 'https://apis.google.com/js/plusone.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
	})();
</script>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
