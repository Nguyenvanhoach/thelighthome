<?php
/**
 * Twenty Twenty functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

/**
 * Table of Contents:
 * Theme Support
 * Required Files
 * Register Styles
 * Register Scripts
 * Register Menus
 * Custom Logo
 * WP Body Open
 * Register Sidebars
 * Enqueue Block Editor Assets
 * Enqueue Classic Editor Styles
 * Block Editor Settings
 */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @since Twenty Twenty 1.0
 */
function twentytwenty_theme_support() {

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Custom background color.
	add_theme_support(
		'custom-background',
		array(
			'default-color' => 'f5efe0',
		)
	);

	// Set content-width.
	global $content_width;
	if ( ! isset( $content_width ) ) {
		$content_width = 580;
	}

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// Set post thumbnail size.
	set_post_thumbnail_size( 1200, 9999 );

	// Add custom image size used in Cover Template.
	add_image_size( 'twentytwenty-fullscreen', 1980, 9999 );

	// Custom logo.
	$logo_width  = 120;
	$logo_height = 90;

	// If the retina setting is active, double the recommended width and height.
	if ( get_theme_mod( 'retina_logo', false ) ) {
		$logo_width  = floor( $logo_width * 2 );
		$logo_height = floor( $logo_height * 2 );
	}

	add_theme_support(
		'custom-logo',
		array(
			'height'      => $logo_height,
			'width'       => $logo_width,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'script',
			'style',
			'navigation-widgets',
		)
	);

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Twenty Twenty, use a find and replace
	 * to change 'twentytwenty' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'twentytwenty' );

	// Add support for full and wide align images.
	add_theme_support( 'align-wide' );

	// Add support for responsive embeds.
	add_theme_support( 'responsive-embeds' );

	/*
	 * Adds starter content to highlight the theme on fresh sites.
	 * This is done conditionally to avoid loading the starter content on every
	 * page load, as it is a one-off operation only needed once in the customizer.
	 */
	if ( is_customize_preview() ) {
		require get_template_directory() . '/inc/starter-content.php';
		add_theme_support( 'starter-content', twentytwenty_get_starter_content() );
	}

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/*
	 * Adds `async` and `defer` support for scripts registered or enqueued
	 * by the theme.
	 */
	$loader = new TwentyTwenty_Script_Loader();
	add_filter( 'script_loader_tag', array( $loader, 'filter_script_loader_tag' ), 10, 2 );

}

add_action( 'after_setup_theme', 'twentytwenty_theme_support' );

/**
 * REQUIRED FILES
 * Include required files.
 */
require get_template_directory() . '/inc/template-tags.php';

// Handle SVG icons.
require get_template_directory() . '/classes/class-twentytwenty-svg-icons.php';
require get_template_directory() . '/inc/svg-icons.php';

// Handle Customizer settings.
require get_template_directory() . '/classes/class-twentytwenty-customize.php';

// Require Separator Control class.
require get_template_directory() . '/classes/class-twentytwenty-separator-control.php';

// Custom comment walker.
require get_template_directory() . '/classes/class-twentytwenty-walker-comment.php';

// Custom page walker.
require get_template_directory() . '/classes/class-twentytwenty-walker-page.php';

// Custom script loader class.
require get_template_directory() . '/classes/class-twentytwenty-script-loader.php';

// Non-latin language handling.
require get_template_directory() . '/classes/class-twentytwenty-non-latin-languages.php';

// Custom CSS.
require get_template_directory() . '/inc/custom-css.php';

// Block Patterns.
require get_template_directory() . '/inc/block-patterns.php';

/**
 * Register and Enqueue Styles.
 *
 * @since Twenty Twenty 1.0
 */
function twentytwenty_register_styles() {

	$theme_version = wp_get_theme()->get( 'Version' );

	wp_enqueue_style( 'twentytwenty-style', get_stylesheet_uri(), array(), $theme_version );
	wp_style_add_data( 'twentytwenty-style', 'rtl', 'replace' );

	// Add output of Customizer settings as inline style.
	wp_add_inline_style( 'twentytwenty-style', twentytwenty_get_customizer_css( 'front-end' ) );

	// Add print CSS.
	wp_enqueue_style( 'twentytwenty-print-style', get_template_directory_uri() . '/print.css', null, $theme_version, 'print' );

}

add_action( 'wp_enqueue_scripts', 'twentytwenty_register_styles' );

/**
 * Register and Enqueue Scripts.
 *
 * @since Twenty Twenty 1.0
 */
function twentytwenty_register_scripts() {

	$theme_version = wp_get_theme()->get( 'Version' );

	if ( ( ! is_admin() ) && is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'twentytwenty-js', get_template_directory_uri() . '/assets/js/index.js', array(), $theme_version, false );
	wp_script_add_data( 'twentytwenty-js', 'async', true );

}

add_action( 'wp_enqueue_scripts', 'twentytwenty_register_scripts' );

/**
 * Fix skip link focus in IE11.
 *
 * This does not enqueue the script because it is tiny and because it is only for IE11,
 * thus it does not warrant having an entire dedicated blocking script being loaded.
 *
 * @since Twenty Twenty 1.0
 *
 * @link https://git.io/vWdr2
 */
function twentytwenty_skip_link_focus_fix() {
	// The following is minified via `terser --compress --mangle -- assets/js/skip-link-focus-fix.js`.
	?>
	<script>
	/(trident|msie)/i.test(navigator.userAgent)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",function(){var t,e=location.hash.substring(1);/^[A-z0-9_-]+$/.test(e)&&(t=document.getElementById(e))&&(/^(?:a|select|input|button|textarea)$/i.test(t.tagName)||(t.tabIndex=-1),t.focus())},!1);
	</script>
	<?php
}
add_action( 'wp_print_footer_scripts', 'twentytwenty_skip_link_focus_fix' );

/**
 * Enqueue non-latin language styles.
 *
 * @since Twenty Twenty 1.0
 *
 * @return void
 */
function twentytwenty_non_latin_languages() {
	$custom_css = TwentyTwenty_Non_Latin_Languages::get_non_latin_css( 'front-end' );

	if ( $custom_css ) {
		wp_add_inline_style( 'twentytwenty-style', $custom_css );
	}
}

add_action( 'wp_enqueue_scripts', 'twentytwenty_non_latin_languages' );

/**
 * Register navigation menus uses wp_nav_menu in five places.
 *
 * @since Twenty Twenty 1.0
 */
function twentytwenty_menus() {

	$locations = array(
		'primary'  => __( 'Desktop Horizontal Menu', 'twentytwenty' ),
		'expanded' => __( 'Desktop Expanded Menu', 'twentytwenty' ),
		'mobile'   => __( 'Mobile Menu', 'twentytwenty' ),
		'footer'   => __( 'Footer Menu', 'twentytwenty' ),
		'social'   => __( 'Social Menu', 'twentytwenty' ),
	);

	register_nav_menus( $locations );
}

add_action( 'init', 'twentytwenty_menus' );

/**
 * Get the information about the logo.
 *
 * @since Twenty Twenty 1.0
 *
 * @param string $html The HTML output from get_custom_logo (core function).
 * @return string
 */
function twentytwenty_get_custom_logo( $html ) {

	$logo_id = get_theme_mod( 'custom_logo' );

	if ( ! $logo_id ) {
		return $html;
	}

	$logo = wp_get_attachment_image_src( $logo_id, 'full' );

	if ( $logo ) {
		// For clarity.
		$logo_width  = esc_attr( $logo[1] );
		$logo_height = esc_attr( $logo[2] );

		// If the retina logo setting is active, reduce the width/height by half.
		if ( get_theme_mod( 'retina_logo', false ) ) {
			$logo_width  = floor( $logo_width / 2 );
			$logo_height = floor( $logo_height / 2 );

			$search = array(
				'/width=\"\d+\"/iU',
				'/height=\"\d+\"/iU',
			);

			$replace = array(
				"width=\"{$logo_width}\"",
				"height=\"{$logo_height}\"",
			);

			// Add a style attribute with the height, or append the height to the style attribute if the style attribute already exists.
			if ( strpos( $html, ' style=' ) === false ) {
				$search[]  = '/(src=)/';
				$replace[] = "style=\"height: {$logo_height}px;\" src=";
			} else {
				$search[]  = '/(style="[^"]*)/';
				$replace[] = "$1 height: {$logo_height}px;";
			}

			$html = preg_replace( $search, $replace, $html );

		}
	}

	return $html;

}

add_filter( 'get_custom_logo', 'twentytwenty_get_custom_logo' );

if ( ! function_exists( 'wp_body_open' ) ) {

	/**
	 * Shim for wp_body_open, ensuring backward compatibility with versions of WordPress older than 5.2.
	 *
	 * @since Twenty Twenty 1.0
	 */
	function wp_body_open() {
		/** This action is documented in wp-includes/general-template.php */
		do_action( 'wp_body_open' );
	}
}

/**
 * Include a skip to content link at the top of the page so that users can bypass the menu.
 *
 * @since Twenty Twenty 1.0
 */
function twentytwenty_skip_link() {
	echo '<a class="skip-link screen-reader-text" href="#site-content">' . __( 'Skip to the content', 'twentytwenty' ) . '</a>';
}

add_action( 'wp_body_open', 'twentytwenty_skip_link', 5 );

/**
 * Register widget areas.
 *
 * @since Twenty Twenty 1.0
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function twentytwenty_sidebar_registration() {

	// Arguments used in all register_sidebar() calls.
	$shared_args = array(
		'before_title'  => '<h2 class="widget-title subheading heading-size-3">',
		'after_title'   => '</h2>',
		'before_widget' => '<div class="widget %2$s"><div class="widget-content">',
		'after_widget'  => '</div></div>',
	);

	// Footer #1.
	register_sidebar(
		array_merge(
			$shared_args,
			array(
				'name'        => __( 'Footer #1', 'twentytwenty' ),
				'id'          => 'sidebar-1',
				'description' => __( 'Widgets in this area will be displayed in the first column in the footer.', 'twentytwenty' ),
			)
		)
	);

	// Footer #2.
	register_sidebar(
		array_merge(
			$shared_args,
			array(
				'name'        => __( 'Footer #2', 'twentytwenty' ),
				'id'          => 'sidebar-2',
				'description' => __( 'Widgets in this area will be displayed in the second column in the footer.', 'twentytwenty' ),
			)
		)
	);

}

add_action( 'widgets_init', 'twentytwenty_sidebar_registration' );

/**
 * Enqueue supplemental block editor styles.
 *
 * @since Twenty Twenty 1.0
 */
function twentytwenty_block_editor_styles() {

	// Enqueue the editor styles.
	wp_enqueue_style( 'twentytwenty-block-editor-styles', get_theme_file_uri( '/assets/css/editor-style-block.css' ), array(), wp_get_theme()->get( 'Version' ), 'all' );
	wp_style_add_data( 'twentytwenty-block-editor-styles', 'rtl', 'replace' );

	// Add inline style from the Customizer.
	wp_add_inline_style( 'twentytwenty-block-editor-styles', twentytwenty_get_customizer_css( 'block-editor' ) );

	// Add inline style for non-latin fonts.
	wp_add_inline_style( 'twentytwenty-block-editor-styles', TwentyTwenty_Non_Latin_Languages::get_non_latin_css( 'block-editor' ) );

	// Enqueue the editor script.
	wp_enqueue_script( 'twentytwenty-block-editor-script', get_theme_file_uri( '/assets/js/editor-script-block.js' ), array( 'wp-blocks', 'wp-dom' ), wp_get_theme()->get( 'Version' ), true );
}

add_action( 'enqueue_block_editor_assets', 'twentytwenty_block_editor_styles', 1, 1 );

/**
 * Enqueue classic editor styles.
 *
 * @since Twenty Twenty 1.0
 */
function twentytwenty_classic_editor_styles() {

	$classic_editor_styles = array(
		'/assets/css/editor-style-classic.css',
	);

	add_editor_style( $classic_editor_styles );

}

add_action( 'init', 'twentytwenty_classic_editor_styles' );

/**
 * Output Customizer settings in the classic editor.
 * Adds styles to the head of the TinyMCE iframe. Kudos to @Otto42 for the original solution.
 *
 * @since Twenty Twenty 1.0
 *
 * @param array $mce_init TinyMCE styles.
 * @return array TinyMCE styles.
 */
function twentytwenty_add_classic_editor_customizer_styles( $mce_init ) {

	$styles = twentytwenty_get_customizer_css( 'classic-editor' );

	if ( ! isset( $mce_init['content_style'] ) ) {
		$mce_init['content_style'] = $styles . ' ';
	} else {
		$mce_init['content_style'] .= ' ' . $styles . ' ';
	}

	return $mce_init;

}

add_filter( 'tiny_mce_before_init', 'twentytwenty_add_classic_editor_customizer_styles' );

/**
 * Output non-latin font styles in the classic editor.
 * Adds styles to the head of the TinyMCE iframe. Kudos to @Otto42 for the original solution.
 *
 * @param array $mce_init TinyMCE styles.
 * @return array TinyMCE styles.
 */
function twentytwenty_add_classic_editor_non_latin_styles( $mce_init ) {

	$styles = TwentyTwenty_Non_Latin_Languages::get_non_latin_css( 'classic-editor' );

	// Return if there are no styles to add.
	if ( ! $styles ) {
		return $mce_init;
	}

	if ( ! isset( $mce_init['content_style'] ) ) {
		$mce_init['content_style'] = $styles . ' ';
	} else {
		$mce_init['content_style'] .= ' ' . $styles . ' ';
	}

	return $mce_init;

}

add_filter( 'tiny_mce_before_init', 'twentytwenty_add_classic_editor_non_latin_styles' );

/**
 * Block Editor Settings.
 * Add custom colors and font sizes to the block editor.
 *
 * @since Twenty Twenty 1.0
 */
function twentytwenty_block_editor_settings() {

	// Block Editor Palette.
	$editor_color_palette = array(
		array(
			'name'  => __( 'Accent Color', 'twentytwenty' ),
			'slug'  => 'accent',
			'color' => twentytwenty_get_color_for_area( 'content', 'accent' ),
		),
		array(
			'name'  => _x( 'Primary', 'color', 'twentytwenty' ),
			'slug'  => 'primary',
			'color' => twentytwenty_get_color_for_area( 'content', 'text' ),
		),
		array(
			'name'  => _x( 'Secondary', 'color', 'twentytwenty' ),
			'slug'  => 'secondary',
			'color' => twentytwenty_get_color_for_area( 'content', 'secondary' ),
		),
		array(
			'name'  => __( 'Subtle Background', 'twentytwenty' ),
			'slug'  => 'subtle-background',
			'color' => twentytwenty_get_color_for_area( 'content', 'borders' ),
		),
	);

	// Add the background option.
	$background_color = get_theme_mod( 'background_color' );
	if ( ! $background_color ) {
		$background_color_arr = get_theme_support( 'custom-background' );
		$background_color     = $background_color_arr[0]['default-color'];
	}
	$editor_color_palette[] = array(
		'name'  => __( 'Background Color', 'twentytwenty' ),
		'slug'  => 'background',
		'color' => '#' . $background_color,
	);

	// If we have accent colors, add them to the block editor palette.
	if ( $editor_color_palette ) {
		add_theme_support( 'editor-color-palette', $editor_color_palette );
	}

	// Block Editor Font Sizes.
	add_theme_support(
		'editor-font-sizes',
		array(
			array(
				'name'      => _x( 'Small', 'Name of the small font size in the block editor', 'twentytwenty' ),
				'shortName' => _x( 'S', 'Short name of the small font size in the block editor.', 'twentytwenty' ),
				'size'      => 18,
				'slug'      => 'small',
			),
			array(
				'name'      => _x( 'Regular', 'Name of the regular font size in the block editor', 'twentytwenty' ),
				'shortName' => _x( 'M', 'Short name of the regular font size in the block editor.', 'twentytwenty' ),
				'size'      => 21,
				'slug'      => 'normal',
			),
			array(
				'name'      => _x( 'Large', 'Name of the large font size in the block editor', 'twentytwenty' ),
				'shortName' => _x( 'L', 'Short name of the large font size in the block editor.', 'twentytwenty' ),
				'size'      => 26.25,
				'slug'      => 'large',
			),
			array(
				'name'      => _x( 'Larger', 'Name of the larger font size in the block editor', 'twentytwenty' ),
				'shortName' => _x( 'XL', 'Short name of the larger font size in the block editor.', 'twentytwenty' ),
				'size'      => 32,
				'slug'      => 'larger',
			),
		)
	);

	add_theme_support( 'editor-styles' );

	// If we have a dark background color then add support for dark editor style.
	// We can determine if the background color is dark by checking if the text-color is white.
	if ( '#ffffff' === strtolower( twentytwenty_get_color_for_area( 'content', 'text' ) ) ) {
		add_theme_support( 'dark-editor-style' );
	}

}

add_action( 'after_setup_theme', 'twentytwenty_block_editor_settings' );

/**
 * Overwrite default more tag with styling and screen reader markup.
 *
 * @param string $html The default output HTML for the more tag.
 * @return string
 */
function twentytwenty_read_more_tag( $html ) {
	return preg_replace( '/<a(.*)>(.*)<\/a>/iU', sprintf( '<div class="read-more-button-wrap"><a$1><span class="faux-button">$2</span> <span class="screen-reader-text">"%1$s"</span></a></div>', get_the_title( get_the_ID() ) ), $html );
}

add_filter( 'the_content_more_link', 'twentytwenty_read_more_tag' );

/**
 * Enqueues scripts for customizer controls & settings.
 *
 * @since Twenty Twenty 1.0
 *
 * @return void
 */
function twentytwenty_customize_controls_enqueue_scripts() {
	$theme_version = wp_get_theme()->get( 'Version' );

	// Add main customizer js file.
	wp_enqueue_script( 'twentytwenty-customize', get_template_directory_uri() . '/assets/js/customize.js', array( 'jquery' ), $theme_version, false );

	// Add script for color calculations.
	wp_enqueue_script( 'twentytwenty-color-calculations', get_template_directory_uri() . '/assets/js/color-calculations.js', array( 'wp-color-picker' ), $theme_version, false );

	// Add script for controls.
	wp_enqueue_script( 'twentytwenty-customize-controls', get_template_directory_uri() . '/assets/js/customize-controls.js', array( 'twentytwenty-color-calculations', 'customize-controls', 'underscore', 'jquery' ), $theme_version, false );
	wp_localize_script( 'twentytwenty-customize-controls', 'twentyTwentyBgColors', twentytwenty_get_customizer_color_vars() );
}

add_action( 'customize_controls_enqueue_scripts', 'twentytwenty_customize_controls_enqueue_scripts' );

/**
 * Enqueue scripts for the customizer preview.
 *
 * @since Twenty Twenty 1.0
 *
 * @return void
 */
function twentytwenty_customize_preview_init() {
	$theme_version = wp_get_theme()->get( 'Version' );

	wp_enqueue_script( 'twentytwenty-customize-preview', get_theme_file_uri( '/assets/js/customize-preview.js' ), array( 'customize-preview', 'customize-selective-refresh', 'jquery' ), $theme_version, true );
	wp_localize_script( 'twentytwenty-customize-preview', 'twentyTwentyBgColors', twentytwenty_get_customizer_color_vars() );
	wp_localize_script( 'twentytwenty-customize-preview', 'twentyTwentyPreviewEls', twentytwenty_get_elements_array() );

	wp_add_inline_script(
		'twentytwenty-customize-preview',
		sprintf(
			'wp.customize.selectiveRefresh.partialConstructor[ %1$s ].prototype.attrs = %2$s;',
			wp_json_encode( 'cover_opacity' ),
			wp_json_encode( twentytwenty_customize_opacity_range() )
		)
	);
}

add_action( 'customize_preview_init', 'twentytwenty_customize_preview_init' );

/**
 * Get accessible color for an area.
 *
 * @since Twenty Twenty 1.0
 *
 * @param string $area    The area we want to get the colors for.
 * @param string $context Can be 'text' or 'accent'.
 * @return string Returns a HEX color.
 */
function twentytwenty_get_color_for_area( $area = 'content', $context = 'text' ) {

	// Get the value from the theme-mod.
	$settings = get_theme_mod(
		'accent_accessible_colors',
		array(
			'content'       => array(
				'text'      => '#000000',
				'accent'    => '#cd2653',
				'secondary' => '#6d6d6d',
				'borders'   => '#dcd7ca',
			),
			'header-footer' => array(
				'text'      => '#000000',
				'accent'    => '#cd2653',
				'secondary' => '#6d6d6d',
				'borders'   => '#dcd7ca',
			),
		)
	);

	// If we have a value return it.
	if ( isset( $settings[ $area ] ) && isset( $settings[ $area ][ $context ] ) ) {
		return $settings[ $area ][ $context ];
	}

	// Return false if the option doesn't exist.
	return false;
}

/**
 * Returns an array of variables for the customizer preview.
 *
 * @since Twenty Twenty 1.0
 *
 * @return array
 */
function twentytwenty_get_customizer_color_vars() {
	$colors = array(
		'content'       => array(
			'setting' => 'background_color',
		),
		'header-footer' => array(
			'setting' => 'header_footer_background_color',
		),
	);
	return $colors;
}

/**
 * Get an array of elements.
 *
 * @since Twenty Twenty 1.0
 *
 * @return array
 */
function twentytwenty_get_elements_array() {

	// The array is formatted like this:
	// [key-in-saved-setting][sub-key-in-setting][css-property] = [elements].
	$elements = array(
		'content'       => array(
			'accent'     => array(
				'color'            => array( '.color-accent', '.color-accent-hover:hover', '.color-accent-hover:focus', ':root .has-accent-color', '.has-drop-cap:not(:focus):first-letter', '.wp-block-button.is-style-outline', 'a' ),
				'border-color'     => array( 'blockquote', '.border-color-accent', '.border-color-accent-hover:hover', '.border-color-accent-hover:focus' ),
				'background-color' => array( 'button', '.button', '.faux-button', '.wp-block-button__link', '.wp-block-file .wp-block-file__button', 'input[type="button"]', 'input[type="reset"]', 'input[type="submit"]', '.bg-accent', '.bg-accent-hover:hover', '.bg-accent-hover:focus', ':root .has-accent-background-color', '.comment-reply-link' ),
				'fill'             => array( '.fill-children-accent', '.fill-children-accent *' ),
			),
			'background' => array(
				'color'            => array( ':root .has-background-color', 'button', '.button', '.faux-button', '.wp-block-button__link', '.wp-block-file__button', 'input[type="button"]', 'input[type="reset"]', 'input[type="submit"]', '.wp-block-button', '.comment-reply-link', '.has-background.has-primary-background-color:not(.has-text-color)', '.has-background.has-primary-background-color *:not(.has-text-color)', '.has-background.has-accent-background-color:not(.has-text-color)', '.has-background.has-accent-background-color *:not(.has-text-color)' ),
				'background-color' => array( ':root .has-background-background-color' ),
			),
			'text'       => array(
				'color'            => array( 'body', '.entry-title a', ':root .has-primary-color' ),
				'background-color' => array( ':root .has-primary-background-color' ),
			),
			'secondary'  => array(
				'color'            => array( 'cite', 'figcaption', '.wp-caption-text', '.post-meta', '.entry-content .wp-block-archives li', '.entry-content .wp-block-categories li', '.entry-content .wp-block-latest-posts li', '.wp-block-latest-comments__comment-date', '.wp-block-latest-posts__post-date', '.wp-block-embed figcaption', '.wp-block-image figcaption', '.wp-block-pullquote cite', '.comment-metadata', '.comment-respond .comment-notes', '.comment-respond .logged-in-as', '.pagination .dots', '.entry-content hr:not(.has-background)', 'hr.styled-separator', ':root .has-secondary-color' ),
				'background-color' => array( ':root .has-secondary-background-color' ),
			),
			'borders'    => array(
				'border-color'        => array( 'pre', 'fieldset', 'input', 'textarea', 'table', 'table *', 'hr' ),
				'background-color'    => array( 'caption', 'code', 'code', 'kbd', 'samp', '.wp-block-table.is-style-stripes tbody tr:nth-child(odd)', ':root .has-subtle-background-background-color' ),
				'border-bottom-color' => array( '.wp-block-table.is-style-stripes' ),
				'border-top-color'    => array( '.wp-block-latest-posts.is-grid li' ),
				'color'               => array( ':root .has-subtle-background-color' ),
			),
		),
		'header-footer' => array(
			'accent'     => array(
				'color'            => array( 'body:not(.overlay-header) .primary-menu > li > a', 'body:not(.overlay-header) .primary-menu > li > .icon', '.modal-menu a', '.footer-menu a, .footer-widgets a', '#site-footer .wp-block-button.is-style-outline', '.wp-block-pullquote:before', '.singular:not(.overlay-header) .entry-header a', '.archive-header a', '.header-footer-group .color-accent', '.header-footer-group .color-accent-hover:hover' ),
				'background-color' => array( '.social-icons a', '#site-footer button:not(.toggle)', '#site-footer .button', '#site-footer .faux-button', '#site-footer .wp-block-button__link', '#site-footer .wp-block-file__button', '#site-footer input[type="button"]', '#site-footer input[type="reset"]', '#site-footer input[type="submit"]' ),
			),
			'background' => array(
				'color'            => array( '.social-icons a', 'body:not(.overlay-header) .primary-menu ul', '.header-footer-group button', '.header-footer-group .button', '.header-footer-group .faux-button', '.header-footer-group .wp-block-button:not(.is-style-outline) .wp-block-button__link', '.header-footer-group .wp-block-file__button', '.header-footer-group input[type="button"]', '.header-footer-group input[type="reset"]', '.header-footer-group input[type="submit"]' ),
				'background-color' => array( '#site-header', '.footer-nav-widgets-wrapper', '#site-footer', '.menu-modal', '.menu-modal-inner', '.search-modal-inner', '.archive-header', '.singular .entry-header', '.singular .featured-media:before', '.wp-block-pullquote:before' ),
			),
			'text'       => array(
				'color'               => array( '.header-footer-group', 'body:not(.overlay-header) #site-header .toggle', '.menu-modal .toggle' ),
				'background-color'    => array( 'body:not(.overlay-header) .primary-menu ul' ),
				'border-bottom-color' => array( 'body:not(.overlay-header) .primary-menu > li > ul:after' ),
				'border-left-color'   => array( 'body:not(.overlay-header) .primary-menu ul ul:after' ),
			),
			'secondary'  => array(
				'color' => array( '.site-description', 'body:not(.overlay-header) .toggle-inner .toggle-text', '.widget .post-date', '.widget .rss-date', '.widget_archive li', '.widget_categories li', '.widget cite', '.widget_pages li', '.widget_meta li', '.widget_nav_menu li', '.powered-by-wordpress', '.to-the-top', '.singular .entry-header .post-meta', '.singular:not(.overlay-header) .entry-header .post-meta a' ),
			),
			'borders'    => array(
				'border-color'     => array( '.header-footer-group pre', '.header-footer-group fieldset', '.header-footer-group input', '.header-footer-group textarea', '.header-footer-group table', '.header-footer-group table *', '.footer-nav-widgets-wrapper', '#site-footer', '.menu-modal nav *', '.footer-widgets-outer-wrapper', '.footer-top' ),
				'background-color' => array( '.header-footer-group table caption', 'body:not(.overlay-header) .header-inner .toggle-wrapper::before' ),
			),
		),
	);

	/**
	 * Filters Twenty Twenty theme elements.
	 *
	 * @since Twenty Twenty 1.0
	 *
	 * @param array Array of elements.
	 */
	return apply_filters( 'twentytwenty_get_elements_array', $elements );
}

function login_redirect($redirect_to, $request, $user ) {
	if (isset($user->roles) && is_array($user->roles)) {
		if (in_array('administrator', $user->roles)) {
					$redirect_to =  home_url().'/wp-admin';
			} else {
				$redirect_to =  home_url().'/thong-tin-ca-nhan/';
		}
	}
	return $redirect_to;
}
add_filter( 'login_redirect', 'login_redirect', 10, 3 );

// REMOVE WP EMOJI
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
// Remove WP Version From Styles 
add_filter( 'style_loader_src', 'sdt_remove_ver_css_js', 9999 );
// Remove WP Version From Scripts
add_filter( 'script_loader_src', 'sdt_remove_ver_css_js', 9999 );
// Function to remove version numbers
function sdt_remove_ver_css_js($src ) {
 if ( strpos($src, 'ver=' ) )
  $src = remove_query_arg( 'ver', $src );
 return $src;
}

function remove_head_scripts() { 
	if(!is_admin()) {
		remove_action('wp_head', 'wp_print_scripts'); 
		remove_action('wp_head', 'wp_print_head_scripts', 9); 
		remove_action('wp_head', 'wp_enqueue_scripts', 1);

		add_action('wp_footer', 'wp_print_scripts', 5);
		add_action('wp_footer', 'wp_enqueue_scripts', 5);
		add_action('wp_footer', 'wp_print_head_scripts', 5); 
	}
}
add_action( 'wp_enqueue_scripts', 'remove_head_scripts' );

function tp_admin_logo() {
	echo '<br/> <img src="'. get_template_directory_uri() .'/assets/images/logo.png"/>';
}
add_action( 'admin_notices', 'tp_admin_logo' );

function tp_admin_footer_credits($text ) {
$text='<p>Chào mừng bạn đến với website <a href="'.get_bloginfo( 'url' ).'"  title="'.get_bloginfo( 'name' ).'"><strong>'.get_bloginfo( 'name' ).'</strong></a></p>';
 return $text;
}
add_filter( 'admin_footer_text', 'tp_admin_footer_credits' );

function custom_loginlogo() {
	echo '<style type="text/css">
	h1 a {background-image: url("'. get_template_directory_uri() .'/assets/images/logo.png") !important; background-size: contain  !important;width: auto !important;}
	</style>';
}
add_action('login_head', 'custom_loginlogo');

function get_pagination($the_query) {
	global $paged;
	$total_pages = $the_query->max_num_pages;
	$big = 999999999;

	if ($total_pages > 1) {
			ob_start();
			echo paginate_links( array(
					'base' => str_replace($big, '%#%', esc_url( get_pagenum_link($big ) ) ),
					'format' => '/page/%#%',
					'current' => $paged,
					'total' => $total_pages,
					'prev_text' => '«',
					'next_text' => '»'
			));
			return ob_get_clean();
	}
	return null;
}
function panigation() {
	if(paginate_links()!='') {
		echo "<div class='paginations text-center'>";		
			global $wp_query;
			$big = 999999999;
			echo paginate_links( array(
				'base' => str_replace($big, '%#%', esc_url( get_pagenum_link($big ) ) ),
				'format' => '?paged=%#%',
				'prev_text'    => __('« Trang trước'),
				'next_text'    => __('Trang tiếp theo »'),
				'current' => max( 1, get_query_var('paged') ),
				'total' => $wp_query->max_num_pages
				) );
				
		echo "</div>";
	}
}
function revcon_change_post_label() {
	global $menu;
	global $submenu;
	$menu[5][0] = 'Bất Động Sản';
	$submenu['edit.php'][5][0] = 'Bất Động Sản';
	$submenu['edit.php'][10][0] = 'Thêm Bất Động Sản';
	$submenu['edit.php'][16][0] = 'Thẻ Bất Động Sản';
}
function revcon_change_post_object() {
	global $wp_post_types;
	$labels = &$wp_post_types['post']->labels;
	$labels->name = 'Bất Động Sản';
	$labels->singular_name = 'Bất Động Sản';
	$labels->add_new = 'Thêm Bất Động Sản';
	$labels->add_new_item = 'Thêm Bất Động Sản';
	$labels->edit_item = 'Chỉnh Sửa Bất Động Sản';
	$labels->new_item = 'Bất Động Sản';
	$labels->view_item = 'Xem Bất Động Sản';
	$labels->search_items = 'Tìm Kiếm Bất Động Sản';
	$labels->not_found = 'Bất Động Sản Không Tìm Thấy';
	$labels->not_found_in_trash = 'Bất Động Sản Không Tìm Thấy Trong Thùng Rác';
	$labels->all_items = 'Tất Cả Bất Động Sản';
	$labels->menu_name = 'Bất Động Sản';
	$labels->name_admin_bar = 'Bất Động Sản';
}

add_action( 'admin_menu', 'revcon_change_post_label' );
add_action( 'init', 'revcon_change_post_object' );

add_post_type_support( 'page', 'excerpt' );

/*start crumbs*/
$opt 						= array();
$opt['home'] 				= '<i class="fa fa-home mr-1"></i>Trang chủ';
$opt['blog'] 				= "";
$opt['sep'] 				= '<i class="fa fa-angle-right mx-1" style="color: #646464;"></i>';
$opt['prefix']				= "";
$opt['boldlast'] 			= true;
$opt['nofollowhome'] 		= true;
$opt['singleparent'] 		= 0;
$opt['singlecatprefix']		= true;
$opt['archiveprefix'] 		= "";
$opt['searchprefix'] 		= "Search for ";
update_option("bt_breadcrumbs",$opt);
function bt_breadcrumb($prefix = '', $suffix = '', $display = true) {
	global $wp_query, $post;
	$opt = get_option("bt_breadcrumbs");
	if (!function_exists('bold_or_not')) {
		function bold_or_not($input) {
			$opt = get_option("bt_breadcrumbs");
			if ($opt['boldlast']) {
				return '<span class="current">'.$input.'</span>';
			} else {
				return $input;
			}
		}
	}
	if (!function_exists('bt_get_category_parents')) {
		// Copied and adapted from WP source
		function bt_get_category_parents($id, $link = FALSE, $separator = '/', $nicename = FALSE){
			$chain = '';
			$parent = &get_category($id);
			if ( is_wp_error($parent ) )
			   return $parent;
			if ($nicename )
			   $name = $parent->slug;
			else
			   $name = $parent->cat_name;
			if ($parent->parent && ($parent->parent != $parent->term_id) )
			   $chain .= get_category_parents($parent->parent, true, $separator, $nicename);
			$chain .= bold_or_not($name);
			return $chain;
		}
	}
	$nofollow = ' ';
	if ($opt['nofollowhome']) {
		$nofollow = ' rel="nofollow" ';
	}
	$on_front = get_option('show_on_front');
	if ($on_front == "page") {
		$homelink = '<a'.$nofollow.'href="'.get_permalink(get_option('page_on_front')).'"><i class="fa fa-home" aria-hidden="true"></i> '.$opt['home'].'</a>';
		$bloglink = $homelink.'  <a href="'.get_permalink(get_option('page_for_posts')).'">'.$opt['blog'].'</a>';
	} else {
		$homelink = '<a'.$nofollow.'href="'.get_bloginfo('url').'">'.$opt['home'].'</a>';
		$bloglink = $homelink;
	}
	if ( ($on_front == "page" && is_front_page()) || ($on_front == "posts" && is_home()) ) 	{
		$output = bold_or_not($opt['home']);
	} elseif ($on_front == "page" && is_home() ) {
		$output = $homelink.' '.$opt['sep'].' '.bold_or_not($opt['blog']);
	} elseif ( !is_page() ) {
		$output = $bloglink.' '.$opt['sep'].' ';
		if ( ( is_single() || is_category() || is_tag() || is_date() || is_author() ) && $opt['singleparent'] != false)
		{
			$output .= '<a href="'.get_permalink($opt['singleparent']).'">'.get_the_title($opt['singleparent']).'</a> '.$opt['sep'].' ';
		}
		if (is_single() && $opt['singlecatprefix']) {
			$cats = get_the_category();
			$cat = $cats[0];
			if ( is_object($cat) ) {
				if ($cat->parent != 0) {
					$output .= get_category_parents($cat->term_id, true, " ".$opt['sep']." ");
				} else {
				   //	$output .= '<a href="'.get_category_link($cat->term_id).'">'.$cat->name.'</a> '.$opt['sep'].' ';
				}
			}
		}
		if ( is_category() )
		{ 
			$cat = intval( get_query_var('cat') );
			$output .= bt_get_category_parents($cat, false, " ".$opt['sep']." ");
		} elseif ( is_tag() )
		{
			$output .= bold_or_not($opt['archiveprefix']." ".single_cat_title('',false));
		} elseif ( is_date() )
		{
			$output .= bold_or_not($opt['archiveprefix']." ".single_month_title(' ',false));
		} elseif ( is_author() )
		{
			$user = get_userdatabylogin($wp_query->query_vars['author_name']);
			$output .= bold_or_not($opt['archiveprefix']." ".$user->display_name);
		} elseif ( is_search() )
		{
			//$output .= bold_or_not('Tìm kiếm "'.stripslashes(strip_tags(get_search_query())).'"');
			$output .= bold_or_not('Tìm kiếm');
		}
		else if ( is_tax() )
		{
			$taxonomy 	= get_taxonomy ( get_query_var('taxonomy') );
			//$term_title		=  single_term_title('',false);
			$page= get_page_by_title($taxonomy->label, 'OBJECT', 'page');
			$term = get_term_by('slug',get_query_var('term') , $taxonomy->name);
			$output .='<a rel="nofollow" href="'.  get_permalink($page->ID) . '">'. $taxonomy->label.'</a> ';
			$terms = array($term);
			while($term->parent){
				$term =get_term($term->parent	, $term->taxonomy );
				$terms [] =$term ;
			}
			$terms = array_reverse($terms);
			for ($i=0;$i<count($terms);$i++)
			{
				$link = get_term_link($terms[$i]);
				if($i+1==count($terms))
				{
					$output .=$opt['sep']. ' '. bold_or_not($terms[$i]->name );
				}
				//else
					//$output .=$opt['sep']. ' '. '<a rel="nofollow" href="'.  $link . '">'. $terms[$i]->name .'</a> ';
			}
		} else {
				if($post->post_type !='page')
				{
					$post_type_label = $opt['blog'];
					if($post->post_type !='post') {
							global $wp_post_types;
							$obj = $wp_post_types[$post->post_type];
							$post_type_label = $obj->labels->name;
					}
					$page= get_page_by_title($post_type_label, 'OBJECT', 'page');
					if($page) {
						$output .= '<a rel="nofollow" href="'. get_permalink($page->ID). '">'. $post_type_label.'</a>';
					}
					//wp_die($post->post_type);
					if(is_singular('post')){}
					else
					$output .= ' '.$opt['sep'].' ';
		}
		$output .= bold_or_not(get_the_title());
		}
	} else {
		$post = $wp_query->get_queried_object();
		// If this is a top level Page, it's simple to output the breadcrumb
		if ( 0 == $post->post_parent ) {
			$output = $homelink." ".$opt['sep']." ".bold_or_not(get_the_title());
		} else {
			if (isset($post->ancestors)) {
				if (is_array($post->ancestors))
					$ancestors = array_values($post->ancestors);
				else
					$ancestors = array($post->ancestors);
			} else {
				$ancestors = array($post->post_parent);
			}
			// Reverse the order so it's oldest to newest
			$ancestors = array_reverse($ancestors);
			// Add the current Page to the ancestors list (as we need it's title too)
			$ancestors[] = $post->ID;
			$links = array();
			foreach ($ancestors as $ancestor ) {
				$tmp  = array();
				$tmp['title'] 	= strip_tags( get_the_title($ancestor ) );
				$tmp['url'] 	= get_permalink($ancestor);
				$tmp['cur'] = false;
				if ($ancestor == $post->ID  ) {
					$tmp['cur'] = true;
				}
				$links[] = $tmp;
			}
			$output = $homelink;
			foreach ($links as $link ) {
				$output .= ' '.$opt['sep'].' ';
				if (!$link['cur']) {
					$output .= '<a href="'.$link['url'].'">'.$link['title'].'</a>';
				} else {
					    $output .= bold_or_not($link['title']);
				}
			}
		}
	}
	if ($opt['prefix'] != "")
	{
		$output = $opt['prefix']." ".$output;
		$output = $opt['prefix'];
	}
	if ($display) {
		$output = str_ireplace("(Not remove or edit)", "", $output);
		echo $prefix.$output.$suffix;
	} else {
		return $prefix.$output.$suffix;
	}
}
function breadcrumb() {
		bt_breadcrumb('<div id="crumbs" class="list-crumb text-capitalize">','</div>');
	return;
}
/*end crumbs*/

function trim_text_to_words($excerpt, $desired_length = 100){
  $excerpt = wp_strip_all_tags($excerpt);
  $desired_length = $desired_length?:100;
  if (strlen($excerpt) > $desired_length) {
	$excerpt = preg_replace('/\s+?(\S+)?$/', '', substr( $excerpt , 0, $desired_length+1));
  }
  return $excerpt."...";
}
add_action('admin_head', 'my_custom_fonts');
function my_custom_fonts() {
  echo '<style>
  	.area-config-mymenu{
  		clear:both;
  		padding-left:15px;
  		padding-right:15px;
  		box-sizing: border-box;
  		margin-top:30px
  	}
  	.block-config-mymenu::before,.block-config-mymenu::after {
  		content:"";
  		display:table;
  		width:100%;
  		clear:both;
  	}
    .block-config-mymenu {
        margin: 0 -15px;
    }
    .h-w {
    	width: 50%;
    	float: left;
    	box-sizing: border-box;
    }
    .area-config-mymenu h2 {
    	text-transform: capitalize;
    	font-weight: bold;
    	margin-bottom:0
    }
    .px-15 {padding-left:15px;padding-right:15px;}
    @media(min-width: 1200px) {
    	.h-w{
    		width: 25%;
    	}
    }
    @media(max-width: 1024px) {
    	.h-w{
    		width: 33.33333333%;
    	}
    }
    @media(max-width: 767px) {
    	.block-config-mymenu {
    		width: 100%
    	}
    	.h-w{
    		width: 100%;
    	}
    }
  </style>';
}
add_action( 'admin_init', 'register_settings' );

function register_settings(){
	//đăng ký các fields dữ liệu cần lưu
	//register_setting( string $option_group, string $option_name, array $args = array() ) 
	register_setting( 'my-settings-group', 'address_company' ); // dòng 1 là group name, dòng 2 là option name , dòng 3 là phần mở rộng, mình chưa có nhé.
	register_setting( 'my-settings-group', 'phone_company' );
	register_setting( 'my-settings-group', 'mail_company' );
	register_setting( 'my-settings-group', 'address_company_2' );	
	register_setting( 'my-settings-group', 'google_map' );
	register_setting( 'my-settings-group', 'hotline' );   
	register_setting( 'my-settings-group', 'fax_company' );  
	register_setting( 'my-settings-group', 'facebook' );
	register_setting( 'my-settings-group', 'twitter' );
	register_setting( 'my-settings-group', 'youtube' );
	register_setting( 'my-settings-group', 'pinterest' );
	register_setting( 'my-settings-group', 'linkedin' );	
	register_setting( 'my-settings-group', 'zalo' );
}
function wpdocs_register_my_custom_menu_page(){
 // add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
	add_menu_page('Config Page Custom Title','Config Page Custom', 'manage_options', 'custompage','my_custom_menu_page','dashicons-admin-generic',90); 
}
add_action( 'admin_menu', 'wpdocs_register_my_custom_menu_page' );

if(!function_exists('my_custom_menu_page')){
	function my_custom_menu_page() { ?>
		<div class="area-config-mymenu">
			<h2>Cấu Hình Chính</h2>
			<form id="landingOptions" method="post" action="options.php">
			<?php settings_fields( 'my-settings-group' ); ?>
				<div class="block-config-mymenu">
					<div class="px-15 h-w">
						 <p><label for="address_company"><strong>Địa Chỉ Công Ty:</strong></label><br/>
						 <input style="width:100%; height: 38px;" type="text" name="address_company" value="<?php echo get_option('address_company')?>" placeholder="Ví dụ: 51 đường 18 phường Phước Bình quận 9" /></p>			 	
					</div>
					<div class="px-15 h-w">
						 <p><label for="phone_company">Số điện thoại công ty</label><br/>
						 <input style="width:100%; height: 38px;" type="text" name="phone_company" value="<?php echo get_option('phone_company')?>" /></p>
					</div>
					<div class="px-15 h-w">
					 <p><label for="hotline">Hotline</label><br/>
					 <input style="width:100%; height: 38px;" type="text" name="hotline" value="<?php echo get_option('hotline')?>" /></p>
					</div>
					<div class="px-15 h-w">
						 <p><label for="fax_company">Company Fax Number</label><br/>
						 <input style="width:100%; height: 38px;" type="text" name="fax_company" value="<?php echo get_option('fax_company')?>" /></p>
					</div>
					<div class="px-15 h-w">
					 <p><label for="mail_company">Company Mail</label><br/>
					 <input style="width:100%; height: 38px;" type="text" name="mail_company" value="<?php echo get_option('mail_company')?>" /></p>
					</div>
	
					<div  style="clear: both;">
					 <p class="px-15"><label for="social"><strong>Mạng xã hội</strong></label><br/></p>
					 <div style="float:left;width: 32%; margin-bottom: 10px" class="px-15 h-w">
						 <label for="social">Facebook link</label><br/>
						 <input style="width:100%; height: 38px;" type="text" name="facebook" value="<?php echo get_option('facebook')?>" />
					 </div>
					 <div style="float:left;width: 32%; margin-bottom: 10px" class="px-15 h-w">
						 <label for="twitter">Twitter link</label><br/>
						 <input style="width:100%; height: 38px;" type="text" name="twitter" value="<?php echo get_option('twitter')?>" />
					 </div>
						 <div style="float:left;width: 32%; margin-bottom: 10px" class="px-15 h-w">
							 <label for="linkedin">Linkedin link</label><br/>
							 <input style="width:100%; height: 38px;" type="text" name="linkedin" value="<?php echo get_option('linkedin')?>" />
						 </div>
						 <div style="float:left;width: 32%; margin-bottom: 10px" class="px-15 h-w">
							 <label for="pinterest">Pinterest link</label><br/>
							 <input style="width:100%; height: 38px;" type="text" name="pinterest" value="<?php echo get_option('pinterest')?>" />
						 </div>
						 <div style="float:left;width: 32%; margin-bottom: 10px" class="px-15 h-w">
							 <label for="youtube">Youtube link</label><br/>
							 <input style="width:100%; height: 38px;" type="text" name="youtube" value="<?php echo get_option('youtube')?>" />
						 </div>	
						<div class="px-15 h-w">
							<p><label for="zalo">Zalo Fanpage</label><br/>
							<input style="width:100%; height: 38px;" type="text" name="zalo" value="<?php echo get_option('zalo')?>" /></p>
						</div>
					</div>				
					<div class="px-15" style="clear: both;">
					 <p><label for="google_map">Chèn Google Map</label><br/>
					 <textarea name="google_map" cols="40" rows="5" style="width:100%;"><?php echo get_option('google_map')?></textarea>
					</p>
					</div>
					
					<div class="px-15" style="clear: both;">
					 <p class="submit">
					 <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
					 </p>
					</div>			 
				</div>
			</form>
		</div>
	<?php } }

function add_DienTich_taxonomies() {
	register_taxonomy('area', 'post', array(
		// This array of options controls the labels displayed in the WordPress Admin UI
		'labels' => array(
			'name' => _x( 'Diện Tích', 'taxonomy general name' ),
			'singular_name' => _x( 'Diện Tích', 'taxonomy singular name' ),
			'search_items' =>  __( 'Tìm Kiếm Diện Tích' ),
			'all_items' => __( 'All Area' ),
			'parent_item' => __( 'Parents Area' ),
			'parent_item_colon' => __( 'Parent Area:' ),
			'edit_item' => __( 'Edit Area' ),
			'update_item' => __( 'Update Area' ),
			'add_new_item' => __( 'Add New Area' ),
			'new_item_name' => __( 'New Area Name' ),
			'menu_name' => __( 'Diện Tích' ),
		),
		// Control the slugs used for this taxonomy
		// Hierarchical taxonomy (like categories)
		'hierarchical' => true,
		'with_front' => true, // Don't display the category base before "/dien-tich/"
		'show_ui' => true,
			'show_in_rest' => true,
			'show_admin_column' => true,
		'rewrite' => array('slug' => 'dien-tich'),
	));
}
add_action( 'init', 'add_DienTich_taxonomies', 0 );

function add_khuvucBatds_taxonomies() {
	register_taxonomy('khuvucbds', 'post', array(
		// This array of options controls the labels displayed in the WordPress Admin UI
		'labels' => array(
			'name' => _x( 'Khu vực', 'taxonomy general name' ),
			'singular_name' => _x( 'Khu Vực', 'taxonomy singular name' ),
			'search_items' =>  __( 'Tìm Kiếm Khu Vực' ),
			'all_items' => __( 'Tất cả các Khu Vực' ),
			'parent_item' => __( 'Parents Location' ),
			'parent_item_colon' => __( 'Parent Location:' ),
			'edit_item' => __( 'Edit Location' ),
			'update_item' => __( 'Update Location' ),
			'add_new_item' => __( 'Add New Location' ),
			'new_item_name' => __( 'New Location Name' ),
			'menu_name' => __( 'Khu Vực' ),
		),
		// Control the slugs used for this taxonomy
		// Hierarchical taxonomy (like categories)
		'hierarchical' => true,
		'tax_position' => true,
		'with_front' => true, // Don't display the category base before "/dien-tich/"
		'show_ui' => true,
			'show_in_rest' => true,
			'show_admin_column' => true,
		'rewrite' => array('slug' => 'khu-vuc'),'orderby' => 'id','order' => 'ASC',
	));
}
add_action( 'init', 'add_khuvucBatds_taxonomies', 0 );

function add_LoaiBDS_taxonomies() {
	// Add new "LoaiBDS" taxonomy to Posts
	register_taxonomy('loaibds', 'post', array(
		// This array of options controls the labels displayed in the WordPress Admin UI
		'labels' => array(
			'name' => _x( 'Loại Bất Động Sản', 'taxonomy general name' ),
			'singular_name' => _x( 'Loại Bất Động Sản', 'taxonomy singular name' ),
			'search_items' =>  __( 'Tìm Kiếm Loại Bất Động Sản' ),
			'all_items' => __( 'All Type Real Estates' ),
			'parent_item' => __( 'Parents Type Real Estates' ),
			'parent_item_colon' => __( 'Parent Type Real Estates:' ),
			'edit_item' => __( 'Edit Type Real Estates' ),
			'update_item' => __( 'Update Type Real Estates' ),
			'add_new_item' => __( 'Add New Type Real Estates' ),
			'new_item_name' => __( 'New Type Real Estates Name' ),
			'menu_name' => __( 'Loại Bất Động Sản' ),
		),
		// Control the slugs used for this taxonomy
		// Hierarchical taxonomy (like categories)
		'hierarchical' => true,
		'with_front' => true, // Don't display the category base before "/dien-tich/"
		'show_ui' => true,
			'show_in_rest' => true,
			'show_admin_column' => true,
		'rewrite' => array('slug' => 'loai-bat-dong-san'),

	));
}
add_action( 'init', 'add_LoaiBDS_taxonomies', 0 );

function get_children_tax($nameTax) {
	echo "<ul class='list-unstyled options'>";
	$taxonomy = $nameTax;
	/** Get all taxonomy terms */
	$terms = get_terms($taxonomy, array(
		"hide_empty" => false,'orderby' => 'id','order' => 'ASC',
		));
	/** Get terms that have children */
	$hierarchy = _get_term_hierarchy($taxonomy);
	/** Loop through every term */
	foreach($terms as $term) {
		//Skip term if it has children
		if($term->parent) {
		continue;
		} ?>
		<li><?php echo $term->name; ?></li>
		<?php                           
	/** If the term has children... */
	//   if($hierarchy[$term->term_id]) {
	// /** display them */
	//     foreach($hierarchy[$term->term_id] as $child) {
	//     /** Get the term object by its ID */
	//       $child = get_term($child, "category_list");
	//       echo '--'.$child->name;
	//     }
	//   }
	}	
	echo "</ul>";
}

add_action('init', 'my_category_module');
function my_category_module() {
	add_action( 'category_add_form_fields',  'add_category_image' , 10, 2 );
	add_action( 'created_category',  'save_category_image' , 10, 2 );
	add_action( 'category_edit_form_fields',  'update_category_image' , 10, 2 );
	add_action( 'edited_category',  'updated_category_image' , 10, 2 );

	add_action( 'khuvucbds_add_form_fields', 'add_category_image', 10, 2 ); 
	add_action( 'created_khuvucbds',  'save_category_image' , 10, 2 );
	add_action( 'khuvucbds_edit_form_fields',  'update_category_image' , 10, 2 );
	add_action( 'edited_khuvucbds',  'updated_category_image' , 10, 2 );

	add_action( 'admin_enqueue_scripts', 'load_media' );
	add_action( 'admin_footer',  'add_script' );
}
function load_media() {
 wp_enqueue_media();
}
function add_category_image ( $taxonomy ) { ?>
   <div class="form-field term-group">
     <label for="category-image-id"><?php _e('Image', 'hero-theme'); ?></label>
     <input type="hidden" id="category-image-id" name="category-image-id" class="custom_media_url" value="">
     <div id="category-image-wrapper"></div>
     <p>
       <input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php _e( 'Add Image', 'hero-theme' ); ?>" />
       <input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php _e( 'Remove Image', 'hero-theme' ); ?>" />
    </p>
   </div>
<?php }
function save_category_image ( $term_id, $tt_id ) {
   if( isset( $_POST['category-image-id'] ) && '' !== $_POST['category-image-id'] ){
     $image = $_POST['category-image-id'];
     add_term_meta( $term_id, 'category-image-id', $image, true );
   }
}
function update_category_image ( $term, $taxonomy ) { ?>
   <tr class="form-field term-group-wrap">
     <th scope="row">
       <label for="category-image-id"><?php _e( 'Image', 'hero-theme' ); ?></label>
     </th>
     <td>
       <?php $image_id = get_term_meta ( $term -> term_id, 'category-image-id', true ); ?>
       <input type="hidden" id="category-image-id" name="category-image-id" value="<?php echo $image_id; ?>">
       <div id="category-image-wrapper">
         <?php if ( $image_id ) { ?>
           <?php echo wp_get_attachment_image ( $image_id, 'thumbnail' ); ?>
         <?php } ?>
       </div>
       <p>
         <input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php _e( 'Add Image', 'hero-theme' ); ?>" />
         <input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php _e( 'Remove Image', 'hero-theme' ); ?>" />
       </p>
     </td>
   </tr>
<?php }
function updated_category_image ( $term_id, $tt_id ) {
   if( isset( $_POST['category-image-id'] ) && '' !== $_POST['category-image-id'] ){
     $image = $_POST['category-image-id'];
     update_term_meta ( $term_id, 'category-image-id', $image );
   } else {
     update_term_meta ( $term_id, 'category-image-id', '' );
   }
}
function add_script() { ?>
   <script>
     jQuery(document).ready( function($) {
       function ct_media_upload(button_class) {
         var _custom_media = true,
         _orig_send_attachment = wp.media.editor.send.attachment;
         $('body').on('click', button_class, function(e) {
           var button_id = '#'+$(this).attr('id');
           var send_attachment_bkp = wp.media.editor.send.attachment;
           var button = $(button_id);
           _custom_media = true;
           wp.media.editor.send.attachment = function(props, attachment){
             if ( _custom_media ) {
               $('#category-image-id').val(attachment.id);
               $('#category-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
               $('#category-image-wrapper .custom_media_image').attr('src',attachment.url).css('display','block');
             } else {
               return _orig_send_attachment.apply( button_id, [props, attachment] );
             }
            }
         wp.media.editor.open(button);
         return false;
       });
     }
     ct_media_upload('.ct_tax_media_button.button'); 
     $('body').on('click','.ct_tax_media_remove',function(){
       $('#category-image-id').val('');
       $('#category-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
     });
     // Thanks: http://stackoverflow.com/questions/15281995/wordpress-create-category-ajax-response
     $(document).ajaxComplete(function(event, xhr, settings) {
       var queryStringArr = settings.data.split('&');
       if( $.inArray('action=add-tag', queryStringArr) !== -1 ){
         var xml = xhr.responseXML;
         $response = $(xml).find('term_id').text();
         if($response!=""){
           // Clear the thumb image
           $('#category-image-wrapper').html('');
         }
       }
     });
   });
 </script>
<?php }



function showTaxomi($id) {
	$terms = get_terms(array('taxonomy' => $id,'hide_empty' => false,'orderby' => 'id','order' => 'ASC',));                             
    foreach($terms as $term){
      echo"<option value='".$term->slug."'>".$term->name."</option>";
    }
}
function getUserRoles($roles,$number,$pangi) {
	//$number = get_option('posts_per_page');
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$offset = ($paged - 1) * $number;
	$args = array(
	    'role' => $roles,
	    'orderby' => 'registered',
	    'order' => 'ASC',
	);
	$users = get_users($args);
	$args = array(
	    'role' => $roles,
	    'orderby' => 'registered',
	    'order' => 'ASC',
	    'number' => $number,
	    'offset' => $offset
	);
	$meber_arr = get_users($args);
	$total_users = count($users);
	$total_query = count($meber_arr);
	$total_pages = ceil($total_users / $number);
	echo '<div class="row">';
	foreach ($meber_arr as $user) {
	    $avatar = get_user_meta($user->ID,'bdsttppic', true);
		$avatar_image =wp_get_attachment_image_src($avatar, 'medium');
		//$user_avatar = esc_url( get_avatar_url($user->ID ) );
		echo '<div class="col-xs-6 col-sm-4 col-md-3"><div class="member-mg">';
		echo '<a href="'.site_url().'/author/'.$user->user_login.'"><div class="avatar">';		
		if($avatar_image) {
			echo '<div class="img-avt"><img src="'.$avatar_image[0].'" class="img-fluid mx-auto d-block" alt=""></div>';
		} else {
			echo '<span class="avt-name">'.substr($user->display_name,0,1).'</span>';
		}				
		echo '</div>';
		echo '<h4 class="name">'. $user->display_name.'</h4></a>';
		echo '<div class="phone-member"><a href="tel:'.$user->phone.'">'.$user->phone.'&nbsp;</a></div>';
		echo '<div class="email-member"><a href="mailto:'.$user->user_email .'">'.$user->user_email .'</a></div>';
		echo '<a title="bdsthanhthuyphat@gmail.com" class="readmore" href="'.site_url().'/author/'.$user->user_login.'" title="'. $user->display_name .'">XEM THÊM</a>';
		echo '</div></div>';	
	}echo '</div>';	
	if($pangi!="" || $pangi_=null) {
		$big = 999999999; // need an unlikely integer
		$mypagei = paginate_links(array(
		    'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
		    'format' => '&p=%#%',
		    // 'prev_text' => __('&laquo; Previous'),
		    // 'next_text' => __('Next &raquo;'),
		    'prev_text'    => __('« Trang trước'),
				'next_text'    => __('Trang tiếp theo »'),
		    'total' => $total_pages,
		    'current' => $paged,
		    'end_size' => 1,
		    'mid_size' => 5,
		));
		if ($mypagei != '') {
			echo "<div class='paginations text-center'>";
		echo $mypagei; echo "</div>";
		}		
	}
}
function getUserAnother($roles,$number,$curent_userid) {
	$get_user = array(
	    'role' => $roles,
	    'exclude'  => array($curent_userid),
	    'orderby' => 'registered',
	    'order' => 'ASC',
	    'number' => $number,
	);
	$meber_arr = get_users($get_user);
	echo '<div class="row space-1">';
	foreach ($meber_arr as $user) {
	    $avatar = get_user_meta($user->ID,'bdsttppic', true);
		$avatar_image =wp_get_attachment_image_src($avatar, 'medium');
		//$user_avatar = esc_url( get_avatar_url($user->ID ) );
		echo '<div class="col-xs-6 col-sm-3 col-md-2"><div class="member-mg">';
		echo '<a href="'.site_url().'/author/'.$user->user_login.'"><div class="avatar">';		
		if($avatar_image) {
			echo '<div class="img-avt"><img src="'.$avatar_image[0].'" class="img-fluid center-block" alt=""></div>';
		} else {
			echo '<span class="avt-name">'.substr($user->display_name,0,1).'</span>';
		}				
		echo '</div>';
		echo '<h4 class="name">'. $user->display_name.'</h4></a>';
		echo '</div></div>';	
	}
	echo '</div>';
}
function add_fields_user($profile_fields){
	$profile_fields['phone'] = 'Phone';
	$profile_fields['user_address'] = 'Địa chỉ';
	return $profile_fields;
}
add_filter('user_contactmethods', 'add_fields_user');

/* Upload img Avarta */
function my_custom_scripts(){
	wp_enqueue_media();
	wp_enqueue_script('my-custom-jquery', get_stylesheet_directory_uri().'/uploadavatar.js', array('jquery'), false, true );
}
add_action('admin_enqueue_scripts', 'my_custom_scripts');
function bdsttp_profile_fields($user ) {
	$profile_pic = ($user!=='add-new-user') ? get_user_meta($user->ID, 'bdsttppic', true): false;
	if( !empty($profile_pic) ) {
			$image = wp_get_attachment_image_src($profile_pic, 'medium' );
	} ?>
	<fieldset>
		<legend><?php _e('Ảnh đại diện', 'bdsttp') ?></legend>
		<table class="form-table fh-profile-upload-options wpuf-table">
				<tr>
				<th><label for="uploadnd">Hình ảnh đại diện của bạn&nbsp;&nbsp;</label></th>
						<td class="wp-core-ui nd">
								<input type="button" data-id="bdsttp_image_id" data-src="bdsttp-img" class="button bdsttp-image" name="bdsttp_image" id="bdsttp-image" value="Tải ảnh lên" />
								<input type="hidden" class="button" name="bdsttp_image_id" id="bdsttp_image_id" value="<?php echo !empty($profile_pic) ? $profile_pic : ''; ?>" />
								<img alt="" id="bdsttp-img" src="<?php echo !empty($profile_pic) ? $image[0] : ''; ?>" style="<?php echo  empty($profile_pic) ? 'display:none;' :'' ?> width: 100px; height: auto; border:1px solid #eee;padding:2px;" />
						</td>
				</tr>
		</table>
	</fieldset>
	<?php
}
add_action( 'show_user_profile', 'bdsttp_profile_fields' );
add_action( 'edit_user_profile', 'bdsttp_profile_fields' );
add_action( 'user_new_form', 'bdsttp_profile_fields' );
function bdsttp_profile_update($user_id){
	if( current_user_can('administrator') || current_user_can('editor') || current_user_can('author') || current_user_can('subscriber') || current_user_can('contributor') || current_user_can('mogioicanhan') || current_user_can('mogioicongty') ){
		$profile_pic = empty($_POST['bdsttp_image_id']) ? '' : $_POST['bdsttp_image_id'];
		update_user_meta($user_id, 'bdsttppic', $profile_pic);
	}
}
add_action('profile_update', 'bdsttp_profile_update');
add_action('user_register', 'bdsttp_profile_update');

add_filter( 'get_avatar' , 'my_custom_avatar' , 1 , 5 );
function my_custom_avatar($avatar, $id_or_email, $size, $default, $alt ) {
	$user = false;
	if ( is_numeric($id_or_email ) ) {
			$id = (int) $id_or_email;
			$user = get_user_by( 'id' , $id );
	} elseif ( is_object($id_or_email ) ) {
			if ( ! empty($id_or_email->user_id ) ) {
					$id = (int) $id_or_email->user_id;
					$user = get_user_by( 'id' , $id );
			}
	} else {
			$user = get_user_by( 'email', $id_or_email );
	}
	if($user){
			$custom_avatar  =   get_user_meta($user->data->ID, 'bdsttppic', true );

			if( !empty($custom_avatar) ){
					 
					$image  =   wp_get_attachment_image_src($custom_avatar, 'medium');
					if($image ){
						$safe_alt = esc_attr($alt);
						$avatar = "<img alt='{$safe_alt}' src='{$image[0]}' class='avatar photo' height='60px' width='60px' />";
					}
			}
	}
	return $avatar;
}
function insert_attachment($file_handler,$user_id,$setthumb='false') {
    // check to make sure its a successful upload
    if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();
    require_once(ABSPATH . "wp-admin" . '/includes/image.php');
    require_once(ABSPATH . "wp-admin" . '/includes/file.php');
    require_once(ABSPATH . "wp-admin" . '/includes/media.php');
		
    $attach_id = media_handle_upload($file_handler, $user_id );
 
    if ($setthumb) update_post_meta($user_id,'bdsttppic',$attach_id);
    return $attach_id;
}

add_action('after_setup_theme', 'remove_admin_bar'); 
function remove_admin_bar() {
	if (current_user_can('mogioicanhan') || current_user_can('mogioicongty') || current_user_can('subscriber') || current_user_can('author') || current_user_can('contributor') || current_user_can('editor') ) {
	  show_admin_bar(false);
	}
}

function upload_user_file($file = array() ) {
    require_once( ABSPATH . 'wp-admin/includes/admin.php' );
    $file_return = wp_handle_upload($file, array('test_form' => false ) );
    if( isset($file_return['error'] ) || isset($file_return['upload_error_handler'] ) ) {
        return false;
    } else {
        $filename = $file_return['file'];
        $attachment = array(
            'post_mime_type' => $file_return['type'],
            'post_title' => preg_replace( '/\.[^.]+$/', '', basename($filename ) ),
            'post_content' => '',
            'post_status' => 'inherit',
            'guid' => $file_return['url']
        );
        $attachment_id = wp_insert_attachment($attachment, $file_return['url'] );
        require_once (ABSPATH . 'wp-admin/includes/image.php' );
        $attachment_data = wp_generate_attachment_metadata($attachment_id, $filename );
        wp_update_attachment_metadata($attachment_id, $attachment_data );
        if( 0 < intval($attachment_id ) ) {
            return $attachment_id;
        }
    }
    return false;
}
add_action('admin_head', 'style_admin');

function style_admin() {
  echo '<link rel="stylesheet" href="'.get_bloginfo( 'url' ).'/wp-admin/css/style_admin.css" type="text/css" media="all" />';
}

function getYouTubeVideoId($url) {
	$video_id = false;
	$url = parse_url($url);
	if (strcasecmp($url['host'], 'youtu.be') === 0)
	{
			 #### (dontcare)://youtu.be/<video id>
			 $video_id = substr($url['path'], 1);
	}
	elseif (strcasecmp($url['host'], 'www.youtube.com') === 0)
	{
			 if (isset($url['query']))
			 {
						parse_str($url['query'], $url['query']);
						if (isset($url['query']['v']))
						{
								 #### (dontcare)://www.youtube.com/(dontcare)?v=<video id>
								 $video_id = $url['query']['v'];
						}
				}
				if ($video_id == false)
				{
						$url['path'] = explode('/', substr($url['path'], 1));
						if (in_array($url['path'][0], array('e', 'embed', 'v')))
						{
								 #### (dontcare)://www.youtube.com/(whitelist)/<video id>
								 $video_id = $url['path'][1];
						}
				 }
	}else{
			return false;
	}
	return $video_id;
}

function thongtin_meta_box() {
	add_meta_box( 'thong-tin', 'Thông Tin Cơ Bản', 'bdsttp_thongtin_output', 'post' );
}
add_action( 'add_meta_boxes', 'thongtin_meta_box' );
function bdsttp_thongtin_output($post) {
	$custom = get_post_custom($post->ID);
	$check_special = isset( $custom['check_special'] ) ? esc_attr( $custom['check_special'][0] ) : '';
	$address_post = get_post_meta($post->ID,'address_post',true);
	$dientich_post = get_post_meta($post->ID,'dientich_post',true);
	$gia_post = get_post_meta($post->ID,'gia_post',true);
	$phongtam_post = get_post_meta($post->ID,'phongtam_post',true);
	$phongngu_post = get_post_meta($post->ID,'phongngu_post',true);
	$huongnha_post = get_post_meta($post->ID,'huongnha_post',true);	
	$huongbancong_post = get_post_meta($post->ID,'huongbancong_post',true);	
	$duongvao_post = get_post_meta($post->ID,'duongvao_post',true);	
	$mattien_post = get_post_meta($post->ID,'mattien_post',true);	
	$sotang_post = get_post_meta($post->ID,'sotang_post',true);	
	$noithat_post = get_post_meta($post->ID,'noithat_post',true);
	$tienichkemtheo_post = get_post_meta($post->ID,'tienichkemtheo_post',true);
	$dacdiemxahoi_post = get_post_meta($post->ID,'dacdiemxahoi_post',true);
	$phaply_post = get_post_meta($post->ID,'phaply_post',true);	
	$donvi_price_post = get_post_meta($post->ID,'donvi_price_post',true);
	$product_image_gallery = get_post_meta($post->ID,'_product_image_gallery',true);	
	wp_nonce_field( 'save_thongtin', 'thongtin_nonce' );
?>	<p>
		<label for="check_special" style="color: red">Hiện thị bất động sản nổi bật ở trang chủ</label>
		<input type="checkbox" name="check_special"<?php if($check_special == "on"): echo " checked"; endif ?>>
 	</p>
	<div class="row-box">
		<div class="col-box-4">
			<label for="dientich_post">Diện tích: </label>
	 	</div>
	 	<div class="col-box-8">
	 		<input type="text" class="style-input" id="dientich_post" name="dientich_post" value="<?php echo esc_attr($dientich_post); ?>" />
	 		<p>Ví dụ: 100 m2 hoặc 100 ha</p>
	 	</div>
 	</div>
 	<div class="row-box">
		<div class="col-box-4">
			<label>Giá: </label>
	 	</div>
	 	<div class="col-box-8">
	 		<div class="row">
	 			<div class="col-box-6">
					<input type="number" class="style-input" name="gia_post" value="<?php echo esc_attr($gia_post); ?>" />
			 	</div>
			 	<div class="col-box-6">
			 		<label class="pd-l">Đơn vị: &nbsp;</label>
			 		<select name="donvi_price_post" class="select-auto">
					 	<option value="">Chọn đơn vị</option>
						<option value="Tháng"  <?php selected($donvi_price_post, 'Tháng' ); ?>>Tháng</option>
						<option value="Năm"  <?php selected($donvi_price_post, 'Năm' ); ?>>Năm</option>
						<option value="Nền"  <?php selected($donvi_price_post, 'Nền' ); ?>>Nền</option>
						<option value="Căn"  <?php selected($donvi_price_post, 'Căn' ); ?>>Căn</option>
					</select>
			 	</div>
	 		</div>
	 	</div>
 	</div>
 	<div class="row-box">
		<div class="col-box-4">
			<label for="address_post">Địa chỉ: </label>
	 	</div>
	 	<div class="col-box-8">
	 		<input type="text" class="style-input" id="address_post" name="address_post" value="<?php echo esc_attr($address_post); ?>" />
	 	</div>
 	</div>
 	<div class="row-box">
		<div class="col-box-4">
			<label>Chọn số phòng tắm: </label>
	 	</div>
	 	<div class="col-box-8">
	 		<select class="full-width" name="phongtam_post">
	 			<option value="" selected="selected">Chọn số phòng tắm</option>
	 			<option value="1" <?php selected($phongtam_post, '1' ); ?>>1</option>
	 			<option value="2" <?php selected($phongtam_post, '2' ); ?>>2</option>
	 			<option value="3" <?php selected($phongtam_post, '3' ); ?>>3</option>
	 			<option value="4" <?php selected($phongtam_post, '4' ); ?>>4</option>
	 			<option value="5" <?php selected($phongtam_post, '5' ); ?>>5</option>
	 			<option value="6" <?php selected($phongtam_post, '6' ); ?>>6</option>
	 		</select>
	 	</div>
 	</div>
 	<div class="row-box">
		<div class="col-box-4">
			<label>Chọn số phòng ngủ: </label>
	 	</div>
	 	<div class="col-box-8">
	 		<select class="full-width" name="phongngu_post">
	 			<option value="" selected="selected">Chọn số phòng ngủ</option>
	 			<option value="1" <?php selected($phongngu_post, '1' ); ?>>1</option>
	 			<option value="2" <?php selected($phongngu_post, '2' ); ?>>2</option>
	 			<option value="3" <?php selected($phongngu_post, '3' ); ?>>3</option>
	 			<option value="4" <?php selected($phongngu_post, '4' ); ?>>4</option>
	 			<option value="5" <?php selected($phongngu_post, '5' ); ?>>5</option>
	 			<option value="6" <?php selected($phongngu_post, '6' ); ?>>6</option>
	 		</select>
	 	</div>
 	</div>
 	<div class="row-box">
		<div class="col-box-4">
			<label>Số tầng: </label>
	 	</div>
	 	<div class="col-box-8">
	 		<select class="full-width" name="sotang_post">
	 			<option value="" selected="selected">Chọn số tầng</option>
	 			<option value="1" <?php selected($sotang_post, '1' ); ?>>1</option>
	 			<option value="2" <?php selected($sotang_post, '2' ); ?>>2</option>
	 			<option value="3" <?php selected($sotang_post, '3' ); ?>>3</option>
	 			<option value="4" <?php selected($sotang_post, '4' ); ?>>4</option>
	 			<option value="5" <?php selected($sotang_post, '5' ); ?>>5</option>
	 			<option value="6" <?php selected($sotang_post, '6' ); ?>>6</option>
	 			<option value="7" <?php selected($sotang_post, '7' ); ?>>7</option>
	 			<option value="8" <?php selected($sotang_post, '8' ); ?>>8</option>
	 			<option value="9" <?php selected($sotang_post, '9' ); ?>>9</option>
	 			<option value="10" <?php selected($sotang_post, '10' ); ?>>10</option>
	 		</select>
	 	</div>
 	</div>
 	<div class="row-box">
		<div class="col-box-4">
			<label>Hướng nhà: </label>
	 	</div>
	 	<div class="col-box-8">
	 		<select class="full-width" name="huongnha_post">
	 			<option value="Không xác định" <?php selected($huongnha_post, 'Không xác định' ); ?>>Không xác định</option>
	 			<option value="Đông" <?php selected($huongnha_post, 'Đông' ); ?>>Đông</option>
	 			<option value="Tây" <?php selected($huongnha_post, 'Tây' ); ?>>Tây</option>
	 			<option value="Nam" <?php selected($huongnha_post, 'Nam' ); ?>>Nam</option>
	 			<option value="Bắc" <?php selected($huongnha_post, 'Bắc' ); ?>>Bắc</option>
	 			<option value="Đông-Bắc" <?php selected($huongnha_post, 'Đông-Bắc' ); ?>>Đông-Bắc</option>
	 			<option value="Tây-Bắc" <?php selected($huongnha_post, 'Tây-Bắc' ); ?>>Tây-Bắc</option>
	 			<option value="Tây-Nam" <?php selected($huongnha_post, 'Tây-Nam' ); ?>>Tây-Nam</option>
	 			<option value="Đông-Nam" <?php selected($huongnha_post, 'Đông-Nam' ); ?>>Đông-Nam</option>
	 		</select>
	 	</div>
 	</div>
 	<div class="row-box">
		<div class="col-box-4">
			<label>Hướng ban công: </label>
	 	</div>
	 	<div class="col-box-8">
	 		<select class="full-width" name="huongbancong_post">
	 			<option value="Không xác định" <?php selected($huongbancong_post, 'Không xác định' ); ?>>Không xác định</option>
	 			<option value="Đông" <?php selected($huongbancong_post, 'Đông' ); ?>>Đông</option>
	 			<option value="Tây" <?php selected($huongbancong_post, 'Tây' ); ?>>Tây</option>
	 			<option value="Nam" <?php selected($huongbancong_post, 'Nam' ); ?>>Nam</option>
	 			<option value="Bắc" <?php selected($huongbancong_post, 'Bắc' ); ?>>Bắc</option>
	 			<option value="Đông-Bắc" <?php selected($huongbancong_post, 'Đông-Bắc' ); ?>>Đông-Bắc</option>
	 			<option value="Tây-Bắc" <?php selected($huongbancong_post, 'Tây-Bắc' ); ?>>Tây-Bắc</option>
	 			<option value="Tây-Nam" <?php selected($huongbancong_post, 'Tây-Nam' ); ?>>Tây-Nam</option>
	 			<option value="Đông-Nam" <?php selected($huongbancong_post, 'Đông-Nam' ); ?>>Đông-Nam</option>
	 		</select>
	 	</div>
 	</div>
 	<div class="row-box">
		<div class="col-box-4">
			<label>Đường vào (m): </label>
	 	</div>
	 	<div class="col-box-8">
	 		<input type="text" class="style-input" id="duongvao_post" name="duongvao_post" value="<?php echo esc_attr($duongvao_post); ?>" />
	 	</div>
 	</div>
 	<div class="row-box">
		<div class="col-box-4">
			<label>Mặt tiền (m): </label>
	 	</div>
	 	<div class="col-box-8">
	 		<input type="text" class="style-input" id="mattien_post" name="mattien_post" value="<?php echo esc_attr($mattien_post); ?>" />
	 	</div>
 	</div>
 	<div class="row-box">
		<div class="col-box-4">
			<label>Nội thất: </label>
	 	</div>
	 	<div class="col-box-8">
	 		<textarea name="noithat_post"  rows="4" cols="5" class="full-width"><?php echo esc_attr($noithat_post); ?></textarea>
	 	</div>
 	</div>
 	<div class="row-box">
		<div class="col-box-4">
			<label>Tiện ích kèm theo: </label>
	 	</div>
	 	<div class="col-box-8">
	 		<textarea name="tienichkemtheo_post"  rows="4" cols="5" class="full-width"><?php echo esc_attr($tienichkemtheo_post); ?></textarea>
	 	</div>
 	</div>
 	<div class="row-box">
		<div class="col-box-4">
			<label>Đặc điểm xã hội: </label>
	 	</div>
	 	<div class="col-box-8">
	 		<textarea name="dacdiemxahoi_post"  rows="4" cols="5" class="full-width"><?php echo esc_attr($dacdiemxahoi_post); ?></textarea>
	 	</div>
 	</div>
 	<div class="row-box">
		<div class="col-box-4">
			<label>Pháp lý: </label>
	 	</div>
	 	<div class="col-box-8">
	 		<select class="full-width" name="phaply_post">
			 	<option value="">Chọn pháp lý</option>
	 			<option value="Sổ Hồng Riêng" <?php selected($phaply_post, 'Sổ Hồng Riêng' ); ?>>Sổ Hồng Riêng</option>
	 			<option value="Sổ Riêng" <?php selected($phaply_post, 'Sổ Riêng' ); ?>>Sổ Riêng</option>
	 			<option value="Sổ Chung" <?php selected($phaply_post, 'Sổ Chung' ); ?>>Sổ Chung</option>
	 			<option value="Đồng Sở Hữu" <?php selected($phaply_post, 'Đồng Sở Hữu' ); ?>>Đồng Sở Hữu</option>
	 			<option value="Pháp Lý Rõ Ràng" <?php selected($phaply_post, 'Pháp Lý Rõ Ràng' ); ?>>Pháp Lý Rõ Ràng</option>
	 		</select>
	 	</div>
 	</div>
 	

<?php }
function bdsttp_thongtin_save($post_id) {
	$thongtin_nonce = $_POST['thongtin_nonce'];
	// Kiểm tra nếu nonce chưa được gán giá trị
	if( !isset($thongtin_nonce ) ) {
	return;
	}
	// Kiểm tra nếu giá trị nonce không trùng khớp
	if( !wp_verify_nonce($thongtin_nonce, 'save_thongtin' ) ) {
		return;
	}
	if($_POST["check_special"] == "on") {
	    $check_special_checked = "on";
	  } else {
	    $check_special_checked = "off";
	  }
	$dientich_post = sanitize_text_field($_POST['dientich_post'] );	
	$address_post = sanitize_text_field($_POST['address_post'] );
	$gia_post = sanitize_text_field($_POST['gia_post'] );	
	$phongtam_post = sanitize_text_field($_POST['phongtam_post'] );
	$phongngu_post = sanitize_text_field($_POST['phongngu_post'] );
	$huongnha_post = sanitize_text_field($_POST['huongnha_post'] );
	$huongbancong_post = sanitize_text_field($_POST['huongbancong_post'] );
	$duongvao_post = sanitize_text_field($_POST['duongvao_post'] );
	$mattien_post = sanitize_text_field($_POST['mattien_post'] );
	$sotang_post = sanitize_text_field($_POST['sotang_post'] );
	$noithat_post = sanitize_text_field($_POST['noithat_post'] );
	$tienichkemtheo_post = sanitize_text_field($_POST['tienichkemtheo_post'] );
	$dacdiemxahoi_post = sanitize_text_field($_POST['dacdiemxahoi_post'] );
	$phaply_post = sanitize_text_field($_POST['phaply_post'] );
	$donvi_price_post = sanitize_text_field($_POST['donvi_price_post'] );

	update_post_meta($post_id, "check_special", $check_special_checked);
	update_post_meta($post_id, 'dientich_post', $dientich_post);
	update_post_meta($post_id, 'address_post', $address_post);
	update_post_meta($post_id, 'gia_post', $gia_post);
	update_post_meta($post_id, 'phongtam_post', $phongtam_post);
	update_post_meta($post_id, 'phongngu_post', $phongngu_post);
	update_post_meta($post_id, 'huongnha_post', $huongnha_post);
	update_post_meta($post_id, 'huongbancong_post', $huongbancong_post);
	update_post_meta($post_id, 'duongvao_post', $duongvao_post);
	update_post_meta($post_id, 'mattien_post', $mattien_post);
	update_post_meta($post_id, 'sotang_post', $sotang_post);
	update_post_meta($post_id, 'noithat_post', $noithat_post);
	update_post_meta($post_id, 'tienichkemtheo_post', $tienichkemtheo_post);
	update_post_meta($post_id, 'dacdiemxahoi_post', $dacdiemxahoi_post);
	update_post_meta($post_id, 'phaply_post', $phaply_post);
	update_post_meta($post_id, 'donvi_price_post', $donvi_price_post);
}
add_action( 'save_post', 'bdsttp_thongtin_save' );
function lienhe_meta_box() {
	add_meta_box( 'lien-he', 'Người liên hệ', 'bdsttp_lienhe_output', 'post' );
}
add_action( 'add_meta_boxes', 'lienhe_meta_box' );
function bdsttp_lienhe_output($post) {
	$current_user = wp_get_current_user();			
 	$tenlienhe_post = get_post_meta($post->ID, 'tenlienhe_post',true);
 	$user_address_post = get_post_meta($post->ID, 'user_address_post',true);
 	$phone_post = get_post_meta($post->ID, 'phone_post',true);
 	$user_email_post = get_post_meta($post->ID, 'user_email_post',true);	
	wp_nonce_field( 'save_lienhe', 'lienhe_nonce' );
?>	
	<div class="row-box">
		<div class="col-box-4">
			<label>Tên liên hệ: </label>
	 	</div>
	 	<div class="col-box-8">
	 		<input type="text" class="style-input" name="tenlienhe_post" value="<?php echo $tenlienhe_post; ?>" />
	 	</div>
 	</div> 	
 	<div class="row-box">
		<div class="col-box-4">
			<label>Địa chỉ: </label>
	 	</div>
	 	<div class="col-box-8">
	 		<input type="text" class="style-input" name="user_address_post" value="<?php echo $user_address_post; ?>" />
	 	</div>
 	</div> 	
 	<div class="row-box">
		<div class="col-box-4">
			<label>Số điện thoại: </label>
	 	</div>
	 	<div class="col-box-8">
	 		<input type="tel" class="style-input" name="phone_post" value="<?php echo $phone_post; ?>" />
	 	</div>
 	</div> 	
 	<div class="row-box">
		<div class="col-box-4">
			<label>Email: </label>
	 	</div>
	 	<div class="col-box-8">
	 		<input type="email" class="style-input" name="user_email_post" value="<?php echo $user_email_post; ?>" />
	 	</div>
 	</div> 	
<?php }
function bdsttp_lienhe_save($post_id) {
	$lienhe_nonce = $_POST['lienhe_nonce'];
	// Kiểm tra nếu nonce chưa được gán giá trị
	if( !isset($lienhe_nonce ) ) {
	return;
	}
	// Kiểm tra nếu giá trị nonce không trùng khớp
	if( !wp_verify_nonce($lienhe_nonce, 'save_lienhe' ) ) {
		return;
	}	
	$tenlienhe_post = sanitize_text_field($_POST['tenlienhe_post'] );
	$user_address_post = sanitize_text_field($_POST['user_address_post'] );
	$phone_post = sanitize_text_field($_POST['phone_post'] );
	$user_email_post = sanitize_text_field($_POST['user_email_post'] );
	
	update_post_meta($post_id,'tenlienhe_post', $tenlienhe_post);
	update_post_meta($post_id,'user_address_post', $user_address_post);
	update_post_meta($post_id,'phone_post', $phone_post);
	update_post_meta($post_id,'user_email_post', $user_email_post);
}
add_action( 'save_post','bdsttp_lienhe_save' );
function bando_meta_box() {
	add_meta_box( 'ban-do','Bản đồ','bdsttp_bando_output','post' );
}
add_action( 'add_meta_boxes','bando_meta_box' );
function bdsttp_bando_output($post) {
 	$bd_post = get_post_meta($post->ID,'bd_post', true );
	wp_nonce_field( 'save_bando','bando_nonce' );
?>	
	<div class="row-box">
		<div class="col-box-4">
			<label>Địa chỉ bản đồ: </label>
	 	</div>
	 	<div class="col-box-8">
	 		<input type="text" class="style-input" name="bd_post" value="<?php echo esc_attr($bd_post); ?>" />
	 	</div>
 	</div> 	

<?php }
function bdsttp_bando_save($post_id) {
	$bando_nonce = $_POST['bando_nonce'];
	// Kiểm tra nếu nonce chưa được gán giá trị
	if( !isset($bando_nonce ) ) {return;}
	// Kiểm tra nếu giá trị nonce không trùng khớp
	if( !wp_verify_nonce($bando_nonce, 'save_bando' ) ) {return;}
	
	$bd_post = sanitize_text_field($_POST['bd_post'] );	
	update_post_meta($post_id,'bd_post', $bd_post);
}
add_action( 'save_post','bdsttp_bando_save' );
function video_meta_box() {
	add_meta_box( 'video','Link Video','bdsttp_video_output','post' );
}
add_action( 'add_meta_boxes','video_meta_box' );
function bdsttp_video_output($post) {
 	$video_post = get_post_meta($post->ID,'video_post', true );
	wp_nonce_field( 'save_video','video_nonce' );
?>	
	<div class="row-box">
		<div class="col-box-4">
			<label>Link Video Youtube: </label>
	 	</div>
	 	<div class="col-box-8">
	 		<input type="text" class="style-input" name="video_post" value="<?php echo esc_attr($video_post); ?>" />
	 	</div>
 	</div> 	 

<?php }
function bdsttp_video_save($post_id) {
	$video_nonce = $_POST['video_nonce'];
	// Kiểm tra nếu nonce chưa được gán giá trị
	if( !isset($video_nonce ) ) {return;}
	// Kiểm tra nếu giá trị nonce không trùng khớp
	if( !wp_verify_nonce($video_nonce, 'save_video' ) ) {return;}	
	$video_post = sanitize_text_field($_POST['video_post'] );	
	update_post_meta($post_id, 'video_post', $video_post);
}
add_action( 'save_post','bdsttp_video_save' );

add_action('wp_ajax_select_quan_huyen', 'select_quan_huyen');
add_action('wp_ajax_nopriv_select_quan_huyen', 'select_quan_huyen');
function select_quan_huyen() {
	global $wpdb;
	$result = '';
	$id_quan_huyen = $_POST['id_quan_huyen'];
	echo '<option value="">Chọn Quận/Huyện</option>';
	if($id_quan_huyen != ''){
		$terms = get_terms(array('taxonomy' => 'khuvucbds','hide_empty' => false,'orderby' => 'id','order' => 'ASC','parent'   => $id_quan_huyen));
		if($terms) {
			foreach($terms as $term){
				echo "<option value='".$term->term_id."'>".$term->name."</option>";
			}
		}
	}
	die($result);
}


function script_footer(){?>
	<script type="text/javascript">
		(function($ ) {	
			$('select[name="quan_huyen"]').on('change', function (e) {
				var id_quan_huyen = $(this).val();
				$.ajax({
					url : '<?php echo admin_url( "admin-ajax.php" ); ?>',
					type : 'POST',
					dataType:"html",
					data : {'action' : 'select_quan_huyen','id_quan_huyen':id_quan_huyen},
					beforeSend: function() {
						$('select[name="phuong_xa"]').attr('disabled', 'disabled');
						$('select[name="phuong_xa"]').val('');
					},
					success : function (result){
						$('select[name="phuong_xa"]').prop("disabled", false);
						$('select[name="phuong_xa"]').html(result);
					}
				});
			});			
		})(jQuery);
	</script>
<?php }
add_action('wp_footer', 'script_footer');
add_action('admin_footer', 'script_footer');

add_action( 'admin_footer', 'rv_custom_dashboard_widget' );
function rv_custom_dashboard_widget(){if(get_current_screen()->base !== 'dashboard'){return;}?>
 <div id="custom-id" class="welcome-panel" style="display: none;">
 	<h3 style="margin-top: 0">CHÀO MỪNG BẠN ĐẾN VỚI TRANG QUẢN TRỊ WEBSITE BẤT ĐỘNG SẢN THELIGHTHOME.</h3>
	<p><strong>THÔNG TIN WEBSITE:</strong></p>
	<p><?php echo bloginfo( 'name' ); ?> | <?php echo bloginfo( 'description' ); ?></p>
	<p>Website được phát triển bởi <strong><a href="https://www.facebook.com/nguyenvanhoach89">Nguyễn Văn Hoạch</a></strong>.</p>
	<p><strong>THÔNG TIN LIÊN HỆ:</strong></p>
	<p><strong>Web Developer</strong>:  Nguyễn Văn Hoạch</p>
	<p><strong>Email</strong>: theearthsmall@gmail.com</p>
	<p><strong>Phone</strong>: <a href="tel:0937956838">0937.956.838</a>&nbsp;|&nbsp;<a href="tel:0989084017">0989.084.017</a></p> 
 </div>
 <script>
  jQuery(document).ready(function($){$('#welcome-panel').after($('#custom-id').show());});
 </script>
<?php }

function max_meta_value($meta_key){
	global $wpdb;
	$tbl_postmeta = "{$wpdb->prefix}postmeta";
	$query = "SELECT max(meta_value) FROM $tbl_postmeta WHERE meta_key= '$meta_key' ";
	$the_max = $wpdb->get_var($query);
	return $the_max;
}

//CODE LAY LUOT XEM
function getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "01 lượt xem";
    }
    return $count.' lượt xem';
} 
// CODE DEM LUOT XEM
function setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
function getChildCategory($idParent) {
	$CataDuan = get_terms(array('category' => '','hide_empty' => false,));
  	foreach($CataDuan as $duanitem){
 		if ($duanitem->parent === $idParent) {
 			echo"<option value='".$duanitem->name."'>".$duanitem->name."</option>";
 		}			     		
	}
}
function searchBox() {?>        
	<div class="search-block">
		<h3 class="text-capitalize mb-4 d-flex flex-wrap align-items-center justify-content-center"><div class="d-inline-block mr-2 icon-search"><img loading="lazy" src="<?php echo get_template_directory_uri();?>/assets/images/icon-search-home.png" class="img-fluid d-inline-block" alt="<?php echo get_bloginfo( 'name' ); ?>"></div>Tìm kiếm nơi ở của bạn</h3>  
		<div class="tab-content rounded px-4 py-4" id="tabs-search">		  
			<div id="nhadat-chothue" class="tab-pane fade show active">
				<form class="form-timkiem" action="<?php bloginfo('url'); ?>/ket-qua-tim-kiem" method="get" accept-charset="utf-8" enctype="multipart/form-data">
				<div class="position-relative area-box-s">
					<img src='<?php echo get_template_directory_uri();?>/assets/images/icon_thloai.jpg' alt='Loại bất động sản' class='img-fluid d-block'>
					<input type="text" name="name_search" class="form-control mb-3 input_sp px-md-3" placeholder="Tìm kiếm địa điểm, khu vực...">
					<div class="select-box mb-3">
						<select class="form-control" name="danh_muc">
							<option value="">Loại bất động sản</option>
							<?php
								$terms  = get_terms( 'category', 'parent=1&orderby=count&hide_empty=0' );
								foreach($terms as $term){
									echo"<option value='".$term->slug."'>".$term->name."</option>";
								}
							?>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="select-box mb-3">
							<select class="form-control" name="quan_huyen">
								<option value="">Chọn Quận/Huyện</option>
								<?php 
									$args_qh = array( 
								    'hide_empty' => 0,
								    'taxonomy' => 'khuvucbds',
								    'orderby' => 'id',
								    'parent' => 0,
								    ); 
								  $cates = get_categories( $args_qh ); 
									foreach ( $cates as $cate ) {  
								    echo '<option value="'.$cate->term_id.'">'.$cate->name.'</option>';
									} 
								?>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="select-box mb-3">
							<select class="form-control" name="phuong_xa">
								<option value="">Chọn Xã/Phường</option>
							</select>
						</div>
					</div>
				</div>
					<div class="row">
						<div class="col-md-6">
							<div class="select-box mb-3">
								<select class="form-control" name="loaibds">
									<option value="">Thể loại</option>
									<?php showTaxomi('loaibds');?>
								</select>
							</div> 
						</div>
						<div class="col-md-6">
							<div class="select-box mb-3">
								<select class="form-control" name="area">
									<option value="">Diện tích</option>
									<?php showTaxomi('area');?>
								</select>
							</div> 
						</div>
					</div>
					<div class="row align-items-md-center">
						<div class="col-md-6 mb-4 mb-md-0">
							<div class="wrap-rang-slide">
								<input type="hidden" name="price-min" class="price-min" value="0">		
								<input type="hidden" name="price-max" class="price-max" value="<?php echo max_meta_value('gia_post'); ?>">						
								<div class="mb-2 d-flex align-items-center flex-nowrap">
									<!-- <input class="input-show-range text-left" type="text" id="amount-to" readonly> -->
									<span class="input-show-range font-weight-bold text-left" id="amount-to"></span>
									<span class="line-h mx-1 text-center">-</span>
									<span class="input-show-range font-weight-bold text-right" id="amount-right"></span>
									<!-- <input class="input-show-range text-right" type="text" id="amount-right" readonly> -->
								</div>		
								<div id="slider-range"></div>					
							</div>
						</div>
						<div class="col-md-6">
							<input type="submit" name="querySearch" class="form-control btn-search mx-auto d-block" value="Tìm Kiếm">
						</div>
					</div>
					<!-- <input class="hinhthuc_bds" type="hidden" name="hinhthuc_bds" value="Cho thuê"> -->
					<?php wp_nonce_field( 'post_nonce', 'post_nonce_field' ); ?>
				</form>                     
		 	</div>    
		</div>    
	</div>   
	        		
<?php }
function news_slidebar($post_page = '10') {
	$args = array(
	'post_type' => 'tin_tuc',
	'post_status' => 'publish',
	'posts_per_page' => $post_page, 
	);
	$the_query = new WP_Query($args );
	if ($the_query->have_posts() ) {
		$string = '<div class="news-right rounded overflow-hidden"><h3 class="title-slidebar px-1 py-2 text-center text-uppercase mb-0">Tin Tức</h3><div class="content p-2">';	
		$stt = 1;
		while ($the_query->have_posts() ) {
			$the_query->the_post();
			$content = get_the_content();
			$datePost= get_the_date();
			if($stt == 1) {
				if ( has_post_thumbnail() ) {		
					$string .= '<div class="row align-items-center">
	                  <div class="col-4 pr-0"><a href="' . get_the_permalink() .'"  title="' . get_the_title() .'">'.get_the_post_thumbnail(get_the_id(), 'thumbnail', array( 'class' => 'img-fluid','alt' => get_the_title(), 'loading'=> 'lazy' ) ).'</a></div>
	                  <div class="col-8"><a href="' . get_the_permalink() .'"  title="' . get_the_title() .'">'.get_the_title().'</a></div>
	                </div>';
				} 
			} else {
				if ( has_post_thumbnail() ) {		
					$string .= '<div class="row align-items-center">
	                  <div class="col-12"><div class="divide my-3 w-100"></div></div>
	                  <div class="col-4 pr-0"><a href="' . get_the_permalink() .'"  title="' . get_the_title() .'">'.get_the_post_thumbnail(get_the_id(), 'thumbnail', array( 'class' => 'img-fluid','alt' => get_the_title(), 'loading'=> 'lazy' ) ).'</a></div>
	                  <div class="col-8"><a href="' . get_the_permalink() .'"  title="' . get_the_title() .'">'.get_the_title().'</a></div>
	                </div>';
				} 
			}
			$stt++;
		}
		$string .= '</div></div>';
	}
	return $string;
	/* Restore original Post Data */
	wp_reset_postdata();
}

function news_home($post_page = '8') {
	$args = array(
	'post_type' => 'tin_tuc',
	'post_status' => 'publish',
	'posts_per_page' => $post_page, 
	);
	$the_query = new WP_Query($args);
	if ( $the_query->have_posts() ) {	
		while ( $the_query->have_posts() ) {
			$the_query->the_post();		
			if ( has_post_thumbnail() ) {
				echo'<div class="row"><div class="col-4 pr-0 my-2"><div class="news-home-inner h-100"><a class="post-media d-block" href="' . get_the_permalink() .'" title="' . get_the_title() .'" ><div class="img-wrap">' .get_the_post_thumbnail( get_the_id(), 'full', array( 'class' =>'img-fluid mx-auto d-block','alt' => get_the_title(), 'loading'=> 'lazy') ).'</div></a></div></div>
					<div class="col-8 my-2">
						<div class="news-home-inner h-100">
							<div class="post-content">
								<div class="text-capitalize title-item-post mb-0"><a href="' . get_the_permalink() .'" title="' . get_the_title() .'" >' .get_the_title() .'</a></div>
							</div>
						</div>
					</div>
				</div>';
			} 				
		}
	}
	/* Restore original Post Data */
	wp_reset_postdata();
}
function get_loai_bds($term_slug,$post_page) { 
	$term_slug_aray = explode(',', $term_slug);
	$args = array(
	'post_type' => 'post',
	'post_status' => 'publish',
	'posts_per_page' => $post_page, 
	'tax_query' => array(
	    array(
	    'taxonomy' => 'loaibds',
	    'field' => 'slug',
	    'terms' => $term_slug_aray
	    )
	)
	);
	$the_query = new WP_Query($args );
	if ($the_query->have_posts() ) {
		echo '<div class="row space-1">';	
		while ($the_query->have_posts() ) {
			$the_query->the_post();
			$dientich_post = get_post_meta(get_the_id(), 'dientich_post', true );
          	$gia_post = get_post_meta(get_the_id(), 'gia_post', true );
			$phongngu_post = get_post_meta(get_the_id(),'phongngu_post',true);	 
			$phongtam_post = get_post_meta(get_the_id(),'phongtam_post',true);     	
	      	$address_post = get_post_meta(get_the_id(), 'address_post', true );
			if ( has_post_thumbnail() ) {	
				if($post_page >= 7 ) {
					echo '<div class="col-6 col-md-3 col-lg-2 my-3">';
				} else {
					echo '<div class="col-6 col-md-4 my-3">';
				}
				echo '<div class="item-real box-real box-real-2 h-100">
                  	<a href="' . get_the_permalink() .'"  title="' . get_the_title() .'"><div class="post-media"><div class="img-wrap">'.get_the_post_thumbnail( get_the_id(), 'full', array( 'class' =>'img-fluid d-block mx-auto','alt' => get_the_title(),'loading' => 'lazy')).'</div></div></a>
              		<div class="p-2 p-sm-2">
                		<a href="' . get_the_permalink() .'"  title="' . get_the_title() .'"><h4 class="text-capitalize mb-2">'. get_the_title() .'</h4></a>   
	                	<div class="block-att d-flex flex-wrap align-items-center justify-content-between">';
							if($gia_post) {
				            	echo '<div class="listing-price mb-2">'.$gia_post.'</div>';
				            }
				            echo '<div class="listing-info d-flex flex-wrap align-items-center mb-2">';
				            	if($phongngu_post) {
					            	echo '<div class="mx-1"><i class="fa fa-bed mr-1" aria-hidden="true"></i>'.$phongngu_post.'</div>';
					            }
					            if($phongtam_post) {
					            	echo '<div class="mx-1"><i class="fa fa-bath mr-1" aria-hidden="true"></i>'.$phongtam_post.'</div>';
					            }
					            if($dientich_post) {
					            	echo '<div class="mx-1"><i class="fa fa-object-group mr-1" aria-hidden="true"></i>'.$dientich_post.'</div>';
					            }
					        echo '</div>';
						echo '</div>';
						echo '<div class="des-mute d-flex flex-nowrap align-items-center">';
							if($address_post) {
								echo '<i class="fa fa-map-marker mr-2" aria-hidden="true"></i><span class="text-capitalize">'.$address_post.'</span>';
							}				 
						echo'</div>';
					echo '</div>';   
				echo '</div>';   
			echo '</div>';                  	
			} 
		}
		echo '</div>';
	}
	/* Restore original Post Data */
	wp_reset_postdata(); ?>	
<?php }

function bds_noibat($posts_per_page) {
  $post = array(
    'post_status'   => 'publish',
    'post_type' => 'post', 
    'posts_per_page' => $posts_per_page,   
    'meta_query' => array(
		array(
			'key'     => 'check_special',
			'value'   => 'on',
			'compare' => 'IN',
		),
	),      
  );

  $getPost = new WP_Query($post );
  if($getPost->have_posts()) {  	
  	echo"<div class='row space-2'>";
	    while ($getPost->have_posts() ) : $getPost->the_post();
	      	$postid = get_the_ID();          
	      	//$loaitinrao_post = get_post_meta($postid, 'loaitinrao_post', true );
	      	$dientich_post = get_post_meta($postid, 'dientich_post', true );
	      	$dientich_post = trim($dientich_post);
	      	$phongtam_post = get_post_meta(get_the_id(),'phongtam_post',true);
					$phongngu_post = get_post_meta(get_the_id(),'phongngu_post',true);
	      	$gia_post = get_post_meta($postid, 'gia_post', true );
	      	$address_post = get_post_meta($postid, 'address_post', true );
					$donvi_price_post = get_post_meta( $postid, 'donvi_price_post', true );
					if($donvi_price_post) {
						$donvi_price_post = '/'.$donvi_price_post;
					}	      	
	        echo '<div class="col-6 col-md-4 col-lg-3 my-2 my-md-3"><div class="item-real box-real h-100"><a href="'.get_the_permalink().'" title="'.get_the_title().'">';
									if(get_post_thumbnail_id($postid)) {
										echo '<div class="post-media"><div class="img-wrap">'.get_the_post_thumbnail( get_the_id(), 'full', array( 'class' =>'img-fluid d-block mx-auto','alt' => get_the_title(),'loading' => 'lazy')).'</div></div>';
									} else {
											echo"<div class='bg-img img-wrap'><img src='".get_template_directory_uri()."/assets/images/logo.png' alt='".get_bloginfo( 'name' )."' class='img-fluid d-block mx-auto'></div>  ";
									}
							echo '</a>';
							echo '<div class="p-2 p-sm-2 p-md-2"><a class="d-block" href="' . get_the_permalink() .'"  title="' . get_the_title() .'"><h4 class="text-capitalize my-1">'. get_the_title() .'</h4></a><div class="block-att d-flex flex-wrap align-items-center justify-content-between">';
								if($gia_post) {
									echo '<div class="pr-1 my-1"><i class="fa fa-usd"></i> Giá: <span class="listing-price">'.price($gia_post).'</span><span class="text-lowercase">'.$donvi_price_post.'</span></div>';
								}
								echo '<div class="listing-info d-flex flex-wrap align-items-center">';
									if($phongngu_post) {
										echo '<div><i class="fa fa-bed mr-1 my-1" aria-hidden="true"></i>'.$phongngu_post.'</div>';
									}
									if($phongtam_post) {
										echo '<div><i class="fa fa-bath mr-1 my-1" aria-hidden="true"></i>'.$phongtam_post.'</div>';
									}
									if($dientich_post) {
										echo '<div><i class="fa fa-object-group mr-1 my-1" aria-hidden="true"></i>Diện tích: <strong>'.$dientich_post.'</strong></div>';
									}
								echo '</div>';
							echo '</div>';
						// echo '<div class="my-1 block-att"><i class="fa fa-calendar"></i>  '.get_the_time('d-m-Y').'</div>';
						echo '<div class="des-mute d-flex flex-nowrap mt-2">';
							if($address_post) {
								echo '<i class="fa fa-map-marker mr-1" aria-hidden="true"></i><span class="text-capitalize">'.$address_post.'</span>';
							}				 
						echo'</div>';
					echo '</div>';
				echo '</div>';
	        echo '</div>';
	    endwhile;
	    //Reset Post Data
    echo "</div>";
	echo '<div class="text-center mt-3 mt-md-4"><a title="Bất động sản nổi bật" href="'.get_bloginfo('url').'/bat-dong-san-noi-bat" class="txt-more px-3 py-2 font-weight-bold d-inline-block">Xem thêm <i class="ml-2 fa fa-chevron-right"></i></a></div>';
    wp_reset_postdata();
  } 
}

function register_info() {?>
	<div id="send-alert-modal" class="modal fade" role="dialog">
	  <div class="modal-dialog modal-lg modal-dialog-centered">
	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header text-left">
	        <h4 class="modal-title">Đăng ký để nhận được tin rao bất động sản mới và nhanh nhất</h4>
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	      </div>
	      <form action="" method="post" accept-charset="utf-8">
	        <div class="modal-body">
	          <div class="content-body p-3">
	            <p>Bạn vui lòng chọn các tiêu chí bên dưới và nhấn nút 'Đăng ký'. Hệ thống sẽ tự tìm kiếm các tin phù hợp với tiêu chí của bạn và gửi email thông báo cho bạn hàng ngày.</p>	            
	            <div class="row ">
	              <div class="col-12 col-sm-6 mb-3">
	                <select class="form-control" name="hinhthuc_bds">
	                  <option value="Cần bán">Cần bán</option>
	                  <option value="Cho thuê">Cho thuê</option>
	                </select>   
	              </div>
	              <div class="col-12 col-sm-6 mb-3">
	                <select class="form-control" name="loai_bds">
	                  <option value="">Loại BĐS</option>
	                  <?php
	                  	$terms = get_terms(array('taxonomy' => 'loaibds','hide_empty' => false,));                             
					    foreach($terms as $term){
					      echo"<option value='".$term->name."'>".$term->name."</option>";
					    }
	                  ?>
	                </select> 
	              </div>
	            </div>
	            <div class="row">
	              <div class="col-12 col-sm-6 mb-3">
	                <select class="form-control" name="city_post">
	                  <option value="">Tỉnh/Thành Phố</option>
	                  <option value="79">Hồ Chí Minh</option>
	                  <?php
	                  //  $tinh_thanhpho = get_thanhpho();
	                  // if(count($tinh_thanhpho) > 0):
	                  //   foreach ($tinh_thanhpho as $k => $v) {
	                  //     echo "<option ".selected($_POST['city_post'], $v['matp'] )."  value='".$v['matp']."'>".$v['name']."</option>";
	                  //   } 
	                  // endif;

	                  ?>
	                </select>                 
	              </div>
	              <div class="col-12 col-sm-6 mb-3">
	                <select class="form-control" name="quan_post">
			 			<option value="">Chọn Quận/Huyện</option>
		           		<?php $quanhuyen = get_address($_POST['city_post'],'0');

		           		if(count($quanhuyen) > 0):
		               		foreach ($quanhuyen as $k => $v) {
		               			echo "<option ".selected($_POST['quan_post'], $v['maqh'] )."  value='".$v['maqh']."'>".$v['qh']."</option>";
		               		}
		               	endif;?>
			 		</select>    
			 		       
	              </div>
	            </div>
	            <div class="row">
	              <div class="col-12 col-sm-6 mb-3">
	                <select class="form-control" name="xa_post">
			 			<option value="">Chọn Phường/Xã</option>
		           		<?php $xa = get_address($city_post,$quan_post,'0');
		           		if(count($xa) > 0):
		               		foreach ($xa as $k => $v) {
		               			echo "<option ".selected($xa_post, $v['xaid'] )."  value='".$v['xaid']."'>".$v['xa']."</option>";
		               		}
		               	endif;?>
			 		</select>
	              </div>
	              <div class="col-12 col-sm-6 mb-3">
	                <input type="text" class="form-control" placeholder="Đường/Phố" name="duong_pho">                
	              </div>
	            </div>
	            <div class="row">
	              <div class="col-12 col-sm-6 mb-3">
	                <select class="form-control" name="area_post">
	                  <option value="">Diện tích</option>
	                  <?php
	                  	$terms = get_terms(array('taxonomy' => 'area','hide_empty' => false,));                             
					    foreach($terms as $term){
					      echo"<option value='".$term->name."'>".$term->name."</option>";
					    }
	                  ?>
	                </select>
	              </div>
	              <div class="col-12 col-sm-6 mb-3">
	                <select class="form-control" name="pricebds_post">
	                  <option value="">Mức giá</option>
	                  <?php
	                  	$terms = get_terms(array('taxonomy' => 'pricebds','hide_empty' => false,));                             
					    foreach($terms as $term){
					      echo"<option value='".$term->name."'>".$term->name."</option>";
					    }
	                  ?>
	                </select>
	              </div>
	            </div>
	            <div class="row">
	              <div class="col-12 mb-3">
	                <textarea class="form-control" name="your_noidung" rows="3">Nhập vào nội dung của bạn ...</textarea>
	              </div>
	            </div>
	            <div class="row">
	              <div class="col-12 mb-3">
	                <input type="email" class="form-control" placeholder="Nhập email của bạn vào (*)" name="your_email">
	                <?php echo $error;?>
	              </div>
	            </div>
	          </div>
	        </div>
	        <div class="modal-footer justify-content-center">
	          <button type="submit" class="btn btn-submit btn-register px-5 py-2" name="dang_ky">Đăng Ký</button>
	           <?php wp_nonce_field( 'post_nonce', 'post_nonce_field' ); ?>
	        </div>
	      </form>
	    </div>

	  </div>
	</div>
<?php 
	if(isset($_POST['dang_ky'] ) && isset($_POST['post_nonce_field'] ) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce' )) {global $wpdb;
		$error = '';
		$email = trim($_POST['your_email']);
		$hinhthuc_bds = trim($_POST['hinhthuc_bds']);
		$loai_bds = trim($_POST['loai_bds']);
		$city_id = trim($_POST['city_post']);	
		$quan_id = trim($_POST['quan_post']);
		$xa_id = trim($_POST['xa_post']);	
		$tbl_city = "{$wpdb->prefix}tinh_thanhpho";
		$tbl_quan = "{$wpdb->prefix}quanhuyen";
		$tbl_xa = "{$wpdb->prefix}xaphuongthitran";

		$address_company = '';$phone_company = '';$mail_company = '';
		if(get_option('address_company') !='') {
			$address_company = get_option('address_company');
		}
		if(get_option('phone_company') !='') {
			$phone_company = get_option('phone_company');
		}
		if(get_option('hotline') !='') {
			$hotline = get_option('hotline');
		}
		if(get_option('mail_company') !='') {
			$mail_company = get_option('mail_company');
		}

		$citydb = $wpdb->get_row("SELECT matp,name FROM $tbl_city WHERE matp = $city_id", ARRAY_A);		
		$city_post = $citydb['name'];

		$quandb = $wpdb->get_row("SELECT maqh,name FROM $tbl_quan WHERE maqh = $quan_id", ARRAY_A);		
		$quan_post = $quandb['name'];

		$xadb = $wpdb->get_row("SELECT xaid,name FROM $tbl_xa WHERE xaid = $xa_id", ARRAY_A);		
		$xa_post = $xadb['name'];
		
		$duong_pho = trim($_POST['duong_pho']);
		$area_post = trim($_POST['area_post']);
		$pricebds_post = trim($_POST['pricebds_post']);
		$your_noidung = trim($_POST['your_noidung']);

		if(empty($email) && $email == '') {
			$error = '<div style="color:red">Bạn nhập Email của bạn để nhận thông tin phù hợp với tiêu chí của bạn!</div>';
		} else {
			$result = array('status' => 0);
			require(get_stylesheet_directory().'/PHPMailer-5.2.16/PHPMailerAutoload.php');

			$mail  = new PHPMailer();
			$body = "";		
			$mail->IsSMTP();
			$mail->CharSet = "UTF-8";
			// $mail->SMTPDebug  = 1;
			$mail->SMTPAuth   = true;
			$mail->Host       = "smtp.gmail.com";
			$mail->SMTPSecure = 'tsl';
			$mail->Port       = 587;
			$mail->Username   = "automails123@gmail.com";
			$mail->Password   = "Khongthequen89";
			$mail->SetFrom('admin@gmail.com');
			$mail->addAddress($email);
			$mail->addCC($mail_company);
			//$mail->addBCC('automails123@gmail.com');
			$mail->Subject    = "Nhận Thông Tin BĐS Theo Tiêu Chí Của Bạn - ".get_bloginfo( 'name' )."";
			$body.="<div style='background-color:#ffffff;color:#000000;font-family:Arial,Helvetica,sans-serif;font-size:15px;margin:0 auto;padding:0'>
			<table align='center' border='0' cellpadding='0' cellspacing='0' style='padding:0;border-spacing:0px;table-layout:fixed;border-collapse:collapse;font-family:Arial,Helvetica,sans-serif;background-color:#f5f5f5;'>
			<tbody>
			<tr>
				<td style='padding:0;margin:0;font-family:Arial,Helvetica,sans-serif;padding-left:40px' bgcolor='#e4e6ea'>

				</td>
			</tr>
			<tr>
				<td bgcolor='#f5f5f5' style='padding:0;margin:0;font-family:Arial,Helvetica,sans-serif'>
					<table border='0' cellpadding='0' cellspacing='0' width='688' align='center' style='padding:0;border-spacing:0px;table-layout:fixed;border-collapse:collapse;font-family:Arial,Helvetica,sans-serif'>
						<tbody>
						<tr>
							<td width='360' align='left' style='padding:0;margin:0;font-family:Arial,Helvetica,sans-serif;padding:10px 0 10px 10px'>
								<a href='".get_bloginfo( 'url' )."' style='text-decoration:none;font-family:Arial,Helvetica,sans-serif' target='_blank'>
									<img src='".get_template_directory_uri()."/assets/images/logo.png' style='border:0;max-width: 100%;height: auto' alt='".get_bloginfo( 'name' )."'>
								</a>
							</td>
							<td width='30' align='left' style='padding:0;margin:0;font-family:Arial,Helvetica,sans-serif'>
								<a href='".get_bloginfo( 'url' )."/gioi-thieu/' style='text-decoration:none;font-family:Arial,Helvetica,sans-serif' target='_blank'>
								</a>
							</td>
							<td width='90' align='left' style='padding:0;margin:0;font-family:Arial,Helvetica,sans-serif'><a href='".get_bloginfo( 'url' )."/gioi-thieu/' style='text-decoration:none;font-family:Arial,Helvetica,sans-serif;color:#333333;font-size:12px;line-height:20px;display:inline-block' target='_blank'>Về Chúng Tôi</a></td>
							<td width='30' align='left' style='padding:0;margin:0;font-family:Arial,Helvetica,sans-serif'>
								<a href='".get_bloginfo( 'url' )."/gioi-thieu/' style='text-decoration:none;font-family:Arial,Helvetica,sans-serif' target='_blank'>
								</a>
							</td>
							<td width='90' align='left' style='padding:0;margin:0;font-family:Arial,Helvetica,sans-serif'><a href='".get_bloginfo( 'url' )."/lien-he/' style='text-decoration:none;font-family:Arial,Helvetica,sans-serif;color:#333333;font-size:12px;line-height:20px;display:inline-block' target='_blank'>Liên Hệ</a></td>
						</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td style='padding:0;margin:0;font-family:Arial,Helvetica,sans-serif;padding-bottom: 30px'>
				<table align='center' border='0' cellpadding='0' cellspacing='0' width='600' style='border-collapse:collapse' bgcolor='#ffffff'>
					<tbody>
						<tr>
						<td bgcolor='#105aa6' width='100%' height='15px' valign='top'></td>
						</tr>
						<tr>
							<td>
								<table border='0' cellpadding='0' cellspacing='0' width='100%' bgcolor='#ffffff'>
									<tbody>
									<tr>
										<td style='background-color:#105aa6;width:16px;height:100%;padding:0;margin:0;line-height:0;border:none'></td>
										<td style='padding:0px 0 22px 0'>
											<table border='0' cellpadding='0' cellspacing='0' width='100%' style='padding:15px 0 0 0'>
												<tbody>
												<tr>
													<td style='padding:14px 10px 0 24px;font-family:Arial,Helvetica,sans-serif;font-size:15px;color:#666666;font-weight:bold'>Email <b>".$email."</b> đã đăng ký nhận các thông tin theo tiêu chí của bạn từ ".get_bloginfo( 'url' ).". Với những tiêu chí như sau:</td>
												</tr>
												<tr>
													<td style='padding:18px 10px 0 24px;font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#666666'>
													<table style='width:100%;border-collapse: collapse;margin-bottom:30px;'>
														<tbody>
															<tr>
																<td style='border:1px solid #ccc;padding:8px;'>Hình thức BĐS</td>
																<td style='border:1px solid #ccc;padding:8px;'>".$hinhthuc_bds."</td>
															</tr>
															<tr>
																<td style='border:1px solid #ccc;padding:8px;'>Loại BĐS</td>
																<td style='border:1px solid #ccc;padding:8px;'>".$loai_bds."</td>
															</tr>
															<tr>
																<td style='border:1px solid #ccc;padding:8px;'>Tình/Thành Phố</td>
																<td style='border:1px solid #ccc;padding:8px;'>".$city_post."</td>
															</tr>
															<tr>
																<td style='border:1px solid #ccc;padding:8px;'>Quận/Huyện</td>
																<td style='border:1px solid #ccc;padding:8px;'>".$quan_post."</td>
															</tr>
															<tr>
																<td style='border:1px solid #ccc;padding:8px;'>Đường/Xã</td>
																<td style='border:1px solid #ccc;padding:8px;'>".$xa_post."</td>
															</tr>
															<tr>
																<td style='border:1px solid #ccc;padding:8px;'>Đường/Phố</td>
																<td style='border:1px solid #ccc;padding:8px;'>".$duong_pho."</td>
															</tr>
															<tr>
																<td style='border:1px solid #ccc;padding:8px;'>Diện tích</td>
																<td style='border:1px solid #ccc;padding:8px;'>".$area_post."</td>
															</tr>
															<tr>
																<td style='border:1px solid #ccc;padding:8px;'>Mức Giá</td>
																<td style='border:1px solid #ccc;padding:8px;'>".$pricebds_post."</td>
															</tr>
															<tr>
																<td style='border:1px solid #ccc;padding:8px;'>Nội dung </td>
																<td style='border:1px solid #ccc;padding:8px;'>".$your_noidung."</td>
															</tr>
														</tbody>
													</table>
													</td>
												</tr>
																						
												<tr>
													<td style='padding:3px 10px 0 24px;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#666;margin-top:30px;'>► Email hỗ trợ: <a href='mailto:".$mail_company."' target='_blank' title='".$mail_company."'> <span style='color:#0388cd'>".$mail_company."</span></a> hoặc</td>
												</tr>
												<tr>
													<td style='padding:3px 10px 0 24px;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#666666'>► Tổng đài Chăm sóc khách hàng: <span style='font-weight:bold'>".$hotline."</span></td>
												</tr>
												<tr>
													<td style='padding:16px 10px 0 24px;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#666666'><span style='font-weight:bold'>".get_bloginfo( 'name' )."</span> trân trọng cảm ơn và rất hân hạnh được phục vụ Quý khách.</td>
												</tr>
												<tr>
													<td style='padding:12px 10px 0 24px;font-family:Arial,Helvetica,sans-serif;font-size:11px;color:#666666;font-style:italic'>*Quý khách vui lòng không trả lời email này*.</td>
												</tr>
												</tbody>
											</table>
										</td>
										<td style='background-color:#105aa6;width:16px;height:100%;padding:0;margin:0;line-height:0;border:none'></td>
									</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr>
							<td style='background-color:#105aa6;width:100%;height:15px'></td>
						</tr>
					</tbody>
				</table>
				</td>
			</tr>
			</tbody>
			</table>
			<table border='0' cellpadding='0' cellspacing='0' width='600' align='center' style='padding:0;border-spacing:0px;table-layout:fixed;border-collapse:collapse;font-family:Arial,Helvetica,sans-serif;'>
			<tbody>
				<tr>
				<td style='padding:0;margin:0;font-family:Arial,Helvetica,sans-serif;padding-bottom:20px'>
					<table border='0' cellpadding='0' cellspacing='0' width='100%' style='padding:0;border-spacing:0px;table-layout:fixed;border-collapse:collapse;font-family:Arial,Helvetica,sans-serif'>
					<tbody>
						<tr>
						<td style='margin:0;font-family:Arial,Helvetica,sans-serif;padding:20px 0'>
							<table border='0' cellpadding='0' cellspacing='0' width='100%' style='padding:0;border-spacing:0px;table-layout:fixed;border-collapse:collapse;font-family:Arial,Helvetica,sans-serif'>
							<tbody>
								<tr>
								<td style='padding:0;margin:0;font-family:Arial,Helvetica,sans-serif;color:#333333;font-size:15px;line-height:20px'><b>".get_bloginfo( 'name' )."</b></td>
								</tr>
								<tr>
								<td style='padding:0;margin:0;font-family:Arial,Helvetica,sans-serif;color:#333333;font-size:12px;line-height:20px'><b>Địa chỉ giao dịch:</b>&nbsp;".$address_company."</td>
								</tr>
								<tr>
								<td style='padding:0;margin:0;font-family:Arial,Helvetica,sans-serif;color:#333333;font-size:12px;line-height:20px'><b>Hotline:</b> ".$hotline." - Email: <b>".$mail_company."</b></td>
								</tr>				                   
							</tbody>
							</table>
						</td>
						</tr>
					</tbody>
					</table>
				</td>
				</tr>
			</tbody>
			</table>
			</div>";
			$mail->MsgHTML($body);	
			// if  update user return true then lets send user an email containing the new password

			if(!$mail->Send()) {
				echo "Mailer Error: " . $mail->ErrorInfo;
				$result['msg'] = 'There is an error, please check your input and try again';
				$result['debug'] = $mail->ErrorInfo;
			} else {
				$result['status'] = 1;
				echo "<script> window.alert('Thông tin của bạn đã gửi tới hệ thống của chúng tôi thành công.');</script>";
			}
		}
		
	}
}

function thongdiep() {
	$error = '';$error_ht='';
	$class_error = '';$class_error_ht = '';
	?>
	<form action="" method="post" accept-charset="utf-8">
		<div class="mb-2 text-center">
			<strong>Gởi Email cho người đăng tin</strong>
		</div>
	    <div class="form-group">
	      <input type="text" name="td_hoten" placeholder="Họ và tên  *" class="form-control <?php echo $class_error_ht;?>">
	      <?php echo $error_ht;?>
	    </div>
	    <div class="form-group">
	      <input type="email" name="td_email" placeholder="Email *" class="form-control <?php echo $error;?>">
	      <?php echo $error;?>
	    </div>
	    <div class="form-group">
	      <input type="tel" name="td_phone" placeholder="Điện thoại" class="form-control">
	    </div>
	    <div class="form-group">
	      <textarea rows="7" class="form-control" name="td_message" placeholder="Xin chào, tôi muốn biết thêm thông tin về bất động sản <?php echo get_the_title();?> Vui lòng liên hệ lại."></textarea>
	    </div>
	    <button type="submit" class="btn btn-submit text-uppercase mx-auto d-block w-100 py-2" name="btn_thongdiep">GỬI Liên Hệ</button>
	    <?php wp_nonce_field( 'post_nonce', 'post_nonce_field' ); ?>
	</form>
<?php 
	if(isset($_POST['btn_thongdiep'] ) && isset($_POST['post_nonce_field'] ) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce' )) {

		global $wpdb;		
		$td_email = trim($_POST['td_email']);
		$td_hoten = trim($_POST['td_hoten']);
		$td_phone = trim($_POST['td_phone']);
		$td_message = trim($_POST['td_message']);	

		$address_company = '609 Hoàng Sa, Phường 7, Quận 3, Thành Phố Hồ Chí Minh';$phone_company = '0912469102';$mail_company = 'thelighthomevn@gmail.com';
		if(get_option('address_company') !='') {
			$address_company = get_option('address_company');
		}
		if(get_option('phone_company') !='') {
			$phone_company = get_option('phone_company');
		}
		if(get_option('hotline') !='') {
			$hotline = get_option('hotline');
		}
		if(get_option('mail_company') !='') {
			$mail_company = get_option('mail_company');
		}

		if(empty($td_hoten) || $td_hoten == '') {
			$error_ht = '<div style="color:red">Bạn chưa nhập Họ và tên!</div>';
			$class_error_ht = 'border-red';
		} if(empty($td_email) || $td_email == '') {
			$error = '<div style="color:red">Bạn chưa nhập Email của bạn!</div>';
			$class_error = 'border-red';
		} 
		else {
			$result = array('status' => 0);
			require(get_stylesheet_directory().'/PHPMailer-5.2.16/PHPMailerAutoload.php');

			$mail  = new PHPMailer();
			$body = "";		
			$mail->IsSMTP();
			$mail->CharSet = "UTF-8";
			// $mail->SMTPDebug  = 1;
			$mail->SMTPAuth   = true;
			$mail->Host       = "smtp.gmail.com";
			$mail->SMTPSecure = 'tsl';
			$mail->Port       = 587;
			$mail->Username   = "automails123@gmail.com";
			$mail->Password   = "Khongthequen89";
			$mail->SetFrom('admin@gmail.com');
			$mail->addAddress($td_email);
			$mail->addCC($mail_company);
			//$mail->addBCC('automails123@gmail.com');
			$mail->Subject    = "Tìm Hiểu Thông Tin - ".get_bloginfo( 'url' )."";
			$body.="<div style='background-color:#ffffff;color:#000000;font-family:Arial,Helvetica,sans-serif;font-size:15px;margin:0 auto;padding:0'>
			<table align='center' border='0' cellpadding='0' cellspacing='0' style='padding:0;border-spacing:0px;table-layout:fixed;border-collapse:collapse;font-family:Arial,Helvetica,sans-serif;background-color:#f5f5f5;'>
			<tbody>
			<tr>
				<td style='padding:0;margin:0;font-family:Arial,Helvetica,sans-serif;padding-left:40px' bgcolor='#e4e6ea'>

				</td>
			</tr>
			<tr>
				<td bgcolor='#f5f5f5' style='padding:0;margin:0;font-family:Arial,Helvetica,sans-serif'>
					<table border='0' cellpadding='0' cellspacing='0' width='688' align='center' style='padding:0;border-spacing:0px;table-layout:fixed;border-collapse:collapse;font-family:Arial,Helvetica,sans-serif'>
						<tbody>
						<tr>
							<td width='360' align='left' style='padding:0;margin:0;font-family:Arial,Helvetica,sans-serif;padding:10px 0 10px 10px'>
								<a href='".get_bloginfo( 'url' )."' style='text-decoration:none;font-family:Arial,Helvetica,sans-serif' target='_blank'>
									<img src='".get_template_directory_uri()."/assets/images/logo.png' style='border:0;max-width: 100%;height: auto' alt='".get_bloginfo( 'name' )."'>
								</a>
							</td>
							<td width='30' align='left' style='padding:0;margin:0;font-family:Arial,Helvetica,sans-serif'>
								<a href='".get_bloginfo( 'url' )."/gioi-thieu/' style='text-decoration:none;font-family:Arial,Helvetica,sans-serif' target='_blank'>
								</a>
							</td>
							<td width='90' align='left' style='padding:0;margin:0;font-family:Arial,Helvetica,sans-serif'><a href='".get_bloginfo( 'url' )."/gioi-thieu/' style='text-decoration:none;font-family:Arial,Helvetica,sans-serif;color:#333333;font-size:12px;line-height:20px;display:inline-block' target='_blank'>Về Chúng Tôi</a></td>
							<td width='30' align='left' style='padding:0;margin:0;font-family:Arial,Helvetica,sans-serif'>
								<a href='".get_bloginfo( 'url' )."/gioi-thieu/' style='text-decoration:none;font-family:Arial,Helvetica,sans-serif' target='_blank'>
								</a>
							</td>
							<td width='90' align='left' style='padding:0;margin:0;font-family:Arial,Helvetica,sans-serif'><a href='".get_bloginfo( 'url' )."/lien-he/' style='text-decoration:none;font-family:Arial,Helvetica,sans-serif;color:#333333;font-size:12px;line-height:20px;display:inline-block' target='_blank'>Liên Hệ</a></td>
						</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td style='padding:0;margin:0;font-family:Arial,Helvetica,sans-serif;padding-bottom: 30px'>
				<table align='center' border='0' cellpadding='0' cellspacing='0' width='600' style='border-collapse:collapse' bgcolor='#ffffff'>
					<tbody>
						<tr>
						<td bgcolor='#105aa6' width='100%' height='15px' valign='top'></td>
						</tr>
						<tr>
							<td>
								<table border='0' cellpadding='0' cellspacing='0' width='100%' bgcolor='#ffffff'>
									<tbody>
									<tr>
										<td style='background-color:#105aa6;width:16px;height:100%;padding:0;margin:0;line-height:0;border:none'></td>
										<td style='padding:0px 0 22px 0'>
											<table border='0' cellpadding='0' cellspacing='0' width='100%' style='padding:15px 0 0 0'>
												<tbody>
												<tr>
													<td style='padding:14px 10px 0 24px;font-family:Arial,Helvetica,sans-serif;font-size:15px;color:#666666;font-weight:bold'>Email <b>".$td_email."</b> đã đăng ký cần tìm hiểu thông tin về bất động sản với tiêu đề <span style='color:red'>".get_the_archive_title()."</span> trên website ".get_bloginfo( 'url' )." với các thông tin như sau: </td>
												</tr>
												<tr>
													<td style='padding:18px 10px 0 24px;font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#666666'>
													<table style='width:100%;border-collapse: collapse;margin-bottom:30px;'>
														<tbody>
															<tr>
																<td style='border:1px solid #ccc;padding:8px;white-space: nowrap;'>Họ Và Tên</td>
																<td style='border:1px solid #ccc;padding:8px;'>".$td_hoten."</td>
															</tr>
															<tr>
																<td style='border:1px solid #ccc;padding:8px;white-space: nowrap;'>Số Điện Thoại</td>
																<td style='border:1px solid #ccc;padding:8px;'>".$td_phone."</td>
															</tr>
															<tr>
																<td style='border:1px solid #ccc;padding:8px;'>Email</td>
																<td style='border:1px solid #ccc;padding:8px;'>".$td_email."</td>
															</tr>
															<tr>
																<td style='border:1px solid #ccc;padding:8px;white-space: nowrap;'>Nội Dung</td>
																<td style='border:1px solid #ccc;padding:8px;'>".$td_message."</td>
															</tr>															
														</tbody>
													</table>
													</td>
												</tr>
																						
												<tr>
													<td style='padding:3px 10px 0 24px;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#666;margin-top:30px;'>► Email hỗ trợ: <a href='mailto:".$mail_company."' target='_blank' title='".$mail_company."'> <span style='color:#0388cd'>".$mail_company."</span></a> hoặc</td>
												</tr>
												<tr>
													<td style='padding:3px 10px 0 24px;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#666666'>► Tổng đài Chăm sóc khách hàng: <span style='font-weight:bold'>".$hotline."</span></td>
												</tr>
												<tr>
													<td style='padding:16px 10px 0 24px;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#666666'><span style='font-weight:bold'>".get_bloginfo( 'name' )."</span> trân trọng cảm ơn và rất hân hạnh được phục vụ Quý khách.</td>
												</tr>
												<tr>
													<td style='padding:12px 10px 0 24px;font-family:Arial,Helvetica,sans-serif;font-size:11px;color:#666666;font-style:italic'>*Quý khách vui lòng không trả lời email này*.</td>
												</tr>
												</tbody>
											</table>
										</td>
										<td style='background-color:#105aa6;width:16px;height:100%;padding:0;margin:0;line-height:0;border:none'></td>
									</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr>
							<td style='background-color:#105aa6;width:100%;height:15px'></td>
						</tr>
					</tbody>
				</table>
				</td>
			</tr>
			</tbody>
			</table>
			<table border='0' cellpadding='0' cellspacing='0' width='600' align='center' style='padding:0;border-spacing:0px;table-layout:fixed;border-collapse:collapse;font-family:Arial,Helvetica,sans-serif;'>
			<tbody>
				<tr>
				<td style='padding:0;margin:0;font-family:Arial,Helvetica,sans-serif;padding-bottom:20px'>
					<table border='0' cellpadding='0' cellspacing='0' width='100%' style='padding:0;border-spacing:0px;table-layout:fixed;border-collapse:collapse;font-family:Arial,Helvetica,sans-serif'>
					<tbody>
						<tr>
						<td style='margin:0;font-family:Arial,Helvetica,sans-serif;padding:20px 0'>
							<table border='0' cellpadding='0' cellspacing='0' width='100%' style='padding:0;border-spacing:0px;table-layout:fixed;border-collapse:collapse;font-family:Arial,Helvetica,sans-serif'>
							<tbody>
								<tr>
								<td style='padding:0;margin:0;font-family:Arial,Helvetica,sans-serif;color:#333333;font-size:15px;line-height:20px'><b>".get_bloginfo( 'name' )."</b></td>
								</tr>
								<tr>
								<td style='padding:0;margin:0;font-family:Arial,Helvetica,sans-serif;color:#333333;font-size:12px;line-height:20px'><b>Địa chỉ giao dịch:</b>&nbsp;".$address_company."</td>
								</tr>
								<tr>
								<td style='padding:0;margin:0;font-family:Arial,Helvetica,sans-serif;color:#333333;font-size:12px;line-height:20px'><b>Hotline:</b> ".$hotline." - Email: <b>".$mail_company."</b></td>
								</tr>				                   
							</tbody>
							</table>
						</td>
						</tr>
					</tbody>
					</table>
				</td>
				</tr>
			</tbody>
			</table>
			</div>";
			$mail->MsgHTML($body);	
			// if  update user return true then lets send user an email containing the new password

			if(!$mail->Send()) {
				echo "Mailer Error: " . $mail->ErrorInfo;
				$result['msg'] = 'There is an error, please check your input and try again';
				$result['debug'] = $mail->ErrorInfo;
			} else {
				$result['status'] = 1;
				echo "<script> window.alert('Thông tin của bạn đã gửi tới hệ thống của chúng tôi thành công.');</script>";
			}
		}
		
	}
}

function create_posttype_tintuc() {
	register_post_type( 'tin_tuc',  	
		array(
		  'labels' => array(
		    'name' => __( 'Tin Tức' ),
		    'singular_name' => __( 'Tin Tức' )
		  ),
		  'hierarchical' => true,
		  'show_ui' => true, 
		  'taxonomies' => array('post_tag'),
		  'public' => true,
		  'has_archive' => true,
		  'menu_position' => 5,
		  'can_export' => true,
		  'capability_type' => 'post',
		  'rewrite' => array('slug' => 'tin-tuc'),
		  'menu_icon' => 'dashicons-analytics', 
		  'supports' => array('title','editor','thumbnail','comments','excerpt', 'custom-fields','author','trackbacks','post-formats','revisions') 
		)
	);
	register_taxonomy( 'danh-muc-tin-tuc', array( 'tin_tuc' ),
		array(
			'labels' => array(
				'name' => 'Danh mục tin tức',
				'menu_name' => 'Danh mục tin tức',
				'singular_name' => 'Danh mục tin tức',
				'all_items' => 'Danh mục tin tức'
			),
			'public' => true,
			'hierarchical' => true,
			'show_ui' => true,
			'rewrite' => array( 'slug' => 'danh-muc-tin-tuc', 'hierarchical' => true, 'with_front' => false ),
		)
	);

}

add_action( 'init', 'create_posttype_tintuc' );
function get_custom_post_type_template_tintuc($single_template) {
	global $post;
	if ($post->post_type == 'tin_tuc') {
		$single_template = dirname( __FILE__ ) . '/single-tin_tuc.php';
	}
	return $single_template;
}
add_filter( 'single_template', 'get_custom_post_type_template_tintuc' );
flush_rewrite_rules(); 
function related_posts($post_page) {
	global $post;
	$categories = get_the_category($post->ID);
	if ($categories) {
		$category_ids = array();
		foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;
		$args=array(
			'category__in' => $category_ids,
			'post__not_in' => array($post->ID),
			'posts_per_page'=> $post_page, 
			'caller_get_posts'=>1
		);
		$my_query = new wp_query($args );
		if($my_query->have_posts() ) {			
			echo '<div class="related-post mt-4"><h2 class="text-uppercase">Bất Động Sản khác Liên Quan</h2><div class="row">';
			while($my_query->have_posts() ) {
				$my_query->the_post(); 
				$content = get_the_content();
				$dientich_post = get_post_meta(get_the_id(), 'dientich_post', true );
				$address_post = get_post_meta(get_the_id(), 'address_post', true );
	      $gia_post = get_post_meta(get_the_id(), 'gia_post', true );
				$content = get_the_content();
				$donvi_price_post = get_post_meta( get_the_id(), 'donvi_price_post', true );
				if($donvi_price_post) {
					$donvi_price_post = '/'.$donvi_price_post;
				}
				$phaply_post = get_post_meta(get_the_id(), 'phaply_post', true );
				$phongtam_post = get_post_meta(get_the_id(),'phongtam_post',true);
				$phongngu_post = get_post_meta(get_the_id(),'phongngu_post',true);
				$huongnha_post = get_post_meta(get_the_id(),'huongnha_post',true);	
				$huongbancong_post = get_post_meta(get_the_id(),'huongbancong_post',true);	
				$duongvao_post = get_post_meta(get_the_id(),'duongvao_post',true);	
				$mattien_post = get_post_meta(get_the_id(),'mattien_post',true);	
				$sotang_post = get_post_meta(get_the_id(),'sotang_post',true);	
				$noithat_post = get_post_meta(get_the_id(),'noithat_post',true);
				$tienichkemtheo_post = get_post_meta(get_the_id(),'tienichkemtheo_post',true);
				$dacdiemxahoi_post = get_post_meta(get_the_id(),'dacdiemxahoi_post',true);
				// $loai_bds = get_the_terms(get_the_id(), 'loaibds' );
				// $loaibds = $loai_bds[0]->name;	

				echo '<div class="col-12 col-md-3 my-3"><div class="row"><div class="col-4 col-md-12 pr-0 pr-md-3"><a href="' . get_the_permalink() .'"  title="' . get_the_title() .'"><div class="img-effect-1 mb-3"><div class="img-wrap rounded overflow-hidden">'.get_the_post_thumbnail( get_the_id(), 'full', array( 'class' =>'img-fluid','alt' => get_the_title(),'loading' => 'lazy')).'</div></div></a></div>
					<div class="col-8 col-md-12">
						<a href="' . get_the_permalink() .'"  title="' . get_the_title() .'"><h4 class="text-capitalize mb-2">'. get_the_title() .'</h4></a> 
						<div class="block-att d-flex flex-wrap align-items-center justify-content-between">';
							if($gia_post) {echo '<div><span class="listing-price">'.price($gia_post).'</span><span class="text-lowercase">'.$donvi_price_post.'</span></div>';}
							echo '<div class="listing-info d-flex flex-wrap align-items-center">';
								if($phongngu_post) {
									echo '<div class="mx-1"><i class="fa fa-bed mr-1" aria-hidden="true"></i>'.$phongngu_post.'</div>';
								}
								if($phongtam_post) {
									echo '<div class="mx-1"><i class="fa fa-bath mr-1" aria-hidden="true"></i>'.$phongtam_post.'</div>';
								}
								if($dientich_post) {
									echo '<div class="mx-1"><i class="fa fa-object-group mr-1" aria-hidden="true"></i>'.$dientich_post.'</div>';
								}
							echo '</div>';
						echo '</div>'; 
					echo '</div>';
					echo '</div>';
					echo '</div>';
				?>
			<?php }
			echo '</div></div>';
		}
	}
	wp_reset_query();
}
function related_taxomy_posts($post_page) {
	global $post;
	$taxonomies_curren_post = get_post_taxonomies($post->ID);
	$get_temr = get_the_terms($post->ID , $taxonomies_curren_post);
	$temr_id = $get_temr[0]->term_id;
	$taxomy_id = $get_temr[0]->taxonomy;
	$custom_taxterms = wp_get_object_terms($post->ID, $taxomy_id, array('fields' => 'ids') );
	// arguments
	$args = array(
	'post_type' => get_post_type($post->ID),
	'post_status' => 'publish',
	'posts_per_page' => $post_page, // you may edit this number
	'orderby' => 'rand',
	// 'tax_query' => array(
	//     array(
	//         'taxonomy' => $taxomy_id,
	//         'field' => 'id',
	//         'terms' => $custom_taxterms
	//     )
	// ),
	'post__not_in' => array ($post->ID),
	);
	$related_items = new WP_Query($args );
	// loop over query
	if ($related_items->have_posts()) :
		echo '<div class="related-post mt-4"><h2 class="text-uppercase">Bài viết khác Liên Quan</h2><div class="row grid-item grid-2 space-m">';
			while ($related_items->have_posts() ) : $related_items->the_post();
				echo '<div class="col-6 col-md-4 my-3"><a class="post-media mb-3 d-block" href="' . get_the_permalink() .'"  title="' . get_the_title() .'"><div class="img-wrap">'. get_the_post_thumbnail( get_the_id(), 'full', array( 'class' =>'img-fluid mx-auto d-block rounded','alt' => get_the_title(),'loading' => 'lazy') ) .'</div></a>
					<div class="post-content">
						<h3 class="text-capitalize"><a href="' . get_the_permalink() .'"  title="' . get_the_title() .'">'. get_the_title() .'</a></h3>   
					</div>
				</div>';
			endwhile;
		echo '</div></div>';
	endif;
	// Reset Post Data
	wp_reset_postdata();
}

function gallery_enqueue_hook($hook) { 
    if ( 'post.php' == $hook || 'post-new.php' == $hook ) { 
		wp_enqueue_media();
		wp_enqueue_script('jquery-addmin', get_template_directory_uri() . '/assets/js/jquery-addmin.min.js'); 		
		wp_enqueue_script('gallery-metabox', get_template_directory_uri() . '/assets/js/gallery-metabox.js'); 
		wp_enqueue_script('ajax-upload', get_template_directory_uri() . '/assets/js/ajax-upload.js'); 		
		wp_enqueue_style('gallery-metabox', get_template_directory_uri() . '/assets/css/gallery-metabox.css'); 
    } 
} 
add_action('admin_enqueue_scripts', 'gallery_enqueue_hook');
function add_gallery_metabox($post_type) {
	//$types = array('post','events','khoa_hoc','products');
	$types = array('post','congtrinh','duan','gallery');
	if (in_array($post_type, $types)) {
  		add_meta_box('gallery-metabox','Slider Hình Ảnh','gallery_meta_callback',$post_type,'normal','high');}  
	}
add_action('add_meta_boxes', 'add_gallery_metabox');

function gallery_meta_callback($post) {
   wp_nonce_field( basename(__FILE__), 'gallery_meta_nonce' );
   $ids = get_post_meta($post->ID, 'tdc_gallery_id', true);
?>
 <table class="form-table" id="gallery-metabox">
   <tr><td>
      <a class="gallery-add button" href="#" data-uploader-title="Thêm hình ảnh" data-uploader-button-text="Thêm nhiều hình ảnh">Thêm nhiều hình ảnh</a>
      <ul id="gallery-metabox-list">
        <?php if ($ids) : foreach ($ids as $key => $value) : $image = wp_get_attachment_image_src($value); ?>
        <li>
           <input type="hidden" name="tdc_gallery_id[<?php echo $key; ?>]" value="<?php echo $value; ?>">
           <img alt="<?php echo get_bloginfo( 'name' ); ?>" class="image-preview" src="<?php echo $image[0]; ?>">
           <a class="change-image button button-small" href="#" data-uploader-title="Đổi hình khác" data-uploader-button-text="Đổi hình khác">Đổi hình khác</a><br>
           <small><a class="remove-image" href="#">Xóa hình</a></small>
        </li>
        <?php endforeach; endif; ?>
     </ul>
  </td></tr>
 </table>
 <?php }

function gallery_meta_save($post_id) {
  if (!isset($_POST['gallery_meta_nonce']) || !wp_verify_nonce($_POST['gallery_meta_nonce'], basename(__FILE__))) return;
  if (!current_user_can('edit_post', $post_id)) return;
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

  if(isset($_POST['tdc_gallery_id'])) {
    update_post_meta($post_id, 'tdc_gallery_id', $_POST['tdc_gallery_id']);
  } else {
    delete_post_meta($post_id, 'tdc_gallery_id');
  }
 }
add_action('save_post', 'gallery_meta_save');

function my_upload_user_file_from_form($file = array() ) {
  require_once( ABSPATH . 'wp-admin/includes/admin.php' );
  $file_return = wp_handle_upload($file, array('test_form' => false ) );
  if( isset($file_return['error'] ) || isset($file_return['upload_error_handler'] ) ) {
    return false;
  } else {
    $filename = $file_return['file'];
    $attachment = array(
      'post_mime_type' => $file_return['type'],
      'post_title' => preg_replace( '/\.[^.]+$/', '', basename($filename ) ),
      'post_content' => '',
      'post_status' => 'inherit',
      'guid' => $file_return['url']
    );
    $attachment_id = wp_insert_attachment($attachment, $file_return['url'] );
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    $attachment_data = wp_generate_attachment_metadata($attachment_id, $filename );
    wp_update_attachment_metadata($attachment_id, $attachment_data );

    if( 0 < intval($attachment_id ) ) {
      return $attachment_id;
    }
  }
  return false;
}
function upload_imgs_gallerry($fileinput, $post_id) {
	require_once( ABSPATH . 'wp-admin/includes/image.php' );
    require_once( ABSPATH . 'wp-admin/includes/file.php' );
    require_once( ABSPATH . 'wp-admin/includes/media.php' );
	$saveId = array();
    foreach ($fileinput['name'] as $key => $value) {
        if ($fileinput['name'][$key]) {
            $file = array(
                'name' => $fileinput['name'][$key],
                'type' => $fileinput['type'][$key],
                'tmp_name' => $fileinput['tmp_name'][$key],
                'error' => $fileinput['error'][$key],
                'size' => $fileinput['size'][$key]
            );
            $_FILES = array("upload_file" => $file);

						// var_dump($file[ư]); exit();

            $attachment_id_gallery = media_handle_upload("upload_file", $post_id);
            if (is_wp_error($attachment_id_gallery)) {
                // There was an error uploading the image.
                echo "Error adding file";

            } else {
                // The image was uploaded successfully!
                //echo wp_get_attachment_image($attachment_id_gallery, array(800, 600)) . "<br>";
                // $arr = sanitize_text_field($attachment_id_gallery);
                // add_post_meta($post_id, 'tdc_gallery_id', $arr);
                // array_push($saveId, $attachment_id_gallery);
                $arr = sanitize_text_field($attachment_id_gallery);               
                array_push($saveId, $attachment_id_gallery);
            }
        }
    }

    $old_id = get_post_meta($post_id, 'tdc_gallery_id', true);
    $sumID = array();
    if($old_id) {
	    $sumID = array_merge($old_id,$saveId);
    } else {
    	$sumID = $saveId;
    }    
    update_post_meta($post_id, 'tdc_gallery_id', $sumID);
}

function share_social() { ?>
	<div class="action-post d-flex flex-wrap align-items-center justify-content-center my-3">
		<div class="item-g btn-goback mr-1 mr-md-3 mb-3"><a title="Quay lại" rel="nofollow" href="javascript:window.history.back(-1);"><i class="fa fa-reply-all mr-1" aria-hidden="true"></i>Quay lại</a></div>
        <div class="item-g print mr-1 mr-md-3 mb-3"><a title="In bài này" onclick="javascript:window.print();" rel="nofollow" href="javascript:void(0)"><i class="fa fa-print mr-1" aria-hidden="true"></i>In bài này</a></div>
        <div class="item-g mr-1 mr-md-3 mb-3">Chia sẻ trên:</div>
        <div class="share-social d-flex flex-wrap align-items-center justify-content-center">
            <a class="mr-2 fb mb-3" title="Chia sẻ trên Facebook" href="http://www.facebook.com/sharer/sharer.php?s=100&p[url]=<?php echo urlencode(get_permalink()); ?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
            <a class="mr-2 gg mb-3" title="Chia sẻ trên Google plus +" href="https://plus.google.com/share?url=<?php echo urlencode(get_permalink()); ?>" target="_blank"><i class="fa fa-google" aria-hidden="true"></i></a>
            <a class="mr-2 twinter mb-3" title="Chia sẻ trên Twinter" href="https://twitter.com/intent/tweet?text=<?php echo urlencode(get_the_title()); ?>+<?php echo get_permalink(); ?>" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
            <a class="mr-2 pinterest mb-3" title="Chia sẻ trên Pinterest" href="https://www.pinterest.com/pin/create/link/?url=<?php echo urlencode(get_permalink()); ?>&media=<?php echo the_post_thumbnail_url('large'); ?>&description=<?php echo get_the_title(get_the_ID()); ?>" target="_blank"><i class="fa fa-pinterest"></i></a>
            <a class="mr-2 linkedin mb-3" title="Chia sẻ trên Linkedin" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(get_permalink()); ?>&title=<?php echo get_the_title(get_the_ID()); ?>&source=<?php echo site_url();?>" target="_blank"><i class="fa fa-linkedin"></i></a>			    
        </div>
    </div>
<?php }
function contactForm() {
	 $success = '';  $errcaptacha = ''; 
	if(isset($_POST['btn-send']) ) { 
		$address_company = '609 Hoàng Sa, Phường 7, Quận 3, Thành Phố Hồ Chí Minh';$phone_company = '0912469102';$mail_company = 'thelighthomevn@gmail.com';
		if(get_option('address_company') !='') {
			$address_company = get_option('address_company');
		}
		if(get_option('phone_company') !='') {
			$phone_company = get_option('phone_company');
		}
		
		if(get_option('hotline') !='') {
			$hotline = get_option('hotline');
		}
		if(get_option('mail_company') !='') {
			$mail_company = get_option('mail_company');
		}
		if(isset($_POST['g-recaptcha-response'])){  
	      $tut_captcha=$_POST['g-recaptcha-response'];
	    } 
	    if(!$tut_captcha){
	      $errcaptacha = '<div class="text-danger">Bạn chưa xác thực reCAPTCHA!.</div>';
	    }  
	    $kiemtra=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LfPR9EZAAAAACw7omi7Jd7NLs0BcJ3LvRm9G77z&response=".$tut_captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
	    
	    $kiemtra = json_decode($kiemtra);
	    
	    if($kiemtra->success == false) {
	      $errcaptacha = 'Bạn đã nhập sai mã Captcha ?';
	      echo '<script> window.alert("Bạn chưa chọn Captcha ?");
						window.location = "'.get_bloginfo( 'url' ).'/lien-he"</script>';	
	      die();
	    } else {
	    	$email = trim($_POST['your-email']);
			$yourName = trim($_POST['your-name']);
			$yourTel = trim($_POST['your-tel']);
			$diachi = trim($_POST['diachi']);
			$yourMessage = trim($_POST['your-message']);
			$result = array('status' => 0);
			require(get_stylesheet_directory().'/PHPMailer-5.2.16/PHPMailerAutoload.php');

			$mail  = new PHPMailer();
			$body = "";		
			$mail->IsSMTP();
			$mail->CharSet = "UTF-8";
			$mail->SMTPDebug  = 2;
			$mail->SMTPAuth   = true;
			$mail->Host       = "smtp.gmail.com";
			$mail->SMTPSecure = 'tls';
			$mail->Port       = 587;
			$mail->Username   = "automails123@gmail.com";
			$mail->Password   = "Khongthequen89";
			$mail->SetFrom('admin@gmail.com');
			$mail->addAddress($mail_company);
			$mail->addCC($email,'automails123@gmail.com');
			// $mail->addBCC('automails123@gmail.com');
			$mail->Subject    = "Nội Dung Liên Hệ Từ - ".get_bloginfo( 'name' )." - ".get_bloginfo('url')."";
			$body.="<div style='background-color:#ffffff;color:#000000;font-family:Arial,Helvetica,sans-serif;font-size:15px;margin:0 auto;padding:0'>
			<table align='center' border='0' cellpadding='0' cellspacing='0' style='padding:0;border-spacing:0px;table-layout:fixed;border-collapse:collapse;font-family:Arial,Helvetica,sans-serif;background-color:#f5f5f5;'>
			<tbody><tr><td style='padding:0;margin:0;font-family:Arial,Helvetica,sans-serif;padding-left:40px' bgcolor='#e4e6ea'></td></tr><tr>
				<td bgcolor='#f5f5f5' style='padding:0;margin:0;font-family:Arial,Helvetica,sans-serif'>
					<table border='0' cellpadding='0' cellspacing='0' width='688' align='center' style='padding:0;border-spacing:0px;table-layout:fixed;border-collapse:collapse;font-family:Arial,Helvetica,sans-serif'>
						<tbody>
						<tr>
							<td width='360' align='left' style='padding:0;margin:0;font-family:Arial,Helvetica,sans-serif;padding:10px 0 10px 10px'>
								<a href='".get_bloginfo( 'url' )."' style='text-decoration:none;font-family:Arial,Helvetica,sans-serif' target='_blank'>
									<img src='".get_template_directory_uri()."/assets/images/logo.png' style='border:0;max-width: 100%;height: auto' alt='".get_bloginfo( 'name' )."'></a>
							</td>
							<td width='30' align='left' style='padding:0;margin:0;font-family:Arial,Helvetica,sans-serif'></td>
							<td width='90' align='left' style='padding:0;margin:0;font-family:Arial,Helvetica,sans-serif'><a href='".get_bloginfo( 'url' )."/gioi-thieu' style='text-decoration:none;font-family:Arial,Helvetica,sans-serif;color:#333333;font-size:12px;line-height:20px;display:inline-block' target='_blank'>Về Chúng Tôi</a></td>
							<td width='30' align='left' style='padding:0;margin:0;font-family:Arial,Helvetica,sans-serif'></td>
							<td width='90' align='left' style='padding:0;margin:0;font-family:Arial,Helvetica,sans-serif'><a href='".get_bloginfo( 'url' )."/lien-he' style='text-decoration:none;font-family:Arial,Helvetica,sans-serif;color:#333333;font-size:12px;line-height:20px;display:inline-block' target='_blank'>Liên Hệ</a></td>
						</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td style='padding:0;margin:0;font-family:Arial,Helvetica,sans-serif;padding-bottom: 30px'>
				<table align='center' border='0' cellpadding='0' cellspacing='0' width='600' style='border-collapse:collapse' bgcolor='#ffffff'>
					<tbody>
						<tr>
						<td bgcolor='#105aa6' width='100%' height='15px' valign='top'></td>
						</tr>
						<tr>
							<td>
								<table border='0' cellpadding='0' cellspacing='0' width='100%' bgcolor='#ffffff'>
									<tbody>
									<tr>
										<td style='background-color:#105aa6;width:16px;height:100%;padding:0;margin:0;line-height:0;border:none'></td>
										<td style='padding:0px 0 22px 0'>
											<table border='0' cellpadding='0' cellspacing='0' width='100%' style='padding:15px 0 0 0'>
												<tbody>
												<tr>
													<td style='padding:14px 10px 0 24px;font-family:Arial,Helvetica,sans-serif;font-size:15px;color:#1a7138'><b>Nội Dung Liên Hệ</b></td>
												</tr>
												<tr>
													<td style='padding:18px 10px 0 24px;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#666666'>Cảm ơn quý khách ".$yourName." đã gửi nội dung sau tới ".get_bloginfo( 'name' ).":</td>
												</tr>
												<tr>
													<td style='padding:18px 10px 0 24px;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#666666'>
													<div style='background-color: #eee;border:2px solid #f50; padding:20px;margin-bottom:15px'>
														<div style='margin-bottom:10px;'>Tên khách hàng: <b>".$yourName."</b></div>
														<div style='margin-bottom:10px;'>Email khách hàng: <b>".$email."</b></div>
														<div style='margin-bottom:10px;'>Địa chỉ: <b>".$diachi."</b></div>
														<div>Nội dung: <b>".$yourMessage."</b></div>
													</div>
													</td>
												</tr>
																						
												<tr>
													<td style='padding:3px 10px 0 24px;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#666;margin-top:30px;'>► Email hỗ trợ: <a href='mailto:".$mail_company."' target='_blank'> <span style='color:#0388cd'>".$mail_company."</span></a> hoặc</td>
												</tr>
												<tr>
													<td style='padding:3px 10px 0 24px;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#666666'>► Tổng đài Chăm sóc khách hàng: <span style='font-weight:bold'>".$phone_company." </span></td>
												</tr>
												<tr>
													<td style='padding:16px 10px 0 24px;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#666666'><span style='font-weight:bold'>".get_bloginfo( 'name' )."</span> trân trọng cảm ơn và rất hân hạnh được phục vụ Quý khách.</td>
												</tr>
												<tr>
													<td style='padding:12px 10px 0 24px;font-family:Arial,Helvetica,sans-serif;font-size:11px;color:#666666;font-style:italic'>*Quý khách vui lòng không trả lời email này*.</td>
												</tr>
												</tbody>
											</table>
										</td>
										<td style='background-color:#105aa6;width:16px;height:100%;padding:0;margin:0;line-height:0;border:none'></td>
									</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr>
							<td style='background-color:#105aa6;width:100%;height:15px'></td>
						</tr>
					</tbody>
				</table>
				</td>
			</tr>
			</tbody>
			</table>
			<table border='0' cellpadding='0' cellspacing='0' width='600' align='center' style='padding:0;border-spacing:0px;table-layout:fixed;border-collapse:collapse;font-family:Arial,Helvetica,sans-serif;'>
			<tbody>
				<tr>
				<td style='padding:0;margin:0;font-family:Arial,Helvetica,sans-serif;padding-bottom:20px'>
					<table border='0' cellpadding='0' cellspacing='0' width='100%' style='padding:0;border-spacing:0px;table-layout:fixed;border-collapse:collapse;font-family:Arial,Helvetica,sans-serif'>
					<tbody>
						<tr>
						<td style='margin:0;font-family:Arial,Helvetica,sans-serif;padding:20px 0'>
							<table border='0' cellpadding='0' cellspacing='0' width='100%' style='padding:0;border-spacing:0px;table-layout:fixed;border-collapse:collapse;font-family:Arial,Helvetica,sans-serif'>
							<tbody>
								<tr>
								<td style='padding:0;margin:0;font-family:Arial,Helvetica,sans-serif;color:#333333;font-size:15px;line-height:20px'><b>".get_bloginfo( 'name' )."</b></td>
								</tr>
								<tr>
								<td style='padding:0;margin:0;font-family:Arial,Helvetica,sans-serif;color:#333333;font-size:12px;line-height:20px'><b>Địa chỉ giao dịch: </b>".$address_company."</td>
								</tr>
								<tr>
								<td style='padding:0;margin:0;font-family:Arial,Helvetica,sans-serif;color:#333333;font-size:12px;line-height:20px'><b>Hotline:</b> ".$phone_company." - Email: <b>".$mail_company."</b></td>
								</tr>				                   
							</tbody>
							</table>
						</td>
						</tr>
					</tbody>
					</table>
				</td>
				</tr>
			</tbody>
			</table>
			</div>";
			$mail->MsgHTML($body);	
			// if  update user return true then lets send user an email containing the new password

			if(!$mail->Send()) {
				echo "Mailer Error: " . $mail->ErrorInfo;
				$result['msg'] = 'There is an error, please check your input and try again';
				$result['debug'] = $mail->ErrorInfo;
			} else {
				$result['status'] = 1;
				echo '<script> window.alert("Cảm ơn Quý Khách đã gửi nội dung liên hệ tới '.get_bloginfo( 'name' ).'. '.get_bloginfo( 'name' ).' sẽ sớm phản hồi lại Quý khách hàng.");
					window.location = "'.get_bloginfo( 'url' ).'"</script>';	
			}
	    }
		
	} ?>
	    <form action="" method="post" accept-charset="utf-8">                                
	      <div class="row">
	          <div class="col-lg-6 my-2"><label class="mb-0">Họ và tên *</label><input type="text" name="your-name" class="form-control" required=""></div>
	          <div class="col-lg-6 my-2"><label class="mb-0">Email *</label><input type="email" name="your-email" required="" class="form-control"></div>
	      </div>
	      <div class="row ">
	          <div class="col-lg-6 my-2"><label class="mb-0">Số điện thoại </label><input type="tel" name="your-tel" class="form-control"></div>
	          <div class="col-lg-6 my-2"><label class="mb-0">Địa chỉ </label><input type="text" name="diachi" class="form-control"></div>
	      </div>
	      <div class="row ">
	          <div class="col-sm-12 my-2"><label class="mb-0">Nội dung </label><textarea name="your-message" cols="40" rows="4" class="form-control"></textarea></div>
	      </div>
	      <div class=" g-recaptcha-block row align-items-center">
	      	<div class="col-12 col-lg-8 my-2">
            	<div class="g-recaptcha" data-sitekey="6LfPR9EZAAAAAJ0e7Ypy2pR6NUV9td8ZW_xoa400"></div>
            </div>
            <div class="col-12 col-lg-4 text-center text-lg-right my-2">
            	<input type="submit" value="Gửi yêu cầu" class="btn btn-read-more text-capitalize px-5 px-sm-3 py-2 ml-sm-auto" name="btn-send">
            </div>
          </div>
          <div class="form-group text-danger mb-0">
            <?php
              echo $errcaptacha;
            ?>
          </div>
	  	</form>
	<?php 		
}

function slideshow_register() {
    register_post_type( 'slideshow',  	
		array(
		  'labels' => array(
		    'name' => __( 'Slider show' ),
		    'singular_name' => __( 'Slider show' )
		  ),
		  'hierarchical' => true,
		  'show_ui' => true, 
		  'taxonomies' => array('post_tag'),
		  'public' => true,
		  'has_archive' => true,
		  'menu_position' => 4,
		  'can_export' => true,
		  'capability_type' => 'post',
		  'rewrite' => array('slug' => 'slideshow'),
		  'menu_icon' => 'dashicons-camera', 
        'supports' => array('title','thumbnail'),
		)
	);
	register_taxonomy( 'slider-location', array( 'slideshow' ),
		array(
			'labels' => array(
				'name' => 'Slider Location',
				'menu_name' => 'Slider Location',
				'singular_name' => 'Slider Location',
				'all_items' => 'Slider Location'
			),
			'public' => true,
			'hierarchical' => true,
			'show_ui' => true,
			'rewrite' => array( 'slug' => 'slider-location', 'hierarchical' => true, 'with_front' => false ),
		)
	);

}
add_action('init', 'slideshow_register');
add_action("admin_init", "admin_init");
function admin_init(){
  add_meta_box("url-meta", "Slider Options", "url_meta", "slideshow", "side", "low");
}
function url_meta(){
  global $post;
  $custom = get_post_custom($post->ID);
  $url = $custom["url"][0];
  $url_open = $custom["url_open"][0];
  ?>
  <label>URL:</label>
  <input name="url" value="<?php echo $url; ?>" />
  <input type="checkbox" name="url_open"<?php if($url_open == "on"): echo " checked"; endif ?>>URL open in new window?<br />
  <?php
}

add_action('save_post', 'save_details');
function save_details(){
  global $post;

  if( $post->post_type == "slideshow" ) {
      if(!isset($_POST["url"])):
         return $post;
      endif;
      if($_POST["url_open"] == "on") {
        $url_open_checked = "on";
      } else {
        $url_open_checked = "off";
      }
      update_post_meta($post->ID, "url", $_POST["url"]);
      update_post_meta($post->ID, "url_open", $url_open_checked);
  }
}
function banner_meta_box() {
	add_meta_box( 'banner-info', 'Thông tin banner', 'banner_output', 'slideshow' );
}
add_action( 'add_meta_boxes', 'banner_meta_box' );

function banner_output($post) {
	$des_banner = get_post_meta($post->ID,'des_banner',true);
	wp_nonce_field( 'save_banner', 'banner_nonce' );?>
	<p>
		<label for="des_banner">Description: </label><br>
		<input type="text" style="height:38px;width: 100%" id="des_banner" name="des_banner" value="<?php echo esc_attr($des_banner); ?>"/>
 	</p>	
<?php }
function banner_save($post_id) {
	$banner_nonce = $_POST['banner_nonce'];
	if( !isset($banner_nonce ) ) { return; }
	// Kiểm tra nếu giá trị nonce không trùng khớp
	if( !wp_verify_nonce($banner_nonce, 'save_banner' ) ) { return; }
	$des_banner = sanitize_text_field($_POST['des_banner'] );	
	update_post_meta($post_id, 'des_banner', $des_banner);
}
add_action( 'save_post', 'banner_save' );


function getSliderBanner($post_page = '-1') {  
  	$args = array(
    'post_type' => 'slideshow',
    'orderby' => 'date',
    'order' => 'ASC',
    'posts_per_page' => $post_page,
        // 'tax_query' => array(
        //     array(
        //         'taxonomy' => 'slider-location',
        //         'field' => 'slug',
        //         'terms' => 'homeslide-vi',//tên ở trong homslide
        //         'operator' => 'IN'
        //     )
        //  )
    );
    $listbanner = new WP_Query($args); 
    if ($listbanner->have_posts()) {
		while ($listbanner->have_posts() ) : $listbanner->the_post();
			$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );	
			$des_banner = get_post_meta(get_the_ID(), 'des_banner', true );
			$custom = get_post_custom(get_the_ID());
		    $url = $custom["url"][0]; 
		    $url_open = $custom["url_open"][0];
		    $custom_title = "#".get_the_ID(); 
		    ?>
		    <div class="item"><img loading="lazy" class="img-fluid mx-auto d-block" src="<?php echo $thumb['0']; ?>" alt="<?php echo get_the_title(); ?>"></div>
		    <?php ?>
		<?php endwhile;
	}
	wp_reset_query(); 
}

// chuyển đổi tiền thành dạng thu gọn
function price( $num = false ) {
	$str = '';
	$num  = trim($num);
	$num = (double) $num;
	if($num < 100000) {
		$str = '0 đồng';
	} else if($num < 1000000) {
		$str = round($num/100000, 1) . ' trăm';
	} else if($num < 1000000000) {
		$str = round($num/1000000, 1) . ' triệu';
	} else {
		$str = round($num/1000000000, 1) . ' tỷ';
	} 
	// $str = '';
	// $num  = trim($num);
	// $arr = str_split($num);
	// $count = count( $arr );
	// $f = number_format($num);
	// if ( $count < 7 ) {
	// 		$str = $num;
	// } else {
	// 		$r = explode(',', $f);
	// 		switch ( count ( $r ) ) {
	// 				case 4:
	// 						$str = $r[0] . ' tỉ';
	// 						if ( (int) $r[1] ) { $str .= ' '. $r[1] . ' Tr'; }
	// 				break;
	// 				case 3:
	// 						$str = $r[0] . ' Triệu';
	// 						if ( (int) $r[1] ) { $str .= ' '. $r[1] . 'K'; }
	// 				break;
	// 		}
	// }
	return ( $str);
}

add_action('wp_ajax_priceMax_action', 'priceMax_action');
add_action('wp_ajax_nopriv_priceMax_action', 'priceMax_action');
function priceMax_action() {
	global $wpdb;
	$result = '';
	$price_max = $_POST['price_max'];
	if($price_max != ''){
		$result =	price($price_max);
	}
	die($result);
}

add_action('wp_ajax_priceMin_action', 'priceMin_action');
add_action('wp_ajax_nopriv_priceMin_action', 'priceMin_action');
function priceMin_action() {
	global $wpdb;
	$result = '';
	$price_min = $_POST['price_min'];
	if($price_min != ''){
		$result =	price($price_min);
	}
	die($result);
}
