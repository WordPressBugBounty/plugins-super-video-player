<?php
/**
 * Keep the plugin's Freemius notices on the plugin's own screens.
 *
 * Until the site owner opts in or skips, Freemius re-adds "You are just one
 * step away - Complete "Super Video Player" Activation Now" on every admin
 * page load, and after an update it pins "We made a few tweaks to the
 * plugin, Opt in..." to the top of every admin screen - Dashboard, Posts,
 * Pages and all. Uninstall feedback named it ("spam me with notifications").
 *
 * They still show where the plugin is used: its own screens (players, Help
 * & Demos, the Freemius account pages) and the Plugins screen.
 *
 * @package SuperVideoPlayer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @param WP_Screen|null $screen The current admin screen.
 * @return bool Whether this is one of the plugin's screens, or the Plugins screen.
 */
function svp_is_plugin_admin_screen( $screen ) {
	if ( ! $screen ) {
		return true; // Unknown context: do not hide anything.
	}
	if ( in_array( $screen->id, array( 'plugins', 'plugins-network' ), true ) ) {
		return true;
	}
	return 'svplayer' === $screen->post_type || false !== strpos( (string) $screen->id, 'svplayer' );
}

/**
 * Freemius "show_admin_notice" filter.
 *
 * @param bool  $show Whether Freemius would show the notice.
 * @param array $msg  The notice.
 * @return bool
 */
function svp_fs_show_admin_notice( $show, $msg ) {
	if ( true !== $show ) {
		return $show;
	}
	return svp_is_plugin_admin_screen( function_exists( 'get_current_screen' ) ? get_current_screen() : null );
}

if ( function_exists( 'svp_fs' ) ) {
	svp_fs()->add_filter( 'show_admin_notice', 'svp_fs_show_admin_notice', 10, 2 );
}
