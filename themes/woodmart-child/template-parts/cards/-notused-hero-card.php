<a href="<?php the_permalink(); ?>">
    <article id="post-<?php the_ID(); ?>" class="hero-card brd-bt">
        <?php if (get_query_var('show_image')) : ?>
            <div class="image-wrap">
                <?php
                $hero_image_id = get_post_thumbnail_id();
                $hero_image_url = wp_get_attachment_image_url($hero_image_id, 'full');
                $alt_text = get_post_meta($hero_image_id, '_wp_attachment_image_alt', true);
                ?>
                <img
                    src="<?php echo esc_url($hero_image_url); ?>"
                    alt="<?php echo esc_attr($alt_text); ?>"
                    loading="eager"
                    width="500"
                    height="auto">

            </div>
        <?php endif; ?>

        <div class="text-wrap">
            <h2><?php the_title() ?></h2>
            <p class="card-excerpt">
                <?php echo mb_substr(get_the_excerpt(), 0, 150) . '...'; ?>
            </p>

            <?php
            $post_id = get_queried_object_id();
            $author_id = get_post_field('post_author', $post_id);
            $author_name = get_the_author_meta('display_name', $author_id);
            $author_url = get_author_posts_url($author_id);
            ?>
            <p class="name">
                Written by: <span class="red"> <a href="<?php echo $author_url ?>"><?php echo $author_name; ?></a> </span>
            </p>

            <p class="author"> By <span> Joe dfsdfdsfsssBlogs </span></p>

            <p class="date">
                <?php echo get_the_date(); ?>
            </p>

        </div>
    </article>

</a>