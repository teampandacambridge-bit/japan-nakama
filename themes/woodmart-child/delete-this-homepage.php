<?php

/**
 * Template Name: Homepage
 * Template Post Type: page
 */

?>
<?php get_template_part('template-parts/headers/nakama-head'); ?>

<section id="homepage-hero" class="container-medium">


    <?php $latest_posts = get_cached_latest_posts(6);
    $count = 0;
    foreach ($latest_posts as $post) {
        setup_postdata($post);
        set_query_var('show_image', $count < 3);
        set_query_var('full_excerpt', $count == 0);
    ?>
        <div id="post-<?php the_ID(); ?>" class="hero-card">
            <?php if (get_query_var('show_image')) : ?>
                <div class="image-wrap">
                    <?php
                    $hero_image_id = get_post_thumbnail_id();
                    $hero_image_url = wp_get_attachment_image_url($hero_image_id, 'full');
                    $alt_text = get_post_meta($hero_image_id, '_wp_attachment_image_alt', true);
                    ?>


                    <a href="<?php the_permalink(); ?>">
                        <img
                            src="<?php echo esc_url($hero_image_url); ?>"
                            alt="<?php echo esc_attr($alt_text); ?>"
                            loading="eager"
                            width="500">
                    </a>

                </div>
            <?php endif; ?>

            <div class="text-wrap">
                <h2>
                    <a href="<?php the_permalink(); ?>">
                        <?php echo the_title() ?>
                    </a>
                </h2>

                <?php if (get_query_var('full_excerpt')) : ?>

                    <?php $ex = mb_substr(get_the_excerpt(), 0, 300); ?>
                <?php else : ?>
                    <?php $ex =  mb_substr(get_the_excerpt(), 0, 120) . '..'; ?>
                <?php endif; ?>

                <p class="card-excerpt">
                    <?php echo $ex; ?>
                </p>

                <?php
                $post_id = get_the_ID();
                $author_id = get_post_field('post_author', $post_id);
                $author_name = get_the_author_meta('display_name', $author_id);
                $author_url = get_author_posts_url($author_id);
                ?>
                <p class="author">
                    <span class="red"> <a href="<?php echo $author_url ?>"><?php echo $author_name; ?></a> </span>
                </p>
                <p class="date"> <?php echo get_the_date(); ?> </p>

            </div>
        </div>


    <?php $count++;
    }
    wp_reset_postdata();
    ?>
</section>
</header>
<div class="container-medium">
    <?php get_template_part('template-parts/content/category-blocks'); ?>
    <?php get_template_part('template-parts/content/text-subcopy'); ?>
    <?php get_template_part('template-parts/content/featured-post'); ?>
</div>
<div class="contain-homepage-bottom">

    <!-- match ids to JS -->
    <div class="main">
        <?php
        get_template_part('template-parts/content/slider-cat-latest', null, array('category_id' => 512, 'count' => 5)); ?>

        <?php
        get_template_part('template-parts/content/slider-cat-latest', null, array('category_id' => 520, 'count' => 5)); ?>

        <?php get_template_part('template-parts/ads/ad', 'horizontal'); ?>

        <?php get_template_part('template-parts/content/slider-cat-latest', null, array('category_id' => 513, 'count' => 5)); ?>

        <?php
        get_template_part('template-parts/content/slider-cat-latest', null, array('category_id' => 515, 'count' => 5)); ?>

        <?php get_template_part('template-parts/content/text-featured-large'); ?>



        <?php get_template_part('template-parts/content/image-text'); ?>


    </div>

    <div class="side">
        <?php get_template_part('template-parts/sidebar/sidebar-homepage'); ?>
    </div>


</div>

<section class="jetpac-block container-medium">
    <a href="https://www.japannakama.co.uk/jetpac/">
        <h2>Plan your journey with ease using Jetpac’s trusted travel guides</h2>
    </a>
</section>


<?php
/**
 * The template for displaying the footer
 */

if (woodmart_get_opt('collapse_footer_widgets') && (! woodmart_get_opt('mobile_optimization', 0) || (wp_is_mobile() && woodmart_get_opt('mobile_optimization')))) {
    woodmart_enqueue_inline_style('widget-collapse');
    woodmart_enqueue_js_script('widget-collapse');
}

$page_id                 = woodmart_page_ID();
$disable_prefooter       = get_post_meta($page_id, '_woodmart_prefooter_off', true);
$disable_footer_page     = get_post_meta($page_id, '_woodmart_footer_off', true);
$disable_copyrights_page = get_post_meta($page_id, '_woodmart_copyrights_off', true);
?>
<?php if (woodmart_needs_footer()) : ?>
    <?php if (! woodmart_is_woo_ajax()) : ?>
        </div><!-- .main-page-wrapper -->
    <?php endif ?>
    </div> <!-- end row -->
    </div> <!-- end container -->

    <?php if (! $disable_prefooter && ('text' === woodmart_get_opt('prefooter_content_type', 'text') && woodmart_get_opt('prefooter_area') || 'html_block' === woodmart_get_opt('prefooter_content_type') && woodmart_get_opt('prefooter_html_block'))) : ?>
        <?php woodmart_enqueue_inline_style('footer-base'); ?>
        <div class="wd-prefooter<?php echo woodmart_get_old_classes(' woodmart-prefooter'); ?>">
            <div class="container">
                <?php if ('text' === woodmart_get_opt('prefooter_content_type', 'text')) : ?>
                    <?php echo do_shortcode(woodmart_get_opt('prefooter_area')); ?>
                <?php else : ?>
                    <?php echo woodmart_get_html_block(woodmart_get_opt('prefooter_html_block')); ?>
                <?php endif; ?>
            </div>
        </div>
    <?php endif ?>

    <?php if (! function_exists('elementor_theme_do_location') || ! elementor_theme_do_location('footer')) : ?>
        <footer class="footer-container color-scheme-<?php echo esc_attr(woodmart_get_opt('footer-style')); ?>">
            <?php if (! $disable_footer_page && woodmart_get_opt('disable_footer')) : ?>
                <?php woodmart_enqueue_inline_style('footer-base'); ?>
                <?php if ('widgets' === woodmart_get_opt('footer_content_type', 'widgets')) : ?>
                    <?php get_sidebar('footer'); ?>
                <?php else : ?>
                    <div class="container main-footer">
                        <?php echo woodmart_get_html_block(woodmart_get_opt('footer_html_block')); ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            <?php if (! $disable_copyrights_page && woodmart_get_opt('disable_copyrights')) : ?>
                <?php woodmart_enqueue_inline_style('footer-base'); ?>
                <div class="copyrights-wrapper copyrights-<?php echo esc_attr(woodmart_get_opt('copyrights-layout')); ?>">
                    <div class="container">
                        <div class="min-footer">
                            <div class="col-left set-cont-mb-s reset-last-child">
                                <?php if (woodmart_get_opt('copyrights') != '') : ?>
                                    <?php echo do_shortcode(woodmart_get_opt('copyrights')); ?>
                                <?php else : ?>
                                    <p>&copy; <?php echo date('Y'); ?> <a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>. <?php esc_html_e('All rights reserved', 'woodmart'); ?></p>
                                <?php endif ?>
                            </div>
                            <?php if (woodmart_get_opt('copyrights2') != '') : ?>
                                <div class="col-right set-cont-mb-s reset-last-child">
                                    <?php echo do_shortcode(woodmart_get_opt('copyrights2')); ?>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            <?php endif ?>
        </footer>
    <?php endif ?>
<?php endif ?>
</div> <!-- end wrapper -->
<div class="wd-close-side wd-fill<?php echo woodmart_get_old_classes(' woodmart-close-side'); ?>"></div>
<?php do_action('woodmart_before_wp_footer'); ?>
<?php wp_footer(); ?>
</body>

</html>