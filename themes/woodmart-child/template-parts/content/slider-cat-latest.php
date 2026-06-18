<?php
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
$category_link = get_category_link($category_id);

if ($latest_posts): ?>

    <?php
    $categories = get_the_category();

    if (!empty($categories)) {
        $current_post_id = get_the_ID();
        $category_names = wp_list_pluck($categories, 'slug');
        $args = array(
            'category_name'  => implode(',', $category_names),
            'posts_per_page' => 4,
            'post__not_in'   => array($current_post_id),
        );
        $query = new WP_Query($args);

        $post_cat           =  $categories[0];
        $category_name      = $post_cat->cat_name;
    }

    $slug_cat = get_cat_name($post_cat->term_id);
    $slug_cat = html_entity_decode($slug_cat);
    $result = preg_replace(['/\s*&\s*/', '/\s*and\s*/i'], '-', $slug_cat);
    $result = preg_replace('/-+/', '-', trim($result, '-'));
    $slug_url = 'latest-' . strtolower($result);
    ?>

    <section class="slider-cat-latest brd-red" id="slider-<?php echo $category_id ?> ">
        <div class="heading-link">
            <h2> Latest <?php echo get_cat_name($category_id); ?></h2>
            <a href="<?php echo $category_link ?>"> View All</a>
        </div>
        <p class="sub-copy">
            <?php echo set_slider_sub($category_id); ?>
        </p>


        <div id="hp-cat-latest-<?php echo $category_id ?>" class="swiper-container">
            <ul class="swiper-wrapper">
                <?php foreach ($latest_posts as $post): setup_postdata($post); ?>
                    <li class="swiper-slide">

                        <a href="<?php the_permalink() ?>">
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
                                    <?php echo mb_substr(get_the_excerpt(), 0, 150) . '...'; ?>
                                </p>

                                <?php
                                $post_id = get_the_ID();
                                $author_id = get_post_field('post_author', $post_id);
                                $author_name = get_the_author_meta('display_name', $author_id);
                                $author_url = get_author_posts_url($author_id);
                                ?>

                                <p class="author" itemprop="author" itemscope itemtype="https://schema.org/Person">
                                    <span>
                                        <a href="<?php echo $author_url; ?>" itemprop="url">
                                            <span itemprop="name"><?php echo $author_name; ?></span>
                                        </a>
                                    </span>
                                </p>

                                <time class="date"><?php echo get_the_date(); ?></time>
                            </div>
                        </a>
                    </li>
                <?php endforeach; ?>
                <?php wp_reset_postdata(); ?>
            </ul>

        </div>
    </section>
<?php else: ?>
    <p>No posts found.</p>
<?php endif; ?>