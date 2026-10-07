<?php
/**
 * View: Users & Modes panel.
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
             USERS & MODES
             ============================================================== -->

        <section
            id="wpct-users"
            class="wpct-panel is-visible"
        >

            <div class="wpct-panel-head">

                <div>

                    <span class="wpct-kicker">
                        01 · User Management
                    </span>

                    <h2>
                        User Modes
                    </h2>

                    <p>
                        Choose which dashboard experience each WordPress
                        account should use.
                    </p>

                </div>

                <span class="wpct-panel-icon dashicons dashicons-admin-users"></span>

            </div>


            <form method="post">

                <?php
                wp_nonce_field(
                    'wpct_save_user_modes',
                    'wpct_nonce'
                );
                ?>


                <div class="wpct-user-grid">

                    <?php foreach ($users as $user) : ?>

                        <?php
                        $mode = wpct_get_user_mode($user->ID);

                        $is_current =
                            $user->ID === get_current_user_id();
                        ?>

                        <article class="wpct-user-card">


                            <!-- User -->

                            <div class="wpct-user-main">

                                <?php
                                echo get_avatar(
                                    $user->ID,
                                    48,
                                    '',
                                    '',
                                    array(
                                        'class' => 'wpct-avatar',
                                    )
                                );
                                ?>

                                <div class="wpct-user-info">

                                    <strong>

                                        <?php
                                        echo esc_html(
                                            $user->display_name
                                        );
                                        ?>


                                        <?php if ($is_current) : ?>

                                            <span class="wpct-you">
                                                YOU
                                            </span>

                                        <?php endif; ?>

                                    </strong>


                                    <span>
                                        <?php
                                        echo esc_html(
                                            $user->user_email
                                        );
                                        ?>
                                    </span>

                                </div>

                            </div>


                            <!-- WordPress Role -->

                            <div class="wpct-user-role">

                                <small>
                                    WordPress Role
                                </small>

                                <span>
                                    <?php
                                    echo esc_html(
                                        implode(
                                            ', ',
                                            $user->roles
                                        )
                                    );
                                    ?>
                                </span>

                            </div>


                            <!-- Toolkit Mode -->

                            <div class="wpct-mode-control">

                                <small>
                                    Toolkit Mode
                                </small>


                                <?php if ($is_current) : ?>

                                    <div class="wpct-mode-switch wpct-mode-switch-locked">

                                        <span class="wpct-mode-option is-active developer">

                                            <span class="dashicons dashicons-admin-tools"></span>

                                            <span>
                                                Developer
                                            </span>

                                        </span>

                                    </div>


                                    <input
                                        type="hidden"
                                        name="wpct_mode[<?php echo esc_attr($user->ID); ?>]"
                                        value="developer"
                                    >


                                <?php else : ?>


                                    <div class="wpct-mode-switch">

                                        <label class="wpct-mode-option <?php echo $mode === 'developer' ? 'is-active developer' : ''; ?>">

                                            <input
                                                type="radio"
                                                name="wpct_mode[<?php echo esc_attr($user->ID); ?>]"
                                                value="developer"
                                                <?php checked($mode, 'developer'); ?>
                                            >

                                            <span class="dashicons dashicons-admin-tools"></span>

                                            <span>
                                                Developer
                                            </span>

                                        </label>


                                        <label class="wpct-mode-option <?php echo $mode === 'client' ? 'is-active client' : ''; ?>">

                                            <input
                                                type="radio"
                                                name="wpct_mode[<?php echo esc_attr($user->ID); ?>]"
                                                value="client"
                                                <?php checked($mode, 'client'); ?>
                                            >

                                            <span class="dashicons dashicons-businessperson"></span>

                                            <span>
                                                Client
                                            </span>

                                        </label>

                                    </div>

                                <?php endif; ?>

                            </div>


                        </article>

                    <?php endforeach; ?>

                </div>


                <div class="wpct-footer">

                    <span>
                        Your own account is always protected as Developer.
                    </span>

                    <button
                        class="button wpct-primary"
                        type="submit"
                        name="wpct_save_modes"
                    >
                        Save User Modes
                    </button>

                </div>

            </form>

        </section>
