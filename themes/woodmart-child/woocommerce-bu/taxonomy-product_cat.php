<?php

/**
 * WooCommerce Product Category Template
 * Shows products only for the current category
 * Excludes child-category products
 * Does NOT display subcategory cards
 */

defined('ABSPATH') || exit;

$current_term = get_queried_object();

if (!$current_term || empty($current_term->term_id) || $current_term->taxonomy !== 'product_cat') {
    wp_safe_redirect(home_url('/shop'));
    exit;
}

$paged = max(1, get_query_var('paged'), get_query_var('page'));

$args = array(
    'post_type'           => 'product',
    'post_status'         => 'publish',
    'paged'               => $paged,
    'ignore_sticky_posts' => true,
    'orderby'             => 'menu_order title',
    'order'               => 'ASC',

    'meta_query' => WC()->query->get_meta_query(),

    'tax_query'  => array_merge(
        WC()->query->get_tax_query(), // keep WC filters
        array(
            array(
                'taxonomy'         => 'product_cat',
                'field'            => 'term_id',
                'terms'            => array((int) $current_term->term_id),
                'include_children' => false,
            ),
        )
    ),
);

$products = new WP_Query($args);
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-KPJK8T');
    </script>
    <!-- End Google Tag Manager -->

    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class('woocommerce product-category'); ?>>

    <!-- Google Tag Manager (noscript) -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KPJK8T"
            height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>
    <!-- End Google Tag Manager (noscript) -->

    <header id="page-header">
        <?php get_template_part('template-parts/navs/primary-nav'); ?>
        <h1 class="homepage-title"><?php echo esc_html(single_term_title('', false)); ?></h1>
    </header>

    <div class="container-medium">

        <section class="products products--archive">
            <div class="products__container">

                <?php if (!empty($current_term->description)) : ?>
                    <div class="products__header">
                        <div class="products__subtitle">
                            <?php echo wp_kses_post(wpautop($current_term->description)); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($products->have_posts()) : ?>

                    <?php woocommerce_product_loop_start(); ?>

                    <?php while ($products->have_posts()) : $products->the_post(); ?>
                        <?php wc_get_template_part('content', 'product'); ?>
                    <?php endwhile; ?>

                    <?php woocommerce_product_loop_end(); ?>

                <?php endif; ?>

            </div>
        </section>

    </div>

    <?php get_template_part('template-parts/footers/main-footer'); ?>
    <?php wp_footer(); ?>
</body>

</html>