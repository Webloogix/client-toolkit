<?php
/**
 * View: Action Permissions panel.
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
             ACTION PERMISSIONS
             ============================================================== -->

        <section
            id="wpct-actions"
            class="wpct-panel"
        >

            <div class="wpct-panel-head">

                <div>

                    <span class="wpct-kicker">
                        04 · Fine Controls
                    </span>

                    <h2>
                        Action Permissions
                    </h2>

                    <p>
                        Control the exact actions each Client can perform
                        inside Posts, Pages, Media and Comments.
                    </p>

                </div>

                <span class="wpct-panel-icon dashicons dashicons-lock"></span>

            </div>


            <form method="post">

                <?php
                wp_nonce_field(
                    'wpct_save_actions',
                    'wpct_actions_nonce'
                );
                ?>


                <?php if ($client_users) : ?>

                    <div class="wpct-action-list">

                        <?php foreach ($client_users as $user) : ?>

                            <?php
                            $user_actions =
                                wpct_get_user_granular_permissions(
                                    $user->ID
                                );
                            ?>


                            <article class="wpct-action-card">


                                <div class="wpct-action-user">

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
                                            Client permissions
                                        </span>

                                    </div>

                                </div>


                                <div class="wpct-action-body">

                                    <?php foreach ($granular as $type => $actions) : ?>

                                        <div class="wpct-action-row">


                                            <div class="wpct-action-type">

                                                <span
                                                    class="dashicons <?php echo esc_attr($permissions[$type]['icon']); ?>"
                                                ></span>

                                                <strong>
                                                    <?php
                                                    echo esc_html(
                                                        $permissions[$type]['label']
                                                    );
                                                    ?>
                                                </strong>

                                            </div>


                                            <div class="wpct-action-options">

                                                <?php foreach ($actions as $action => $label) : ?>

                                                    <?php
                                                    $allowed = in_array(
                                                        $action,
                                                        $user_actions[$type],
                                                        true
                                                    );
                                                    ?>


                                                    <label
                                                        class="wpct-action-option <?php echo $allowed ? 'is-on' : ''; ?>"
                                                    >

                                                        <input
                                                            type="checkbox"
                                                            name="wpct_user_granular_permissions[<?php echo esc_attr($user->ID); ?>][<?php echo esc_attr($type); ?>][]"
                                                            value="<?php echo esc_attr($action); ?>"
                                                            <?php checked($allowed); ?>
                                                        >


                                                        <span>
                                                            <?php
                                                            echo esc_html(
                                                                $label
                                                            );
                                                            ?>
                                                        </span>

                                                    </label>

                                                <?php endforeach; ?>


                                                <?php if ($type === 'comments') : ?>

                                                    <span class="wpct-no-add">
                                                        No Add / Upload
                                                    </span>

                                                <?php endif; ?>

                                            </div>

                                        </div>

                                    <?php endforeach; ?>

                                </div>

                            </article>

                        <?php endforeach; ?>

                    </div>

                <?php else : ?>

                    <div class="wpct-empty">

                        <span class="dashicons dashicons-lock"></span>

                        <strong>
                            No Client users to configure
                        </strong>

                        <p>
                            Action permissions become available after
                            assigning Client mode.
                        </p>

                    </div>

                <?php endif; ?>


                <div class="wpct-footer">

                    <span>
                        Action permissions are the second permission layer.
                    </span>

                    <button
                        class="button wpct-primary"
                        type="submit"
                        name="wpct_save_actions"
                    >
                        Save Action Permissions
                    </button>

                </div>

            </form>

        </section>
