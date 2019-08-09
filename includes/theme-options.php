<?php
/**
 * Bugis Theme Options
 *
 * @package WordPress
 * @subpackage Bugis
 */

/**
 * Properly enqueue styles and scripts for our theme options page.
 *
 * This function is attached to the admin_enqueue_scripts action hook.
 *
 * @param string $hook_suffix The action passes the current page to the function. We don't
 * 	do anything if we're not on our theme options page.
 */
function bugis_admin_enqueue_scripts( $hook_suffix ) {
	if ( $hook_suffix != 'appearance_page_theme_options' )
		return;

	wp_enqueue_style( 'bugis-theme-options', get_template_directory_uri() . '/includes/theme-options.css', false, '2011-04-28' );
	wp_enqueue_script( 'bugis-theme-options', get_template_directory_uri() . '/includes/theme-options.js', array( 'farbtastic' ), '2011-04-28' );
	wp_enqueue_style( 'farbtastic' );
}
add_action( 'admin_enqueue_scripts', 'bugis_admin_enqueue_scripts' );

/**
 * Register the form setting for our bugis_options array.
 *
 * This function is attached to the admin_init action hook.
 *
 * This call to register_setting() registers a validation callback, bugis_theme_options_validate(),
 * which is used when the option is saved, to ensure that our option values are complete, properly
 * formatted, and safe.
 *
 * We also use this function to add our theme option if it doesn't already exist.
 */
function bugis_theme_options_init() {

	// If we have no options in the database, let's add them now.
	if ( false === bugis_get_theme_options() )
		add_option( 'bugis_theme_options', bugis_get_default_theme_options() );

	register_setting(
		'bugis_options',       // Options group, see settings_fields() call in theme_options_render_page()
		'bugis_theme_options', // Database option, see bugis_get_theme_options()
		'bugis_theme_options_validate' // The sanitization callback, see bugis_theme_options_validate()
	);
}
add_action( 'admin_init', 'bugis_theme_options_init' );

/**
 * Add our theme options page to the admin menu.
 *
 * This function is attached to the admin_menu action hook.
 */
function bugis_theme_options_add_page() {
	add_theme_page(
		__( 'Theme Options', 'bugis' ), // Name of page
		__( 'Theme Options', 'bugis' ), // Label in menu
		'edit_theme_options',                  // Capability required
		'theme_options',                       // Menu slug, used to uniquely identify the page
		'theme_options_render_page'            // Function that renders the options page
	);
}
add_action( 'admin_menu', 'bugis_theme_options_add_page' );

/**
 * Returns an array of layout options registered for Bugis.
 */
function bugis_layouts() {
	$layout_options = array(
		'content-sidebar' => array(
			'value' => 'content-sidebar',
			'label' => __( 'Content on left', 'bugis' ),
			'thumbnail' => get_template_directory_uri() . '/includes/images/content-sidebar.png',
		),
		'sidebar-content' => array(
			'value' => 'sidebar-content',
			'label' => __( 'Content on right', 'bugis' ),
			'thumbnail' => get_template_directory_uri() . '/includes/images/sidebar-content.png',
		),
		'content' => array(
			'value' => 'content',
			'label' => __( 'One-column, no Sidebar', 'bugis' ),
			'thumbnail' => get_template_directory_uri() . '/includes/images/content.png',
		),
	);

	return apply_filters( 'bugis_layouts', $layout_options );
}

/**
 * Returns the default options for Bugis.
 */
function bugis_get_default_theme_options() {
	$default_theme_options = array(
		'link_color'   => '#DFB40B',
		'theme_layout' => 'content-sidebar',
		'custom_logo' => '',
		'custom_favicon' => '',
		'custom_apple_icon' => '',
		'custom_footertext' => '',
		'sharebtn' => '',
		'hide_submenus' => '',
		'use-slider' => '',
	);

	return apply_filters( 'bugis_default_theme_options', $default_theme_options );
}

/**
 * Returns the options array for Bugis.
 */
function bugis_get_theme_options() {
	return get_option( 'bugis_theme_options' );
}

/**
 * Returns the options array for Bugis.
 */
function theme_options_render_page() {
	?>
	<div class="wrap">
		<h2><?php printf( __( '%s Theme Options', 'bugis' ), wp_get_theme() ); ?></h2>
		<?php settings_errors(); ?>

		<form method="post" action="options.php">
			<?php
				settings_fields( 'bugis_options' );
				$options = bugis_get_theme_options();
				$default_options = bugis_get_default_theme_options();
			?>

			<table class="form-table">
			<h3 style="margin-top:30px;"><?php _e( 'Custom Color', 'bugis' ); ?></h3>
				<tr valign="top"><th scope="row"><?php _e( 'Custom Link Color', 'bugis' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Link Color', 'bugis' ); ?></span></legend>
							<input type="text" name="bugis_theme_options[link_color]" id="link-color" value="<?php echo esc_attr( $options['link_color'] ); ?>" />
							<a href="#" class="pickcolor hide-if-no-js" id="link-color-example"></a>
							<input type="button" class="pickcolor button hide-if-no-js" value="<?php esc_attr_e( 'Select a Color', 'bugis' ); ?>">
							<div id="colorPickerDiv" style="z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;"></div>
							<br />
							<small class="description"><?php printf( __( 'Default color: %s', 'bugis' ), $default_options['link_color'] ); ?></small>
						</fieldset>
					</td>
				</tr>
			</table>

			<table class="form-table">
			<h3 style="margin-top:30px;"><?php _e( 'Layout Options, Custom Logo, Custom Footer Text', 'bugis' ); ?></h3>
				<tr valign="top" class="image-radio-option"><th scope="row"><?php _e( 'Layout Options', 'bugis' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Layout Options', 'bugis' ); ?></span></legend>
						<?php
							foreach ( bugis_layouts() as $layout ) {
								?>
								<div class="layout">
								<label class="description">
									<input type="radio" name="bugis_theme_options[theme_layout]" value="<?php echo esc_attr( $layout['value'] ); ?>" <?php checked( $options['theme_layout'], $layout['value'] ); ?> />
									<span>
										<img src="<?php echo esc_url( $layout['thumbnail'] ); ?>"/>
										<?php echo $layout['label']; ?>
									</span>
								</label>
								</div>
								<?php
							}
						?>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Custom Logo Image', 'bugis' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Custom Logo image', 'bugis' ); ?></span></legend>
							<input class="regular-text" type="text" name="bugis_theme_options[custom_logo]" value="<?php esc_attr_e( $options['custom_logo'] ); ?>" />
						<label class="description" for="bugis_theme_options[custom_logo]"><br/><a href="<?php echo home_url(); ?>/wp-admin/media-new.php" target="_blank"><?php _e('Upload your own logo image', 'bugis'); ?></a> <?php _e(' using the WordPress Media Library and then insert the URL here', 'bugis'); ?></label>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Custom Footer text', 'bugis' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Custom Footer text', 'bugis' ); ?></span></legend>
							<textarea id="bugis_theme_options[custom_footertext]" class="small-text" cols="80" rows="6" name="bugis_theme_options[custom_footertext]"><?php echo esc_textarea( $options['custom_footertext'] ); ?></textarea>
						<br/><label class="description" for="bugis_theme_options[custom_footertext]"><?php _e( 'Customize the footer credit text. Standard HTML is allowed.', 'bugis' ); ?></label>
						</fieldset>
					</td>
				</tr>
			</table>

			<table class="form-table">
			<h3 style="margin-top:30px;"><?php _e( 'Share Buttons, Sub Menu Option, Responsive Slider', 'bugis' ); ?></h3>
				<tr valign="top"><th scope="row"><?php _e( 'Activate the Share Button', 'bugis' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Activate the Share Button', 'bugis' ); ?></span></legend>
							<input id="bugis_theme_options[sharebtn]" name="bugis_theme_options[sharebtn]" type="checkbox" value="1" <?php checked( '1', $options['sharebtn'] ); ?> />
							<label class="description" for="bugis_theme_options[sharebtn]"><?php _e( 'Check this box to use the Bugis Share button option in your posts.', 'bugis' ); ?></label>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Hide sub menus on mobile devices', 'bugis' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Hide sub menus on mobile devices', 'bugis' ); ?></span></legend>
							<input id="bugis_theme_options[hide_submenus]" name="bugis_theme_options[hide_submenus]" type="checkbox" value="1" <?php checked( '1', $options['hide_submenus'] ); ?> />
							<label class="description" for="bugis_theme_options[hide_submenus]"><?php _e( 'Check this box to hide the main navigation sub menus on mobile devices (tablets and smartphones). With this option your readers can focus mainly on your latest articles even if they view your site on small screens.', 'bugis' ); ?></label>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Include Responsive Slider', 'bugis' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Include Responsive Slider', 'bugis' ); ?></span></legend>
							<input id="bugis_theme_options[use-slider]" name="bugis_theme_options[use-slider]" type="checkbox" value="1" <?php checked( '1', $options['use-slider'] ); ?> />
							<label class="description" for="bugis_theme_options[use-slider]"><?php _e( 'Check this box to inlcude the Responsive Slider WordPress-Plugin at the top of your latest posts on your blogs front page.', 'bugis' ); ?></label>
						</fieldset>
					</td>
				</tr>
			</table>

			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}

/**
 * Sanitize and validate form input. Accepts an array, return a sanitized array.
 *
 */
function bugis_theme_options_validate( $input ) {
	global $layout_options;

	// Link color must be 3 or 6 hexadecimal characters
	if ( isset( $input['link_color'] ) && preg_match( '/^#?([a-f0-9]{3}){1,2}$/i', $input['link_color'] ) )
			$output['link_color'] = '#' . strtolower( ltrim( $input['link_color'], '#' ) );

	// Theme layout must be in our array of theme layout options
	if ( isset( $input['theme_layout'] ) && array_key_exists( $input['theme_layout'], bugis_layouts() ) )
		$output['theme_layout'] = $input['theme_layout'];

	// Text options must be safe text with no HTML tags
	$input['custom_logo'] = wp_filter_nohtml_kses( $input['custom_logo'] );
	$input['custom_favicon'] = wp_filter_nohtml_kses( $input['custom_favicon'] );
	$input['custom_apple_icon'] = wp_filter_nohtml_kses( $input['custom_apple_icon'] );

	// textarea option must be safe text with the allowed tags for posts
	$input['custom_footertext'] = wp_filter_post_kses( $input['custom_footertext'] );

	// checkbox value is either 0 or 1
	if ( ! isset( $input['sharebtn'] ) )
		$input['sharebtn'] = null;
	$input['sharebtn'] = ( $input['sharebtn'] == 1 ? 1 : 0 );

	if ( ! isset( $input['hide_submenus'] ) )
		$input['hide_submenus'] = null;
	$input['hide_submenus'] = ( $input['hide_submenus'] == 1 ? 1 : 0 );

	if ( ! isset( $input['use-slider'] ) )
		$input['use-slider'] = null;
	$input['use-slider'] = ( $input['use-slider'] == 1 ? 1 : 0 );

	return $input;
}

/**
 * Add a style block to the theme for the current link color.
 *
 * This function is attached to the wp_head action hook.
 */
function bugis_print_link_color_style() {
	$options = bugis_get_theme_options();
	$link_color = $options['link_color'];

	$default_options = bugis_get_default_theme_options();

	// Don't do anything if the current link color is the default.
	if ( $default_options['link_color'] == $link_color )
		return;
?>
	<style>
		/* Link color */
		a, #site-title h1 a, #secondary .textwidget a, #content .entry-header h1.entry-title a:hover, #main-nav ul ul a:hover, #content .entry-meta .cat-links a:hover, #content .entry-meta .tag-links a:hover, #content .entry-meta a.post-date:hover,#content .entry-meta a.share-btn:hover, #content .entry-meta a.like-btn:hover, #secondary a:hover, #respond a:hover, a.post-edit-link:hover, #comments .comment-header a.comment-reply-link:hover, .comment-header a.comment-time:hover, a.comment-edit-link:hover, a#cancel-comment-reply-link:hover, .widget_calendar table#wp-calendar tbody tr td a, #nav-below .nav-previous a:hover, #nav-below .nav-next a:hover, #image-nav span.previous-image a:hover, #image-nav span.next-image a:hover,#comment-nav-below .nav-next a:hover, #comment-nav-below .nav-previous a:hover, #site-generator a:hover, #content .wp-pagenavi span.current, #content .wp-pagenavi a:hover, #smart-archives-list a:hover, ul#smart-archives-block li a:hover {
			color: <?php echo $link_color; ?>;
		}
		#main-nav ul li a:hover, #content .post .entry-summery a:hover, .page-link a:hover, #content .format-link .entry-content a:hover, input#submit:hover, input.wpcf7-submit:hover, #colophon ul.menu a:hover, .jetpack_subscription_widget form#subscribe-blog input[type="submit"]:hover  {
			background:<?php echo $link_color; ?>;
		}
	</style>
<?php
}
add_action( 'wp_head', 'bugis_print_link_color_style' );

/**
 * Adds Bugis layout classes to the array of body classes.
 */
function bugis_layout_classes( $existing_classes ) {
	$options = bugis_get_theme_options();
	$current_layout = $options['theme_layout'];

	if ( in_array( $current_layout, array( 'content-sidebar', 'sidebar-content' ) ) )
		$classes = array( 'two-column' );
	else
		$classes = array( 'one-column' );

	$classes[] = $current_layout;

	$classes = apply_filters( 'bugis_layout_classes', $classes, $current_layout );

	return array_merge( $existing_classes, $classes );
}
add_filter( 'body_class', 'bugis_layout_classes' );

/*-----------------------------------------------------------------------------------*/
/* Add a style block to the theme for optimized mobile main menu.
/*
/* This function is attached to the wp_head action hook.
/*-----------------------------------------------------------------------------------*/

function bugis_print_hide_submenus_style() {
	$options = bugis_get_theme_options();
	$hide_submenus = $options['hide_submenus'];

		$default_options = bugis_get_default_theme_options();

	// Don't do anything if the current option is the default.
	if ( $default_options['hide_submenus'] == $hide_submenus )
		return;
?>
<style>
@media screen and (max-width: 1024px) {
#main-nav ul ul,
#main-nav ul ul ul,
#main-nav ul li ul li {
	display:none;
	margin:0;
}
</style>
<?php
}
add_action( 'wp_head', 'bugis_print_hide_submenus_style' );


/*-----------------------------------------------------------------------------------*/
/* Implements theme options into Theme Customizer
/*
/* @param $wp_customize Theme Customizer object
/* @return void
/*
/* @since Bugis 1.1
/*
 /*-----------------------------------------------------------------------------------*/

function bugis_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	$options  = bugis_get_theme_options();
	$defaults = bugis_get_default_theme_options();

	// Link Color (added to Color Scheme section in Theme Customizer)
	$wp_customize->add_setting( 'bugis_theme_options[link_color]', array(
		'default'           => '#DFB40B',
		'type'              => 'option',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'        => 'edit_theme_options',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'link_color', array(
		'label'    => __( 'Link Color', 'bugis' ),
		'section'  => 'colors',
		'settings' => 'bugis_theme_options[link_color]',
	) ) );

	// Default Layout
	$wp_customize->add_section( 'bugis_layout', array(
		'title'    => __( 'Layout', 'bugis' ),
		'priority' => 50,
	) );

	$wp_customize->add_setting( 'bugis_theme_options[theme_layout]', array(
		'type'              => 'option',
		'default'           => $defaults['theme_layout'],
		'sanitize_callback' => 'sanitize_key',
	) );

	$layouts = bugis_layouts();
	$choices = array();
	foreach ( $layouts as $layout ) {
		$choices[$layout['value']] = $layout['label'];
	}

	$wp_customize->add_control( 'bugis_theme_options[theme_layout]', array(
		'section'    => 'bugis_layout',
		'type'       => 'radio',
		'choices'    => $choices,
	) );
}
add_action( 'customize_register', 'bugis_customize_register' );

/**
 * Bind JS handlers to make Theme Customizer preview reload changes asynchronously.
 * Used with blogname and blogdescription.
 *
 * @since Twenty Eleven 1.3
 */
function bugis_customize_preview_js() {
	wp_enqueue_script( 'bugis-customizer', get_template_directory_uri() . '/inc/theme-customizer.js', array( 'customize-preview' ), '20120523', true );
}
add_action( 'customize_preview_init', 'bugis_customize_preview_js' );