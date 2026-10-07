<?php
/**
 * View: Tab navigation.
 *
 * Rendered inside wpct_settings_page(); $users, $client_users, $permissions,
 * $granular and $enabled are available.
 *
 * @package WP_Client_Toolkit
 */

if (! defined('ABSPATH')) {
    exit;
}
?>
        <!-- ==============================================================
             TABS
             ============================================================== -->

        <nav
            class="wpct-tabs"
            aria-label="Client Toolkit sections"
        >

            <button
                type="button"
                class="wpct-tab is-active"
                data-target="wpct-users"
            >
                <span class="dashicons dashicons-admin-users"></span>
                Users &amp; Modes
            </button>


            <button
                type="button"
                class="wpct-tab"
                data-target="wpct-defaults"
            >
                <span class="dashicons dashicons-admin-settings"></span>
                Default Access
            </button>


            <button
                type="button"
                class="wpct-tab"
                data-target="wpct-clients"
            >
                <span class="dashicons dashicons-businessperson"></span>
                Client Access
            </button>


            <button
                type="button"
                class="wpct-tab"
                data-target="wpct-actions"
            >
                <span class="dashicons dashicons-lock"></span>
                Action Permissions
            </button>

        </nav>
