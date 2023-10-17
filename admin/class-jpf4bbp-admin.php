<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://ween.codes
 * @since      1.0.0
 *
 * @package    Jpf4bbp
 * @subpackage Jpf4bbp/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Jpf4bbp
 * @subpackage Jpf4bbp/admin
 * @author     Ween Codes <weencodes@gmail.com>
 */
class Jpf4bbp_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	private $post;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		$this->post = isset($_GET['post']) ? $_GET['post'] : null;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Jpf4bbp_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Jpf4bbp_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/jpf4bbp-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Jpf4bbp_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Jpf4bbp_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/jpf4bbp-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function bbp_extra_forum_fields_admin() {

		$value = get_post_meta( $this->post, 'bbp_objective', true );
		?>
		<fieldset class="job-forums">
			<legend><?= __( 'Job purpose forum', 'jpf4bbp' ); ?></legend>
			<p>
				<strong class="label"><?= __( 'Objective', 'jpf4bbp' ); ?></strong>
				<label class="screen-reader-text" for="bbp_objective">
					<?= __( 'Objective', 'jpf4bbp' ); ?>
				</label>
				<select name="bbp_objective">
					<option value="0">
						<?= __( '-- select --', 'jpf4bbp' ); ?>
					</option>
					<option value="1" <?= $value && 1 == $value ? 'selected="selected"' : '' ?>>
						<?= __( 'Discussion', 'jpf4bbp' ); ?>
					</option>
					<option value="2" <?= $value && 2 == $value ? 'selected="selected"' : '' ?>>
						<?= __( 'Opportunity', 'jpf4bbp' ); ?>
					</option>
				</select>
			</p>
		</fieldset>
		<?php
	}

	public function bbp_save_forum_extra_fields( $forum_id = null ) {

		$forum_id = $forum_id && null === $forum_id ? $this->post : $forum_id;

	    if ( isset($_POST['bbp_objective']) && $_POST['bbp_objective'] != '' ) {
    		update_post_meta( $forum_id, 'bbp_objective', $_POST['bbp_objective'] );
		}
	}

	public function jpf4bbp_register_specialties_taxonomy() {
		$labels = array(
			'name'                       => _x('Specialties', 'taxonomy general name', 'jpf4bbp'),
			'singular_name'              => _x('Specialty', 'taxonomy singular name', 'jpf4bbp'),
			'search_items'               => __('Search Specialties', 'jpf4bbp'),
			'popular_items'              => __('Popular Specialties', 'jpf4bbp'),
			'all_items'                  => __('All Specialties', 'jpf4bbp'),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __('Edit Specialty', 'jpf4bbp'),
			'update_item'                => __('Update Specialty', 'jpf4bbp'),
			'add_new_item'               => __('Add New Specialty', 'jpf4bbp'),
			'new_item_name'              => __('New Specialty Name', 'jpf4bbp'),
			'separate_items_with_commas' => __('Separate Specialties with commas', 'jpf4bbp'),
			'add_or_remove_items'        => __('Add or remove Specialties', 'jpf4bbp'),
			'choose_from_most_used'      => __('Choose from the most used Specialties', 'jpf4bbp'),
			'menu_name'                  => __('Specialties', 'jpf4bbp'),
		);
	
		$args = array(
			'hierarchical'          => true,
			'labels'                => $labels,
			'public'                => true,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'query_var'             => true,
			'rewrite'               => array('slug' => 'specialties'),
		);
	
		register_taxonomy('specialties', 'topic', $args);
	}

	public function jpf4bbp_register_odss_taxonomy() {
		$labels = array(
			'name'                       => _x('ODSs', 'taxonomy general name', 'jpf4bbp'),
			'singular_name'              => _x('ODS', 'taxonomy singular name', 'jpf4bbp'),
			'search_items'               => __('Search ODSs', 'jpf4bbp'),
			'popular_items'              => __('Popular ODSs', 'jpf4bbp'),
			'all_items'                  => __('All ODSs', 'jpf4bbp'),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __('Edit ODS', 'jpf4bbp'),
			'update_item'                => __('Update ODS', 'jpf4bbp'),
			'add_new_item'               => __('Add New ODS', 'jpf4bbp'),
			'new_item_name'              => __('New ODS Name', 'jpf4bbp'),
			'separate_items_with_commas' => __('Separate ODSs with commas', 'jpf4bbp'),
			'add_or_remove_items'        => __('Add or remove ODSs', 'jpf4bbp'),
			'choose_from_most_used'      => __('Choose from the most used ODSs', 'jpf4bbp'),
			'menu_name'                  => __('ODSs', 'jpf4bbp'),
		);
	
		$args = array(
			'hierarchical'          => true,
			'labels'                => $labels,
			'public'                => true,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'query_var'             => true,
			'rewrite'               => array('slug' => 'odss'),
		);
	
		register_taxonomy('odss', 'topic', $args);
	}

	public function jpf4bbp_admin_groups_tabs() {
		$tabs_html    = '';
		$idle_class   = 'nav-tab';
		$active_class = 'nav-tab nav-tab-active';
		$active_tab   = '';

		$tabs = array();

		$tabs[] = array(
			'href'  => ( is_multisite() ) ? get_admin_url( get_current_blog_id(), add_query_arg( array( 'taxonomy' =>  'specialties', 'post_type' => bbp_get_topic_post_type() ), 'edit-tags.php' ) ) : bp_get_admin_url( add_query_arg( array( 'taxonomy' =>  'specialties', 'post_type' => bbp_get_topic_post_type() ), 'edit-tags.php' ) ),
			'name'  => __( 'Specialties', 'jpf4bbp' ),
			'class' => 'bp-tags',
		);

		$tabs[] = array(
			'href'  => ( is_multisite() ) ? get_admin_url( get_current_blog_id(), add_query_arg( array( 'taxonomy' =>  'odss', 'post_type' => bbp_get_topic_post_type() ), 'edit-tags.php' ) ) : bp_get_admin_url( add_query_arg( array( 'taxonomy' =>  'odss', 'post_type' => bbp_get_topic_post_type() ), 'edit-tags.php' ) ),
			'name'  => __( 'ODSs', 'jpf4bbp' ),
			'class' => 'bp-tags',
		);

		foreach ( array_values( $tabs ) as $tab_data ) {
			$is_current = (bool) ( $tab_data['name'] == $active_tab );
			$tab_class  = $is_current ? $tab_data['class'] . ' ' . $active_class : $tab_data['class'] . ' ' . $idle_class;
			$tabs_html .= '<a href="' . esc_url( $tab_data['href'] ) . '" class="' . esc_attr( $tab_class ) . '">' . esc_html( $tab_data['name'] ) . '</a>';
		}

		echo $tabs_html;
	}

}
