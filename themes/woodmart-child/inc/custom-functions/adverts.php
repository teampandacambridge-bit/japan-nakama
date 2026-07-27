<?php
// === 1. Register Settings Page ===
add_menu_page(
    'Ad Settings',                // Page title
    'Ad Settings',                // Menu title
    'manage_options',             // Capability
    'ad-settings',                // Menu slug
    'render_ad_settings_page',    // Callback function
    'dashicons-megaphone',        // Icon (optional, pick any dashicon)
    81                           // Position in menu (optional)
);


// === 2. Render Settings Page ===
function render_ad_settings_page()
{
?>
    <div class="wrap">
        <h1>Ad Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('ad_settings_group');
            do_settings_sections('ad-settings');
            submit_button();
            ?>
        </form>
    </div>
<?php
}

// === 3. Register Settings & Fields ===
add_action('admin_init', function () {
    $labels = [
        1 => 'Sidebar Top',
        2 => 'Sidebar Bottom',
    ];

    foreach ($labels as $i => $label) {
        register_setting('ad_settings_group', "global_image_{$i}");
        register_setting('ad_settings_group', "global_url_{$i}");

        add_settings_section("section_{$i}", $label, null, 'ad-settings');

        add_settings_field(
            "global_image_{$i}",
            "$label Image",
            function () use ($i) {
                render_image_field("global_image_{$i}");
            },
            'ad-settings',
            "section_{$i}"
        );

        add_settings_field(
            "global_url_{$i}",
            "$label Link URL",
            function () use ($i) {
                render_url_field("global_url_{$i}");
            },
            'ad-settings',
            "section_{$i}"
        );
    }

    // === Responsive Ads (2 slots) ===
    for ($i = 1; $i <= 2; $i++) {
        register_setting('ad_settings_group', "responsive_image_mobile_{$i}");
        register_setting('ad_settings_group', "responsive_image_desktop_{$i}");
        register_setting('ad_settings_group', "responsive_image_url_{$i}");

        add_settings_section("responsive_section_{$i}", "Responsive Horizontal Ad #{$i}", null, 'ad-settings');

        add_settings_field(
            "responsive_image_mobile_{$i}",
            'Mobile Image',
            function () use ($i) {
                render_image_field("responsive_image_mobile_{$i}");
            },
            'ad-settings',
            "responsive_section_{$i}"
        );

        add_settings_field(
            "responsive_image_desktop_{$i}",
            'Desktop Image',
            function () use ($i) {
                render_image_field("responsive_image_desktop_{$i}");
            },
            'ad-settings',
            "responsive_section_{$i}"
        );

        add_settings_field(
            "responsive_image_url_{$i}",
            'Link URL',
            function () use ($i) {
                render_url_field("responsive_image_url_{$i}");
            },
            'ad-settings',
            "responsive_section_{$i}"
        );
    }
});

// === 4. Field Rendering Helpers ===
function render_image_field($option_name)
{
    $value = esc_attr(get_option($option_name));
    echo '<input type="text" name="' . esc_attr($option_name) . '" value="' . $value . '" class="regular-text">';
}

function render_url_field($option_name)
{
    $value = esc_attr(get_option($option_name));
    echo '<input type="text" name="' . esc_attr($option_name) . '" value="' . $value . '" class="regular-text">';
}

// === 6. Ad Display Helpers ===
function insert_ad_code($image_key, $url_key)
{
    $image = esc_url(get_option($image_key));
    $url = esc_url(get_option($url_key));

    if ($image && $url) {
        return '<div class="custom-ad" style="text-align:center; margin:20px 0;">
                    <a href="' . $url . '" target="_blank" rel="noopener noreferrer nofollow sponsored">
                        <img src="' . $image . '" alt="Ad" style="max-width:100%; height:auto;">
                    </a>
                </div>';
    }

    return '';
}

function display_responsive_ad($index = 1)
{
    $mobile = esc_url(get_option("responsive_image_mobile_{$index}"));
    $desktop = esc_url(get_option("responsive_image_desktop_{$index}"));
    $url = esc_url(get_option("responsive_image_url_{$index}"));

    if ($mobile && $desktop && $url) {
        return '<div>
            <a class="article-ad" href="' . $url . '" target="_blank" rel="noopener noreferrer nofollow sponsored">
                <picture>
                    <source srcset="' . $mobile . '" media="(max-width: 768px)">
                    <source srcset="' . $desktop . '" media="(min-width: 769px)">
                    <img src="' . $desktop . '" alt="Responsive Ad" style="max-width:100%; height:auto;">
                </picture>
            </a>
            </div>
        ';
    }

    return ''; // Always return a string, even if empty
}



/**
 * Inject in-content adverts before every Nth <h2> in single post content,
 * alternating between the two "in-content" nakama-adverts slots.
 *
 * Replaces the old h2_ads_1 / h2_ads_2 pair (two overlapping injectors using
 * the legacy ad system). One pass, predictable cadence, plugin-driven ads.
 */
function jn_inject_in_content_ads($content)
{
    // Single posts only, and only if the plugin + some headings are present.
    if (! is_singular('post') || ! function_exists('nakama_advert') || strpos($content, '<h2') === false) {
        return $content;
    }

    $every  = 3;   // insert an ad before every 3rd heading
    $slots  = ['in-content-1', 'in-content-2']; // alternate between these
    $count  = 0;   // headings seen
    $placed = 0;   // ads placed (drives the alternation)

    return preg_replace_callback('/<h2\b[^>]*>/i', function ($matches) use (&$count, &$placed, $every, $slots) {
        $count++;

        if ($count % $every !== 0) {
            return $matches[0];
        }

        $slot = $slots[$placed % count($slots)];
        $placed++;

        $ad = nakama_advert($slot, false); // return, don't echo
        return $ad . $matches[0];
    }, $content);
}
add_filter('the_content', 'jn_inject_in_content_ads');
