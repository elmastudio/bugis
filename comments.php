<?php
/**
 * @package WordPress
 * @subpackage Bugis
 */
?>

<div id="comments">
<?php if ( post_password_required() ) : ?>
		<div class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'bugis' ); ?></div>
	</div><!-- end comments -->
<?php
		/* Stop the rest of comments.php from being processed,
		 * but don't kill the script entirely -- we still have
		 * to fully load the template.
		 */
		return;
	endif;
?>

<?php
	// You can start editing here -- including this comment!
?>
<?php if ( have_comments() ) : ?>
		<h3 id="comments-title"><?php
			printf( _n( '1 Comment', '%1$s Comments', get_comments_number(), 'bugis' ),
			number_format_i18n( get_comments_number() ));
		?></h3>	
			<ol class="commentlist">
				<?php wp_list_comments( array( 'callback' => 'bugis_comment' ) ); ?>
			</ol>
		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		
		<nav id="comment-nav-below">
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'bugis' ) ); ?></div>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'bugis' ) ); ?></div>
		</nav>
		<?php endif; // check for comment navigation ?>

	<?php else : // this is displayed if there are no comments so far ?>

		<?php if ( comments_open() ) : // If comments are open, but there are no comments ?>

		<?php else : // or, if we don't have comments:

			/* If there are no comments and comments are closed,
			 * let's leave a little note, shall we?
			 * But only on posts! We don't want the note on pages.
			 */
			if ( ! comments_open() && ! is_page() ) :
			?>
			<p class="nocomments"><?php _e( 'Comments are closed.', 'bugis' ); ?></p>
			<?php endif; // end ! comments_open() && ! is_page() ?>


		<?php endif; ?>

	<?php endif; ?>

	<?php comment_form (
	array(
		'comment_notes_before' =>__( '<p class="comment-notes">Required fields are marked <span class="required">*</span>.</p>', 'bugis'),
		'comment_notes_after' => '',
		'comment_field'  => '<p class="comment-form-comment"><label for="comment">' . _x( 'Message <span class="required">*</span>', 'noun', 'bugis' ) . 			'</label><br/><textarea id="comment" name="comment" rows="8"></textarea></p>',
		'label_submit'	=> __( 'Send', 'bugis' ))
	); ?>

</div><!-- end comments -->