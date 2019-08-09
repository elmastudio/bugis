<?php
/**
 * @package WordPress
 * @subpackage Bugis
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<div class="entry-wrap">
	<div class="post-type">
		<?php if ( get_post_format() ) : ?>
			<a href="<?php the_permalink(); ?>" class="post-format <?php echo get_post_format(); ?>" title="Permalink"><?php _e('Permalink', 'bugis') ?></a>
		<?php else: ?>
			<a href="<?php the_permalink(); ?>" class="post-format standard" title="Permalink"><?php _e('Permalink', 'bugis') ?></a>
		<?php endif; ?>
		<p class="post-comments"><?php comments_popup_link( __( '0', 'bugis' ), __( '1', 'bugis' ), __( '%', 'bugis' ), 'comments-link', __( 'off', 'bugis' ) ); ?></p>
	</div><!--end post-type	-->
	
		<header class="entry-header">			
			<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'bugis' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
		</header><!--end entry-header -->
		
		<div class="entry-content">
			<?php if ( has_post_thumbnail() ): ?>
				<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a>
			<?php endif; ?>
			<?php the_content(); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'bugis' ), 'after' => '</div>' ) ); ?>
		</div><!-- end entry-content -->
		
		<?php if ( get_post_format() ) : // Show author bio only for standard post format posts ?>
	
		<?php else: ?>
	
			<?php if ( get_the_author_meta( 'description' ) ) : // If a user has filled out their description, show a bio on their entries  ?>
			<div class="author-info">
				<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'bugis_author_bio_avatar_size', 70 ) ); ?>
				<div class="author-description">
					<h3><?php printf( __( 'Author: %s', 'bugis' ), "<a href='" . get_author_posts_url( get_the_author_meta( 'ID' ) ) . "' title='" . esc_attr( get_the_author() ) . "' rel='me'>" . get_the_author() . "</a>" ); ?></h3>
					<p><?php the_author_meta( 'description' ); ?></p>
				</div><!-- end author-description -->
			</div><!-- end author-info -->
			<?php endif; ?>
		<?php endif; ?>
	
		<?php if ( 'post' == $post->post_type ) : // Hide entry-meta information for pages on search results ?>
		<footer class="entry-meta">
			<?php // Share Button (Post Shortlink, Twitter and Facebook Like). Activated on theme options page.
			$options = get_option('bugis_theme_options');
			if( $options['sharebtn'] ) : ?>
				<?php get_template_part( 'sharebtn'); ?>
			<?php endif; ?>
			
			<a href="<?php the_permalink(); ?>" class="post-date"><?php echo get_the_date(); ?></a>
			<p><span class="cat-links"><span class="cat-links-title"><?php _e( 'Categories ', 'bugis' ); ?></span><?php the_category( ', ' ); ?></span>
			<span class="tag-links"><?php the_tags( '<span class="tag-links-title">' . __( 'Tags ', 'bugis' ) . '</span>', ', ', '' ); ?></span></p>
			<?php edit_post_link( __( 'edit post &rarr;', 'bugis'), '<div class="edit-link">', '</div>'); ?>
		</footer><!-- end entry-meta -->
		<?php endif; ?>

	</div><!--end entry-wrap-->
</article><!-- end post-<?php the_ID(); ?> -->