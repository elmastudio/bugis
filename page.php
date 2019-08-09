<?php
/**
 * @package WordPress
 * @subpackage Bugis
 */

get_header(); ?>

<div id="main" class="clearfix">
	<div id="content">
		<?php the_post(); ?>
			<?php get_template_part( 'content', 'page' ); ?>
			
			<div id="page-comments">
				<?php comments_template( '', true ); ?>
			</div><!-- end page-comments -->

	</div><!-- end content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>