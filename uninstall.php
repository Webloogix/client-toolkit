<?php
/**
 * Removes plugin data on uninstall.
 *
 * @package WP_Client_Toolkit
 */

if (! defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

delete_option('wpct_client_permissions');

delete_metadata('user', 0, 'wpct_user_mode', '', true);
delete_metadata('user', 0, 'wpct_user_permissions', '', true);
delete_metadata('user', 0, 'wpct_user_granular_permissions', '', true);
