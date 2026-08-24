<?php

// === 1. Register Menu ===
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
        'Featured Articles',
        'Featured Articles',
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

    add_submenu_page(
        'nakama-settings',
        'Homepage Events',
        'Homepage Events',
        'manage_options',
        'nakama-homepage-events',
        'nakama_homepage_events_page'
    );
}
add_action('admin_menu', 'add_nakama_settings_menu');


// === 2. General Settings page ===
function nakama_general_page()
{
?>
    <div class="wrap">
        <h1>Featured Articles</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('nakama_settings_group');
            do_settings_sections('nakama-settings-general');
            submit_button();
            ?>
        </form>
    </div>
<?php
}

add_action('admin_init', function () {
    register_setting('nakama_settings_group', 'nakama_post_id', [
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    register_setting('nakama_settings_group', 'nakama_post_id_2', [
        'sanitize_callback' => 'sanitize_text_field',
    ]);

    add_settings_section('nakama_general_section', null, null, 'nakama-settings-general');

    add_settings_field(
        'nakama_post_id',
        'Featured Post ID 1',
        function () {
            echo '<input type="text" name="nakama_post_id" id="nakama_post_id" value="' . esc_attr(get_option('nakama_post_id')) . '" class="regular-text" />';
        },
        'nakama-settings-general',
        'nakama_general_section'
    );

    add_settings_field(
        'nakama_post_id_2',
        'Featured Post ID 2',
        function () {
            echo '<input type="text" name="nakama_post_id_2" id="nakama_post_id_2" value="' . esc_attr(get_option('nakama_post_id_2')) . '" class="regular-text" />';
        },
        'nakama-settings-general',
        'nakama_general_section'
    );
});


// === 3. Sidebar Coupons page ===
function nakama_admin_enqueue($hook)
{
    if ($hook === 'nakama-settings_page_nakama-sidebar-coupons') {
        wp_enqueue_script('jquery-ui-sortable');
    }
}
add_action('admin_enqueue_scripts', 'nakama_admin_enqueue');

function nakama_sidebar_coupons_page()
{
    $coupons = get_option('nakama_coupons', []);
    $heading = get_option('nakama_coupon_heading', '');
?>
    <div class="wrap">
        <h1>Sidebar Coupons</h1>
        <form method="post" action="options.php">
            <?php settings_fields('nakama_sidebar_group'); ?>

            <h2>Section Heading</h2>
            <input type="text" name="nakama_coupon_heading" value="<?php echo esc_attr($heading); ?>" style="width: 400px;" />

            <h2 style="margin-top:30px;">Coupons</h2>
            <table id="nakama-coupons-table" class="form-table">
                <thead>
                    <tr>
                        <th>Heading</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Discount</th>
                        <th>Code</th>
                        <th>CTA</th>
                        <th>Link</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($coupons)) : ?>
                        <?php foreach ($coupons as $index => $coupon) : ?>
                            <tr>
                                <td><input type="text" name="nakama_coupons[<?php echo $index; ?>][heading]" value="<?php echo esc_attr($coupon['heading'] ?? ''); ?>" /></td>
                                <td><input type="text" name="nakama_coupons[<?php echo $index; ?>][type]" value="<?php echo esc_attr($coupon['type'] ?? ''); ?>" /></td>
                                <td><input type="text" name="nakama_coupons[<?php echo $index; ?>][description]" value="<?php echo esc_attr($coupon['description'] ?? ''); ?>" /></td>
                                <td><input type="text" name="nakama_coupons[<?php echo $index; ?>][discount]" value="<?php echo esc_attr($coupon['discount'] ?? ''); ?>" /></td>
                                <td><input type="text" name="nakama_coupons[<?php echo $index; ?>][code]" value="<?php echo esc_attr($coupon['code'] ?? ''); ?>" /></td>
                                <td><input type="text" name="nakama_coupons[<?php echo $index; ?>][cta]" value="<?php echo esc_attr($coupon['cta'] ?? ''); ?>" /></td>
                                <td><input type="text" name="nakama_coupons[<?php echo $index; ?>][link]" value="<?php echo esc_attr($coupon['link'] ?? ''); ?>" /></td>
                                <td><button type="button" class="button remove-coupon">Remove</button></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            <p>
                <button type="button" class="button" id="add-coupon">Add Coupon</button>
            </p>

            <?php submit_button(); ?>
        </form>
    </div>

    <script>
        jQuery(document).ready(function($) {
            const tableBody = $("#nakama-coupons-table tbody");

            // Enable drag-and-drop sorting
            tableBody.sortable({
                items: "tr",
                cursor: "move",
                axis: "y",
                update: function() {
                    reindexCoupons();
                }
            });

            // Reindex coupons after drag-drop or remove
            function reindexCoupons() {
                tableBody.find("tr").each(function(index) {
                    $(this).find("input").each(function() {
                        const name = $(this).attr("name");
                        if (name) {
                            const updatedName = name.replace(/\[\d+\]/, `[${index}]`);
                            $(this).attr("name", updatedName);
                        }
                    });
                });
            }

            // Add new coupon row
            $("#add-coupon").on("click", function() {
                const rowCount = tableBody.find("tr").length;
                const row = $(`
                <tr>
                    <td><input type="text" name="nakama_coupons[${rowCount}][heading]" value="" /></td>
                    <td><input type="text" name="nakama_coupons[${rowCount}][type]" value="" /></td>
                    <td><input type="text" name="nakama_coupons[${rowCount}][description]" value="" /></td>
                    <td><input type="text" name="nakama_coupons[${rowCount}][discount]" value="" /></td>
                    <td><input type="text" name="nakama_coupons[${rowCount}][code]" value="" /></td>
                    <td><input type="text" name="nakama_coupons[${rowCount}][cta]" value="" /></td>
                    <td><input type="text" name="nakama_coupons[${rowCount}][link]" value="" /></td>
                    <td><button type="button" class="button remove-coupon">Remove</button></td>
                </tr>
            `);
                tableBody.append(row);
            });

            // Remove coupon row
            tableBody.on("click", ".remove-coupon", function() {
                $(this).closest("tr").remove();
                reindexCoupons();
            });
        });
    </script>
<?php
}

function nakama_sanitize_coupons($coupons)
{
    if (!is_array($coupons)) {
        return [];
    }

    $allowed_keys = ['heading', 'type', 'description', 'discount', 'code', 'cta', 'link'];
    $clean = [];

    foreach ($coupons as $coupon) {
        if (!is_array($coupon)) {
            continue;
        }
        $row = [];
        foreach ($allowed_keys as $key) {
            $row[$key] = isset($coupon[$key]) ? sanitize_text_field($coupon[$key]) : '';
        }
        $clean[] = $row;
    }

    return $clean;
}

// === 4. Homepage Events page ===

/**
 * Defaults for the homepage events takeover copy.
 *
 * Used as the fallback when an option has never been saved, so the section
 * renders its original copy on a site where nothing has been entered yet.
 */
function nakama_homepage_events_defaults()
{
    return [
        'nakama_events_ribbon'   => 'Updated weekly with what to book and what to catch before it closes',
        'nakama_events_heading'  => 'Japanense Events In London & Across the UK',
        'nakama_events_subcopy'  => '',
    ];
}

/**
 * Get one piece of homepage events copy, falling back to its default.
 *
 * @param string $key Option name, e.g. 'nakama_events_heading'.
 * @return string
 */
function nakama_get_homepage_events_copy($key)
{
    $defaults = nakama_homepage_events_defaults();
    $value    = get_option($key, null);

    // An option that has never been saved falls back to the default; one saved
    // as an empty string is respected as a deliberate "show nothing".
    if ($value === null || $value === false) {
        return $defaults[$key] ?? '';
    }

    return $value;
}

function nakama_homepage_events_page()
{
?>
    <div class="wrap">
        <h1>Homepage Events</h1>
        <p>Copy for the "What's On" events section on the homepage.</p>
        <form method="post" action="options.php">
            <?php
            settings_fields('nakama_homepage_events_group');
            do_settings_sections('nakama-homepage-events');
            submit_button();
            ?>
        </form>
    </div>
<?php
}

add_action('admin_init', function () {
    register_setting('nakama_homepage_events_group', 'nakama_events_ribbon', [
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    register_setting('nakama_homepage_events_group', 'nakama_events_heading', [
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    register_setting('nakama_homepage_events_group', 'nakama_events_subcopy', [
        'sanitize_callback' => 'sanitize_textarea_field',
    ]);

    add_settings_section('nakama_homepage_events_section', null, null, 'nakama-homepage-events');

    add_settings_field(
        'nakama_events_ribbon',
        'Ribbon Strip Text',
        function () {
            printf(
                '<input type="text" name="nakama_events_ribbon" id="nakama_events_ribbon" value="%s" class="large-text" />
                 <p class="description">The one-line strap at the top of the section, next to the pulsing dot.</p>',
                esc_attr(nakama_get_homepage_events_copy('nakama_events_ribbon'))
            );
        },
        'nakama-homepage-events',
        'nakama_homepage_events_section'
    );

    add_settings_field(
        'nakama_events_heading',
        'Main Heading (H2)',
        function () {
            printf(
                '<input type="text" name="nakama_events_heading" id="nakama_events_heading" value="%s" class="large-text" />
                 <p class="description">The main heading for the events section.</p>',
                esc_attr(nakama_get_homepage_events_copy('nakama_events_heading'))
            );
        },
        'nakama-homepage-events',
        'nakama_homepage_events_section'
    );

    add_settings_field(
        'nakama_events_subcopy',
        'Sub Copy',
        function () {
            printf(
                '<textarea name="nakama_events_subcopy" id="nakama_events_subcopy" rows="4" class="large-text">%s</textarea>
                 <p class="description">The paragraph below the heading. Leave blank to hide it.</p>',
                esc_textarea(nakama_get_homepage_events_copy('nakama_events_subcopy'))
            );
        },
        'nakama-homepage-events',
        'nakama_homepage_events_section'
    );
});

function nakama_settings_init()
{
    register_setting('nakama_sidebar_group', 'nakama_coupon_heading', [
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    register_setting('nakama_sidebar_group', 'nakama_coupons', [
        'sanitize_callback' => 'nakama_sanitize_coupons',
    ]);
}
add_action('admin_init', 'nakama_settings_init');
