<?php
/**
 * Settings page controller.
 *
 * @package WP_Client_Toolkit
 */

if (! defined('ABSPATH')) {
    exit;
}

function wpct_settings_page() {

    if (! current_user_can('manage_options')) {

        wp_die(
            esc_html__(
                'You do not have permission to access this page.',
                'wp-client-toolkit'
            )
        );
    }

    $users = get_users(
        array(
            'orderby' => 'display_name',
            'order'   => 'ASC',
        )
    );

    $permissions = wpct_get_permissions();
    $granular    = wpct_get_granular_permissions();

    $notice      = wpct_process_settings_save(
        $users,
        $permissions,
        $granular
    );
    $notice_type = 'success';

    $enabled      = wpct_get_enabled_permissions();
    $client_users = wpct_get_client_users();

    $developer_count = count($users) - count($client_users);

    $views = WPCT_PLUGIN_DIR . 'admin/views/';

    if ($notice) {
        ?>
        <div class="notice notice-<?php echo esc_attr($notice_type); ?> is-dismissible">
            <p><?php echo esc_html($notice); ?></p>
        </div>
        <?php
    }

    ?>

    <div class="wrap wpct-admin-wrap">

        <?php
        include $views . 'header.php';
        include $views . 'tabs.php';
        include $views . 'panel-users.php';
        include $views . 'panel-defaults.php';
        include $views . 'panel-clients.php';
        include $views . 'panel-actions.php';
        include $views . 'security-notice.php';
        ?>

    </div>

    <?php
}
