<?php
/**
 * @package WordPress
 * @subpackage Bugis
 */

get_header(); ?>

<div id="main" class="clearfix">
	<div id="content">
		<article class="page">
			<div class="entry-wrap">
				<header class="entry-header">
					<h1 class="entry-title"><?php _e( 'Not Found', 'bugis' ); ?></h1>
				</header><!--end entry-header -->

				<div class="entry-content">
					<p><?php _e( 'Apologies, but the page you requested could not be found. Perhaps searching will help.', 'bugis' ); ?></p>
					<?php get_search_form(); ?>
				</div><!-- end entry-content -->

			<script type="text/javascript">
			// focus on search field after it has loaded
			document.getElementById('s') && document.getElementById('s').focus();
			</script>
			</div><!-- end entry-wrap -->
		</article>
	</div><!--end content-->

<?php get_sidebar(); ?>
<?php get_footer(); ?>