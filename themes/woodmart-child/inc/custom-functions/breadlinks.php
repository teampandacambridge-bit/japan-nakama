<?php
function custom_breadcrumbs()
{

    if (!is_singular('post')) {
        return;
    }

    $home_url  = home_url('/');
    $items     = [];
    $position  = 1;

    echo '<nav class="bread-links">';

    /* ---------- HOME ---------- */
    echo '<a href="' . esc_url($home_url) . '">Home</a>';

    $items[] = [
        '@type'    => 'ListItem',
        'position' => $position++,
        'name'     => 'Home',
        'item'     => $home_url,
    ];

    /* ======================================================
       PRIMARY: PAGE-BASED BREADCRUMB
    ====================================================== */
    $page_path = get_post_meta(get_the_ID(), '_post_custom_value', true);

    if (!empty($page_path)) {

        $page = get_page_by_path($page_path);

        if ($page) {

            $page_id   = $page->ID;
            $parent_id = wp_get_post_parent_id($page_id);

            if ($parent_id) {
                echo ' &gt; <a href="' . esc_url(get_permalink($parent_id)) . '">'
                    . esc_html(get_the_title($parent_id)) .
                    '</a>';

                $items[] = [
                    '@type'    => 'ListItem',
                    'position' => $position++,
                    'name'     => get_the_title($parent_id),
                    'item'     => get_permalink($parent_id),
                ];
            }

            echo ' &gt; <a href="' . esc_url(get_permalink($page_id)) . '">'
                . esc_html(get_the_title($page_id)) .
                '</a>';

            $items[] = [
                '@type'    => 'ListItem',
                'position' => $position++,
                'name'     => get_the_title($page_id),
                'item'     => get_permalink($page_id),
            ];

            echo ' &gt; <span class="current">' . esc_html(get_the_title()) . '</span>';

            $items[] = [
                '@type'    => 'ListItem',
                'position' => $position,
                'name'     => get_the_title(),
            ];

            echo '</nav>';
            output_breadcrumb_schema($items);
            return;
        }
    }

    /* ======================================================
       FALLBACK: CATEGORY-BASED BREADCRUMB
    ====================================================== */

    $categories = get_the_category();

    if (!empty($categories)) {

        // Choose primary category (first one)
        $category = $categories[0];

        // Get full ancestor chain
        $ancestors = array_reverse(get_ancestors($category->term_id, 'category'));

        foreach ($ancestors as $ancestor_id) {
            echo ' &gt; <a href="' . esc_url(get_category_link($ancestor_id)) . '">'
                . esc_html(get_cat_name($ancestor_id)) .
                '</a>';

            $items[] = [
                '@type'    => 'ListItem',
                'position' => $position++,
                'name'     => get_cat_name($ancestor_id),
                'item'     => get_category_link($ancestor_id),
            ];
        }

        echo ' &gt; <a href="' . esc_url(get_category_link($category->term_id)) . '">'
            . esc_html($category->name) .
            '</a>';

        $items[] = [
            '@type'    => 'ListItem',
            'position' => $position++,
            'name'     => $category->name,
            'item'     => get_category_link($category->term_id),
        ];
    }

    echo ' &gt; <span class="current">' . esc_html(get_the_title()) . '</span>';

    $items[] = [
        '@type'    => 'ListItem',
        'position' => $position,
        'name'     => get_the_title(),
    ];

    echo '</nav>';
    output_breadcrumb_schema($items);
}


function output_breadcrumb_schema($items)
{
    echo '<script type="application/ld+json">';
    echo wp_json_encode([
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => $items,
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    echo '</script>';
}


add_filter('wpseo_schema_graph_pieces', 'disable_yoast_breadcrumbs_for_guides', 11, 2);

function disable_yoast_breadcrumbs_for_guides($pieces, $context)
{

    if (is_single() && has_category(array('osaka-guides', 'kyoto-guides'))) {

        foreach ($pieces as $key => $piece) {
            if ($piece instanceof \Yoast\WP\SEO\Generators\Schema\Breadcrumb) {
                unset($pieces[$key]);
            }
        }
    }

    return $pieces;
}
