<?php

/**
 * WooCommerce Product Archive Template
 * Shop + Product Category + Tag Archives
 */

defined('ABSPATH') || exit;

get_header('shop');
?>

<?php
/**
 * Hook: woocommerce_before_main_content
 * Outputs wrapper + breadcrumb + structured data
 */
do_action('woocommerce_before_main_content');
?>

<header class="woocommerce-products-header">

    <?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
        <h1 class="woocommerce-products-header__title page-title">
            <?php woocommerce_page_title(); ?>
        </h1>
    <?php endif; ?>

    <?php
    /**
     * Archive description
     */
    do_action('woocommerce_archive_description');
    ?>

</header>

<?php if (woocommerce_product_loop()) : ?>

    <?php
    /**
     * Result count + ordering dropdown
     */
    do_action('woocommerce_before_shop_loop');
    ?>

    <?php woocommerce_product_loop_start(); ?>

    <?php if (wc_get_loop_prop('total')) : ?>
        <?php while (have_posts()) : the_post(); ?>

            <?php
            /**
             * Product card template
             */
            do_action('woocommerce_shop_loop');
            wc_get_template_part('content', 'product');
            ?>

        <?php endwhile; ?>
    <?php endif; ?>

    <?php woocommerce_product_loop_end(); ?>

    <?php
    /**
     * Pagination
     */
    do_action('woocommerce_after_shop_loop');
    ?>

<?php else : ?>

    <?php
    /**
     * No products found
     */
    do_action('woocommerce_no_products_found');
    ?>

<?php endif; ?>

<?php
/**
 * Sidebar
 */
do_action('woocommerce_sidebar');

/**
 * Closing wrappers
 */
do_action('woocommerce_after_main_content');

get_footer('shop');
