<?php
/**
 * Blocks direct URL access to features a Client has no access to.
 *
 * @package WP_Client_Toolkit
 */

if (! defined('ABSPATH')) {
    exit;
}

/* ==========================================================================
   CLIENT DIRECT URL RESTRICTION
   ========================================================================== */

function wpct_restrict_client_access() {

    if (
        ! is_admin() ||
        ! wpct_is_client()
    ) {
        return;
    }

    global $pagenow;


    /* Posts */

    if (
        ! wpct_client_has_permission('posts') &&
        in_array(
            $pagenow,
            array(
                'edit.php',
                'post-new.php',
            ),
            true
        ) &&
        (
            ! isset($_GET['post_type']) ||
            $_GET['post_type'] === 'post'
        )
    ) {

        wp_safe_redirect(admin_url());
        exit;
    }


    /* Pages */

    if (
        ! wpct_client_has_permission('pages') &&
        (
            (
                $pagenow === 'edit.php' &&
                isset($_GET['post_type']) &&
                $_GET['post_type'] === 'page'
            ) ||

            (
                $pagenow === 'post-new.php' &&
                isset($_GET['post_type']) &&
                $_GET['post_type'] === 'page'
            ) ||

            (
                $pagenow === 'post.php' &&
                isset($_GET['post']) &&
                get_post_type(
                    absint($_GET['post'])
                ) === 'page'
            )
        )
    ) {

        wp_safe_redirect(admin_url());
        exit;
    }


    /* Media */

    if (
        ! wpct_client_has_permission('media') &&
        (
            $pagenow === 'upload.php' ||
            $pagenow === 'media-new.php' ||

            (
                $pagenow === 'post.php' &&
                isset($_GET['post']) &&
                get_post_type(
                    absint($_GET['post'])
                ) === 'attachment'
            )
        )
    ) {

        wp_safe_redirect(admin_url());
        exit;
    }


    /* Comments */

    if (
        ! wpct_client_has_permission('comments') &&
        in_array(
            $pagenow,
            array(
                'edit-comments.php',
                'comment.php',
            ),
            true
        )
    ) {

        wp_safe_redirect(admin_url());
        exit;
    }
}

add_action(
    'admin_init',
    'wpct_restrict_client_access'
);
