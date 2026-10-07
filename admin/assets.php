<?php
/**
 * Enqueue stylesheets and scripts.
 *
 * @package WP_Client_Toolkit
 */

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Settings page assets.
 */
function wpct_enqueue_admin_assets($hook_suffix) {

    if ($hook_suffix !== 'toplevel_page_wp-client-toolkit') {
        return;
    }

    wp_enqueue_style(
        'wpct-admin',
        WPCT_PLUGIN_URL . 'assets/css/admin.css',
        array(),
        WPCT_VERSION
    );

    wp_enqueue_script(
        'wpct-admin',
        WPCT_PLUGIN_URL . 'assets/js/admin.js',
        array(),
        WPCT_VERSION,
        true
    );
}

add_action(
    'admin_enqueue_scripts',
    'wpct_enqueue_admin_assets'
);


/**
 * Client dashboard assets.
 */
function wpct_enqueue_client_dashboard_assets($hook_suffix) {

    if (
        $hook_suffix !== 'index.php' ||
        ! wpct_is_client()
    ) {
        return;
    }

    wp_enqueue_style(
        'wpct-client-dashboard',
        WPCT_PLUGIN_URL . 'assets/css/client-dashboard.css',
        array(),
        WPCT_VERSION
    );
}

add_action(
    'admin_enqueue_scripts',
    'wpct_enqueue_client_dashboard_assets'
);
