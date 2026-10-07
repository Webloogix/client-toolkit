<?php
/**
 * Admin menu registration.
 *
 * @package WP_Client_Toolkit
 */

if (! defined('ABSPATH')) {
    exit;
}

/* ==========================================================================
   ADMIN MENU
   ========================================================================== */

function wpct_add_admin_menu() {

    add_menu_page(
        'WP Client Toolkit',
        'Client Toolkit',
        'manage_options',
        'wp-client-toolkit',
        'wpct_settings_page',
        'dashicons-admin-users',
        30
    );
}

add_action(
    'admin_menu',
    'wpct_add_admin_menu'
);
