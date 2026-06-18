<?php

/**
 * Template Name: Checkout
 * Template Post Type: page
 */

?>




<?php get_template_part('template-parts/headers/nakama-head'); ?>


</header>
<div class="container-medium">
    <main id="post-content" class="col-12 col-md-9" role="main">
        <article>
            <?php echo do_shortcode('[woocommerce_checkout]'); ?>
        </article>
    </main>
</div>
<?php get_template_part('template-parts/footers/main-footer'); ?>
</body>

</html>