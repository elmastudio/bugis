<?php
/**
 * @package WordPress
 * @subpackage Bugis
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-wrap">
	<?php if (is_sticky()) echo __( '<h2 class="sticky-label">Featured</h2>', 'bugis' ); ?>
		<div class="post-type">
			<a href="<?php the_permalink(); ?>" class="post-format gallery" title="Permalink"><?php _e('Permalink', 'bugis') ?></a>
			<p class="post-comments"><?php comments_popup_link( __( '0', 'bugis' ), __( '1', 'bugis' ), __( '%', 'bugis' ), 'comments-link', __( 'off', 'bugis' ) ); ?></p>
		</div><!--end post-type	-->

		<header class="entry-header">
			<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'bugis' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
		</header><!-- end entry-header -->


		<?php if ( post_password_required() ) : ?>
		<div class="entry-content">
			<?php the_content( __( 'View the pictures &rarr;', 'bugis' ) ); ?>
			
		<?php else : ?>
			
			<div class="entry-content">
			<?php
				$images = get_children( array( 'post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC', 'numberposts' => 999 ) );
				if ( $images ) :
					$total_images = count( $images );
					$image = array_shift( $images );
					$image_img_tag = wp_get_attachment_image( $image->ID, 'medium' );
			?>

				<figure class="gallery-thumb">
					<a href="<?php the_permalink(); ?>"><?php echo $image_img_tag; ?></a>
				</figure><!-- end gallery-thumb -->
				
			<?php endif; ?>
				<?php the_content( __( 'View the pictures &rarr;', 'bugis' ) ); ?>
			<?php endif; ?>

			<p class="pics-count"><?php printf( _n( 'This gallery contains <a %1$s>%2$s photo</a>.', 'This gallery contains <a %1$s>%2$s photos</a>', $total_images, 'bugis' ),
						'href="' . get_permalink() . '" title="' . sprintf( esc_attr__( 'Permalink to %s', 'bugis' ), the_title_attribute( 'echo=0' ) ) . '" rel="bookmark"',
						number_format_i18n( $total_images )
					); ?></p>
			
			<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'bugis' ), 'after' => '</div>' ) ); ?>
		</div><!-- end entry-content -->
	
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
		
	</div><!-- end entry-wrap -->
</article><!-- end post-<?php the_ID(); ?> -->