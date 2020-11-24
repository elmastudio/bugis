<?php
/**
 * Bugis functions and definitions
 *
 * @package Bugis
 * @since Bugis 1.0
 */

/*-----------------------------------------------------------------------------------*/
/*   Make theme available for translation.
/*-----------------------------------------------------------------------------------*/
load_theme_textdomain( 'bugis', get_template_directory() . '/languages' );

/*-----------------------------------------------------------------------------------*/
/* Include Google Webfonts
/*-----------------------------------------------------------------------------------*/
function load_fonts() {
					wp_register_style('googleFonts', 'https://fonts.googleapis.com/css?family=Anton');
					wp_enqueue_style( 'googleFonts');
			 }

add_action('wp_print_styles', 'load_fonts');

/*-----------------------------------------------------------------------------------*/
/* Set the content width based on the theme's design and stylesheet.
/*-----------------------------------------------------------------------------------*/
if ( ! isset( $content_width ) )
	$content_width = 660; /* pixels */

/*-----------------------------------------------------------------------------------*/
/*  Tell WordPress to run bugis() when the 'after_setup_theme' hook is run.
/*-----------------------------------------------------------------------------------*/
add_action( 'after_setup_theme', 'bugis' );

if ( ! function_exists( 'bugis' ) ):

/*-----------------------------------------------------------------------------------*/
/*   Create Bugis Theme Options Page
/*-----------------------------------------------------------------------------------*/
require( get_template_directory() . '/includes/theme-options.php' );

/*-----------------------------------------------------------------------------------*/
/*  Call JavaScript Scripts for Bugis (Fitvids for elasic videos and Custom)
/*-----------------------------------------------------------------------------------*/

add_action('wp_enqueue_scripts','bugis_scripts_function');
	function bugis_scripts_function() {
		wp_enqueue_script( 'fitvids', get_template_directory_uri() . '/js/jquery.fitvids.js', false, '1.1');
		wp_enqueue_script( 'custom', get_template_directory_uri() . '/js/custom.js', false, '1.0');
}

/*-----------------------------------------------------------------------------------*/
/*   Sets up theme defaults and registers support for WordPress features.
/*-----------------------------------------------------------------------------------*/
function bugis() {

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Let WordPress manage the document title.
	add_theme_support( 'title-tag' );

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'bugis' ),
		'footer' => __( 'Footer Navigation', 'bugis' )
	) );

	// Add support for Post Formats
	add_theme_support( 'post-formats', array( 'aside', 'status', 'link', 'quote', 'chat', 'image', 'gallery', 'video', 'audio' ) );

	// This theme allows users to set a custom background.
	add_theme_support( 'custom-background', apply_filters( 'bugis_custom_background_args', array(
		'default-color' => 'EFEFE4',
	) ) );
}
endif;

/*-----------------------------------------------------------------------------------*/
/* Get wp_nav_menu() fallback, wp_page_menu(), to show a home link.
/*-----------------------------------------------------------------------------------*/
function bugis_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'bugis_page_menu_args' );

/*-----------------------------------------------------------------------------------*/
/*  Sets the post excerpt length to 40 characters.
/*-----------------------------------------------------------------------------------*/
function bugis_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'bugis_excerpt_length' );

/*-----------------------------------------------------------------------------------*/
/*  Returns a "Continue Reading" link for excerpts
/*-----------------------------------------------------------------------------------*/
function bugis_continue_reading_link() {
	return ' <a href="'. get_permalink() . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'bugis' ) . '</a>';
}

/*-----------------------------------------------------------------------------------*/
/*  Replaces "[...]" with an ellipsis and bugis_continue_reading_link() in excerpts.
/*-----------------------------------------------------------------------------------*/
function bugis_auto_excerpt_more( $more ) {
	return ' &hellip;' . bugis_continue_reading_link();
}
add_filter( 'excerpt_more', 'bugis_auto_excerpt_more' );

/*-----------------------------------------------------------------------------------*/
/*  Adds a pretty "Continue Reading" link to custom post excerpts.
/*-----------------------------------------------------------------------------------*/
function bugis_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= bugis_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'bugis_custom_excerpt_more' );

/*-----------------------------------------------------------------------------------*/
/*  Remove inline styles printed when the gallery shortcode is used.
/*-----------------------------------------------------------------------------------*/
function bugis_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
add_filter( 'gallery_style', 'bugis_remove_gallery_css' );

if ( ! function_exists( 'bugis_comment' ) ) :


/*-----------------------------------------------------------------------------------*/
/* Template for comments and pingbacks.
/*-----------------------------------------------------------------------------------*/
function bugis_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'comment' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<?php echo get_avatar( $comment, 40 ); ?>

			<div class="comment-header">
				<?php printf( __( '%s', 'bugis' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
				<a class="comment-time" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
				<?php
					/* translators: 1: date, 2: time */
					printf( __( '%1$s at %2$s', 'bugis' ),
					get_comment_date(),
					get_comment_time() );
				?></a>
				<?php edit_comment_link( __( '| Edit &rarr;', 'bugis' ), ' ' );?>
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'bugis' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- end comment-header -->

			<div class="comment-content">
				<?php comment_text(); ?>
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'bugis' ); ?></p>
				<?php endif; ?>
			</div><!-- end comment-content -->
		</article><!-- end comment -->

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'bugis' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('| Edit &rarr;', 'bugis'), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
endif;

/*-----------------------------------------------------------------------------------*/
/* Register widgetized area and update sidebar with default widgets
/*-----------------------------------------------------------------------------------*/
function bugis_widgets_init() {

	register_sidebar( array (
		'name' => __( 'Main Sidebar', 'bugis' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

}
add_action( 'init', 'bugis_widgets_init' );

/*-----------------------------------------------------------------------------------*/
/*  Customize the Bugis search form
/*-----------------------------------------------------------------------------------*/
function bugis_search_form( $form ) {

		$form = '	<form method="get" id="searchform" action="'.home_url('url').'">
			<input type="text" class="field" name="s" id="s"  placeholder="'. esc_attr__('Search', 'bugis') .'" />
			<input type="submit" class="submit" name="submit" id="searchsubmit" value="'. esc_attr__('Search', 'bugis') .'" />
	</form>';

		return $form;
}
add_filter( 'get_search_form', 'bugis_search_form' );

/*-----------------------------------------------------------------------------------*/
/*  Removes the default CSS style from the WP image gallery
/*-----------------------------------------------------------------------------------*/
add_filter('gallery_style', create_function('$a', 'return "
<div class=\'gallery\'>";'));


/*-----------------------------------------------------------------------------------*/
/* Add One Click Demo Import code.
/*-----------------------------------------------------------------------------------*/
require get_template_directory() . '/includes/demo-installer.php';


/*-----------------------------------------------------------------------------------*/
/*  Bugis Shortcodes
/*-----------------------------------------------------------------------------------*/

 // Enable shortcodes in widget areas
add_filter( 'widget_text', 'do_shortcode' );

// Replace WP autop formatting
if (!function_exists( "bugis_remove_wpautop")) {
	function bugis_remove_wpautop($content) {
		$content = do_shortcode( shortcode_unautop( $content ) );
		$content = preg_replace( '#^<\/p>|^<br \/>|<p>$#', '', $content);
		return $content;
	}
}

// Columns Shortcodes
// Don't forget to add "_last" behind the shortcode if it is the last column.

// Two Columns
function bugis_shortcode_two_columns_one( $atts, $content = null ) {
	 return '<div class="two-columns-one">' . bugis_remove_wpautop($content) . '</div>';
}
add_shortcode( 'two_columns_one', 'bugis_shortcode_two_columns_one' );

function bugis_shortcode_two_columns_one_last( $atts, $content = null ) {
	 return '<div class="two-columns-one last">' . bugis_remove_wpautop($content) . '</div>';
}
add_shortcode( 'two_columns_one_last', 'bugis_shortcode_two_columns_one_last' );

// Three Columns
function bugis_shortcode_three_columns_one($atts, $content = null) {
	 return '<div class="three-columns-one">' . bugis_remove_wpautop($content) . '</div>';
}
add_shortcode( 'three_columns_one', 'bugis_shortcode_three_columns_one' );

function bugis_shortcode_three_columns_one_last($atts, $content = null) {
	 return '<div class="three-columns-one last">' . bugis_remove_wpautop($content) . '</div>';
}
add_shortcode( 'three_columns_one_last', 'bugis_shortcode_three_columns_one_last' );

function bugis_shortcode_three_columns_two($atts, $content = null) {
	 return '<div class="three-columns-two">' . bugis_remove_wpautop($content) . '</div>';
}
add_shortcode( 'three_columns_two', 'bugis_shortcode_three_columns' );

function bugis_shortcode_three_columns_two_last($atts, $content = null) {
	 return '<div class="three-columns-two last">' . bugis_remove_wpautop($content) . '</div>';
}
add_shortcode( 'three_columns_two_last', 'bugis_shortcode_three_columns_two_last' );

// Four Columns
function bugis_shortcode_four_columns_one($atts, $content = null) {
	 return '<div class="four-columns-one">' . bugis_remove_wpautop($content) . '</div>';
}
add_shortcode( 'four_columns_one', 'bugis_shortcode_four_columns_one' );

function bugis_shortcode_four_columns_one_last($atts, $content = null) {
	 return '<div class="four-columns-one last">' . bugis_remove_wpautop($content) . '</div>';
}
add_shortcode( 'four_columns_one_last', 'bugis_shortcode_four_columns_one_last' );

function bugis_shortcode_four_columns_two($atts, $content = null) {
	 return '<div class="four-columns-two">' . bugis_remove_wpautop($content) . '</div>';
}
add_shortcode( 'four_columns_two', 'bugis_shortcode_four_columns_two' );

function bugis_shortcode_four_columns_two_last($atts, $content = null) {
	 return '<div class="four-columns-two last">' . bugis_remove_wpautop($content) . '</div>';
}
add_shortcode( 'four_columns_two_last', 'bugis_shortcode_four_columns_two_last' );

function bugis_shortcode_four_columns_three($atts, $content = null) {
	 return '<div class="four-columns-three">' . bugis_remove_wpautop($content) . '</div>';
}
add_shortcode( 'four_columns_three', 'bugis_shortcode_four_columns_three' );

function bugis_shortcode_four_columns_three_last($atts, $content = null) {
	 return '<div class="four-columns-three last">' . bugis_remove_wpautop($content) . '</div>';
}
add_shortcode( 'four_columns_three_last', 'bugis_shortcode_four_columns_three_last' );

// Divide Text Shortcode
function bugis_shortcode_divider($atts, $content = null) {
	 return '<div class="divider"></div>';
}
add_shortcode( 'divider', 'bugis_shortcode_divider' );

//Text Highlight and Info Boxes Shortcodes
function bugis_shortcode_highlight($atts, $content = null) {
	 return '<span class="highlight">' . do_shortcode( bugis_remove_wpautop($content) ) . '</span>';
}
add_shortcode( 'highlight', 'bugis_shortcode_highlight' );

function bugis_shortcode_white_box($atts, $content = null) {
	 return '<div class="white-box">' . do_shortcode( bugis_remove_wpautop($content) ) . '</div>';
}
add_shortcode( 'white_box', 'bugis_shortcode_white_box' );

function bugis_shortcode_yellow_box($atts, $content = null) {
	 return '<div class="yellow-box">' . do_shortcode( bugis_remove_wpautop($content) ) . '</div>';
}
add_shortcode( 'yellow_box', 'bugis_shortcode_yellow_box' );

function bugis_shortcode_red_box($atts, $content = null) {
	 return '<div class="red-box">' . do_shortcode( bugis_remove_wpautop($content) ) . '</div>';
}
add_shortcode( 'red_box', 'bugis_shortcode_red_box' );

function bugis_shortcode_blue_box($atts, $content = null) {
	 return '<div class="blue-box">' . do_shortcode( bugis_remove_wpautop($content) ) . '</div>';
}
add_shortcode( 'blue_box', 'bugis_shortcode_blue_box' );

function bugis_shortcode_green_box($atts, $content = null) {
	 return '<div class="green-box">' . do_shortcode( bugis_remove_wpautop($content) ) . '</div>';
}
add_shortcode( 'green_box', 'bugis_shortcode_green_box' );

//Button Shortcode
function bugis_button( $atts, $content = null ) {
		extract(shortcode_atts(array(
		'link'	=> '#',
		'target'	=> '',
		'color'	=> '',
		'size'	=> '',
		'align'	=> '',
		), $atts));

	$style = ($color) ? ' '.$color. '-btncolor' : '';
	$align = ($align) ? ' align'.$align : '';
	$size = ($size == 'large') ? ' large-button' : '';
	$target = ($target == 'blank') ? ' target="_blank"' : '';

	$out = '<a' .$target. ' class="button-link' .$style.$size.$align. '" href="' .$link. '"><span>' .do_shortcode($content). '</span></a>';

		return $out;
}
add_shortcode('button', 'bugis_button');

/*-----------------------------------------------------------------------------------*/
/*  Deactives the default CSS styles for the Smart Archives Reloaded plugin
/*-----------------------------------------------------------------------------------*/
add_filter('smart_archives_load_default_styles', '__return_false');

/*-----------------------------------------------------------------------------------*/
/*  Custom Bugis Flickr Widget
/*-----------------------------------------------------------------------------------*/
class bugis_flickr extends WP_Widget {

	public function __construct() {
		parent::__construct( 'bugis_flickr', __( 'Flickr Widget (Bugis)', 'bugis' ), array(
			'classname'   => 'widget_bugis_flickr',
			'description' => __( 'Show preview images from a flickr account or group.', 'bugis' ),
		) );
	}

	function widget($args, $instance) {
		extract( $args );
		$title = $instance['title'];
		$id = $instance['id'];
		$number = $instance['number'];
		$type = $instance['type'];
		$sorting = $instance['sorting'];

		echo $before_widget; ?>
		<?php if($title != '')
			echo '<h3 class="widget-title">'.$title.'</h3>'; ?>

				<div class="flickr_badge_wrapper"><script type="text/javascript" src="https://www.flickr.com/badge_code_v2.gne?count=<?php echo $number; ?>&amp;display=<?php echo $sorting; ?>&amp;&amp;source=<?php echo $type; ?>&amp;<?php echo $type; ?>=<?php echo $id; ?>&amp;size=s"></script><div class="clear"></div></div>

		 <?php
		 echo $after_widget;
	 }

	 function update($new_instance, $old_instance) {
			 return $new_instance;
	 }

	 function form($instance) {
		$title = esc_attr($instance['title']);
		$id = esc_attr($instance['id']);
		$number = esc_attr($instance['number']);
		$type = esc_attr($instance['type']);
		$sorting = esc_attr($instance['sorting']);
		?>

		 <p>
						<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','bugis'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
				</p>
				<p>
						<label for="<?php echo $this->get_field_id('id'); ?>"><?php _e('Flickr ID (<a href="http://www.idgettr.com" target="_blank">idGettr</a>):','bugis'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('id'); ?>" value="<?php echo $id; ?>" class="widefat" id="<?php echo $this->get_field_id('id'); ?>" />
				</p>
				 <p>
						<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of photos:','bugis'); ?></label>
						<select name="<?php echo $this->get_field_name('number'); ?>" class="widefat" id="<?php echo $this->get_field_id('number'); ?>">
								<?php for ( $i = 1; $i <= 10; $i += 1) { ?>
								<option value="<?php echo $i; ?>" <?php if($number == $i){ echo "selected='selected'";} ?>><?php echo $i; ?></option>
								<?php } ?>
						</select>
				</p>
				<p>
						<label for="<?php echo $this->get_field_id('type'); ?>"><?php _e('Choose user or group:','bugis'); ?></label>
						<select name="<?php echo $this->get_field_name('type'); ?>" class="widefat" id="<?php echo $this->get_field_id('type'); ?>">
								<option value="user" <?php if($type == "user"){ echo "selected='selected'";} ?>><?php _e('User', 'bugis'); ?></option>
								<option value="group" <?php if($type == "group"){ echo "selected='selected'";} ?>><?php _e('Group', 'bugis'); ?></option>
						</select>
				</p>
				<p>
						<label for="<?php echo $this->get_field_id('sorting'); ?>"><?php _e('Show latest or random pictures:','bugis'); ?></label>
						<select name="<?php echo $this->get_field_name('sorting'); ?>" class="widefat" id="<?php echo $this->get_field_id('sorting'); ?>">
								<option value="latest" <?php if($sorting == "latest"){ echo "selected='selected'";} ?>><?php _e('Latest', 'bugis'); ?></option>
								<option value="random" <?php if($sorting == "random"){ echo "selected='selected'";} ?>><?php _e('Random', 'bugis'); ?></option>
						</select>
				</p>
		<?php
	}
}

register_widget('bugis_flickr');

/*-----------------------------------------------------------------------------------*/
/*  Custom Bugis Social Links Widget
/*-----------------------------------------------------------------------------------*/
 class bugis_sociallinks extends WP_Widget {

	public function __construct() {
		parent::__construct( 'bugis_sociallinks', __( 'Social Links Widget (Bugis)', 'bugis' ), array(
			'classname'   => 'widget_bugis_sociallinks',
			'description' => __( 'Link to your social profiles.', 'bugis' ),
		) );
	}

	function widget($args, $instance) {
		extract( $args );
		$title = $instance['title'];
		$behance = $instance['behance'];
		$delicious = $instance['delicious'];
		$deviantart = $instance['deviantart'];
		$digg = $instance['digg'];
		$dribbble = $instance['dribbble'];
		$ember = $instance['ember'];
		$facebook = $instance['facebook'];
		$ffffound = $instance['ffffound'];
		$pinterest = $instance['pinterest'];
		$fivehundredpx = $instance['fivehundredpx'];
		$flickr = $instance['flickr'];
		$instagram = $instance['instagram'];
		$foursquare = $instance['foursquare'];
		$googleplus = $instance['googleplus'];
		$gowalla = $instance['gowalla'];
		$grooveshark = $instance['grooveshark'];
		$lastfm = $instance['lastfm'];
		$soundcloud = $instance['soundcloud'];
		$linkedin = $instance['linkedin'];
		$picasa = $instance['picasa'];
		$slideshare = $instance['slideshare'];
		$squidoo = $instance['squidoo'];
		$tumblr = $instance['tumblr'];
		$twitter = $instance['twitter'];
		$vimeo = $instance['vimeo'];
		$wordpress = $instance['wordpress'];
		$github = $instance['github'];
		$xing = $instance['xing'];
		$youtube = $instance['youtube'];
		$zootool = $instance['zootool'];
		$rss = $instance['rss'];
		$rsscomments = $instance['rsscomments'];

		echo $before_widget; ?>
		<?php if($title != '')
			echo '<h3 class="widget-title">'.$title.'</h3>'; ?>

				<ul class="social-links">
			<?php
			if($behance != '' ){
				echo '<li><a href="'.$behance.'" class="behance" title="Behance Network">Behance</a></li>';
			}
			?>
			<?php if($delicious != ''){
				echo '<li><a href="'.$delicious.'" class="delicious" title="Delicious">Delicious</a></li>';
			}
			?>
			<?php if($deviantart != ''){
				echo '<li><a href="'.$deviantart.'" class="deviantart" title="deviantART">deviantART</a></li>';
			}
			?>
			<?php if($digg != ''){
				echo '<li><a href="'.$digg.'" class="digg" title="Digg">Digg</a></li>';
			}
			?>
			<?php if($dribbble != ''){
				echo '<li><a href="'.$dribbble.'" class="dribbble" title="Dribbble">Dribbble</a></li>';
			}
			?>
			<?php if($ember != ''){
				echo '<li><a href="'.$ember.'" class="ember" title="Ember">Ember</a></li>';
			}
			?>
			<?php
			if($facebook != ''){
				echo '<li><a href="'.$facebook.'" class="facebook" title="Facebook">Facebook</a></li>';
			}
			?>
			<?php if($ffffound != ''){
				echo '<li><a href="'.$ffffound.'" class="ffffound" title="Ffffound">Ffffound</a></li>';
			}
			?>
			<?php if($fivehundredpx != ''){
				echo '<li><a href="'.$fivehundredpx.'" class="fivehundredpx" title="500px">500px</a></li>';
			}
			?>
			<?php if($pinterest != ''){
				echo '<li><a href="'.$pinterest.'" class="pinterest" title="Pinterest">Pinterest</a></li>';
			}
			?>
			<?php if($flickr != ''){
				echo '<li><a href="'.$flickr.'" class="flickr" title="Flickr">Flickr</a></li>';
			}
			?>
			<?php if($instagram != ''){
				echo '<li><a href="'.$instagram.'" class="instagram" title="Instagram">Instagram</a></li>';
			}
			?>
			<?php if($foursquare != ''){
				echo '<li><a href="'.$foursquare.'" class="foursquare" title="Foursquare">Foursquare</a></li>';
			}
			?>
			<?php
			if($googleplus != ''){
				echo '<li><a href="'.$googleplus.'" class="googleplus" title="Google+">Google+</a></li>';
			}
			?>
			<?php if($gowalla != ''){
				echo '<li><a href="'.$gowalla.'" class="gowalla" title="Gowalla">Gowalla</a></li>';
			}
			?>
			<?php if($grooveshark != ''){
				echo '<li><a href="'.$grooveshark.'" class="grooveshark" title="Grooveshark">Grooveshark</a></li>';
			}
			?>
			<?php if($lastfm != ''){

				echo '<li><a href="'.$lastfm.'" class="lastfm" title="Lastfm">Lastfm</a></li>';
			}
			?>
			<?php if($soundcloud != ''){
				echo '<li><a href="'.$soundcloud.'" class="soundcloud" title="Soundcloud">Soundcloud</a></li>';
			}
			?>
			<?php if($linkedin != ''){
				echo '<li><a href="'.$linkedin.'" class="linkedin" title="LinkedIn">LinkedIn</a></li>';
			}
			?>
			<?php if($picasa != ''){
				echo '<li><a href="'.$picasa.'" class="picasa" title="Picasa">Picasa</a></li>';
			}
			?>
			<?php if($slideshare != ''){
				echo '<li><a href="'.$slideshare.'" class="slideshare" title="Slideshare">Slideshare</a></li>';
			}
			?>
			<?php if($squidoo != ''){
				echo '<li><a href="'.$squidoo.'" class="squidoo" title="Squidoo">Squidoo</a></li>';
			}
			?>
			<?php if($tumblr != ''){
				echo '<li><a href="'.$tumblr.'" class="tumblr" title="Tumblr">Tumblr</a></li>';
			}
			?>
			<?php
			if($twitter != ''){
				echo '<li><a href="'.$twitter.'" class="twitter" title="Twitter">Twitter</a></li>';
			}
			?>
			<?php if($vimeo != ''){
				echo '<li><a href="'.$vimeo.'" class="vimeo" title="Vimeo">Vimeo</a></li>';
			}
			?>
			<?php if($wordpress != ''){
				echo '<li><a href="'.$wordpress.'" class="wordpress" title="WordPress">WordPress</a></li>';
			}
			?>
			<?php if($github != ''){
				echo '<li><a href="'.$github.'" class="github" title="GitHub">GitHub</a></li>';
			}
			?>
			<?php if($xing != ''){
				echo '<li><a href="'.$xing.'" class="xing" title="Xing">Xing</a></li>';
			}
			?>
			<?php if($youtube != ''){
				echo '<li><a href="'.$youtube.'" class="youtube" title="YouTube">YouTube</a></li>';
			}
			?>
			<?php if($zootool != ''){
				echo '<li><a href="'.$zootool.'" class="zootool" title="Zootool">Zootool</a></li>';
			}
			?>
			<?php if($rss != ''){
				echo '<li><a href="'.$rss.'" class="rss" title="RSS Feed">RSS Feed</a></li>';
			}
			?>
			<?php if($rsscomments != ''){
				echo '<li><a href="'.$rsscomments.'" class="rsscomments" title="RSS Comments">RSS Comments</a></li>';
			}
			?>
		</ul>

		 <?php
		 echo $after_widget;
	 }

	 function update($new_instance, $old_instance) {
			 return $new_instance;
	 }

	 function form($instance) {
		$title = esc_attr($instance['title']);
		$behance = esc_attr($instance['behance']);
		$delicious = esc_attr($instance['delicious']);
		$deviantart = esc_attr($instance['deviantart']);
		$digg = esc_attr($instance['digg']);
		$dribbble = esc_attr($instance['dribbble']);
		$ember = esc_attr($instance['ember']);
		$facebook = esc_attr($instance['facebook']);
		$ffffound = esc_attr($instance['ffffound']);
		$pinterest = esc_attr($instance['pinterest']);
		$fivehundredpx = esc_attr($instance['fivehundredpx']);
		$flickr = esc_attr($instance['flickr']);
		$instagram = esc_attr($instance['instagram']);
		$foursquare = esc_attr($instance['foursquare']);
		$googleplus = esc_attr($instance['googleplus']);
		$gowalla = esc_attr($instance['gowalla']);
		$grooveshark = esc_attr($instance['grooveshark']);
		$lastfm = esc_attr($instance['lastfm']);
		$soundcloud = esc_attr($instance['soundcloud']);
		$linkedin = esc_attr($instance['linkedin']);
		$picasa = esc_attr($instance['picasa']);
		$slideshare = esc_attr($instance['slideshare']);
		$squidoo = esc_attr($instance['squidoo']);
		$tumblr = esc_attr($instance['tumblr']);
		$twitter = esc_attr($instance['twitter']);
		$vimeo = esc_attr($instance['vimeo']);
		$wordpress = esc_attr($instance['wordpress']);
		$github = esc_attr($instance['github']);
		$xing = esc_attr($instance['xing']);
		$youtube = esc_attr($instance['youtube']);
		$zootool = esc_attr($instance['zootool']);
		$rss = esc_attr($instance['rss']);
		$rsscomments = esc_attr($instance['rsscomments']);
		?>

		 <p>
						<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','bugis'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
				</p>
				<p>
						<label for="<?php echo $this->get_field_id('behance'); ?>"><?php _e('Behance Network URL:','bugis'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('behance'); ?>" value="<?php echo $behance; ?>" class="widefat" id="<?php echo $this->get_field_id('behance'); ?>" />
				</p>

		 <p>
						<label for="<?php echo $this->get_field_id('delicious'); ?>"><?php _e('Delicious URL:','bugis'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('delicious'); ?>" value="<?php echo $delicious; ?>" class="widefat" id="<?php echo $this->get_field_id('delicious'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('deviantart'); ?>"><?php _e('deviantART URL:','bugis'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('deviantart'); ?>" value="<?php echo $deviantart; ?>" class="widefat" id="<?php echo $this->get_field_id('deviantart'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('digg'); ?>"><?php _e('Digg URL:','bugis'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('digg'); ?>" value="<?php echo $digg; ?>" class="widefat" id="<?php echo $this->get_field_id('digg'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('dribbble'); ?>"><?php _e('Dribbble URL:','bugis'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('dribbble'); ?>" value="<?php echo $dribbble; ?>" class="widefat" id="<?php echo $this->get_field_id('dribbble'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('ember'); ?>"><?php _e('Ember URL:','bugis'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('ember'); ?>" value="<?php echo $ember; ?>" class="widefat" id="<?php echo $this->get_field_id('ember'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('facebook'); ?>"><?php _e('Facebook URL:','bugis'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('facebook'); ?>" value="<?php echo $facebook; ?>" class="widefat" id="<?php echo $this->get_field_id('facebook'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('ffffound'); ?>"><?php _e('Ffffound URL:','bugis'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('ffffound'); ?>" value="<?php echo $ffffound; ?>" class="widefat" id="<?php echo $this->get_field_id('ffffound'); ?>" />
				</p>

			<p>
						<label for="<?php echo $this->get_field_id('pinterest'); ?>"><?php _e('Pinterest URL:','bugis'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('pinterest'); ?>" value="<?php echo $pinterest; ?>" class="widefat" id="<?php echo $this->get_field_id('pinterest'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('fivehundredpx'); ?>"><?php _e('500px URL:','bugis'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('fivehundredpx'); ?>" value="<?php echo $fivehundredpx; ?>" class="widefat" id="<?php echo $this->get_field_id('fivehundredpx'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('flickr'); ?>"><?php _e('Flickr URL:','bugis'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('flickr'); ?>" value="<?php echo $flickr; ?>" class="widefat" id="<?php echo $this->get_field_id('flickr'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('instagram'); ?>"><?php _e('Instagram URL (e.g. via Instagrid.me):','bugis'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('instagram'); ?>" value="<?php echo $instagram; ?>" class="widefat" id="<?php echo $this->get_field_id('instagram'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('foursquare'); ?>"><?php _e('Foursquare URL:','bugis'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('foursquare'); ?>" value="<?php echo $foursquare; ?>" class="widefat" id="<?php echo $this->get_field_id('foursquare'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('googleplus'); ?>"><?php _e('Google+ URL:','bugis'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('googleplus'); ?>" value="<?php echo $googleplus; ?>" class="widefat" id="<?php echo $this->get_field_id('googleplus'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('gowalla'); ?>"><?php _e('Gowalla URL:','bugis'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('gowalla'); ?>" value="<?php echo $gowalla; ?>" class="widefat" id="<?php echo $this->get_field_id('gowalla'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('grooveshark'); ?>"><?php _e('Grooveshark URL:','bugis'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('grooveshark'); ?>" value="<?php echo $grooveshark; ?>" class="widefat" id="<?php echo $this->get_field_id('grooveshark'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('lastfm'); ?>"><?php _e('Last.fm URL:','bugis'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('lastfm'); ?>" value="<?php echo $lastfm; ?>" class="widefat" id="<?php echo $this->get_field_id('lastfm'); ?>" />
				</p>

			<p>
						<label for="<?php echo $this->get_field_id('soundcloud'); ?>"><?php _e('Soundcloud URL:','bugis'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('soundcloud'); ?>" value="<?php echo $soundcloud; ?>" class="widefat" id="<?php echo $this->get_field_id('soundcloud'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('linkedin'); ?>"><?php _e('Linkedin URL:','bugis'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('linkedin'); ?>" value="<?php echo $linkedin; ?>" class="widefat" id="<?php echo $this->get_field_id('linkedin'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('picasa'); ?>"><?php _e('Picasa URL:','bugis'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('picasa'); ?>" value="<?php echo $picasa; ?>" class="widefat" id="<?php echo $this->get_field_id('picasa'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('slideshare'); ?>"><?php _e('Slideshare URL:','bugis'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('slideshare'); ?>" value="<?php echo $slideshare; ?>" class="widefat" id="<?php echo $this->get_field_id('slideshare'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('squidoo'); ?>"><?php _e('Squidoo URL:','bugis'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('squidoo'); ?>" value="<?php echo $squidoo; ?>" class="widefat" id="<?php echo $this->get_field_id('squidoo'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('tumblr'); ?>"><?php _e('Tumblr URL:','bugis'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('tumblr'); ?>" value="<?php echo $tumblr; ?>" class="widefat" id="<?php echo $this->get_field_id('tumblr'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('twitter'); ?>"><?php _e('Twitter URL:','bugis'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('twitter'); ?>" value="<?php echo $twitter; ?>" class="widefat" id="<?php echo $this->get_field_id('twitter'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('vimeo'); ?>"><?php _e('Vimeo URL:','bugis'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('vimeo'); ?>" value="<?php echo $vimeo; ?>" class="widefat" id="<?php echo $this->get_field_id('vimeo'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('wordpress'); ?>"><?php _e('WordPress URL:','bugis'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('wordpress'); ?>" value="<?php echo $wordpress; ?>" class="widefat" id="<?php echo $this->get_field_id('wordpress'); ?>" />
				</p>

			<p>
						<label for="<?php echo $this->get_field_id('github'); ?>"><?php _e('GitHub URL:','bugis'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('github'); ?>" value="<?php echo $github; ?>" class="widefat" id="<?php echo $this->get_field_id('github'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('xing'); ?>"><?php _e('Xing URL:','bugis'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('xing'); ?>" value="<?php echo $xing; ?>" class="widefat" id="<?php echo $this->get_field_id('xing'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('youtube'); ?>"><?php _e('YouTube URL:','bugis'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('youtube'); ?>" value="<?php echo $youtube; ?>" class="widefat" id="<?php echo $this->get_field_id('youtube'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('zootool'); ?>"><?php _e('Zootool URL:','bugis'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('zootool'); ?>" value="<?php echo $zootool; ?>" class="widefat" id="<?php echo $this->get_field_id('zootool'); ?>" />
				</p>
		 <p>
						<label for="<?php echo $this->get_field_id('rss'); ?>"><?php _e('RSS-Feed URL:','bugis'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('rss'); ?>" value="<?php echo $rss; ?>" class="widefat" id="<?php echo $this->get_field_id('rss'); ?>" />
				</p>

		<p>
						<label for="<?php echo $this->get_field_id('rsscomments'); ?>"><?php _e('RSS for Comments URL:','bugis'); ?></label>
						<input type="text" name="<?php echo $this->get_field_name('rsscomments'); ?>" value="<?php echo $rsscomments; ?>" class="widefat" id="<?php echo $this->get_field_id('rsscomments'); ?>" />
				</p>

		<?php
	}
}

register_widget('bugis_sociallinks');
