<?php get_template_part('template-parts/headers/nakama-head'); ?>


</header>
<div class="container-medium">

    <div class="shop-category-grid">

        <?php
        $args = [
            'taxonomy'   => 'product_cat',
            'parent'     => 0, // only top-level categories
            'hide_empty' => true,
        ];

        $categories = get_terms($args);

        foreach ($categories as $category) :

            $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
            $image = wp_get_attachment_url($thumbnail_id);
            $link = get_term_link($category);
        ?>

            <a href="<?php echo esc_url($link); ?>" class="shop-card">

                <?php if ($image) : ?>
                    <div class="shop-card-image">
                        <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($category->name); ?>">
                    </div>
                <?php endif; ?>

                <div class="shop-card-content">
                    <h2><?php echo esc_html($category->name); ?></h2>
                    <p><?php echo esc_html($category->description); ?></p>
                </div>

            </a>

        <?php endforeach; ?>

    </div>

</div>
<?php get_template_part('template-parts/footers/main-footer'); ?>
</body>

</html>