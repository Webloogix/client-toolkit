<?php
/**
 * View: Hero and stats.
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
             HERO
             ============================================================== -->

        <header class="wpct-hero">

            <div>

                <span class="wpct-eyebrow">
                    WordPress Administration
                </span>

                <h1>
                    WP Client Toolkit
                </h1>

                <p>
                    Give clients a focused dashboard while keeping complete
                    control over what they can access and change.
                </p>

            </div>

            <div class="wpct-hero-icon">
                <span class="dashicons dashicons-admin-users"></span>
            </div>

        </header>


        <!-- ==============================================================
             STATS
             ============================================================== -->

        <div class="wpct-stats">

            <div class="wpct-stat">

                <span class="dashicons dashicons-groups"></span>

                <div>

                    <strong>
                        <?php echo esc_html(count($users)); ?>
                    </strong>

                    <small>
                        Total Users
                    </small>

                </div>

            </div>


            <div class="wpct-stat">

                <span class="dashicons dashicons-businessperson"></span>

                <div>

                    <strong>
                        <?php echo esc_html(count($client_users)); ?>
                    </strong>

                    <small>
                        Client Users
                    </small>

                </div>

            </div>


            <div class="wpct-stat">

                <span class="dashicons dashicons-admin-tools"></span>

                <div>

                    <strong>
                        <?php echo esc_html($developer_count); ?>
                    </strong>

                    <small>
                        Developers
                    </small>

                </div>

            </div>


            <div class="wpct-stat">

                <span class="dashicons dashicons-lock"></span>

                <div>

                    <strong>
                        <?php echo esc_html(count($enabled)); ?>
                        <em>
                            /<?php echo esc_html(count($permissions)); ?>
                        </em>
                    </strong>

                    <small>
                        Default Features
                    </small>

                </div>

            </div>

        </div>
