<?php

/**
 * The admin-specific functionality of the plugin.
 */
class Nm_scroller_Admin {

	/**
	 * The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/nm_scroller-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'wp-color-picker');
	}

	/**
	 * Register the JavaScript for the admin area.
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/nm_scroller-admin.js', array( 'jquery' ), $this->version, false );
    wp_enqueue_script( 'wp-color-picker');
	}

	/**
	 * Register scroller custom post type
	 */
	public function register_scroller_cpt() {

		$labels = array(
			'name'                  => _x( 'Nordic Milk Scroller', 'Post Type General Name', 'nm_scroller' ),
			'singular_name'         => _x( 'Page', 'Post Type Singular Name', 'nm_scroller' ),
			'menu_name'             => __( 'Scroller', 'nm_scroller' ),
			'name_admin_bar'        => __( 'Scroller', 'nm_scroller' ),
			'archives'              => __( 'Our Pages', 'nm_scroller' ),
			'attributes'            => __( 'Page Attributes', 'nm_scroller' ),
			'parent_item_colon'     => __( 'Parent page:', 'nm_scroller' ),
			'all_items'             => __( 'All pages', 'nm_scroller' ),
			'add_new_item'          => __( 'Add new page', 'nm_scroller' ),
			'add_new'               => __( 'Add new', 'nm_scroller' ),
			'new_item'              => __( 'New page', 'nm_scroller' ),
			'edit_item'             => __( 'Edit page', 'nm_scroller' ),
			'update_item'           => __( 'Update page', 'nm_scroller' ),
			'view_item'             => __( 'View page', 'nm_scroller' ),
			'view_items'            => __( 'View pages', 'nm_scroller' ),
			'search_items'          => __( 'Search page', 'nm_scroller' ),
			'not_found'             => __( 'Not found', 'nm_scroller' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'nm_scroller' ),
			'insert_into_item'      => __( 'Insert into pages sheet', 'nm_scroller' ),
			'uploaded_to_this_item' => __( 'Uploaded to this page sheet', 'nm_scroller' ),
			'items_list'            => __( 'Pages list', 'nm_scroller' ),
			'item_published'				=> __( 'Pages published', 'nm_scroller' ),
			'items_list_navigation' => __( 'Pages list navigation', 'nm_scroller' ),
			'filter_items_list'     => __( 'Filter page list', 'nm_scroller' ),
		);

		$args = array(
			'label'                 => __( 'Scroller', 'nm_scroller' ),
			'description'           => __( 'Pages to be shown on the scroller section', 'nm_scroller' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'page-attributes'),
			'taxonomies'						=> array( 'packages' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'menu_icon'             => 'dashicons-slides',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => false,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'post',
			'show_in_rest'	    => false
		);

		register_post_type( 'scroller', $args );
	}

	/**
	 * Register background metabox for scroller cpt
	 */
	function register_background_metabox() {
		add_meta_box( 'nm_scroller_background', __( 'Scroller Options', 'textdomain' ), array($this,'render_background_metabox'), 'scroller', 'side', );
	}

	/**
	 * Render background metabox with color selector for scroller cpt
	 */
	function render_background_metabox($post) {
		wp_nonce_field( 'nm_scroller_background', 'nm_scroller_background_wpnonce' );
		
		if ( get_post_meta($post->ID, 'nm_scroller_background_color', true ) ) {
			$background_color = '#' . get_post_meta($post->ID, 'nm_scroller_background_color', true );
		} else {
			$background_color = "#FFFFFF";
		}
		?>
		<p class="post-attributes-label-wrapper">
			<label class="post-attributes-label" for="menu_order"><?php echo __( 'Background color', 'nm_scroller' ); ?></label>
		</p>
    <input name="nm_scroller_background_color" type="text" id="nm_scroller_background_color" value="<?php echo $background_color; ?>" data-default-color="#ffffff">
    <script type="text/javascript">
		
    jQuery(document).ready(function($) {
			$('#nm_scroller_background_color').wpColorPicker();
    });             
    </script>
		<p class="post-attributes-help-text"><?php echo __( 'Color applied to the page background', 'nm_scroller' ); ?> </p>
    <?php
	}

	/**
	 * Save background color
	 */
	function save_background_color( $post_id ) {
		if (	!isset( $_POST['nm_scroller_background_wpnonce'] ) || 
					!wp_verify_nonce( $_POST['nm_scroller_background_wpnonce'], 'nm_scroller_background' ) ||
					defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ||
					!current_user_can( 'edit_post', $post_id ) || 
					!isset( $_POST['nm_scroller_background_color'])) {
			return;
		}
		update_post_meta( $post_id, 'nm_scroller_background_color', sanitize_html_class($_POST['nm_scroller_background_color']) );
	}
}
