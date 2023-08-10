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

}
