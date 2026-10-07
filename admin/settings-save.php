<?php
/**
 * Settings form handlers.
 *
 * @package WP_Client_Toolkit
 */

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Process any submitted settings form.
 *
 * @param WP_User[] $users       All site users.
 * @param array     $permissions Feature definitions.
 * @param array     $granular    Granular action definitions.
 *
 * @return string Success notice, or an empty string when nothing was saved.
 */
function wpct_process_settings_save(
    $users,
    $permissions,
    $granular
) {

    $notice = '';

    if (isset($_POST['wpct_save_modes'])) {

        check_admin_referer(
            'wpct_save_user_modes',
            'wpct_nonce'
        );

        $modes = isset($_POST['wpct_mode'])
            ? (array) wp_unslash($_POST['wpct_mode'])
            : array();

        $current_id = get_current_user_id();

        foreach ($users as $user) {

            $mode = isset($modes[$user->ID])
                ? sanitize_key($modes[$user->ID])
                : 'developer';

            /*
             * Current admin account can never become Client.
             */
            if (
                $user->ID === $current_id ||
                ! in_array(
                    $mode,
                    array('developer', 'client'),
                    true
                )
            ) {
                $mode = 'developer';
            }

            update_user_meta(
                $user->ID,
                'wpct_user_mode',
                $mode
            );

            /*
             * Remove Client-specific settings when switching
             * a user back to Developer.
             */
            if ($mode !== 'client') {

                delete_user_meta(
                    $user->ID,
                    'wpct_user_permissions'
                );

                delete_user_meta(
                    $user->ID,
                    'wpct_user_granular_permissions'
                );
            }
        }

        $notice = 'User modes saved successfully.';
    }


    /* ----------------------------------------------------------------------
       SAVE DEFAULT ACCESS
       ---------------------------------------------------------------------- */

    if (isset($_POST['wpct_save_defaults'])) {

        check_admin_referer(
            'wpct_save_defaults',
            'wpct_defaults_nonce'
        );

        $submitted = isset($_POST['wpct_permissions'])
            ? (array) wp_unslash($_POST['wpct_permissions'])
            : array();

        $submitted = array_map(
            'sanitize_key',
            $submitted
        );

        $enabled = array_values(
            array_intersect(
                array_keys($permissions),
                $submitted
            )
        );

        update_option(
            'wpct_client_permissions',
            $enabled
        );

        $notice = 'Default Client access saved successfully.';
    }


    /* ----------------------------------------------------------------------
       SAVE INDIVIDUAL CLIENT ACCESS
       ---------------------------------------------------------------------- */

    if (isset($_POST['wpct_save_client_access'])) {

        check_admin_referer(
            'wpct_save_client_access',
            'wpct_client_access_nonce'
        );

        $submitted = isset($_POST['wpct_user_permissions'])
            ? (array) wp_unslash($_POST['wpct_user_permissions'])
            : array();

        $available = array_keys($permissions);

        foreach ($users as $user) {

            if (! wpct_is_client($user->ID)) {
                continue;
            }

            $values = isset($submitted[$user->ID])
                ? (array) $submitted[$user->ID]
                : array();

            $values = array_map(
                'sanitize_key',
                $values
            );

            update_user_meta(
                $user->ID,
                'wpct_user_permissions',
                array_values(
                    array_intersect(
                        $available,
                        $values
                    )
                )
            );
        }

        $notice = 'Individual Client access saved successfully.';
    }


    /* ----------------------------------------------------------------------
       SAVE GRANULAR ACTION PERMISSIONS
       ---------------------------------------------------------------------- */

    if (isset($_POST['wpct_save_actions'])) {

        check_admin_referer(
            'wpct_save_actions',
            'wpct_actions_nonce'
        );

        $submitted = isset($_POST['wpct_user_granular_permissions'])
            ? (array) wp_unslash(
                $_POST['wpct_user_granular_permissions']
            )
            : array();

        foreach ($users as $user) {

            if (! wpct_is_client($user->ID)) {
                continue;
            }

            $clean = array();

            foreach ($granular as $type => $actions) {

                $values = isset(
                    $submitted[$user->ID][$type]
                )
                    ? (array) $submitted[$user->ID][$type]
                    : array();

                $values = array_map(
                    'sanitize_key',
                    $values
                );

                $clean[$type] = array_values(
                    array_intersect(
                        array_keys($actions),
                        $values
                    )
                );
            }

            update_user_meta(
                $user->ID,
                'wpct_user_granular_permissions',
                $clean
            );
        }

        $notice = 'Action permissions saved successfully.';
    }

    return $notice;
}
