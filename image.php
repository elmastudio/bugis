<?php
/**
 * @package WordPress
 * @subpackage Bugis
 */

get_header(); ?>

<div id="main" class="clearfix">
	<div id="content">
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="entry-wrap">
				<div class="post-type">
				<a href="<?php the_permalink(); ?>" class="post-format gallery" title="Permalink"><?php _e('Permalink', 'bugis') ?></a>
					<p class="post-comments"><?php comments_popup_link( __( '0', 'bugis' ), __( '1', 'bugis' ), __( '%', 'bugis' ), 'comments-link', __( 'off', 'bugis' ) ); ?></p>
				</div><!--end post-type	-->
				
			<header class="entry-header">		
				<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'bugis' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
			</header><!--end entry-header -->
					
			<nav id="image-nav">
				<span class="next-image"><?php next_image_link( false, __( 'Next Image &rarr;' , 'bugis' ) ); ?></span>
				<span class="previous-image"><?php previous_image_link( false, __( '&larr; Previous Image' , 'bugis' ) ); ?></span>
			</nav><!-- #image-nav -->
				
			<div class="entry-content">
				<div class="entry-attachment">
					<div class="attachment">
<?php
	/**
	 * Grab the IDs of all the image attachments in a gallery so we can get the URL of the next adjacent image in a gallery,
	 * or the first image (if we're looking at the last image in a gallery), or, in a gallery of one, just the link to that image file
	 */
	$attachments = array_values( get_children( array( 'post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) ) );
	foreach ( $attachments as $k => $attachment ) {
		if ( $attachment->ID == $post->ID )
			break;
	}
	$k++;
	// If there is more than 1 attachment in a gallery
	if ( count( $attachments ) > 1 ) {
		if ( isset( $attachments[ $k ] ) )
			// get the URL of the next image attachment
			$next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
		else
			// or get the URL of the first image attachment
			$next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
	} else {
		// or, if there's only 1 image, get the URL of the image
		$next_attachment_url = wp_get_attachment_url();
	}
?>
								<a href="<?php echo $next_attachment_url; ?>" title="<?php echo esc_attr( get_the_title() ); ?>" rel="attachment"><?php
								$attachment_size = apply_filters( 'theme_attachment_size', 848 );
								echo wp_get_attachment_image( $post->ID, array( $attachment_size, 1024 ) ); // filterable image width with 1024px limit for image height.
								?></a>

								<?php if ( ! empty( $post->post_excerpt ) ) : ?>
								<div class="entry-caption">
									<?php the_excerpt(); ?>
								</div>
								<?php endif; ?>
							</div><!-- .attachment -->

						</div><!-- .entry-attachment -->
						
					</div><!-- end entry-content -->
		
	</div><!--end entry-wrap-->
	</article><!-- #post-<?php the_ID(); ?> -->
	
		<?php comments_template(); ?>
	
	</div><!--end content-->
	
<?php get_sidebar(); ?>
<?php get_footer(); ?>