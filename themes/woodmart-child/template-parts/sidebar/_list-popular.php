<?php $page_cat = get_query_var('page_cat', []); ?>

<div class="short-list">
    <ul>
        <h2>Most Popular </h2>
        <?php $args = array(
            'post_type' => 'post', // Query pages
            'orderby'        => 'date', // Order by date
            'order'          => 'DESC', // Show the latest post first
            // 'posts_per_page' => 2, // Limit the query to only 1 post

        );
        $query = new WP_Query($args); ?>

        <?php if ($query->have_posts()) : ?>
            <ul class="short-list">
                <?php $count = 1; ?>
                <?php while ($query->have_posts() && $count <= 5) : $query->the_post(); ?>
                    <li>
                        <div class="dot-wrap">
                            <div class="dot">
                                <p><?php echo $count; ?></p>
                            </div>
                        </div>

                        <a href="<?php the_permalink() ?>" class="card">
                            <h3><?php the_title(); ?></h3>
                        </a>
                    </li>
                    <?php $count++; ?>
                <?php endwhile; ?>
            </ul>

        <?php endif;
        wp_reset_postdata(); ?>
    </ul>
</div>