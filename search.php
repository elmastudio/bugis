<?php
/**
 * @package WordPress
 * @subpackage Bugis
 */

get_header(); ?>

<div id="main" class="clearfix">
	<div id="content">

			<?php if ( have_posts() ) : ?>
			<header class="page-header">
			<h2 class="page-title"><?php echo $wp_query->found_posts; ?> <?php printf( __( 'Search Results for &lsquo;%s&rsquo;', 'bugis' ), '<span>' . get_search_query() . '</span>' ); ?></h2>
		</header><!--end .page-header -->

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'content', get_post_format() );
					?>

				<?php endwhile; ?>

				<?php /* Display navigation to next/previous pages when applicable, also check if WP page navi plugin is activated */ ?>
				<?php if(function_exists('wp_pagenavi')) : wp_pagenavi(); else: ?>
	
				<?php if (  $wp_query->max_num_pages > 1 ) : ?>

					<nav id="nav-below">
						<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'bugis' ) ); ?></div>
						<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'bugis' ) ); ?></div>
					</nav><!-- end nav-below -->

				<?php endif; ?>
				
				<?php endif; ?>

				<?php else : ?>

				<article id="post-0" class="page no-results not-found">
				<div class="entry-wrap">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing Found', 'bugis' ); ?></h1>
					</header><!--end entry-header -->

					<div class="entry-content">
						<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'bugis' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- end entry-content -->

				</div><!-- end entry-wrap -->
			</article>
			<?php endif; ?>

	</div><!--end content-->

<?php get_sidebar(); ?>
<?php get_footer(); ?>