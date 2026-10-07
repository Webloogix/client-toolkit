<?php
/**
 * Helpers: permission definitions and user/permission lookups.
 *
 * @package WP_Client_Toolkit
 */

if (! defined('ABSPATH')) {
    exit;
}

/* ==========================================================================
   HELPERS
   ========================================================================== */

/**
 * Available feature permissions.
 */
function wpct_get_permissions() {

    return array(
        'posts' => array(
            'label'       => 'Posts',
            'description' => 'Website content management',
            'icon'        => 'dashicons-edit',
        ),

        'pages' => array(
            'label'       => 'Pages',
            'description' => 'Website page management',
            'icon'        => 'dashicons-admin-page',
        ),

        'media' => array(
            'label'       => 'Media',
            'description' => 'Images, files and uploads',
            'icon'        => 'dashicons-format-image',
        ),

        'comments' => array(
            'label'       => 'Comments',
            'description' => 'Review and moderate comments',
            'icon'        => 'dashicons-admin-comments',
        ),
    );
}


/**
 * Granular actions available for each feature.
 */
function wpct_get_granular_permissions() {

    return array(
        'posts' => array(
            'view'   => 'View / Manage',
            'add'    => 'Add New',
            'edit'   => 'Edit',
            'delete' => 'Delete',
        ),

        'pages' => array(
            'view'   => 'View / Manage',
            'add'    => 'Add New',
            'edit'   => 'Edit',
            'delete' => 'Delete',
        ),

        'media' => array(
            'view'   => 'View / Manage',
            'add'    => 'Upload',
            'edit'   => 'Edit',
            'delete' => 'Delete',
        ),

        'comments' => array(
            'view'   => 'View / Manage',
            'edit'   => 'Edit',
            'delete' => 'Delete',
        ),
    );
}


/**
 * Get default feature-level Client permissions.
 */
function wpct_get_enabled_permissions() {

    $defaults = array(
        'posts',
        'pages',
        'media',
        'comments',
    );

    $permissions = get_option(
        'wpct_client_permissions',
        $defaults
    );

    if (! is_array($permissions)) {
        return $defaults;
    }

    return array_values(
        array_intersect(
            array_keys(wpct_get_permissions()),
            $permissions
        )
    );
}


/**
 * Get user's toolkit mode.
 */
function wpct_get_user_mode($user_id = 0) {

    $user_id = $user_id
        ? absint($user_id)
        : get_current_user_id();

    $mode = get_user_meta(
        $user_id,
        'wpct_user_mode',
        true
    );

    return in_array(
        $mode,
        array('developer', 'client'),
        true
    )
        ? $mode
        : 'developer';
}


/**
 * Get user's feature permissions.
 */
function wpct_get_user_permissions($user_id) {

    $permissions = get_user_meta(
        $user_id,
        'wpct_user_permissions',
        true
    );

    if (! is_array($permissions)) {
        return wpct_get_enabled_permissions();
    }

    return array_values(
        array_intersect(
            array_keys(wpct_get_permissions()),
            $permissions
        )
    );
}


/**
 * Check feature-level permission for a user.
 */
function wpct_user_has_permission($user_id, $permission) {

    return in_array(
        $permission,
        wpct_get_user_permissions($user_id),
        true
    );
}


/**
 * Check current Client feature permission.
 */
function wpct_client_has_permission($permission) {

    return wpct_user_has_permission(
        get_current_user_id(),
        $permission
    );
}


/**
 * Get user's granular permissions.
 */
function wpct_get_user_granular_permissions($user_id) {

    $saved = get_user_meta(
        $user_id,
        'wpct_user_granular_permissions',
        true
    );

    $available = wpct_get_granular_permissions();

    if (! is_array($saved)) {

        $defaults = array();

        foreach ($available as $type => $actions) {
            $defaults[$type] = array_keys($actions);
        }

        return $defaults;
    }

    $clean = array();

    foreach ($available as $type => $actions) {

        $clean[$type] = (
            isset($saved[$type]) &&
            is_array($saved[$type])
        )
            ? array_values(
                array_intersect(
                    array_keys($actions),
                    $saved[$type]
                )
            )
            : array();
    }

    return $clean;
}


/**
 * Check granular permission.
 */
function wpct_user_has_granular_permission(
    $user_id,
    $content_type,
    $action
) {

    $permissions = wpct_get_user_granular_permissions(
        $user_id
    );

    return (
        isset($permissions[$content_type]) &&
        in_array(
            $action,
            $permissions[$content_type],
            true
        )
    );
}


/**
 * Check granular permission for current Client.
 */
function wpct_client_has_granular_permission(
    $content_type,
    $action
) {

    return wpct_user_has_granular_permission(
        get_current_user_id(),
        $content_type,
        $action
    );
}


/**
 * Is user a Client?
 */
function wpct_is_client($user_id = 0) {

    return wpct_get_user_mode($user_id) === 'client';
}


/**
 * Get all Client users.
 */
function wpct_get_client_users() {

    return array_values(
        array_filter(
            get_users(),
            function ($user) {
                return wpct_is_client($user->ID);
            }
        )
    );
}


/**
 * Feature permission helper used by capability filters.
 */
function wpct_client_has_permission_for_user(
    $user_id,
    $feature
) {

    return wpct_user_has_permission(
        $user_id,
        $feature
    );
}

