<article id="post-<?php the_ID(); ?>" class="hero-card brd-bt">
    <!-- <?php if (get_query_var('show_image')) : ?>
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
    <?php endif; ?> -->

    <div class="text-wrap">
        <h2><a href="<?php the_permalink(); ?>">Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere, dignissimos!</a></h2>
        <p class="card-excerpt">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Et vel officiis exercitationem aut. Consectetur delectus quo nemo, deleniti vero saepe </p>

        <p class="author"> By <span> Joe Blogs </span></p>
        <p class="date"> 1st january 2025 </p>

    </div>
</article>