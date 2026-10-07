<?php
/**
 * View: Individual Client Access panel.
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
             INDIVIDUAL CLIENT ACCESS
             ============================================================== -->

        <section
            id="wpct-clients"
            class="wpct-panel"
        >

            <div class="wpct-panel-head">

                <div>

                    <span class="wpct-kicker">
                        03 · Per User
                    </span>

                    <h2>
                        Individual Client Access
                    </h2>

                    <p>
                        Override the default feature access for a specific
                        Client without changing other users.
                    </p>

                </div>

                <span class="wpct-panel-icon dashicons dashicons-businessperson"></span>

            </div>


            <form method="post">

                <?php
                wp_nonce_field(
                    'wpct_save_client_access',
                    'wpct_client_access_nonce'
                );
                ?>


                <?php if ($client_users) : ?>

                    <div class="wpct-client-list">

                        <?php foreach ($client_users as $user) : ?>

                            <?php
                            $user_permissions =
                                wpct_get_user_permissions(
                                    $user->ID
                                );
                            ?>


                            <article class="wpct-client-card">


                                <div class="wpct-client-heading">

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


                                    <div>

                                        <strong>
                                            <?php
                                            echo esc_html(
                                                $user->display_name
                                            );
                                            ?>
                                        </strong>

                                        <span>
                                            <?php
                                            echo esc_html(
                                                $user->user_email
                                            );
                                            ?>
                                        </span>

                                    </div>


                                    <span class="wpct-client-status">
                                        CLIENT
                                    </span>

                                </div>


                                <div class="wpct-client-features">

                                    <?php foreach ($permissions as $key => $permission) : ?>

                                        <?php
                                        $checked = in_array(
                                            $key,
                                            $user_permissions,
                                            true
                                        );
                                        ?>


                                        <label
                                            class="wpct-mini-feature <?php echo $checked ? 'is-on' : ''; ?>"
                                        >

                                            <input
                                                type="checkbox"
                                                name="wpct_user_permissions[<?php echo esc_attr($user->ID); ?>][]"
                                                value="<?php echo esc_attr($key); ?>"
                                                <?php checked($checked); ?>
                                            >


                                            <span
                                                class="dashicons <?php echo esc_attr($permission['icon']); ?>"
                                            ></span>


                                            <span>
                                                <?php
                                                echo esc_html(
                                                    $permission['label']
                                                );
                                                ?>
                                            </span>

                                        </label>

                                    <?php endforeach; ?>

                                </div>

                            </article>

                        <?php endforeach; ?>

                    </div>

                <?php else : ?>

                    <div class="wpct-empty">

                        <span class="dashicons dashicons-businessperson"></span>

                        <strong>
                            No Client users yet
                        </strong>

                        <p>
                            Assign a user to Client mode in Users &amp;
                            Modes to configure individual access.
                        </p>

                    </div>

                <?php endif; ?>


                <div class="wpct-footer">

                    <span>
                        Custom feature access overrides the default selection.
                    </span>

                    <button
                        class="button wpct-primary"
                        type="submit"
                        name="wpct_save_client_access"
                    >
                        Save Client Access
                    </button>

                </div>

            </form>

        </section>
