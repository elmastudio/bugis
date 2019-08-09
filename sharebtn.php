<ul class="post-share">
	<li class="post-shortlink"><?php _e( 'Short URL', 'bugis' ); ?> <input type='text' value='<?php echo wp_get_shortlink(get_the_ID()); ?>' onclick='this.focus(); this.select();' /></li>
	<li class="post-googleplus"><div class="g-plusone" data-size="medium" data-href="<?php the_permalink(); ?>"></div></li>
	<li class="post-twitter"><a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php the_permalink(); ?>" data-text="<?php the_title(); ?>" data-count="horizontal">Tweet</a>
	<li class="post-fb"><iframe src="https://www.facebook.com/plugins/like.php?href=<?php echo urlencode(get_permalink($post->ID)); ?>&amp;layout=button_count&amp;show_faces=false&amp;width=450&amp;action=like&amp;colorscheme=light" scrolling="no" frameborder="0" allowTransparency="true"></iframe></li>
</ul><!-- end post-share -->
<a href="#" class="share-btn"><?php _e( 'Share', 'bugis' ); ?></a>
