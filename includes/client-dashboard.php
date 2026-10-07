<?php
/**
 * Client dashboard: widget cleanup and welcome panel.
 *
 * @package WP_Client_Toolkit
 */

if (! defined('ABSPATH')) {
    exit;
}

/* ==========================================================================
   CLIENT DASHBOARD
   ========================================================================== */

function wpct_customize_client_dashboard() {

    if (
        ! is_admin() ||
        ! wpct_is_client()
    ) {
        return;
    }


    $boxes = array(
        'dashboard_site_health',
        'dashboard_right_now',
        'dashboard_activity',
        'dashboard_quick_press',
        'dashboard_primary',
        'dashboard_secondary',
        'dashboard_php_nag',
        'dashboard_browser_nag',
    );


    foreach ($boxes as $box) {

        remove_meta_box(
            $box,
            'dashboard',
            'normal'
        );

        remove_meta_box(
            $box,
            'dashboard',
            'side'
        );
    }
}

add_action(
    'wp_dashboard_setup',
    'wpct_customize_client_dashboard'
);


/**
 * Add Client welcome dashboard widget.
 */
function wpct_add_client_welcome_panel() {

    if (wpct_is_client()) {

        wp_add_dashboard_widget(
            'wpct_client_welcome',
            'Welcome to Your Dashboard',
            'wpct_client_welcome_content'
        );
    }
}

add_action(
    'wp_dashboard_setup',
    'wpct_add_client_welcome_panel',
    20
);


/**
 * Client dashboard content.
 */
function wpct_client_welcome_content() {

    $user    = wp_get_current_user();
    $user_id = get_current_user_id();

    $features = wpct_get_user_permissions(
        $user_id
    );


    $cards = array(

        'posts' => array(
            'title'       => 'Posts',
            'description' => 'Create and manage website posts.',
            'url'         => admin_url('edit.php'),
            'add'         => admin_url('post-new.php'),
            'add_label'   => 'Add New',
            'icon'        => 'dashicons-edit',
        ),

        'pages' => array(
            'title'       => 'Pages',
            'description' => 'Edit and manage your website pages.',
            'url'         => admin_url('edit.php?post_type=page'),
            'add'         => admin_url('post-new.php?post_type=page'),
            'add_label'   => 'Add New',
            'icon'        => 'dashicons-admin-page',
        ),

        'media' => array(
            'title'       => 'Media',
            'description' => 'Upload and manage images and files.',
            'url'         => admin_url('upload.php'),
            'add'         => admin_url('media-new.php'),
            'add_label'   => 'Upload',
            'icon'        => 'dashicons-format-image',
        ),

        'comments' => array(
            'title'       => 'Comments',
            'description' => 'Review and manage website comments.',
            'url'         => admin_url('edit-comments.php'),
            'add'         => '',
            'add_label'   => '',
            'icon'        => 'dashicons-admin-comments',
        ),
    );

    ?>

    <div class="wpct-client-dashboard">

        <div class="wpct-client-hero">

            <span class="wpct-eyebrow">
                Client Dashboard
            </span>

            <h2>
                Welcome, <?php echo esc_html($user->display_name); ?>!
            </h2>

            <p>
                Manage the website content available to you from the options below.
            </p>

        </div>


        <div class="wpct-client-grid">

            <?php foreach ($cards as $key => $card) : ?>

                <?php
                if (
                    ! in_array(
                        $key,
                        $features,
                        true
                    ) ||
                    ! wpct_client_has_granular_permission(
                        $key,
                        'view'
                    )
                ) {
                    continue;
                }
                ?>


                <article class="wpct-client-card-ui">

                    <div class="wpct-client-icon">

                        <span
                            class="dashicons <?php echo esc_attr($card['icon']); ?>"
                        ></span>

                    </div>


                    <h3>
                        <?php echo esc_html($card['title']); ?>
                    </h3>


                    <p>
                        <?php echo esc_html($card['description']); ?>
                    </p>


                    <div class="wpct-client-actions">

                        <a
                            class="button button-primary"
                            href="<?php echo esc_url($card['url']); ?>"
                        >
                            Manage <?php echo esc_html($card['title']); ?>
                        </a>


                        <?php if (
                            $card['add'] &&
                            wpct_client_has_granular_permission(
                                $key,
                                'add'
                            )
                        ) : ?>

                            <a
                                class="button"
                                href="<?php echo esc_url($card['add']); ?>"
                            >
                                <?php echo esc_html($card['add_label']); ?>
                            </a>

                        <?php endif; ?>

                    </div>

                </article>

            <?php endforeach; ?>

        </div>

    </div>

    <?php
}
