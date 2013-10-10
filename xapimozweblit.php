<?php
/**
 * Plugin Name: xAPI Mozilla Web Literacy Standards
 * Plugin URI: http://.../xapimozweblit
 * Description: This plugin was developed as an <acronym title="Advanced Distributed Learning">ADL</acronym> design team project for the Experience <acronym title="Application Programming Interface">API</acronym>
 * Version: 0.0.1
 * Author: Dustin Vietzke
 * Author URI: http://vitzkrieg.net
 *
 * === RELEASE NOTES ===
 * 2013-09-18 - v1.0 - first version
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
 * Online: http://www.gnu.org/licenses/gpl.txt
 *
 * @package xAPI_Mozilla_Web_Lits
 * @version 0.0.1
 * @author Dustin Vietzke <dustin@vitzkrieg.net>
 * @copyright Copyright (c) 2013, Dustin Vietzke
 * @link http://.../xapimozweblit
 * @license http://www.gnu.org/licenses/gpl.txt
 */

/*
*/

/**
 * @class xAPI_Mozilla_Web_Lits
 *
 * @since 0.0.1
 */
class xAPI_Mozilla_Web_Lits_Load {

	/**
	 * PHP4 constructor method.  This will be removed once the plugin only supports WordPress 3.2,
	 * which is the version that drops PHP4 support.
	 *
	 * @since 0.0.1
	 */
	function xAPI_Mozilla_Web_Lits_Load() {
		$this->__construct();
	}

	/**
	 * PHP5 constructor method.
	 *
	 * @since 0.0.1
	 */
	function __construct() {
		global $xapimozweblit;

		/* Set up an empty class for the global $xapimozweblit object.
		$xapimozweblit = new stdClass;*/

		/* Set the constants needed by the plugin. */
		add_action( 'plugins_loaded', array( &$this, 'constants' ), 1 );

		/* Internationalize the text strings used.*/
		add_action( 'plugins_loaded', array( &$this, 'i18n' ), 2 );

		/* Load the functions files. */
		add_action( 'plugins_loaded', array( &$this, 'includes' ), 3 );

		// if both logged in and not logged in users can send this AJAX request,
		// add both of these actions, otherwise add only the appropriate one
		add_action( 'wp_ajax_nopriv_myajax-submit', array( &$this, 'myajax_submit' ), 4 );
		add_action( 'wp_ajax_myajax-submit', array( &$this, 'myajax_submit' ), 4 );
		add_action( 'wp_ajax_nopriv_myajax-button', array( &$this, 'myajax_button' ), 4 );
		add_action( 'wp_ajax_myajax-button', array( &$this, 'myajax_button' ), 4 );

		/* Load the necessary JavaScript files */
		add_action("init", array( &$this, 'xapimozweblit_scripts' ), 10 );

		/* Filter for custom template(s) */
		add_filter( 'template_include', array( &$this, 'xapimozweblit_template_chooser' ) );

		/* Load the admin files.
		add_action( 'plugins_loaded', array( &$this, 'admin' ), 4 );*/

		/* Register activation hook. */
		register_activation_hook( __FILE__, array( &$this, 'activation' ) );
	}

	/**
	 * Defines constants used by the plugin.
	 *
	 * @since 0.0.1
	 */
	function constants() {

		/*
		 * Used on back end
		 */

		/* Set the version number of the plugin. */
		define( 'XAPIMOZWEBLIT_VERSION', '0.0.1' );

		/* Set constant path to the xapimozweblit plugin directory. */
		define( 'XAPIMOZWEBLIT_BASE_FILE', __FILE__ );

		/* Set constant path to the xapimozweblit plugin directory. */
		define( 'XAPIMOZWEBLIT_DIR', trailingslashit( plugin_dir_path( XAPIMOZWEBLIT_BASE_FILE ) ) );

		/* Set constant path to the xapimozweblit plugin URL. */
		define( 'XAPIMOZWEBLIT_URI', trailingslashit( plugin_dir_url( XAPIMOZWEBLIT_BASE_FILE ) ) );

		/* Set the constant path to the xapimozweblit includes directory. */
		define( 'XAPIMOZWEBLIT_INCLUDES', XAPIMOZWEBLIT_DIR . trailingslashit( 'includes' ) );

		/* Set the constant path to the xapimozweblit admin directory.
		define( 'XAPIMOZWEBLIT_ADMIN', XAPIMOZWEBLIT_DIR . trailingslashit( 'admin' ) );*/

		/* Set the constant path to the xapimozweblit templates directory. */
		define( 'XAPIMOZWEBLIT_TEMPLATES', XAPIMOZWEBLIT_DIR . trailingslashit( 'templates' ) );

		/* Set the constant path to the xapimozweblit templates directory. */
		define( 'XAPIMOZWEBLIT_IMAGES', XAPIMOZWEBLIT_DIR . trailingslashit( 'images' ) );

		/*
		 * Used on front end
		 */

		/* Set the constant path to the xapimozweblit js directory. */
		define( 'XAPIMOZWEBLIT_JS', XAPIMOZWEBLIT_URI . trailingslashit( 'js' ) );

		/* Set the constant path to the xapimozweblit ajax directory. */
		define( 'XAPIMOZWEBLIT_AJAX', XAPIMOZWEBLIT_URI . trailingslashit( 'ajax' ) );
	}


	/**
	 * Loads the initial files needed by the plugin.
	 *
	 * @since 0.0.1
	 */
	function includes() {

		/* Load the plugin custom post type file. */
		require_once( XAPIMOZWEBLIT_INCLUDES . 'xapimozweblit_post_type.php' );

		/* Load the plugin functions file. */
		require_once( XAPIMOZWEBLIT_INCLUDES . 'functions.php' );

		/* Load the update functionality.
		require_once( XAPIMOZWEBLIT_INCLUDES . 'update.php' );*/

		/* Load the admin bar functions.
		require_once( XAPIMOZWEBLIT_INCLUDES . 'admin-bar.php' );*/

		/* Load the functions related to capabilities.
		require_once( XAPIMOZWEBLIT_INCLUDES . 'capabilities.php' );*/

		/* Load the content permissions functions.
		require_once( XAPIMOZWEBLIT_INCLUDES . 'content-permissions.php' );*/

		/* Load the private site functions.
		require_once( XAPIMOZWEBLIT_INCLUDES . 'private-site.php' );*/

		/* Load the shortcodes functions file.
		require_once( XAPIMOZWEBLIT_INCLUDES . 'shortcodes.php' );*/

		/* Load the template functions.
		require_once( XAPIMOZWEBLIT_INCLUDES . 'template.php' );*/

		/* Load the widgets functions file.
		require_once( XAPIMOZWEBLIT_INCLUDES . 'widgets.php' );*/
	}

	/**
	 * Loads the translation files.
	 *
	 * @since 0.0.1
	 */
	function i18n() {

		/* Load the translation of the plugin. */
		load_plugin_textdomain( 'xapimozweblit', false, 'xapimozweblit/languages' );
	}

	/**
	 * Loads the admin functions and files.
	 *
	 * @since 0.0.1
	 */
	function admin() {

		/* Only load files if in the WordPress admin. */
		if ( is_admin() ) {

			/* Load the main admin file.
			require_once( XAPIMOZWEBLIT_ADMIN . 'admin.php' );*/

			/* Load the plugin settings.
			require_once( XAPIMOZWEBLIT_ADMIN . 'settings.php' );*/
		}
	}

	/**
	 * Method that runs only when the plugin is activated.
	 *
	 * @since 0.0.1
	 */
	function activation() {

		/* Get the administrator role. */
		$role =& get_role( 'administrator' );

		/* If the administrator role exists, add required capabilities for the plugin. */
		if ( !empty( $role ) ) {

			/* xAPI mozweblit management capabilities. */
			$role->add_cap( 'edit_xapimozweblit' );
			$role->add_cap( 'read_xapimozweblit' );
			$role->add_cap( 'delete_xapimozweblit' );
			$role->add_cap( 'edit_xapimozweblits' );
			$role->add_cap( 'edit_others_xapimozweblits' );
			$role->add_cap( 'publish_xapimozweblits' );
			$role->add_cap( 'read_private_xapimozweblits' );

			/* mozweblit Taxonomy permissions capabilities. */
			$role->add_cap( 'manage_mozweblits' );
			$role->add_cap( 'edit_mozweblits' );
			$role->add_cap( 'delete_mozweblits' );
			$role->add_cap( 'assign_mozweblits' );
		}

	}

	/**
	 * Loads the front-end JavaScript files
	 *
	 * @global type $post
	 * @global type $wp_query
	 * @since 0.0.1
	 */
	function xapimozweblit_scripts(){

		wp_enqueue_script( 'google-jquery',
			'//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js', array( 'jquery' ) ,
			'', false );

		wp_enqueue_script( 'ckeditor',
			get_bloginfo('url') .'/wp-content/plugins/ckeditor-for-wordpress/ckeditor/ckeditor.js',
			array( 'google-jquery' ),
			'', false );

		wp_enqueue_script( 'ckeditor-jquery',
			get_bloginfo('url') .'/wp-content/plugins/ckeditor-for-wordpress/ckeditor/adapters/jquery.js',
			array( 'ckeditor' ),
			'', false );

		wp_enqueue_script( 'adl-verbs',
			XAPIMOZWEBLIT_JS. 'verbs.js',
			array( 'ckeditor-jquery' ),
			'', false );

		wp_enqueue_script( 'xapimozweblit',
			XAPIMOZWEBLIT_JS. 'xapimozweblit.js',
			array( 'adl-verbs' ),
			'', false );

		global $post;
		global $wp_query;
		$postID = $post-ID;

		wp_localize_script( 'xapimozweblit', 'MyAjax', array(
			// URL to wp-admin/admin-ajax.php to process the request
			'ajaxurl'          => admin_url( 'admin-ajax.php' ),

			// generate a nonce with a unique ID "myajax-post-comment-nonce"
			// so that you can check it later when an AJAX request is sent
			'postCommentNonce' => wp_create_nonce( 'myajax-post-comment-nonce' ),
			'post' => $post,
			'postID' => $postID,
			'wp_query' => $wp_query,
			)
		);

	}

	/**
	 * Get the custom template if is set
	 *
	 * @since 0.0.1
	 */
	function xapimozweblit_template_hierarchy( $template ) {

		// Get the template slug
		$template_slug = rtrim( $template, '.php' );
		$template = $template_slug . '.php';

		// Check if a custom template exists in the theme folder,
		// if not, load the plugin template file
		if ( $theme_file = locate_template( array( '/xapimozweblit_template/' . $template ) ) ) {
			$file = $theme_file;
		}
		else {
		   $file = XAPIMOZWEBLIT_TEMPLATES . $template;
		}

		//$file = locate_template( array( '/xapimozweblit_template/' . $template, XAPIMOZWEBLIT_TEMPLATES . $template ));

		if (!$file){
			return '';
		}

		return apply_filters( 'xapimozweblit_repl_template_' . $template, $file );
	}

	/**
	 * Returns template file
	 *
	 * @since 0.0.1
	 */
	function xapimozweblit_template_chooser( $template ) {

		// Post ID
		$post_id = get_the_ID();

		$post_type = get_post_type( $post_id );

		// For all other CPT
		if ( $post_type == 'xapimozweblit' ) {

			$mb_template = '';

			// Else use custom template
			if ( is_single() ) {
			   $mb_template = $this->xapimozweblit_template_hierarchy( 'post-' . $post_type );
			} else {
			   $mb_template = $this->xapimozweblit_template_hierarchy( 'archive-' . $post_type );
			}

		}

		if ( is_tax('mozweblit') ) {

			$mb_template = $this->xapimozweblit_template_hierarchy( 'taxonomy-mozweblit' );

		}

		return ($mb_template != '') ? $mb_template : $template;

	}

	/**
	 * Handles the AJAX call coming from the submit button on the front-end
	 *
	 * @since 0.0.1
	 */
	function myajax_submit() {

	    $nonce = $_POST['postCommentNonce'];

	    // check to see if the submitted nonce matches with the
	    // generated nonce we created earlier
	    if ( ! wp_verify_nonce( $nonce, 'myajax-post-comment-nonce' ) ){
	        die ( 'Busted!');
	    }


	    $name = (isset($data["name"])) ? $data["name"] : "Unknown User";
	    $verb = (isset($data["verb"])) ? $data["verb"] : "answered";
	    $response = (isset($data["result"])) ? $data["result"]["response"] : NULL;

	    $statement = $name;

	    $statement .= " " . $verb;

	    $statement .= " with " . $object;

	    $is_valid = false;


	    if($response){
	        if ($errors = xapimozweblit_validate_user_html('' . $response)) {
	            $valid_str = " is valid.";
	            $is_valid = true;
	        } else {
	            $valid_str = " is not valid.";

	            foreach ($errors as $error) {
	                $valid_str .= PHP_EOL . $error;
	            }
	        }

	        $statement .= " and " . $valid_str . PHP_EOL . $response;
	    }

	    $result =  array(
						"success" => $is_valid
						);

		$postID = $_POST["postID"];

	    echo $this->grassblade_dynamic($postID, $verb, $object, $result);

	    // IMPORTANT: don't forget to "exit"
	    exit;
	}

	/**
	 * Handles button clicks coming from the front-end CKEditor
	 *
	 * @since 0.0.1
	 */
	function myajax_button() {

		echo "myajax_button()";

	    $nonce = $_POST['postCommentNonce'];

	    // check to see if the submitted nonce matches with the
	    // generated nonce we created earlier
	    if ( ! wp_verify_nonce( $nonce, 'myajax-post-comment-nonce' ) ){
	        die ( 'Busted!');
	    }

	    $data = $_POST["data"];
	    $name = (isset($data["name"])) ? $data["name"] : "a button";
	    $verb = (isset($data["verb"])) ? $data["verb"] : "interacted";

		$postID = $_POST["postID"];

	    echo $this->grassblade_dynamic($postID, $verb, $name, null);

	    // IMPORTANT: don't forget to "exit"
	    exit;
	}

	/*
	 * Takes the data passed from the front-end and passes it to Grassblade
	 *
	 * @verb = supported xAPI verb
	 * @result = was the activity completed succesfully?
	 * @object = the WordPress page the activity was attempted on
	 * @context = the larger picture the activity is included in (Moz Web Lit)
	 */
	function grassblade_dynamic($postID, $verb, $object, $result){

		$return = 'grassblade_dynamic()' . '<br />';

		if ( !function_exists ( "grassblade_send_statements" ) ) {
		$return .= "grassblade_send_statements() does not exist." . '<br />';
			return $return;
		}

		if(!$uri = get_permalink( $postID )){
			$uri = "http://example.com";
		}

		$pTitle = "No title";

		$pDesc = "Post data unavailable";

		if ( $pObj = get_post( $postID ) ) {

			$pTitle = $pObj->post_title;
			$pDesc = $pObj->post_excerpt;

		}

		if($object){
			$uri .= "#" . $object;

			$pTitle = $object;
			$pDesc = "CKEditor button: " . $object;
		}

		if (is_string($verb)) {
			$verb =  grassblade_getverb($verb);
		}

		$statement = 	array(
			"actor" => grassblade_getactor($guest_tracking = true),
			"verb" => $verb,
			/*
			Make this be the page they are currently on
			*/
			//"object" => grassblade_getobject("http://domain.com/wordpress/quizzes/quiz-1/", "Walkthrough Link", "Test Desc", "http://adlnet.gov/expapi/activities/interaction"),
			//object" => $this->getxAPIPostObject($postID),
			"object" => grassblade_getobject($uri, $pTitle, $pDesc, "http://adlnet.gov/expapi/activities/assessment"),
			/*
			Need to customize this
			Probably have it realate to the Moz Web Lit(s)
			"context" => array(
							"contextActivities" => array(
								"parent" => grassblade_getobject("http://domain.com/wordpress/course/course-1/", "Test Parent", "Test Parent Desc", "http://adlnet.gov/expapi/activities/course"),
								"grouping" => grassblade_getobject("http://domain.com/wordpress/course/course-1/", "Test Parent", "Test Parent Desc", "http://adlnet.gov/expapi/activities/course"),
							)
						),
						*/
			"context" => $this->getxAPIPostContext($postID),
			);

		if($result){
			$statement[	"result" ] =  $result;
		}

		$statements = array($statement);

		//Uncomment to debug
		/*
		$return .= "<h3>Statement</h3>" . '<br />';
		$return .=  "<pre>" . '<br />';
		$return .= print_r($statements) . '<br />';
		$return .= "</pre>" . '<br />';
		$return .= "<h3>Return Value</h3>" . '<br />';
		$return .= "<pre>" . '<br />';
		$return .= print_r(grassblade_send_statements($statements)) . '<br />';
		$return .= "</pre>";

		return $return;
*/
		grassblade_send_statements($statements);
	}

	/*
	 * Creates an xAPI Object from the given WordPress post id
	 * @param { Integer } $id WordPress post id
	 */
	function getxAPIPostObject($id){

		if(!$pObj = get_post($id)){
			return NULL;
		}

		$pURI = get_permalink( $id );

		$pTitle = $pObj->post_title;
		$pDesc = $pObj->post_excerpt;

		return grassblade_getobject($pURI, $pTitle, $pDesc, "http://adlnet.gov/expapi/activities/objective/");
	}

	/*
	 * Creates an xAPI Context object from the given WordPress post id
	 * @param { Integer } $id WordPress post id
	 */
	function getxAPIPostContext($id){

		if(!$pObj = get_post($id)){
			return NULL;
		}

		$contextParent = NULL;

		if($parent = $pObj->post_parent){
			$contextParent = $this->getxAPIPostObject( $pObj->post_parent );
		}

		$context = array (
			//"registration" => get_permalink( $id ),
			"contextActivities" => array(
					"parent" => $this->getxAPIPostObject( $pObj->post_parent )
				),
			);

		return $context;
	}
}

$xapimozweblit_load = new xAPI_Mozilla_Web_Lits_Load();

?>