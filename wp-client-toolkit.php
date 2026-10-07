<?php
/**
 * Plugin Name:       WP Client Toolkit
 * Plugin URI:        https://github.com/Webloogix/client-toolkit
 * Description:       A professional toolkit for managing Client and Developer dashboard experiences and permissions.
 * Version:           1.6.0
 * Requires at least: 5.8
 * Requires PHP:      7.4
 * Author:            Webloogix
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wp-client-toolkit
 *
 * @package WP_Client_Toolkit
 */

if (! defined('ABSPATH')) {
    exit;
}

define('WPCT_VERSION', '1.6.0');
define('WPCT_PLUGIN_FILE', __FILE__);
define('WPCT_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('WPCT_PLUGIN_URL', plugin_dir_url(__FILE__));

/* Core: permission definitions and lookups. */
require_once WPCT_PLUGIN_DIR . 'includes/helpers.php';

/* Client restrictions: menus, URLs, actions, capabilities, comments. */
require_once WPCT_PLUGIN_DIR . 'includes/menu-restrictions.php';
require_once WPCT_PLUGIN_DIR . 'includes/url-restrictions.php';
require_once WPCT_PLUGIN_DIR . 'includes/action-restrictions.php';
require_once WPCT_PLUGIN_DIR . 'includes/capabilities.php';
require_once WPCT_PLUGIN_DIR . 'includes/comments.php';

/* Client dashboard experience. */
require_once WPCT_PLUGIN_DIR . 'includes/client-dashboard.php';

/* Settings screen (admin only). */
if (is_admin()) {
    require_once WPCT_PLUGIN_DIR . 'admin/menu.php';
    require_once WPCT_PLUGIN_DIR . 'admin/settings-save.php';
    require_once WPCT_PLUGIN_DIR . 'admin/settings-page.php';
    require_once WPCT_PLUGIN_DIR . 'admin/assets.php';
}
