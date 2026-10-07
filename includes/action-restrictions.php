<?php
/**
 * Blocks direct URL access to actions (add/edit/delete) a Client is not allowed.
 *
 * @package WP_Client_Toolkit
 */

if (! defined('ABSPATH')) {
    exit;
}

/* ==========================================================================
   GRANULAR ACCESS RESTRICTION
   ========================================================================== */

function wpct_restrict_client_granular_access() {

    if (
        ! is_admin() ||
        ! wpct_is_client()
    ) {
        return;
    }

    global $pagenow;


    $checks = array(

        /* Posts */

        array(
            'posts',
            'view',
            $pagenow === 'edit.php' &&
            (
                ! isset($_GET['post_type']) ||
                $_GET['post_type'] === 'post'
            ),
        ),

        array(
            'posts',
            'add',
            $pagenow === 'post-new.php' &&
            (
                ! isset($_GET['post_type']) ||
                $_GET['post_type'] === 'post'
            ),
        ),

        array(
            'posts',
            'edit',
            $pagenow === 'post.php' &&
            isset($_GET['post']) &&
            get_post_type(
                absint($_GET['post'])
            ) === 'post',
        ),


        /* Pages */

        array(
            'pages',
            'view',
            $pagenow === 'edit.php' &&
            isset($_GET['post_type']) &&
            $_GET['post_type'] === 'page',
        ),

        array(
            'pages',
            'add',
            $pagenow === 'post-new.php' &&
            isset($_GET['post_type']) &&
            $_GET['post_type'] === 'page',
        ),

        array(
            'pages',
            'edit',
            $pagenow === 'post.php' &&
            isset($_GET['post']) &&
            get_post_type(
                absint($_GET['post'])
            ) === 'page',
        ),


        /* Media */

        array(
            'media',
            'view',
            $pagenow === 'upload.php',
        ),

        array(
            'media',
            'add',
            $pagenow === 'media-new.php',
        ),

        array(
            'media',
            'edit',
            $pagenow === 'post.php' &&
            isset($_GET['post']) &&
            get_post_type(
                absint($_GET['post'])
            ) === 'attachment',
        ),


        /* Comments */

        array(
            'comments',
            'view',
            $pagenow === 'edit-comments.php',
        ),

        array(
            'comments',
            'edit',
            $pagenow === 'comment.php' &&
            (
                ! isset($_GET['action']) ||
                ! in_array(
                    sanitize_key(
                        wp_unslash($_GET['action'])
                    ),
                    array(
                        'trash',
                        'delete',
                        'deletecomment',
                        'untrash',
                    ),
                    true
                )
            ),
        ),
    );


    foreach ($checks as $check) {

        if (
            $check[2] &&
            (
                ! wpct_client_has_permission($check[0]) ||
                ! wpct_client_has_granular_permission(
                    $check[0],
                    $check[1]
                )
            )
        ) {

            wp_safe_redirect(admin_url());
            exit;
        }
    }


    /*
     * Comment delete/trash/untrash actions.
     */

    if (
        $pagenow === 'comment.php' &&
        isset($_GET['action']) &&
        in_array(
            sanitize_key(
                wp_unslash($_GET['action'])
            ),
            array(
                'trash',
                'delete',
                'deletecomment',
                'untrash',
            ),
            true
        ) &&
        ! wpct_client_has_granular_permission(
            'comments',
            'delete'
        )
    ) {

        wp_safe_redirect(
            admin_url('edit-comments.php')
        );

        exit;
    }
}

add_action(
    'admin_init',
    'wpct_restrict_client_granular_access'
);
