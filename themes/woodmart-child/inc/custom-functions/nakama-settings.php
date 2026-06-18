<?php
function add_nakama_settings_menu()
{
    add_menu_page(
        'Nakama Settings',
        'Nakama Settings',
        'manage_options',
        'nakama-settings',
        'nakama_general_page',
        'dashicons-admin-generic',
        80
    );

    add_submenu_page(
        'nakama-settings',
        'General Settings',
        'General',
        'manage_options',
        'nakama-settings',
        'nakama_general_page'
    );

    add_submenu_page(
        'nakama-settings',
        'Sidebar Coupons',
        'Sidebar Coupons',
        'manage_options',
        'nakama-sidebar-coupons',
        'nakama_sidebar_coupons_page'
    );
}
add_action('admin_menu', 'add_nakama_settings_menu');


// -------------------- GENERAL SETTINGS --------------------
function nakama_general_page()
{
?>
    <div class="wrap">
        <h1>Custom Nakama Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('nakama_settings_group');
            do_settings_sections('nakama-settings-general');
            ?>

            <table class="form-table" role="presentation">
                <tr valign="top">
                    <th scope="row"><label for="nakama_post_id">Featured Post ID 1</label></th>
                    <td>
                        <input type="text" name="nakama_post_id" id="nakama_post_id"
                            value="<?php echo esc_attr(get_option('nakama_post_id')); ?>"
                            class="regular-text" />
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row"><label for="nakama_post_id_2">Featured Post ID 2</label></th>
                    <td>
                        <input type="text" name="nakama_post_id_2" id="nakama_post_id_2"
                            value="<?php echo esc_attr(get_option('nakama_post_id_2')); ?>"
                            class="regular-text" />
                    </td>
                </tr>
            </table>

            <?php submit_button(); ?>
        </form>
    </div>
<?php
}

add_action('admin_init', function () {
    register_setting('nakama_settings_group', 'nakama_post_id');
    register_setting('nakama_settings_group', 'nakama_post_id_2');
});
