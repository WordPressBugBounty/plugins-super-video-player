<?php
/**
 * Keep the Super Video Player menu as users know it.
 *
 * Until 1.8.18 the Freemius menu slug matched no admin menu, so Freemius never
 * added its own items to the Super Video Player menu (it added a second
 * top-level menu for its opt-in page instead). With the slug fixed in
 * super-video-player.php, Freemius would add "Account", "Contact Us",
 * "Support Forum" and "Upgrade" to the menu. They stay out of it: the Help &
 * Demos page already has pricing, and support runs through bplugins.com.
 *
 * Only the menu items are hidden. Freemius still registers the pages, so its
 * upgrade, trial and account links keep working, and the "Upgrade" link on
 * the Plugins screen stays: Freemius builds that link on admin_init, outside
 * the admin_menu run this filter is limited to.
 *
 * @package SuperVideoPlayer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Freemius "is_submenu_visible" filter.
 *
 * @param bool   $visible Whether Freemius would show the item.
 * @param string $id      Freemius submenu item: account, contact, support, pricing, ...
 * @return bool
 */
function svp_fs_is_submenu_visible( $visible, $id ) {
	// Freemius adds the "Support Forum" link on init, not admin_menu, and the
	// setting controls nothing else.
	if ( 'support' === $id ) {
		return false;
	}
	if ( ! in_array( $id, array( 'account', 'contact', 'pricing' ), true ) ) {
		return $visible;
	}
	if ( doing_action( 'admin_menu' ) || doing_action( 'network_admin_menu' ) ) {
		return false;
	}
	return $visible;
}

if ( function_exists( 'svp_fs' ) ) {
	svp_fs()->add_filter( 'is_submenu_visible', 'svp_fs_is_submenu_visible', 10, 2 );
}
