<?php get_header(); ?>

<div class="container">
    <h1>Shop</h1>

    <?php
    do_action('woocommerce_before_main_content');

    if (woocommerce_product_loop()) {

        woocommerce_product_loop_start();

        while (have_posts()) {
            the_post();
            wc_get_template_part('content', 'product');
        }

        woocommerce_product_loop_end();
    }

    do_action('woocommerce_after_main_content');
    ?>
</div>

<?php get_footer(); ?>