<?php
$categories = [];

if (is_front_page()) {
    // Homepage: show selected category slugs
    $slugs = ['food', 'travel', 'lifestyle', 'events', 'anime'];
    $slugs = array_slice($slugs, 0, 5);

    $categories = get_categories([
        'slug' => $slugs,
        'hide_empty' => false,
    ]);
} elseif (is_category()) {
    // Category page: show subcategories of current category
    $current_category = get_queried_object();

    if ($current_category && isset($current_category->term_id)) {
        $categories = get_categories([
            'child_of' => $current_category->term_id,
            'hide_empty' => false,
        ]);
    }
} elseif (is_404()) {
    // 404 page: show a fallback or popular categories
    $slugs = ['food', 'travel', 'lifestyle', 'events', 'anime'];

    $categories = get_categories([
        'slug' => $slugs,
        'hide_empty' => false,
    ]);
}
?>

<?php if (!empty($categories)) : ?>
    <section class="category-blocks">
        <ul>
            <?php foreach ($categories as $category) : ?>
                <?php
                $slug = $category->slug;
                $image_base = get_stylesheet_directory_uri() . '/assets/img/bg-' . $slug;
                ?>
                <li>
                    <picture>
                        <source media="(max-width: 767px)" srcset="<?php echo esc_url($image_base . '-mobile.png'); ?>">
                        <img src="<?php echo esc_url($image_base . '-desktop.png'); ?>" class="category-bg" alt="<?php echo esc_url($slug . 'animie style poster'); ?>">
                    </picture>

                    <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>">
                        <h2><?php echo esc_html($category->name); ?></h2>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
<?php endif; ?>