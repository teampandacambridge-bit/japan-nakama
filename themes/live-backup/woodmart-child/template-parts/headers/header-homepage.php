<section id="homepage-hero" class="container-medium">
    <?php $latest_posts = get_cached_latest_posts(6);
    $count = 0;
    foreach ($latest_posts as $post) {
        setup_postdata($post);
        set_query_var('show_image', $count < 3);
        set_query_var('full_excerpt', $count == 0);
    ?>

        <article id="post-<?php the_ID(); ?>" class="hero-card" itemscope itemtype="https://schema.org/Article">
            <?php if (get_query_var('show_image')) : ?>
                <div class="image-wrap">

                    <?php
                    $hero_image_id = get_post_thumbnail_id();
                    $alt_text = get_post_meta($hero_image_id, '_wp_attachment_image_alt', true);

                    // Use 'large' or 'medium' for default src; 'full' is too heavy for most cases
                    $default_size = 'large';
                    $hero_image_src = wp_get_attachment_image_url($hero_image_id, $default_size);
                    $hero_image_srcset = wp_get_attachment_image_srcset($hero_image_id, $default_size);
                    ?>

                    <a href="<?php the_permalink(); ?>">
                        <img
                            src="<?php echo esc_url($hero_image_src); ?>"
                            srcset="<?php echo esc_attr($hero_image_srcset); ?>"
                            sizes="100vw"
                            alt="<?php echo esc_attr($alt_text); ?>"
                            loading="eager"
                            fetchpriority="high"
                            width="1200"
                            height="600">

                    </a>

                </div>


            <?php endif; ?>
            <div class="text-wrap">
                <h2>
                    <a href="<?php the_permalink(); ?>">
                        <?php echo the_title() ?>
                    </a>
                </h2>

                <?php if (get_query_var('full_excerpt')) : ?>
                    <?php $ex = mb_substr(get_the_excerpt(), 0, 300); ?>
                <?php else : ?>
                    <?php $ex =  mb_substr(get_the_excerpt(), 0, 120) . '..'; ?>
                <?php endif; ?>
                <p class="card-excerpt">
                    <?php echo $ex; ?>
                </p>

                <?php
                $post_id = get_the_ID();
                $author_id = get_post_field('post_author', $post_id);
                $author_name = get_the_author_meta('display_name', $author_id);
                $author_url = get_author_posts_url($author_id);
                ?>
                <p class="author" itemprop="author" itemscope itemtype="https://schema.org/Person">
                    Written by:
                    <span>
                        <a href="<?php echo $author_url; ?>" itemprop="url">
                            <span itemprop="name"><?php echo $author_name; ?></span>
                        </a>
                    </span>
                </p>

                <time class="date" datetime="<?php echo get_the_date('c'); ?>">
                    <?php echo get_the_date(); ?>
                </time>

            </div>
        </article>
    <?php $count++;
    }
    wp_reset_postdata();
    ?>
</section>