<?php

/**
 * Template Name: Category Landing
 * Template Post Type: page
 */

?>

<?php $page_category_data = get_post_categories_data();

if (!empty($page_category_data)) {
    $page_cat = $page_category_data[0];
    set_query_var('page_cat', $page_cat);
} ?>

<?php get_template_part('template-parts/headers/header', 'categories'); ?>

<div id="categories-landing" class="container-md">

    <!-- <div class="row">
        <div class="col-12 ">
            <?php get_template_part('template-parts/content/drop-down-links'); ?>
        </div>
    </div> -->
    <!-- 
   > -->



    <?php $category = get_category_by_slug($page_cat['slug']);

    if (category_description($category->term_id)) { ?>
        <div class="row sub-copy">
            <div class="col-12">
                <p>
                    <?php echo category_description($category->term_id); ?>
                </p>
            </div>
        </div>
    <?php } ?>

    <div class="row">
        <div class="col-12 col-md-6">
            <?php get_template_part('template-parts/content/card', 'main'); ?>
        </div>
        <div class="col-12 col-md-6">
            <?php get_template_part('template-parts/content/card', 'stack_three'); ?>
        </div>
    </div>

    <div class="row">
        <main id="categories-content" class="col-12 col-md-9" role="main">

            <?php get_template_part('template-parts/content/card', 'stack_two'); ?>

            <?php get_template_part('template-parts/ads/ad', 'horizontal'); ?>

            <!-- <?php get_template_part('template-parts/forms/sign-up', 'mobile-box'); ?> -->

            <?php get_template_part('template-parts/content/card', 'archive-list'); ?>



        </main>

        <?php get_template_part('template-parts/sidebar/sidebar-categories'); ?>


    </div>

</div>




<?php get_footer(); ?>