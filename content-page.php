<?php
/**
 * @package WordPress
 * @subpackage Bugis
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-wrap">
		<header class="entry-header">
			<h1 class="entry-title"><?php the_title(); ?></h1>
		</header><!-- end entry-header -->

		<div class="entry-content">
			<?php the_content(); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'bugis' ), 'after' => '</div>' ) ); ?>
			<?php edit_post_link( __( 'edit page &rarr;', 'bugis'), '<div class="edit-link">', '</div>'); ?>
		</div><!-- end entry-content -->

	</div><!--end entry-wrap -->
</article><!-- end post-<?php the_ID(); ?> -->