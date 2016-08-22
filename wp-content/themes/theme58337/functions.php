<?php
/**
 * Child Theme functions and configurations.
 *
 * @package    theme58337
 * @subpackage Functions
 * @since      1.0.0
 */

// Optinization and improvements for a third-party plugins.
require_once( get_stylesheet_directory() . '/init/config/third-party-plugins.php' );

/**
 * Cherry Wizard and Cherry Data Manager add-ons.
 */

// Assign register plugins function to appropriate filter.
add_filter( 'cherry_theme_required_plugins',     'cherry_child_register_plugins' );

// Assign options filter to apropriate filter.
add_filter( 'cherry_data_manager_export_options', 'cherry_child_options_to_export' );

// Assign option id's filter to apropriate filter.
add_filter( 'cherry_data_manager_options_ids',    'cherry_child_options_ids' );

// Assign cherry_child_menu_meta to aproprite filter.
add_filter( 'cherry_data_manager_menu_meta',      'cherry_child_menu_meta' );

// Customize a cherry shortcodes.
add_filter( 'custom_cherry4_shortcodes',          '__return_true' );


/**
 * Get ristered plugins array for curent theme.
 *
 * @return array
 */	 
function cherry_child_get_rigestered_plugins() {

	return array(
		'contact-form-7' => array(
			'name'     => __( 'Contact Form 7', 'child-theme-domain' ),
			'required' => false,
		),
		'cherry-shortcodes' => array(
			'name'     => __( 'Cherry Shortcodes', 'child-theme-domain' ),
			'source'   => 'cherry-free',
			'required' => false,
		),
		'cherry-services' => array(
			'name'     => __( 'Cherry Services', 'child-theme-domain' ),
			'source'   => 'cherry-free',
			'required' => false,
		),
		'cherry-shortcodes-templater' => array(
			'name'     => __( 'Cherry Shortcodes Templater', 'child-theme-domain' ),
			'source'   => 'cherry-free',
			'required' => false,
		),
		'cherry-portfolio' => array(
			'name'     => __( 'Cherry Portfolio', 'child-theme-domain' ),
			'source'   => 'cherry-free',
			'required' => false,
		),
		'cherry-testimonials' => array(
			'name'     => __( 'Cherry Testimonials', 'child-theme-domain' ),
			'source'   => 'cherry-free',
			'required' => false,
		),
		'cherry-team' => array(
			'name'     => __( 'Cherry Team', 'child-theme-domain' ),
			'source'   => 'cherry-free',
			'required' => false,
		),
		'cherry-social' => array(
			'name'     => __( 'Cherry Social', 'child-theme-domain' ),
			'source'   => 'cherry-free',
			'required' => false,
		),
		'cherry-mega-menu' => array(
			'name'     => __( 'Cherry Mega Menu', 'child-theme-domain' ),
			'source'   => 'cherry-free',
			'required' => false,
		),
		'motopress-cherryframework4' => array(
			'name'     => __( 'MotoPress and CherryFramework 4 Integration', 'child-theme-domain' ),
			'source'   => 'cherry-free',
			'required' => false,
		),
		'motopress-content-editor' => array(
			'name'       => __( 'MotoPress Content Editor', 'child-theme-domain' ),
			'source'     => 'cherry-premium',
			'source_alt' => CHILD_DIR . '/assets/includes/plugins/motopress-content-editor.zip',
			'required'   => false,
		),
		'motopress-slider' => array(
			'name'       => __( 'MotoPress Slider', 'child-theme-domain' ),
			'source'     => 'cherry-premium',
			'source_alt' => CHILD_DIR . '/assets/includes/plugins/motopress-slider.zip',
			'required'   => false,
		),
	);
}

/**
 * Register required plugins for theme.
 *
 * Plugins registered by this function will be automatically installed by Cherry Wizard.
 *
 * Notes:
 * - Slug parameter must be the same with plugin key in array
 * - Source parameter supports 3 possible values:
 *   a) cherry    - plugin will be downloaded from cherry plugins repository
 *   b) wordpress - plugin will be downloaded from wordpress.org repository
 *   c) path      - plugin will be downloaded by provided path
 *
 * @param  array $plugins Default array of required plugins (empty).
 * @return array          New array of required plugins.
 */
function cherry_child_register_plugins( $plugins ) {
	$prepared_plugins = array();
	$plugins          = cherry_child_get_rigestered_plugins();

	foreach ( $plugins as $slug => $data ) {

		$prepared_plugins[ $slug ]         = $data;
		$prepared_plugins[ $slug ]['slug'] = $slug;

		if ( ! isset( $data['source'] ) ) {
			$prepared_plugins[ $slug ]['source'] = 'wordpress';
		}
	}

	return $prepared_plugins;
}

require_once get_stylesheet_directory() . '/inc/class-tgm-plugin-activation.php';
add_action( 'tgmpa_register', 'cherry_child_tgmpa_register' );

/**
 * Register plugin for TGM activator.
 *
 * @ignore
 */
function cherry_child_tgmpa_register() {
	$prepared_plugins = array();
	$plugins          = cherry_child_get_rigestered_plugins();

	foreach ( $plugins as $slug => $data ) {

		$prepared_plugins[ $slug ]         = $data;
		$prepared_plugins[ $slug ]['slug'] = $slug;

		if ( ! empty( $data['source'] ) && 'cherry-premium' == $data['source'] && ! empty( $data['source_alt'] ) ) {
			$prepared_plugins[ $slug ]['source'] = $data['source_alt'];
		}
	}

	/**
	 * Array of configuration settings. Amend each line as needed.
	 */
	$config = array(
		'default_path' => '',                      // Default absolute path to pre-packaged plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => true,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
		'strings'      => array(
			'page_title'                      => __( 'Install Recommended Plugins', 'child-theme-domain' ),
			'menu_title'                      => __( 'Install Plugins', 'child-theme-domain' ),
			'installing'                      => __( 'Installing Plugin: %s', 'child-theme-domain' ), // %s = plugin name.
			'oops'                            => __( 'Something went wrong with the plugin API.', 'child-theme-domain' ),
			'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s).
			'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s).
			'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s).
			'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
			'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
			'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s).
			'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s).
			'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s).
			'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
			'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins' ),
			'return'                          => __( 'Return to Recommended Plugins Installer', 'child-theme-domain' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'child-theme-domain' ),
			'complete'                        => __( 'All plugins installed and activated successfully. %s', 'child-theme-domain' ), // %s = dashboard link.
			'nag_type'                        => 'updated',
		),
	);

	tgmpa( $prepared_plugins, $config );

}

/**
 * Pass own options to export (for example if you use thirdparty plugin and need to export some default options).
 *
 * WARNING #1
 * You should NOT totally overwrite $options_ids array with this filter, only add new values.
 *
 * @param  array $options Default options to export.
 * @return array          Filtered options to export.
 */
function cherry_child_options_to_export( $options ) {

	/**
	 * Example:
	 *
	 * $options[] = 'woocommerce_default_country';
	 * $options[] = 'woocommerce_currency';
	 * $options[] = 'woocommerce_enable_myaccount_registration';
	 */

	$options[] = 'mpsl_last_preset_id';
	$options[] = 'mpsl_last_private_preset_id';
	$options[] = 'mpsl_preset';
	$options[] = 'mpsl_css';
	$options[] = 'mpsl_preview_default_css';
	$options[] = 'mpsl_preview_css';
	$options[] = 'mpsl_default_css';
	$options[] = 'mpsl_private_css';

	return $options;
}

/**
 * Pass some own options (which contain page ID's) to export function,
 * if needed (for example if you use thirdparty plugin and need to export some default options).
 *
 * WARNING #1
 * With this filter you need pass only options, which contain page ID's and it's would be rewrited with new ID's on import.
 * Standrd options should passed via 'cherry_data_manager_export_options' filter.
 *
 * WARNING #2
 * You should NOT totally overwrite $options_ids array with this filter, only add new values.
 *
 * @param  array $options_ids Default array.
 * @return array              Result array.
 */
function cherry_child_options_ids( $options_ids ) {

	/**
	 * Example:
	 *
	 * $options_ids[] = 'woocommerce_cart_page_id';
	 * $options_ids[] = 'woocommerce_checkout_page_id';
	 */

	return $options_ids;
}

/**
 * Pass additional nav menu meta atts to import function.
 *
 * By default all nav menu meta fields are passed to XML file,
 * but on import processed only default fields, with this filter you can import your own custom fields.
 *
 * @param  array $extra_meta Ddditional menu meta fields to import.
 * @return array             Filtered meta atts array.
 */
function cherry_child_menu_meta( $extra_meta ) {

	/**
	 * Example:
	 *
	 * $extra_meta[] = '_cherry_megamenu';
	 */

	return $extra_meta;
}


/**
 * Customizations.
 */

// Include custom assets.
add_action( 'wp_enqueue_scripts',             'theme58337_include_custom_assets', 11 );

// Print a `totop` button on frontend.
add_action( 'cherry_footer_after',            'theme58337_print_totop_button' );

// Adds a new theme option - `totop` button.
add_filter( 'cherry_general_options_list',    'theme58337_add_totop_option' );

// Adds a new theme option - `Google Analytics Code`.
add_filter( 'cherry_general_options_list',    'theme58337_add_google_code' );

// Print a google analytics code on the bottom of HTML document.
add_filter( 'wp_footer',                      'theme58337_print_google_code', 9999 );

// Changed a `Breadcrumbs` output format.
add_filter( 'cherry_breadcrumbs_custom_args', 'theme58337_breadcrumbs_wrapper_format' );

// Modify a comment form.
add_filter( 'comment_form_defaults',          'theme58337_modify_comment_form' );

// Modify the columns on the `Posts` and `Pages` screen.
add_filter( 'manage_posts_columns',           'theme58337_add_thumbnail_column_header' );
add_filter( 'manage_pages_columns',           'theme58337_add_thumbnail_column_header' );
add_action( 'manage_posts_custom_column' ,    'theme58337_add_thumbnail_column_data', 10, 2 );
add_action( 'manage_pages_custom_column' ,    'theme58337_add_thumbnail_column_data', 10, 2 );

// Body classes for 'paddings' on pages
add_filter( 'body_class',					  'theme58337_paddings_body_classes' );
add_filter( 'cherry_page_options_list', 	  'theme58337_new_settings_paddings' );

if ( is_admin() ) {
	add_action( 'load-post.php',     	  	  'theme58337_add_pagetitle_metabox' );
	add_action( 'load-post-new.php', 	  	  'theme58337_add_pagetitle_metabox' );
}

/* Body classes for 2 sidebars */
add_filter( 'body_class', 'theme58337_two_sidebars_classes' );

/* Add animation support for row and columns shortcodes */
add_filter( 'cherry_shortcodes/data/shortcodes',	'theme58337_add_row_col_animation_options', 999 );
add_filter( 'shortcode_atts_row', 					'theme58337_new_row_animation_attributes', 11, 3 );
add_filter( 'shortcode_atts_col', 					'theme58337_new_col_animation_attributes', 11, 3 );

/* Register clients post type */
add_action( 'init', 'theme58337_clients_post_type_init' );

/* Add portfolio filter title*/
add_filter( 'cherry-portfolio-before-filters-html', 'theme58337_add_portfolio_filter_title' );

/* Change portfolio show all label */
add_filter('cherry_portfolio_show_all_text', 'theme58337_change_portfolio_show_all_title');

/* Add new metaboxes for single portfolio */
add_filter( 'cherry_portfolio_post_settings_metabox_params', 'theme58337_add_client_metabox_to_portfolio');

/* Get new portfolio taxonomy from template macros */
add_filter( 'cherry-portfolio-standart-format-postdata', 'theme58337_get_client_taxonomy' );

/* Change default format for portfolio date macros button */
add_filter('cherry_templater_macros_buttons', 'theme58337_change_default_portfolio_date_macros_button', 12, 2);

// Moto padding option
add_action( 'mp_library', 'theme58337_extend_row_paddings_classes', 11, 1 );

// Bg for call-to-action widget
add_filter('cherry_footer_options_list', 'theme58337_call_to_action_bg_option');

// New css function
add_filter( 'cherry_css_func_list', 'cherry_theme58337_add_call_to_action_bg', 11 );

// Add new small button on tinymce
add_action('admin_head', 'theme58337_add_button');
add_action( 'admin_enqueue_scripts', 'theme58337_custom_button_style' );

// Change comment title
add_filter ('cherry_title_comments', 'theme58337_change_comments_title');

// Change grid type for system pages
add_filter( 'cherry_get_page_grid_type', 'theme58337_get_page_grid_type', 11 );

/**
 * Enqueue scripts and styles.
 *
 * @ignore
 */
function theme58337_include_custom_assets() {
	// Get the theme prefix.
	$prefix = cherry_get_prefix();

	wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css', false, '4.4.0', 'all' );
	wp_enqueue_style( 'scrollbar', CHILD_URI . '/assets/css/jquery.mCustomScrollbar.css', false, '3.1.3', 'all' );
	wp_enqueue_style( 'fontello', CHILD_URI . '/assets/css/fontello.css', false, '1.0.0', 'all' );
	wp_enqueue_style( 'animate', CHILD_URI . '/assets/css/animate.css', false, '1.0.0', 'all' );
	wp_enqueue_script( $prefix . 'scrollbar', CHILD_URI . '/assets/js/min/jquery.mCustomScrollbar.min.js', array( 'jquery' ), '3.1.3', true );
	wp_enqueue_script( $prefix . 'wow', CHILD_URI . '/assets/js/min/wow.min.js', array( 'jquery' ), '1.1.2', true );
	wp_enqueue_script( $prefix . 'attrchange', CHILD_URI . '/assets/js/min/attrchange.min.js', array( 'jquery' ), '1.0', true );
	wp_enqueue_script( $prefix . 'grayscale', CHILD_URI . '/assets/js/min/grayscale.js', array( 'jquery' ), '1.0', true );
	wp_enqueue_script( $prefix . 'script', CHILD_URI . '/assets/js/script.js', array( 'jquery' ), '1.0', true );
}

/**
 * Display a `To Top` button.
 *
 * @ignore
 */
function theme58337_print_totop_button() {

	if ( 'true' != cherry_get_option( 'to_top_button', 'true' ) ) {
		return;
	}

	$mobile_class = '';

	if ( wp_is_mobile() ) {
		$mobile_class = 'mobile-back-top';
	}

	printf( '<div id="back-top" class="%s"><a href="#top"></a></div>', $mobile_class );
}

/**
 * Retrieve array with all options + new option `To Top`.
 *
 * @ignore
 * @param  array $args Set of all options.
 * @return array
 */
function theme58337_add_totop_option( $args ) {
	$args['to_top_button'] = array(
		'type'        => 'switcher',
		'title'       => __( 'To Top', 'child-theme-domain' ),
		'description' => __( 'Display to top button?', 'child-theme-domain' ),
		'value'       => 'true',
	);

	return $args;
}

/**
 * Retrieve array with custom arguments for breadcrumbs format.
 *
 * @ignore
 * @param  array $args Arguments.
 * @return array
 */
function theme58337_breadcrumbs_wrapper_format( $args ) {
	$args['wrapper_format'] = '<div class="container">
		<div class="row">
			<div class="col-md-12 col-sm-12">%s</div>
			<div class="col-md-12 col-sm-12">%s</div>
		</div>
	</div>';

	return $args;
}

/**
 * Retrieve a comment fields with placeholders.
 *
 * @ignore
 * @param  array $args The default comment form arguments.
 * @return array
 */
function theme58337_modify_comment_form( $args ) {
	$args = wp_parse_args( $args );

	if ( ! isset( $args['format'] ) ) {
		$args['format'] = current_theme_supports( 'html5', 'comment-form' ) ? 'html5' : 'xhtml';
	}

	$req      = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
	$html_req = ( $req ? " required='required'" : '' );
	$html5    = 'html5' === $args['format'];
	$commenter = wp_get_current_commenter();

	$args['title_reply'] = __( 'Leave a comment', 'child-theme-domain' );
	$args['label_submit'] = __( 'Send', 'child-theme-domain' );
	$args['submit_button'] = '<input name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s" /><input type="reset" class="reset" value="'.__( 'Clear', 'child-theme-domain' ).'">';

	$args['fields']['author'] = '<div class="row"><div class="col-xs-12 col-sm-12 col-md-4 col-lg-4"><p class="comment-form-author"><input id="author" name="author" type="text" placeholder="' . __( 'Name', 'child-theme-domain' ) . '" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . $html_req . ' /></div>';

	$args['fields']['email'] = '<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4"><p class="comment-form-email"><input id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' placeholder="' . __( 'Email', 'child-theme-domain' ) . '" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" aria-describedby="email-notes"' . $aria_req . $html_req  . ' /></p></div>';

	$args['fields']['url'] = '<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4"><p class="comment-form-url"><input id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' placeholder="' . __( 'Website', 'child-theme-domain' ) . '" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p></div></div>';

	$args['comment_field'] = '<p class="comment-form-comment"><textarea id="comment" name="comment" placeholder="' . __( 'Your message', 'child-theme-domain' ) . '" cols="45" rows="3" aria-describedby="form-allowed-tags" aria-required="true" required="required"></textarea></p>';

	return $args;
}

/**
 * Retrieve array with column labels + new label `Featured Image`.
 *
 * @ignore
 * @param  array $post_columns An array of column name => label.
 * @return array
 */
function theme58337_add_thumbnail_column_header( $post_columns ) {
	return array_merge( $post_columns, array( 'thumbnail' => '<span class="dashicons dashicons-format-image"></span><span class="screen-reader-text">' . __( 'Featured Image', 'child-theme-domain' ) . '</span>' ) );
}

/**
 * Display Post Featured Image in `edit.php` and `edit.php?post_type=page` admin pages.
 *
 * @ignore
 * @param string $column  The name of the column to display.
 * @param int    $post_id The ID of the current post.
 */
function theme58337_add_thumbnail_column_data( $column, $post_id ) {

	if ( 'thumbnail' !== $column ) {
		return;
	}

	$post_type = get_post_type( $post_id );

	if ( ! in_array( $post_type, array( 'post', 'page' ) ) ) {
		return;
	}

	$thumb = get_the_post_thumbnail( $post_id, array( 50, 50 ) );
	echo empty( $thumb ) ? '&mdash;' : $thumb;
}

/**
 * Retrieve array with all options + new option `Google Analytics Code`.
 *
 * @ignore
 * @param  array $options Set of all options.
 * @return array
 */
function theme58337_add_google_code( $options ) {
	$options['google_analytics'] = array(
		'type'        => 'textarea',
		'title'       => __( 'Google Analytics Code', 'child-theme-domain' ),
		'description' => __( 'You can paste your Google Analytics or other tracking code in this box. This will be automatically added to the footer.', 'child-theme-domain' ),
		'value'       => '',
	);

	return $options;
}

/**
 * Dispaly a google analytics code on the bottom of HTML document.
 *
 * @ignore
 */
function theme58337_print_google_code() {
	$google_code = cherry_get_option( 'google_analytics' );

	if ( empty( $google_code ) ) {
		return;
	}

	printf( '<script>%s</script>', $google_code );
}

/* Change default comments avatar size */
add_filter('cherry_comment_list_args', 'theme58337_change_comment_avatar_size');
function theme58337_change_comment_avatar_size($defaults) {

	$defaults['avatar_size'] = 128;
	return $defaults;
}

/* Change default author avatar size */
add_filter('cherry_get_the_post_avatar_defaults', 'theme58337_change_author_avatar_size');
function theme58337_change_author_avatar_size($defaults) {

	$defaults['size'] = 128;
	return $defaults;
}

/* Push textarea in comment form in bottom */
add_filter( 'comment_form_fields', 'theme58337_move_comment_field_to_bottom' );
function theme58337_move_comment_field_to_bottom( $fields ) {
	$comment_field = $fields['comment'];
	unset( $fields['comment'] );
	$fields['comment'] = $comment_field;

	return $fields;
}

/* Padding classes on body */
function theme58337_paddings_body_classes ($classes) {
	global $post;

	if ( ! is_object( $post ) ) {
		return $classes;
	}

	$meta = get_post_meta( $post->ID, 'theme58337', true );

	$meta_page_paddings = '';
	if( !empty($meta) && isset($meta['page-paddings']) ) {
		$meta_page_paddings = $meta['page-paddings'];
	}

	$cherry_page_paddings = cherry_get_option( 'page_paddings' );

	if ( ($meta_page_paddings !== '') && is_page() ) {
		$type = $cherry_page_paddings && 'inherit' === $meta_page_paddings ? $cherry_page_paddings : $meta['page-paddings'] ;
	} else {
		$type = $cherry_page_paddings;
	}

	switch ( $type ) {
		case 'paddings-2':
			$classes[] = 'bottom-padding';
			break;
		case 'paddings-3':
			$classes[] = 'top-padding';
			break;
		case 'paddings-4':
			$classes[] = 'no-padding';
			break;
	}

	return $classes;
}

/* Two sidebars class on body */
function theme58337_two_sidebars_classes ($classes) {
	$layout = cherry_current_page()->get_property( 'layout' );
	
	if (
		$layout == 'sidebar-content-sidebar' || 
		$layout == 'sidebar-sidebar-content' || 
		$layout == 'content-sidebar-sidebar'
	) {
		$classes[] = 'two-sidebars';
	}

	return $classes;
}

/* New paddings settings */
function theme58337_new_settings_paddings( $options ) {
	$new_options = array(
		'page_paddings' => array(
			'type'			=> 'radio',
			'title'			=> __('Choose paddings for page content', 'child-theme-domain'),
			'label'			=> '',
			'value'			=> 'paddings-1',
			'class'			=> '',
			'options'		=> array(
				'paddings-1' => array(
					'label' => __( 'Content with top and bottom paddings', 'child-theme-domain' ),
					'img_src' => CHILD_URI.'/admin/assets/images/paddings-1.png'
				),
				'paddings-2' => array(
					'label' => __( 'Content bottom padding', 'child-theme-domain' ),
					'img_src' => CHILD_URI.'/admin/assets/images/paddings-2.png'
				),
				'paddings-3' => array(
					'label' => __( 'Content top padding', 'child-theme-domain' ),
					'img_src' => CHILD_URI.'/admin/assets/images/paddings-3.png'
				),
				'paddings-4' => array(
					'label' => __( 'No paddings', 'child-theme-domain' ),
					'img_src' => CHILD_URI.'/admin/assets/images/paddings-4.png'
				),
			)
		)
	);
	$options = array_merge( $options, $new_options );

	return $options;
}

function theme58337_add_pagetitle_metabox(){
	$screen    = get_current_screen();
	$post_type = $screen->post_type;

	if ( !empty( $post_type ) && 'page' == $post_type ) {
		require_once( CHILD_DIR . '/admin/class-theme58337-pagepaddings-meta.php' );
	}
}

add_filter( 'cherry_logo_options_list', 	  'theme58337_new_settings_logo_disable' );
function theme58337_new_settings_logo_disable( $options ) {
	$new_options = array(
		'logo-on-off' => array(
			'type'			=> 'switcher',
			'title'			=> __('Display logo on mobiles', 'cherry'),
			'label'			=> '',
			'description'	=> '',
			'description'	=> __('Display logo at secondary pages on mobile resolutions. ', 'cherry'),
			'value'			=> 'true',
			'toggle'		=> array(
				'true_toggle'	=> __( 'Display', 'cherry' ),
				'false_toggle'	=> __( 'Hide', 'cherry' ),
				'true_slave'	=> 'switcher-test-true-slave',
				'false_slave'	=> 'switcher-test-false-slave'
			),
		)
	);
	$options = array_merge( $options, $new_options );

	return $options;
}

/* Add animation support for row and columns shortcodes */
function theme58337_add_row_col_animation_options( $shortcodes ) {
	$shortcodes['row']['atts']['animation'] = array(
		'type'   => 'select',
		'values' => array(
			'none'   	=> __( 'None', 'child-theme-domain' ),
			'top'  		=> __( 'From Top', 'child-theme-domain' ),
			'bottom'    => __( 'From Bottom', 'child-theme-domain' ),
			'left'   	=> __( 'From Left', 'child-theme-domain' ),
			'right'  	=> __( 'From Right', 'child-theme-domain' ),
		),
		'default' => 'none',
		'name'    => __( 'Animation', 'child-theme-domain' ),
		'desc'    => __( 'Choose column animation', 'child-theme-domain' ),
	);
	$shortcodes['row']['atts']['delay'] = array(
		'type'    => 'number',
		'min'     => 0,
		'max'     => 1000,
		'step'    => 50,
		'default' => 0,
		'name'    => __( 'Animation delay', 'child-theme-domain' ),
		'desc'    => __( 'Specify animation delay in ms. Maximum delay is 1000ms.', 'child-theme-domain' ),
	);

	$shortcodes['col']['atts']['animation'] = array(
		'type'   => 'select',
		'values' => array(
			'none'   	=> __( 'None', 'child-theme-domain' ),
			'top'  		=> __( 'From Top', 'child-theme-domain' ),
			'bottom'    => __( 'From Bottom', 'child-theme-domain' ),
			'left'   	=> __( 'From Left', 'child-theme-domain' ),
			'right'  	=> __( 'From Right', 'child-theme-domain' ),
		),
		'default' => 'none',
		'name'    => __( 'Animation', 'child-theme-domain' ),
		'desc'    => __( 'Choose column animation', 'child-theme-domain' ),
	);
	$shortcodes['col']['atts']['delay'] = array(
		'type'    => 'number',
		'min'     => 0,
		'max'     => 1000,
		'step'    => 50,
		'default' => 0,
		'name'    => __( 'Animation delay', 'child-theme-domain' ),
		'desc'    => __( 'Specify animation delay in ms. Maximum delay is 1000ms.', 'child-theme-domain' ),
	);

	return $shortcodes;
}

function theme58337_new_row_animation_attributes($out, $pairs, $atts) {
	$out['animation'] 	= '';
	
	if (isset($atts['animation'])) {
		switch ($atts['animation']) {
			case 'top':
				$out['class'] .= ' wow fadeInDownBig ';
				break;

			case 'bottom':
				$out['class'] .= ' wow fadeInUpBig ';
				break;

			case 'left':
				$out['class'] .= ' wow fadeInLeftBig ';
				break;

			case 'right':
				$out['class'] .= ' wow fadeInRightBig ';
				break;
		}
	}

	if (isset($atts['delay']) && !($atts['delay'] == 0)) {
		$out['class'] .= ' delay-'.absint($atts['delay']).' ';
	}

	return $out;
}

function theme58337_new_col_animation_attributes($out, $pairs, $atts) {
	$out['animation'] 	= '';
	
	if (isset($atts['animation'])) {
		switch ($atts['animation']) {
			case 'top':
				$out['class'] .= ' wow fadeInDownBig ';
				break;

			case 'bottom':
				$out['class'] .= ' wow fadeInUpBig ';
				break;

			case 'left':
				$out['class'] .= ' wow fadeInLeftBig ';
				break;

			case 'right':
				$out['class'] .= ' wow fadeInRightBig ';
				break;
		}
	}

	if ( isset($atts['delay']) && !($atts['delay'] == 0) ) {
		$out['class'] .= ' delay-'.absint($atts['delay']).' ';
	}

	return $out;
}

/* Register clients post type */
function theme58337_clients_post_type_init() {
	$labels = array(
			'name'               => __( 'Clients', 'child-theme-domain' ),
			'singular_name'      => __( 'Clients', 'child-theme-domain' ),
			'add_new'            => __( 'Add New', 'child-theme-domain' ),
			'add_new_item'       => __( 'Add New Client', 'child-theme-domain' ),
			'edit_item'          => __( 'Edit Client', 'child-theme-domain' ),
			'new_item'           => __( 'New Client', 'child-theme-domain' ),
			'view_item'          => __( 'View Client', 'child-theme-domain' ),
			'search_items'       => __( 'Search Clients', 'child-theme-domain' ),
			'not_found'          => __( 'No clients found', 'child-theme-domain' ),
			'not_found_in_trash' => __( 'No clients found in trash', 'child-theme-domain' ),
		);

	$supports = array(
		'title',
		'editor',
		'thumbnail',
		'revisions',
		'cherry-grid-type',
		'cherry-layouts',
	);

	$args = array(
		'labels'          => $labels,
		'supports'        => $supports,
		'public'          => true,
		'capability_type' => 'post',
		'hierarchical'    => false, // Hierarchical causes memory issues - WP loads all records!
		'rewrite'         => array(
			'slug'       => 'client-view',
			'with_front' => false,
			'feeds'      => true
		),
		'query_var'       => true,
		'menu_position'   => null,
		'menu_icon'       => ( version_compare( $GLOBALS['wp_version'], '3.8', '>=' ) ) ? 'dashicons-groups' : '',
		'can_export'      => true,
		'has_archive'     => true,
	);

	register_post_type( 'clients', $args );
}

/* Add portfolio filter title*/
function theme58337_add_portfolio_filter_title() {
	return '<div class="filter-title">'.__('SORT GALLERY: ', 'child-theme-domain').'</div>';
}

/* Change portfolio show all label */
function theme58337_change_portfolio_show_all_title($title) {
	$title = __('ALL', 'child-theme-domain');

	return $title;
}

/* Add new metaboxes for single portfolio */
function theme58337_add_client_metabox_to_portfolio($options) {
	$options['callback_args'][] = array(
		'id'			=> 'client',
		'type'			=> 'text',
		'label'			=> __( 'Client: ', 'child-theme-domain' ),
		'description'	=> __( 'Enter client name', 'child-theme-domain' ),
		'value'			=> '',
	);
	$options['callback_args'][] = array(
		'id'			=> 'info',
		'type'			=> 'text',
		'label'			=> __( 'Info: ', 'child-theme-domain' ),
		'description'	=> __( 'Enter info', 'child-theme-domain' ),
		'value'			=> '',
	);
	return $options;
}

/* Get new portfolio taxonomy from template macros */
function theme58337_get_client_taxonomy($_postdata) {
	$post_id = get_the_ID();
	$post_meta  = get_post_meta( $post_id, '_cherry_portfolio', true );
	$date_format = get_option( 'date_format' );

	$client = isset( $post_meta[ 'client' ] ) ? sprintf( '<span class="title">%1$s</span>%2$s',  __( 'Client: ', 'child-theme-domain' ), $post_meta[ 'client' ]) : '' ;
	$info = isset( $post_meta[ 'info' ] ) ? sprintf( '<span class="title">%1$s</span>%2$s',  __( 'Info: ', 'child-theme-domain' ), $post_meta[ 'info' ]) : '' ;

	/* Change default date format */
	$date = sprintf( '<span class="title">%1$s</span><time class="post-date" datetime="%2$s">%3$s</time>',  __( 'Date: ', 'child-theme-domain' ), esc_attr( get_the_date( 'c' ) ), esc_html( get_the_date( $date_format ) ) );

	$_postdata['client'] 	= $client;
	$_postdata['info'] 		= $info;
	$_postdata['date']    	= $date;
	$_postdata['prevlink']  = get_adjacent_post_link( '%link', __( 'Previous projects', 'child-theme-domain' ) );
	$_postdata['nextlink']	= get_adjacent_post_link( '%link', __( 'Next projects', 'child-theme-domain' ), 0, '', false );

	return $_postdata;
}

/* Change default format for portfolio date macros button & add new */
function theme58337_change_default_portfolio_date_macros_button( $macros_buttons, $shortcode) {
	
	if ( 'portfolio' != $shortcode ) {
		return $macros_buttons;
	}
	$macros_buttons['date']['open'] = '%%DATE%%';
	$macros_buttons['client'] = array(
		'id' => 'theme58337_client',
		'value' => __( 'Client', 'child-theme-domain' ),
		'open' => '%%CLIENT%%',
		'close' => '',
	);
	$macros_buttons['info'] = array(
		'id' => 'theme58337_info',
	    'value' => __( 'Info', 'child-theme-domain' ),
	    'open' => '%%INFO%%',
	    'close' => '',
	);

	return $macros_buttons;
}

// Moto padding option
function theme58337_extend_row_paddings_classes( $motopressCELibrary ) {

	if ( ! defined( 'CHERRY_SHORTCODES_PREFIX' ) ) {
		return;
	}

	if (isset($motopressCELibrary)) {

		$rowObj = &$motopressCELibrary->getObject( CHERRY_SHORTCODES_PREFIX . 'row');

		if ($rowObj) {
			$styleClasses = &$rowObj->getStyle('mp_style_classes');
			$styleClasses['predefined']['paddings'] = array(
				'label'         => __('Additional settings', 'child-theme-domain'),
				'allowMultiple' => true,
				'values' => array(
					'paddings' => array(
						'class' => 'paddings',
						'label' => __('Paddings on row', 'child-theme-domain'),
					),
				)
			);
		}
	}
}

// Bg for call-to-action widget
function theme58337_call_to_action_bg_option( $options ) {
	$new_options['call-to-action-bg'] = array(
		'type'			=> 'background',
		'title'			=> __('Background image for footer Call-To-Action area', 'child-theme-domain'),
		'label'			=> '',
		'decsription'	=> '',
		'hint'			=>  array(
			'type'		=> 'text',
			'content'	=> __('Allows user to add background image from the media library and define its background settings like background repeat, position, attachment, origin. You can choose background for footer call to action area. You can also specify an background in the row shortcode in widget area.', 'child-theme-domain'),
		),
		'multi_upload'		=> true,
		'library_type'		=> 'image',
		'value'				=> array(
			'image'			=> '',
			'color'			=> '',
			'repeat'		=> 'repeat',
			'position'		=> 'left',
			'attachment'	=> 'fixed',
			'clip'			=> 'padding-box',
			'size'			=> 'cover',
			'origin'		=> 'padding-box',
		)
	);
	$options = array_merge( $options, $new_options );

	return $options;
}

// New dinamic-style css functions
function cherry_theme58337_add_call_to_action_bg( $func_list ) {
	$func_list = array_merge( array( 'call_to_action_bg' => 'theme58337_call_to_action_bg' ), $func_list );
	$func_list = array_merge( array( 'swiper_button_prev' => 'swiper_carousel_button_prev' ), $func_list );
	$func_list = array_merge( array( 'swiper_button_next' => 'swiper_carousel_button_next' ), $func_list );

	return $func_list;
}

// call_to_action background
function theme58337_call_to_action_bg() {
	$callToActionBg = '';
	$callToActionBgStyles = '';

	if(cherry_get_option( "call-to-action-bg" )) {
		$callToActionBg = cherry_get_option( "call-to-action-bg" );

		$callToActionBgImageId 		= $callToActionBg['image'];
		$callToActionBgColor 		= $callToActionBg['color'];
		$callToActionBgRepeat 		= $callToActionBg['repeat'];
		$callToActionBgPosition 	= $callToActionBg['position'];
		$callToActionBgAttachment 	= $callToActionBg['attachment'];
		$callToActionBgClip 		= $callToActionBg['clip'];
		$callToActionBgSize 		= $callToActionBg['size'];
		$callToActionBgOrigin 		= $callToActionBg['origin'];

		if ($callToActionBgImageId !== '') {
			$callToActionBgImage 		= wp_get_attachment_image_src($callToActionBgImageId, 'full');
			$callToActionBgStyles 		.= 'background-image: url('.$callToActionBgImage[0].');';
			$callToActionBgStyles 		.= 'background-repeat: '.$callToActionBgRepeat.';';
			$callToActionBgStyles 		.= 'background-position: '.$callToActionBgPosition.';';
			$callToActionBgStyles 		.= 'background-attachment: '.$callToActionBgAttachment.';';
			$callToActionBgStyles 		.= 'background-clip: '.$callToActionBgClip.';';
			$callToActionBgStyles 		.= 'background-size: '.$callToActionBgSize.';';
			$callToActionBgStyles 		.= 'background-origin: '.$callToActionBgOrigin.';';
		}
		if ($callToActionBgColor !== '') {
			$callToActionBgStyles 		.= 'background-color: '.$callToActionBgColor.';';
		}
	}

	return $callToActionBgStyles;
}

// swiper carousel button prev
function swiper_carousel_button_prev() {
	return 'content: "'.__('Prev', 'child-theme-domain').'"';
}

// swiper carousel button next
function swiper_carousel_button_next() {
	return 'content: "'.__('Next', 'child-theme-domain').'"';
}

/* Add new small button on tinymce */
function theme58337_add_button() {
    global $typenow;
    // check user permissions
    if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') ) {
    return;
    }
    // verify the post type
    if( ! in_array( $typenow, array( 'post', 'page' ) ) )
        return;
    // check if WYSIWYG is enabled
    if ( get_user_option('rich_editing') == 'true') {
        add_filter("mce_external_plugins", "theme58337_add_tinymce_plugin");
        add_filter('mce_buttons', 'theme58337_register_my_tc_button');
    }
}
function theme58337_add_tinymce_plugin($plugin_array) {
    $plugin_array['small_button'] = trailingslashit( CHILD_URI ) . 'assets/js/admin-script.js';
    return $plugin_array;
}
function theme58337_register_my_tc_button($buttons) {
   array_splice($buttons, 2, 0, "small_button");  
   return $buttons;
}
function theme58337_custom_button_style() {
	wp_enqueue_style( 'theme58337_custom_button', trailingslashit( CHILD_URI ) . 'assets/css/custom-button.css' );
}
foreach ( array('post.php','post-new.php') as $hook ) {
    add_action( "admin_head-$hook", 'theme58337_custom_button_text_var' );
}
function theme58337_custom_button_text_var() {
    $title 		= __( 'Small text', 'child-theme-domain' );
    $alertTitle = __( 'You need select text', 'child-theme-domain' ); ?>

	<script type='text/javascript'>
		var titleName = '<?php echo $title; ?>';
		var alertTitle = '<?php echo $alertTitle; ?>';
	</script>
<?php }

// Change comment title
function theme58337_change_comments_title($title_comments) {
	$title_comments = sprintf( _n( '%s response', '%s responses', get_comments_number(), 'child-theme-domain' ), number_format_i18n( get_comments_number() ) );
	$title_comments = '<h3 class="comments-title">'.$title_comments.'</h3>';
	return $title_comments;
}

// Change grid type for system pages
function theme58337_get_page_grid_type( $grid_type ) {
	if ( 
		is_author() ||
		is_archive() ||
		is_category()
	) {
		$grid_type['content'] = 'boxed';
	}

	return $grid_type;
}

// Change comment date
add_filter( 'get_comment_date', 'theme58337_comment_date' );
function theme58337_comment_date($d) {
	$comment_id = get_comment_ID();
	$comment = get_comment( $comment_id );
	$d = mysql2date(get_option('date_format'), $comment->comment_date);
    return $d;
}