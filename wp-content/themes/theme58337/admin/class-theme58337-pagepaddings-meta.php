<?php
/**
 * Adds a `pagetitleblock` metabox.
 *
 * @package WordPress
 * @subpackage theme58337
 * @since 1.0.0
 */
class theme58337_pagepaddings {

	/**
	 * Holds the instances of this class.
	 *
	 * @since 1.0.0
	 * @var   object
	 */
	private static $instance = null;

	/**
	 * Sets up the needed actions for adding and saving the meta boxes.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		if ( !class_exists( 'Cherry_Interface_Builder' ) ) {
			return;
		}

		if ( !class_exists( 'Cherry_Options_Framework' ) ) {
			return;
		}

		// Adds the meta box.
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ), 10, 2 );

		// Saves the post format on the post editing page.
		add_action( 'save_post',      array( $this, 'save_post'      ), 10, 2 );
	}

	/**
	 * Adds the meta box.
	 *
	 * @since  1.0.0
	 * @param  string $post_type The post type of the current post being edited.
	 * @param  object $post      The current post object.
	 * @return void
	 */
	public function add_meta_boxes( $post_type, $post ) {

		/**
		 * Filter the array of 'add_meta_box' parametrs.
		 *
		 * @since 1.0.0
		 */
		$metabox = array(
			'id'            => 'theme58337-page-title-metabox',
			'title'         => __( 'Additional page options', 'child-theme-domain' ),
			'page'          => $post_type,
			'context'       => 'normal',
			'priority'      => 'high'
		);

		/**
		 * Add meta box to the administrative interface.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_meta_box
		 */
		add_meta_box(
			$metabox['id'],
			$metabox['title'],
			array( $this, 'callback_metabox' ),
			$metabox['page'],
			$metabox['context'],
			$metabox['priority']
		);

	}

	/**
	 * Displays a meta box of radio selectors on the post editing screen, which allows theme users to select
	 * the layout they wish to use for the specific post.
	 *
	 * @since  1.0.0
	 * @param  object $post    The post object currently being edited.
	 * @param  array  $metabox Specific information about the meta box being loaded.
	 * @return void
	 */
	public function callback_metabox( $post, $metabox ) {

		$value = get_post_meta( $post->ID, 'theme58337', true );

		$metaPaddings = ( !empty( $value ) && isset( $value['page-paddings'] ) ) ? $value['page-paddings'] : 'inherit' ;

		$args = array(
			'page-paddings' => array(
				'id'            => 'page-paddings',
				'type'			=> 'radio',
				'title'			=> __('Choose paddings for page content', 'child-theme-domain'),
				'label'			=> '',
				'value'			=> $metaPaddings,
				'class'			=> '',
				'options'		=> $this->get_page_paddings_options(),
			),
		);

		wp_nonce_field( basename( __FILE__ ), 'theme58337-page-title-nonce' );

		$builder = new Cherry_Interface_Builder( array(
			'name_prefix' => 'theme58337',
			'pattern'     => 'inline',
			'class'       => array( 'section' => 'single-section' ),
		) );

		foreach ($args as $value) {
			printf( '<div class="page-title-box">%s</div>', $builder->add_form_item( $value ) );
		}

	}

	/**
	 * Saves the post metadata if on the post editing screen in the admin.
	 *
	 * @since  1.0.0
	 * @param  int      $post_id The ID of the current post being saved.
	 * @param  object   $post    The post object currently being saved.
	 * @return void|int
	 */
	public function save_post( $post_id, $post = '' ) {

		if ( !is_object( $post ) ) {
			$post = get_post();
		}

		// Verify the nonce for the post formats meta box.
		if ( !isset( $_POST['theme58337-page-title-nonce'] )
			|| !wp_verify_nonce( $_POST['theme58337-page-title-nonce'], basename( __FILE__ ) )
			) {
			return $post_id;
		}

		// Get the meta key.
		$meta_key = 'theme58337';

		$meta = array_map( 'sanitize_text_field' , $_POST[ $meta_key ] );
		$new_meta_value = array();

		if ( isset( $meta['page-paddings'] ) && in_array( $meta['page-paddings'], array_keys( $this->get_page_paddings_options() ) ) ) {
			$new_meta_value['page-paddings'] = $meta['page-paddings'];
		} else {
			$new_meta_value['page-paddings'] = 'inherit';
		}

		if ( current_user_can( 'edit_post_meta', $post_id, $meta_key ) ) {
			update_post_meta( $post_id, $meta_key, $new_meta_value );
		}
	}

	/**
	 * Returns the values for a `Breadcrumbs and title` select.
	 *
	 * @since  1.0.7
	 * @return array
	 */
	public function get_page_heading_options() {
		return array(
					'inherit'          => __( 'Inherit', 'child-theme-domain' ),
					'none'             => __( "Don't display", 'child-theme-domain' ),
					'both'             => __( 'Show both - breadcrumbs and title', 'child-theme-domain' ),
					'only-title'       => __( 'Show only page title', 'child-theme-domain' ),
					'only-breadcrumbs' => __( 'Show only breadcrumbs', 'child-theme-domain' ),
				);
	}

	/**
	 * Returns the values for a `Choose paddings for page content` radio-buttons.
	 *
	 * @since  1.0.7
	 * @return array
	 */
	public function get_page_paddings_options() {
		return array(
					'inherit' => array(
						'label'   => __( 'Inherit', 'child-theme-domain' ),
						'img_src' => CHILD_URI . '/admin/assets/images/inherit.png',
					),
					'paddings-1' => array(
						'label'   => __( 'Content with top and bottom paddings', 'child-theme-domain' ),
						'img_src' => CHILD_URI . '/admin/assets/images/paddings-1.png',
					),
					'paddings-2' => array(
						'label'   => __( 'Content bottom padding', 'child-theme-domain' ),
						'img_src' => CHILD_URI .'/admin/assets/images/paddings-2.png',
					),
					'paddings-3' => array(
						'label'   => __( 'Content top padding', 'child-theme-domain' ),
						'img_src' => CHILD_URI.'/admin/assets/images/paddings-3.png',
					),
					'paddings-4' => array(
						'label'   => __( 'No paddings', 'child-theme-domain' ),
						'img_src' => CHILD_URI.'/admin/assets/images/paddings-4.png',
					),
				);
	}

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @return object
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}
}

theme58337_pagepaddings::get_instance(); ?>