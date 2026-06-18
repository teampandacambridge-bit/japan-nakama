<section id="featured-post">
    <?php

    $featured_post_id = get_option('nakama_post_id');
    $post = get_post($featured_post_id);

    if ($post) { ?>

        <div class="img-wrap">
            <?php
            $slider_image_id = get_post_thumbnail_id();
            $slider_image_url = wp_get_attachment_image_url($slider_image_id, 'small');
            $alt_text = get_post_meta($slider_image_id, '_wp_attachment_image_alt', true);
            ?>



            <a href="<?php echo the_permalink(); ?>">
                <img
                    src=" <?php echo esc_url($slider_image_url); ?>"
                    alt="<?php echo esc_attr($alt_text); ?>"
                    loading="lazy"
                    width="400"
                    height="auto">
            </a>

        </div>
        <div class="text-wrap">
            <h2><?php the_title() ?></h2>
            <p><?php the_excerpt() ?></p>

        </div>

    <?php } else {
        echo 'Post not found.';
    }
    ?>
</section>
<!-- 
    echo '<h2>' . esc_html($post->post_title) . '</h2>';
        echo '<p>' . esc_html($post->post_content) . '</p>'; -->