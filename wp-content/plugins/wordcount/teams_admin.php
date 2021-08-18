<?php
/**
 * BuddyBoss Groups component admin screen.
 *
 * Props to WordPress core for the Comments admin screen, and its contextual
 * help text, on which this implementation is heavily based.
 *
 * @package BuddyBoss\Groups
 * @since BuddyPress 1.7.0
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Include WP's list table class.
if ( ! class_exists( 'WP_List_Table' ) ) {
	require ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

// The per_page screen option. Has to be hooked in extremely early.
if ( is_admin() && ! empty( $_REQUEST['page'] ) && 'bp-groups' == $_REQUEST['page'] ) {
	add_filter( 'set-screen-option', 'bp_groups_admin_screen_options', 10, 3 );
}

/**
 * Register the Groups component in BuddyBoss > Groups admin screen.
 *
 * @since BuddyPress 1.7.0
 */
function bp_groups_add_admin_menu() {

	if ( true === bp_disable_group_type_creation() ) {

		// Add our screen.
		$hooks[] = add_submenu_page(
			'buddyboss-platform',
			__( 'Teams', 'buddyboss' ),
			__( 'Teams', 'buddyboss' ),
			'bp_moderate',
			'bp-groups',
			'bp_groups_admin'
		);

	} else {
		// Add our screen.
		$hooks[] = add_submenu_page(
			'buddyboss-platform',
			__( 'Teams', 'buddyboss' ),
			__( 'Teams', 'buddyboss' ),
			'bp_moderate',
			'bp-groups',
			'bp_groups_admin'
		);
	}

	foreach ( $hooks as $hook ) {
		// Hook into early actions to load custom CSS and our init handler.
		add_action( "load-$hook", 'bp_groups_admin_load' );
	}
}
add_action( bp_core_admin_hook(), 'bp_groups_add_admin_menu', 60 );