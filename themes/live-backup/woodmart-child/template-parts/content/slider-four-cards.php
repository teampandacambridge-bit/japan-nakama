<?php $page_cat = get_query_var('page_cat', []); ?>
<?php $cat_id = $page_cat['id']; ?>

<?php

$args = array(
    'post_type' => 'post',
    'posts_per_page' => 8,
    'category__not_in' => [$cat_id],
    'orderby'        => 'rand',
    'category__not_in' => 17,

);
$query = new WP_Query($args);


?>

<div class="slider-four-cards">
    <h2>Explore More Japan</h2>
    <div id="cat-page-swiper" class="swiper-container">
        <div class="swiper-wrapper">

            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <div class="swiper-slide">
                    <a href="<?php the_permalink(); ?>" class="post-card">
                        <div class="image">

                            <?php echo get_the_post_thumbnail(get_the_ID(), 'small'); ?>
                        </div>
                        <div class="text">
                            <p class="tag tag-solid_red"> <?php echo get_the_category_list(', ') ?>
                            </p>
                            <h3> <?php echo get_the_title(); ?></h3>
                            <!-- <p> <?php echo mb_substr(get_the_excerpt(), 0, 100) . '...'; ?></p> -->
                        </div>
                    </a>
                </div>

            <?php endwhile; ?>
        </div>
    </div>
</div>