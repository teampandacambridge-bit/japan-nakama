<?php
$categories = [];

if (is_front_page()) {
    // Homepage: show selected category slugs
    $slugs = ['japan-life', 'releases', 'guides-travel', 'art-design', 'guides'];
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
    $slugs = ['japan-life', 'releases', 'guides-travel', 'art-design', 'guides'];

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
                        <source media="(max-width: 768px)" srcset="<?php echo esc_url($image_base . '-mobile.png'); ?>">
                        <source media="(min-width: 769px)" srcset="<?php echo esc_url($image_base . '-desktop.png'); ?>">
                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/img/bg-placeholder.png'; ?>" alt="<?php echo esc_attr($category->name); ?>" class="category-bg">
                    </picture>
                    <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>">
                        <h2><?php echo esc_html($category->name); ?></h2>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
<?php endif; ?>