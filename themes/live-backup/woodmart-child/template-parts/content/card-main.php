<!-- <?php
        $page_cat = get_query_var('page_cat', []);

        // print_r($page_cat['slug']);

        $args = array(
            'post_type'      => 'post',
            'category_name'  => $page_cat['slug'],
            'posts_per_page' => 1,
            'orderby'        => 'date',
            'order'          => 'DESC',
        );



        $query = new WP_Query($args);

        if ($query->have_posts()) :
            while ($query->have_posts()) : $query->the_post(); ?>
        <div class="card-main">
            <a href="<?php echo get_permalink(); ?>">
                <div class="card-main__image">

                    <?php if (has_post_thumbnail()) : ?>
                        <?php echo get_the_post_thumbnail(get_the_ID(), 'medium'); ?>
                    <?php endif; ?>

                    <div class="card-main__tag tag tag_solid-red">
                        <p><?php echo $page_cat['name']; ?></p>
                    </div>
                </div>

                <div class="card-main__text">
                    <h2><?php the_title(); ?></h2>
                    <p>

                        <?php
                        if (!empty(get_the_excerpt())) { ?>
                    <p><?php echo mb_substr(get_the_excerpt(), 0, 200) . '...'; ?></p>
                <?php
                        } else { ?>
                    <p>

                    </p>

                <?php } ?>

                </p>

                <p class="author">By <span class="red"><?php echo esc_html(get_the_author()); ?></span></p>
                </div>
            </a>
        </div>
<?php endwhile;
        endif;
        wp_reset_postdata();
?> -->