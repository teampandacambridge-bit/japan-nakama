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
} ?>

<?php


$slug_cat = get_cat_name($post_cat->term_id);

// Decode HTML entities (convert &amp; back to &)
$slug_cat = html_entity_decode($slug_cat);

// Replace both ' & ' and 'and' with '-'
$result = preg_replace(['/\s*&\s*/', '/\s*and\s*/i'], '-', $slug_cat);

// Ensure no double hyphens and trim excess hyphens
$result = preg_replace('/-+/', '-', trim($result, '-'));

$slug_url = 'latest-' . strtolower($result); // Convert to lowercase for SEO-friendly URL

?>

<?php if ($query->have_posts()) : ?>
    <section class="related-posts">

        <h2>Latest In <?php echo ucfirst($result) ?> </h2>
        <!-- <p>View more from </p>

        <a class="cat-heading" href="/<?php echo $slug_url ?>/"><?php echo get_cat_name($post_cat->term_id) ?> </a> -->

        <div class="posts">
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <a href="<?php the_permalink(); ?>" class="post-card">
                    <div class="image">
                        <?php echo get_the_post_thumbnail(get_the_ID(), 'small'); ?>
                    </div>
                    <div class="text">
                        <p><?php the_title(''); ?></p>
                    </div>
                </a>
            <?php endwhile; ?>
        </div>
    </section>
<?php endif;
wp_reset_postdata();
