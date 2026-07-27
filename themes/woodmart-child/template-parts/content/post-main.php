<main id="post-content" role="main">
    <article>
        <?php the_content(); ?>
    </article>

    <?php
    // Get global post object and author ID
    global $post;
    $author_id = $post->post_author;
    ?>
    <section class="post-author">


        <div class="avatar">
            <?php
            $author_bio_avatar_size = apply_filters('woodmart_author_bio_avatar_size', 250);
            echo get_avatar($author_id, $author_bio_avatar_size, '', 'author-avatar');
            ?>
        </div>

        <div class="bio">
            <h2>Written by <?php echo esc_html(get_the_author_meta('display_name', $author_id)); ?></h2>
            <p><?php echo esc_html(get_the_author_meta('description', $author_id)); ?></p>
            <a href="<?php echo esc_url(get_author_posts_url($author_id)); ?>">View All</a>
        </div>
    </section>



    <?php

    $articles = array();

    // Get categories attached to current post
    $categories = wp_get_post_terms($post->ID, 'category');

    if (!empty($categories) && !is_wp_error($categories)) {

        $cat_id = $categories[0]->term_id;

        $args = array(
            'post_type'      => 'post',
            'posts_per_page' => 2,
            'post__not_in'   => array($post->ID),
            'tax_query'      => array(
                array(
                    'taxonomy' => 'category',
                    'field'    => 'term_id',
                    'terms'    => $cat_id,
                ),
            ),
        );

        $related_query = new WP_Query($args);

        if ($related_query->have_posts()) {
            while ($related_query->have_posts()) {
                $related_query->the_post();

                $articles[] = array(
                    'href'        => get_permalink(),
                    'title'       => get_the_title(),
                    'description' => get_the_excerpt(),
                    'date'        => get_the_date('Y-m-d'),
                    'image_id'    => get_post_thumbnail_id(get_the_ID()),
                );
            }
            wp_reset_postdata();
        }
    }
    ?>

    <?php if (!empty($articles)) : ?>
        <section class="read-more">
            <h2 class="read-more__heading">You May Also Like</h2>

            <div class="read-more__grid">
                <?php foreach ($articles as $article) : ?>
                    <a href="<?= esc_url($article['href']) ?>" class="article-card">

                        <div class="article-card__image-wrap">
                            <?php if ($article['image_id']) : ?>
                                <?php
                                // wp_get_attachment_image() outputs src + srcset + sizes
                                // so the browser picks the sharpest size for the card
                                // width / device pixel ratio.
                                echo wp_get_attachment_image(
                                    $article['image_id'],
                                    'large',
                                    false,
                                    array(
                                        'class'   => 'article-card__image',
                                        'alt'     => $article['title'],
                                        'loading' => 'lazy',
                                        // Full width on mobile, ~half the content column on desktop.
                                        'sizes'   => '(min-width: 768px) 400px, 100vw',
                                    )
                                );
                                ?>
                            <?php endif; ?>
                        </div>

                        <div class="article-card__body">
                            <h3 class="article-card__title">
                                <?= esc_html($article['title']) ?>
                            </h3>

                            <p class="article-card__desc">
                                <?= esc_html($article['description']) ?>
                            </p>

                            <time class="article-card__date" datetime="<?= esc_attr($article['date']) ?>">
                                <?= date('M j, Y', strtotime($article['date'])) ?>
                            </time>
                        </div>

                    </a>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>


</main>