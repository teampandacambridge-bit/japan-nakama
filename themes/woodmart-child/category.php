<?php get_template_part('template-parts/headers/nakama-head'); ?>
</header>

<div id="categories-landing" class="container-medium">


    <div class="row">
        <div class="col-12 col-md-6">

            <?php
            $args = array(
                'posts_per_page' => 1,
                'orderby'        => 'date',
                'order'          => 'DESC',
                'cat'            => get_queried_object_id(),
            );
            $query = new WP_Query($args);

            if ($query->have_posts()) :
                while ($query->have_posts()) : $query->the_post(); ?>
                    <div class="card-main">
                        <a href="<?php echo get_permalink(); ?>" class="wrapper">
                            <div class="card-main__image">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php echo get_the_post_thumbnail(get_the_ID(), 'medium'); ?>
                                <?php endif; ?>

                                <div class="card-main__tag tag tag_solid-red">
                                    <p><?php single_cat_title(); ?></p>
                                </div>
                            </div>

                            <div class="card-main__text">
                                <time class="date" datetime="<?php echo get_the_date('c'); ?>">
                                    <?php echo get_the_date(); ?>
                                </time>

                                <h2><?php the_title(); ?></h2>

                                <?php if (!empty(get_the_excerpt())) : ?>
                                    <p><?php echo mb_substr(get_the_excerpt(), 0, 200) . '...'; ?></p>
                                <?php else : ?>
                                    <p></p>
                                <?php endif; ?>
                            </div>
                        </a>
                    </div>
            <?php endwhile;
            endif;
            wp_reset_postdata();
            ?>
        </div>

        <div class="col-12 col-md-6">
            <?php $page_cat = get_query_var('page_cat', []) ?>

            <?php $args = array(

                'posts_per_page' => 3,
                'orderby'        => 'date',
                'order'          => 'DESC',
                'offset'         => 1,
                'cat'            => get_queried_object_id(),
            );

            $query = new WP_Query($args); ?>

            <?php if ($query->have_posts()) : ?>
                <div class="card-stack_three">
                    <ul>

                        <?php while ($query->have_posts()) : $query->the_post(); ?>
                            <li>
                                <a href="<?php the_permalink() ?>" class="stacked-card">

                                    <p class="tag"> <?php single_cat_title(); ?>
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

                                        <p class="author">
                                            Written by:
                                            <span>
                                                <?php echo get_the_author() ?>
                                            </span>
                                        </p>

                                        <time class="date" datetime="<?php echo get_the_date('c'); ?>">
                                            <?php echo get_the_date(); ?>
                                        </time>
                                    </div>


                                </a>
                            </li>


                        <?php endwhile; ?>
                    </ul>
                </div>
            <?php endif;
            wp_reset_postdata(); ?>

        </div>
    </div>

    <div class="row">
        <?php get_template_part('template-parts/content/category-blocks'); ?>
    </div>

    <div class="row sub-copy">
        <div class="col-12">
            <p><?php echo category_description(); ?></p>
        </div>
    </div>


    <div class="row">
        <main id="categories-content" class="col-12 col-md-9" role="main">


            <div class="card-stack__two">
                <?php $args = array(
                    'posts_per_page' => 2,
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                    'offset'         => 4,
                    'cat'            => get_queried_object_id(),
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

                                                    <p class="author">
                                                        By:
                                                        <span>
                                                            <?php echo get_the_author() ?>
                                                        </span>
                                                    </p>

                                                    <time class="date" datetime="<?php echo get_the_date('c'); ?>">
                                                        <?php echo get_the_date(); ?>
                                                    </time>
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

            <?php get_template_part('template-parts/ads/ad', 'horizontal'); ?>

            <!-- <?php $page_cat = get_query_var('page_cat', ['id']) ?>
            <?php $cat_id = $page_cat['id']; ?> -->

            <?php
            $category = get_queried_object();
            $cat_id = $category->term_id;
            ?>


            <?php
            $paged          = isset($_POST['page']) ? intval($_POST['page']) : 1;
            $posts_per_page = 8;
            $skip           = 6; // Posts shown in the sections above (keep in sync with old-funcs.php load_more_posts())
            $args = array(
                'post_type'      => 'post',
                'posts_per_page' => $posts_per_page,
                // Manual offset that folds pagination together with the skipped posts.
                // (WP_Query's `paged` and `offset` cannot be combined reliably.)
                'offset'         => $skip + ($paged - 1) * $posts_per_page,
                'category__in'   => [$cat_id],
                'orderby'        => 'date',
                'order'          => 'DESC',
            );
            $query = new WP_Query($args);

            $available = max(0, $query->found_posts - $skip);
            $max_pages = (int) ceil($available / $posts_per_page);

            if ($query->have_posts()) :
                wp_localize_script('load-more-posts', 'ajax_object', array(
                    'ajax_url' => admin_url('admin-ajax.php'),
                    'max_pages' => $max_pages,
                    'page_cat' => $cat_id,
                ));
            ?>

                <div class="list-container">
                    <h2>More From Our <?php single_cat_title(); ?> Archive</h2>

                    <div id="card-archive-list">
                        <ul>
                            <?php while ($query->have_posts()) : $query->the_post(); ?>
                                <li>
                                    <a href="<?php the_permalink(); ?>">
                                        <div class="image">
                                            <?php
                                            if (has_post_thumbnail()) {
                                                echo get_the_post_thumbnail(get_the_ID(), 'medium');
                                            }
                                            ?>
                                        </div>
                                        <div class="text">
                                            <h3><?php the_title(); ?></h3>
                                            <div class="date-author">
                                                <p class="author">By <span class="red"><?php echo get_the_author(); ?></span></p>
                                                <p class="date"><?php echo get_the_date(); ?></p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            <?php endwhile; ?>
                        </ul>

                        <div class="pagination-controls">
                            <button id="prev-page" disabled>Previous</button>
                            <p>Page <span><?php echo $paged; ?></span> of <span><?php echo $max_pages; ?></span></p>
                            <button id="next-page">Next</button>
                        </div>
                    </div>
                </div>

            <?php
            endif; // End if have_posts
            wp_reset_postdata();
            ?>

        </main>
        <?php get_template_part('template-parts/sidebar/sidebar-categories'); ?>


    </div>
</div>



<?php get_template_part('template-parts/footers/main-footer'); ?>