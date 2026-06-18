<?php

/**
 * Template Name: Homepage
 * Template Post Type: page
 */

?>


<?php get_template_part('template-parts/headers/nakama-head'); ?>
<?php get_template_part('template-parts/headers/header-homepage'); ?>




</header>
<div class="container-medium">
    <?php get_template_part('template-parts/content/category-blocks'); ?>
    <?php get_template_part('template-parts/content/text-subcopy'); ?>
    <?php get_template_part('template-parts/content/featured-post_1'); ?>
</div>

<div class="contain-homepage-bottom">

    <!-- match ids to JS -->
    <div class="main">

        <?php get_template_part('template-parts/content/travel-cards'); ?>

        <!-- 512 -->
        <?php
        get_template_part('template-parts/content/slider-cat-latest', null, array('category_id' => 512, 'count' => 5)); ?>

        <?php
        get_template_part('template-parts/content/slider-cat-latest', null, array('category_id' => 520, 'count' => 5)); ?>

        <?php get_template_part('template-parts/content/featured-post_2'); ?>

        <?php get_template_part('template-parts/ads/ad', 'horizontal'); ?>


        <?php get_template_part('template-parts/content/slider-cat-latest', null, array('category_id' => 513, 'count' => 5)); ?>

        <?php
        get_template_part('template-parts/content/slider-cat-latest', null, array('category_id' => 515, 'count' => 5)); ?>

        <?php get_template_part('template-parts/content/text-featured-large'); ?>

        <?php get_template_part('template-parts/content/image-text'); ?>

        <!-- <section class="jetpac-block container-medium">
            <a href="https://www.japannakama.co.uk/jetpac/">
                <h2>Plan your journey with ease using Jetpac’s trusted travel guides</h2>
            </a>
        </section> -->


    </div>

    <aside class="side">
        <?php get_template_part('template-parts/sidebar/sidebar-homepage'); ?>
    </aside>



</div>



<?php get_template_part('template-parts/footers/main-footer'); ?>
</body>

</html>