<?php

/**
 * Template Name: Homepage
 * Template Post Type: page
 */

?>


<?php get_template_part('template-parts/headers/nakama-head'); ?>
<?php get_template_part('template-parts/headers/header-homepage'); ?>
</header>

<?php get_template_part('template-parts/content/events-takeover'); ?>

<div class="container-medium">

    <?php get_template_part('template-parts/content/text-subcopy'); ?>
    <?php get_template_part('template-parts/content/featured-post_1'); ?>
    <?php get_template_part('template-parts/content/category-blocks'); ?>
</div>

<div class="contain-homepage-bottom">

    <!-- match ids to JS -->
    <div class="main">




        <!-- 515 / Creativity -->
        <?php
        get_template_part('template-parts/content/slider-cat-latest', null, array('category_id' => 515, 'count' => 5)); ?>


        <!-- 512 / Travel -->
        <?php
        get_template_part('template-parts/content/slider-cat-latest', null, array('category_id' => 512, 'count' => 5)); ?>

        <?php get_template_part('template-parts/content/travel-cards'); ?>

        <?php
        //TV
        get_template_part('template-parts/content/slider-cat-latest', null, array('category_id' => 516, 'count' => 5)); ?>

        <?php get_template_part('template-parts/content/featured-post_2'); ?>

        <?php get_template_part('template-parts/ads/ad', 'horizontal'); ?>


        <!-- Lifestyle -->
        <?php get_template_part('template-parts/content/slider-cat-latest', null, array('category_id' => 513, 'count' => 5)); ?>



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


<!-- 
Latest Creativity -515
Latest Travel (with the cities part below the article selection part, instead of above) 512
Latest TV & Film - 516
Latest Lifestyle  - 513
-->