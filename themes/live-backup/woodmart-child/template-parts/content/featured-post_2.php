<?php
$featured_post_2_id = get_option('nakama_post_id_2');
$post_2 = get_post($featured_post_2_id);

if ($post_2) {

    // Prepare post data so template tags work correctly
    setup_postdata($post_2);

    // Get the featured image for this post
    $card_thumb_id = get_post_thumbnail_id($post_2->ID);
    $bg_url = wp_get_attachment_image_url($card_thumb_id, 'small');
?>

    <section class="card-image-text-split">
        <div class="text">
            <h2><?php echo get_the_title($post_2); ?></h2>

            <p><?php echo get_the_excerpt($post_2); ?></p>

            <a class="btn-pill" href="<?php echo esc_url(get_permalink($post_2)); ?>">
                Read More
            </a>
        </div>

        <div class="image">
            <img src="<?php echo $bg_url ?>" alt="">
        </div>
        <div class=" overlay">

        </div>
    </section>

<?php
    // Reset global post data
    wp_reset_postdata();
}
?>