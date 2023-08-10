<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://ween.codes
 * @since      1.0.0
 *
 * @package    Jpf4bbp
 * @subpackage Jpf4bbp/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Jpf4bbp
 * @subpackage Jpf4bbp/public
 * @author     Ween Codes <weencodes@gmail.com>
 */
class Jpf4bbp_Public {

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

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( 'bootstrap', plugin_dir_url( __FILE__ ) . 'css/bootstrap.css', array(), $this->version );

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/jpf4bbp-public.css', array(), $this->version, 'all' );

		wp_enqueue_style( 'datatables-css', '//cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css', array(), '1.13.5', 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/jpf4bbp-public.js', array( 'jquery' ), $this->version, false );

		wp_localize_script( 'wp-api', 'wpApiSettings', array(
			'root' => esc_url_raw( rest_url() ),
			'nonce' => wp_create_nonce( 'wp_rest' )
		));

		wp_enqueue_script('wp-api');

		wp_enqueue_script( 'datatables-js', '//cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js', array( 'jquery' ), '1.13.5', false );

	}

	public function jpf4bbp_tab_objectives() {
		global $bp;
   
		if ( current_user_can( 'moderate' ) || current_user_can( 'company' ) ) {
		
			bp_core_new_nav_item( array(
				'name' 					  => __( 'Opportunities', 'jpf4bbp' ),
				'slug' 					  => __( 'opportunities', 'jpf4bbp' ),
				'screen_function' 		  => array( $this, 'jpf4bbp_objectives_screen' ),
				'position' 				  => 90,
				'parent_url'      		  => bp_loggedin_user_domain() . '/opportunities/',
				'parent_slug'     		  => $bp->profile->slug,
				'default_subnav_slug' 	  => 'lista',
				'show_for_displayed_user' => false
			));
		}
	}

	public function jpf4bbp_objectives_screen() {
		
		add_action( 'bp_template_title', array( $this, 'jpf4bbp_objectives_title' ) );
		add_action( 'bp_template_content', array( $this, 'jpf4bbp_objectives_content' ) );
		bp_core_load_template( 'buddypress/members/single/plugins' );
	}
	
	public function jpf4bbp_objectives_title() {
		_e( 'Opportunities', 'jpf4bbp' );
	}
	
	public function jpf4bbp_objectives_content() {
		include 'partials/jpf4bbp-objectives-topics.php';
	}

	public function jpf4bbp_get_topic_statuses() {
		$statuses = array(
			bbp_get_pending_status_id() => __( 'Pending', 'jpf4bbp' ),
			bbp_get_public_status_id()  => __( 'Open', 'jpf4bbp' ),
			bbp_get_closed_status_id()  => __( 'Closed', 'jpf4bbp' ),
			bbp_get_trash_status_id()   => __( 'Trash', 'jpf4bbp' )
		);

		if ( current_user_can( 'company' ) ) {
			unset( $statuses[bbp_get_spam_status_id()] );
			unset( $statuses[bbp_get_pending_status_id()] );
		}

		return $statuses;
	}

	public function jpf4bbp_change_default_topic_status( $args ) {
		$forum_id = (int) $_POST['bbp_forum_id'];
		$bbp_objective = get_post_meta( $forum_id, 'bbp_objective', true );
		if ( current_user_can( 'company' ) && 2 == $bbp_objective ) {
			$args['post_status'] = bbp_get_pending_status_id();
		}
	
		return $args;
	}

	public function jpf4bbp_save_topic_status( $post ) {
		$ok = null;
		
		if ( $post ) {
			$topic = array(
				'ID'           => $post['id'],
				'post_status'  => $post['status']
			);
			$ok = wp_update_post( $topic );
		}

		return
		!$post || !$ok || is_wp_error( $ok )
		? 400
		: 200;
	}

	public function jpf4bbp_add_rest_api_routes() {

		register_rest_route( 'jpf4bbp', '/change-topic-status', array(
			'methods' => 'POST',
			'callback' => array( $this, 'jpf4bbp_save_topic_status' ),
			'permission_callback' => function () {
				return current_user_can( 'moderate' ) || current_user_can( 'company' );
			}
		));
	}

	public function jpf4bbp_current_forum_has_opportunity_objective() {
		$forum_id = bbp_get_forum_id();
		return 2 == get_post_meta( $forum_id, 'bbp_objective', true ) || null;
	}

	public function jpf4bbp_current_user_can_create_topic( $ret_val ) {

		if ( $this->jpf4bbp_current_forum_has_opportunity_objective() ) {
			return current_user_can( 'moderate' ) || current_user_can( 'company' );
		}

    	return $ret_val;
	}

}
