<?php
/**
 * View: Default Access panel.
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
             DEFAULT ACCESS
             ============================================================== -->

        <section
            id="wpct-defaults"
            class="wpct-panel"
        >

            <div class="wpct-panel-head">

                <div>

                    <span class="wpct-kicker">
                        02 · Default Access
                    </span>

                    <h2>
                        Default Client Access
                    </h2>

                    <p>
                        Set the feature-level access inherited by Client
                        users who do not have custom access configured.
                    </p>

                </div>

                <span class="wpct-panel-icon dashicons dashicons-admin-settings"></span>

            </div>


            <form method="post">

                <?php
                wp_nonce_field(
                    'wpct_save_defaults',
                    'wpct_defaults_nonce'
                );
                ?>


                <div class="wpct-feature-grid">

                    <?php foreach ($permissions as $key => $permission) : ?>

                        <?php
                        $checked = in_array(
                            $key,
                            $enabled,
                            true
                        );
                        ?>


                        <label
                            class="wpct-feature <?php echo $checked ? 'is-on' : ''; ?>"
                        >

                            <input
                                type="checkbox"
                                name="wpct_permissions[]"
                                value="<?php echo esc_attr($key); ?>"
                                <?php checked($checked); ?>
                            >


                            <span class="wpct-feature-icon">

                                <span
                                    class="dashicons <?php echo esc_attr($permission['icon']); ?>"
                                ></span>

                            </span>


                            <span class="wpct-feature-copy">

                                <strong>
                                    <?php
                                    echo esc_html(
                                        $permission['label']
                                    );
                                    ?>
                                </strong>

                                <small>
                                    <?php
                                    echo esc_html(
                                        $permission['description']
                                    );
                                    ?>
                                </small>

                            </span>


                            <span class="wpct-switch">
                                <i></i>
                            </span>

                        </label>

                    <?php endforeach; ?>

                </div>


                <div class="wpct-footer">

                    <span>
                        Feature access is the first permission layer.
                    </span>

                    <button
                        class="button wpct-primary"
                        type="submit"
                        name="wpct_save_defaults"
                    >
                        Save Default Access
                    </button>

                </div>

            </form>

        </section>
