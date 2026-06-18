<?php
// Fetch recent posts from the category (not ordered yet)

$current_category = get_queried_object();

$args = array(
    'cat'            => $current_category->term_id,
    'posts_per_page' => 20, // fetch more, we’ll trim to 5 after sorting
    'orderby'        => 'date',
    'order'          => 'DESC',
);

$query = new WP_Query($args);
?>

<?php if ($query->have_posts()) : ?>
    <?php
    $posts_with_views = array();

    while ($query->have_posts()) : $query->the_post();
        $views = get_post_views_last_days(get_the_ID(), 30); // last month
        $posts_with_views[get_the_ID()] = $views;
    endwhile;

    // Sort by view count, descending
    arsort($posts_with_views);

    // Keep only top 5
    $top_posts = array_slice($posts_with_views, 0, 5, true);
    ?>


    <div class="short-list">

        <?php if (is_category('events')) : ?>
            <h2>Trending Events</h2>
        <?php elseif (is_front_page() || is_home()) : ?>
            <h2>Trending Articles</h2>
        <?php elseif (is_category()) : ?>
            <h2>Trending Articles</h2>
        <?php else : ?>
            <h2>Trending</h2>
        <?php endif; ?>

        <ul class="short-list">
            <?php $dot_num = 1; ?>
            <?php foreach ($top_posts as $post_id => $views) : ?>
                <li>
                    <div class="dot-wrap">
                        <div class="dot">
                            <p><?php echo $dot_num; ?></p>
                        </div>
                    </div>

                    <a href="<?php echo get_permalink($post_id); ?>">
                        <h3><?php echo get_the_title($post_id); ?></h3>
                        <!-- <?php echo  $views ?> -->
                    </a>
                </li>
                <?php $dot_num++; ?>
            <?php endforeach; ?>
        </ul>
    </div>


<?php endif;
wp_reset_postdata(); ?>