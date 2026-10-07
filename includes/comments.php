<?php
/**
 * Comment row/bulk action filters.
 *
 * @package WP_Client_Toolkit
 */

if (! defined('ABSPATH')) {
    exit;
}

/* ==========================================================================
   COMMENT ACTION FILTERS
   ========================================================================== */

function wpct_filter_comment_actions(
    $actions,
    $comment
) {

    if (
        wpct_is_client() &&
        ! wpct_client_has_granular_permission(
            'comments',
            'delete'
        )
    ) {

        unset($actions['trash']);
        unset($actions['delete']);
        unset($actions['untrash']);
    }

    return $actions;
}

add_filter(
    'comment_row_actions',
    'wpct_filter_comment_actions',
    10,
    2
);


function wpct_filter_comment_bulk_actions(
    $actions
) {

    if (
        wpct_is_client() &&
        ! wpct_client_has_granular_permission(
            'comments',
            'delete'
        )
    ) {

        unset($actions['trash']);
        unset($actions['delete']);
        unset($actions['untrash']);
    }

    return $actions;
}

add_filter(
    'bulk_actions-edit-comments',
    'wpct_filter_comment_bulk_actions'
);
