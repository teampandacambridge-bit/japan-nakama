<!-- <?php $page_cat = get_query_var('page_cat', []) ?>

<?php $args = array(
    'post_type' => 'post',
    'category_name' => $page_cat['slug'],
    'posts_per_page' => 3,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'offset'         => 1,
);
$query = new WP_Query($args); ?>

<?php if ($query->have_posts()) : ?>
    <div class="card-stack_three">
        <ul>

            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <li>
                    <a href="<?php the_permalink() ?>" class="stacked-card">

                        <p class="tag tag-solid_red"> <?php echo $page_cat['name'] ?>
                        </p>


                        <div class="heading-image">
                            <div class="heading">
                                <h2> <?php the_title() ?> </h2>

                                <div class="stacked-card__copy--desk">
                                    <p> <?php echo mb_substr(get_the_excerpt(), 0, 50) . '...'; ?></p>
                                </div>

                            </div>

                            <div class="image">
                                <?php
                                if (has_post_thumbnail()) {
                                    $featured_image = get_the_post_thumbnail(get_the_ID(), 'medium');
                                    echo $featured_image;
                                }
                                ?>
                            </div>
                        </div>

                        <div class="stacked-card__copy--mobile">
                            <?php echo mb_substr(get_the_excerpt(), 0, 50) . '...'; ?>


                            <!-- <?php
                                    if (!empty(get_the_excerpt())) { ?>
                                <p><?php echo mb_substr(get_the_excerpt(), 0, 100) . '...'; ?></p>
                            <?php
                                    } else { ?>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium, eveniet minus. Expedita dolorum modi cupiditate quasi, assumenda voluptatibus cumque voluptate qui aut fuga sit inventore.
                                </p>

                            <?php } ?> -->
</div>

<div class="date-author">
    <div class="author">
        <p class="author-name"> <?php echo get_the_author() ?></span> </p>
    </div>
    <div class="date">
        <?php echo get_the_date() ?>
    </div>
</div>


</a>
</li>


<?php endwhile; ?>
</ul>
</div>
<?php endif;
wp_reset_postdata(); ?> -->