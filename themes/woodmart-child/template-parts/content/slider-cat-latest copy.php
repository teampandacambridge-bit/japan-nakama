<?php
// Prevent function redeclaration
if (!function_exists('get_latest_posts_by_category')) {
    function get_latest_posts_by_category($category_id, $count = 8, $cache_time = 3600)
    {
        $transient_key = 'latest_posts_cat_' . $category_id;
        $latest_posts = get_transient($transient_key);

        if (false === $latest_posts) {
            $args = array(
                'post_type'      => 'post',
                'posts_per_page' => $count,
                'cat'            => $category_id,
                'post_status'    => 'publish',
                'orderby'        => 'date',
                'order'          => 'DESC',
            );

            $latest_posts = get_posts($args);
            set_transient($transient_key, $latest_posts, $cache_time);
        }

        return $latest_posts;
    }
}

// Get parameters
$category_id = isset($args['category_id']) ? $args['category_id'] : 1;
$count = isset($args['count']) ? $args['count'] : 8;
$cache_time = isset($args['cache_time']) ? $args['cache_time'] : 3600;

// Fetch posts
$latest_posts = get_latest_posts_by_category($category_id, $count, $cache_time);

if ($latest_posts): ?>
    <section class="slider-cat-latest brd-red" id="slider-<?php echo $category_id ?> ">
        <div class="heading-link">
            <h2> Latest <?php echo get_cat_name($category_id); ?></h2>
            <a href="">View All </a>
        </div>
        <p class="sub-copy">
            <?php echo set_slider_sub(16); ?>
        </p>


        <div id="hp-cat-latest-<?php echo $category_id ?>" class="swiper-container">
            <ul class="swiper-wrapper">
                <?php foreach ($latest_posts as $post): setup_postdata($post); ?>
                    <li class="swiper-slide">
                        <div class="img-wrap">
                            <?php
                            $slider_image_id = get_post_thumbnail_id();
                            $slider_image_url = wp_get_attachment_image_url($slider_image_id, 'small');
                            $alt_text = get_post_meta($slider_image_id, '_wp_attachment_image_alt', true);
                            ?>
                            <img
                                src="<?php echo esc_url($slider_image_url); ?>"
                                alt="<?php echo esc_attr($alt_text); ?>"
                                loading="lazy"
                                width="400"
                                height="auto">
                        </div>
                        <div class="text-wrap">
                            <h3> <?php the_title(); ?> </h3>
                            <p class="excerpt">
                                <?php echo get_the_excerpt(); ?>
                            </p>
                            <p class="author"><?php the_author(); ?></p>
                            <time class="date"><?php the_date(); ?></time>
                        </div>
                    </li>
                <?php endforeach; ?>
                <?php wp_reset_postdata(); ?>
            </ul>

        </div>
    </section>
<?php else: ?>
    <p>No posts found.</p>
<?php endif; ?>