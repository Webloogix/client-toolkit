<?php
/**
 * Capability enforcement through the map_meta_cap filter.
 *
 * @package WP_Client_Toolkit
 */

if (! defined('ABSPATH')) {
    exit;
}

/* ==========================================================================
   CAPABILITY ENFORCEMENT
   ========================================================================== */

function wpct_filter_client_capabilities(
    $caps,
    $cap,
    $user_id,
    $args
) {

    if (
        wpct_get_user_mode($user_id) !== 'client'
    ) {
        return $caps;
    }


    /*
     * Existing post/page/media editing and deletion.
     */

    if (
        in_array(
            $cap,
            array(
                'edit_post',
                'delete_post',
            ),
            true
        ) &&
        isset($args[0])
    ) {

        $post_id = absint($args[0]);
        $type    = get_post_type($post_id);

        $map = array(
            'post'       => 'posts',
            'page'       => 'pages',
            'attachment' => 'media',
        );

        if (isset($map[$type])) {

            $feature = $map[$type];

            $action = (
                $cap === 'edit_post'
            )
                ? 'edit'
                : 'delete';


            if (
                ! wpct_client_has_permission_for_user(
                    $user_id,
                    $feature
                ) ||
                ! wpct_user_has_granular_permission(
                    $user_id,
                    $feature,
                    $action
                )
            ) {

                return array('do_not_allow');
            }
        }
    }


    /*
     * Creation and comment capabilities.
     */

    $create_map = array(

        'create_posts' => array(
            'posts',
            'add',
        ),

        'create_pages' => array(
            'pages',
            'add',
        ),

        'upload_files' => array(
            'media',
            'add',
        ),

        'edit_comment' => array(
            'comments',
            'edit',
        ),

        'delete_comment' => array(
            'comments',
            'delete',
        ),

        'moderate_comments' => array(
            'comments',
            'edit',
        ),
    );


    if (isset($create_map[$cap])) {

        list(
            $feature,
            $action
        ) = $create_map[$cap];


        if (
            ! wpct_client_has_permission_for_user(
                $user_id,
                $feature
            ) ||
            ! wpct_user_has_granular_permission(
                $user_id,
                $feature,
                $action
            )
        ) {

            return array('do_not_allow');
        }
    }


    return $caps;
}

add_filter(
    'map_meta_cap',
    'wpct_filter_client_capabilities',
    10,
    4
);
