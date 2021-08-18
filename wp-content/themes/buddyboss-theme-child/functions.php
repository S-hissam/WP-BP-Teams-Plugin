<?php
/**
 * @package BuddyBoss Child
 * The parent theme functions are located at /buddyboss-theme/inc/theme/functions.php
 * Add your own functions at the bottom of this file.
 */


/****************************** THEME SETUP ******************************/

/**
 * Sets up theme for translation
 *
 * @since BuddyBoss Child 1.0.0
 */
function buddyboss_theme_child_languages()
{
  /**
   * Makes child theme available for translation.
   * Translations can be added into the /languages/ directory.
   */

  // Translate text from the PARENT theme.
  load_theme_textdomain( 'buddyboss-theme', get_stylesheet_directory() . '/languages' );

  // Translate text from the CHILD theme only.
  // Change 'buddyboss-theme' instances in all child theme files to 'buddyboss-theme-child'.
  // load_theme_textdomain( 'buddyboss-theme-child', get_stylesheet_directory() . '/languages' );

}
add_action( 'after_setup_theme', 'buddyboss_theme_child_languages' );

/**
 * Enqueues scripts and styles for child theme front-end.
 *
 * @since Boss Child Theme  1.0.0
 */
function buddyboss_theme_child_scripts_styles()
{
  /**
   * Scripts and Styles loaded by the parent theme can be unloaded if needed
   * using wp_deregister_script or wp_deregister_style.
   *
   * See the WordPress Codex for more information about those functions:
   * http://codex.wordpress.org/Function_Reference/wp_deregister_script
   * http://codex.wordpress.org/Function_Reference/wp_deregister_style
   **/

  // Styles
  wp_enqueue_style( 'buddyboss-child-css', get_stylesheet_directory_uri().'/assets/css/custom.css', '', '1.0.0' );

  // Javascript
  wp_enqueue_script( 'buddyboss-child-js', get_stylesheet_directory_uri().'/assets/js/custom.js', '', '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'buddyboss_theme_child_scripts_styles', 9999 );


/****************************** CUSTOM FUNCTIONS ******************************/

// Add your own custom functions here
function redirect_to_page( $redirect_to_calculated, $redirect_url_specified, $user ) {
	return home_url() ."/dashboard/" ;
}
add_filter( 'login_redirect', 'redirect_to_page', 100, 3 );

function bbp_logout_redirect(){
  wp_safe_redirect( home_url() );
  exit;
}
add_action('wp_logout','bbp_logout_redirect');

function send_notification_to_nk($notification, $user) {
	// Todo
	write_log("Hello from us");
	
}
add_filter( 'bp_rest_notifications_pre_insert_value', "send_notification_to_nk" );

//Force BuddyBoss Platform to use HTML not text
function bb_use_html_wp_mail() {
return 'text/html';
}
add_filter( 'wp_mail_content_type', 'bb_use_html_wp_mail' );
function bb_get_bp_email_content_plaintext( $content = '', $property = 'content_plaintext', $transform = 'replace-tokens', $bp_email ) {
if ( ! did_action( 'bp_send_email' ) ) {
return $content;
}
return $bp_email->get_template( 'add-content' );
}
add_filter( 'bp_email_get_content_plaintext', 'bb_get_bp_email_content_plaintext', 10, 4 );

//Force BuddyBoss Platform to use WP_MAIL
add_filter('bp_email_use_wp_mail', '__return_true');

?>