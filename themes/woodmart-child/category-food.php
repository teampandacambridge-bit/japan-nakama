<?php get_template_part('template-parts/headers/nakama-head'); ?>
</header>

<div id="categories-landing" class="container-medium">

    <div class="row sub-copy">
        <div class="col-12">
            <p><?php echo category_description(); ?></p>
        </div>
    </div>

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
        <?php
        $categories = [];

        if (is_front_page()) {
            // Homepage: show selected category slugs
            $slugs = ['japan-life', 'releases', 'guides-travel', 'art-design', 'guides'];
            $slugs = array_slice($slugs, 0, 5);

            $categories = get_categories([
                'slug' => $slugs,
                'hide_empty' => false,
            ]);
        } elseif (is_category()) {
            // Category page: show subcategories of current category
            $current_category = get_queried_object();

            if ($current_category && isset($current_category->term_id)) {
                $categories = get_categories([
                    'child_of' => $current_category->term_id,
                    'hide_empty' => false,
                ]);
            }
        } elseif (is_404()) {
            // 404 page: show a fallback or popular categories
            $slugs = ['japan-life', 'releases', 'guides-travel', 'art-design', 'guides'];

            $categories = get_categories([
                'slug' => $slugs,
                'hide_empty' => false,
            ]);
        }
        ?>

        <?php if (!empty($categories)) : ?>
            <section class="category-blocks">
                <ul>
                    <?php foreach ($categories as $category) : ?>
                        <?php
                        $slug = $category->slug;
                        $image_base = get_stylesheet_directory_uri() . '/assets/img/bg-' . $slug;
                        ?>
                        <li>
                            <picture>
                                <source media="(max-width: 767px)" srcset="<?php echo esc_url($image_base . '-mobile.png'); ?>">
                                <img src="<?php echo esc_url($image_base . '-desktop.png'); ?>" class="category-bg">
                            </picture>

                            <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>">
                                <h2><?php echo esc_html($category->name); ?></h2>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>
        <?php endif; ?>
    </div>


</div>



<?php get_template_part('template-parts/footers/main-footer'); ?>