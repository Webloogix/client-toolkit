<?php
/**
 * Hides admin menu items from Client users.
 *
 * @package WP_Client_Toolkit
 */

if (! defined('ABSPATH')) {
    exit;
}

/* ==========================================================================
   CLIENT ADMIN MENU RESTRICTIONS
   ========================================================================== */

function wpct_hide_client_menus() {

    if (
        ! is_admin() ||
        ! wpct_is_client()
    ) {
        return;
    }


    if (! wpct_client_has_permission('posts')) {
        remove_menu_page('edit.php');
    }


    if (! wpct_client_has_permission('pages')) {
        remove_menu_page('edit.php?post_type=page');
    }


    if (! wpct_client_has_permission('media')) {
        remove_menu_page('upload.php');
    }


    if (! wpct_client_has_permission('comments')) {
        remove_menu_page('edit-comments.php');
    }


    /*
     * Always hidden for Clients.
     */

    remove_menu_page('plugins.php');
    remove_menu_page('themes.php');
    remove_menu_page('tools.php');
    remove_menu_page('options-general.php');
    remove_menu_page('users.php');
}

add_action(
    'admin_menu',
    'wpct_hide_client_menus',
    999
);
