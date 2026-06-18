<?php $page_cat = get_query_var('page_cat', []); ?>

<div class="card-stack__two">
    <?php $args = array(
        'post_type' => 'post',
        'category_name' => $page_cat['slug'],
        'posts_per_page' => 2,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'offset'         => 5, // Skip the most recent post
    );
    $query = new WP_Query($args); ?>

    <?php if ($query->have_posts()) : ?>
        <div class="stacked-cards__two">
            <ul>

                <?php while ($query->have_posts()) : $query->the_post(); ?>
                    <li>
                        <a href="<?php the_permalink() ?>">
                            <div class="stacked-card">
                                <div class="image">
                                    <?php
                                    if (has_post_thumbnail()) {
                                        $featured_image = get_the_post_thumbnail(get_the_ID(), 'medium');
                                        echo $featured_image;
                                    }
                                    ?>
                                </div>
                                <div class="text">
                                    <div class="heading">
                                        <h2> <?php the_title() ?> </h2>
                                    </div>


                                    <!-- <p class="excerpt"><?php echo mb_substr(get_the_excerpt(), 0, 100) . '...'; ?></p> -->


                                    <?php
                                    if (!empty(get_the_excerpt())) { ?>
                                        <p class="excerpt"><?php echo mb_substr(get_the_excerpt(), 0, 100) . '...'; ?></p>
                                    <?php
                                    } else { ?>

                                    <?php } ?>


                                    <div class="date-author">

                                        <p class="author-name"> <?php echo get_the_author() ?></p>


                                        <p class="date">
                                            <?php echo get_the_date() ?>
                                        </p>
                                    </div>

                                </div>

                            </div>
                        </a>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
    <?php endif;
    wp_reset_postdata(); ?>

</div>