<?php


/**
 * Template Name: WC Home
 * Template Post Type: page
 */

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-KPJK8T');
    </script>
    <!-- End Google Tag Manager -->


    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KPJK8T"
            height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <header id="page-header">
        <?php get_template_part('template-parts/navs/primary-nav'); ?>
        <?php
        if (!is_singular('post')) {
            $h1 = is_category() ? single_cat_title('', false) : get_the_title();
            echo '<h1 class="homepage-title"> Shop </h1>';
        }
        ?>


    </header>
    <div class="container-medium">


        <!-- Hero Section -->
        <!-- <section class="hero">
        <div class="hero__image">
            <img src="https://images.unsplash.com/photo-1755184108643-a8ee184ce542?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxqYXBhbmVzZSUyMHRlYSUyMGNlcmVtb255JTIwbWF0Y2hhfGVufDF8fHx8MTc3MTIzODU3Nnww&ixlib=rb-4.1.0&q=80&w=1080" alt="Japanese tea ceremony">
            <div class="hero__overlay"></div>
        </div>
        <div class="hero__content">
            <h1 class="hero__title">Discover Authentic Japanese Craftsmanship</h1>
            <p class="hero__description">
                Curated collection of traditional and contemporary Japanese products,
                handpicked to bring the essence of Japan to your home.
            </p>
        </div>
    </section> -->

        <!-- Features Section -->
        <!-- <section class="features">
        <div class="features__container">
            <div class="features__item">
                <div class="features__icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                    </svg>
                </div>
                <h3 class="features__title">Authentic Products</h3>
                <p class="features__description">Sourced directly from trusted Japanese artisans and manufacturers</p>
            </div>

            <div class="features__item">
                <div class="features__icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                    </svg>
                </div>
                <h3 class="features__title">Quality Guaranteed</h3>
                <p class="features__description">Every item is inspected to ensure the highest standards</p>
            </div>

            <div class="features__item">
                <div class="features__icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="1" y="3" width="15" height="13"></rect>
                        <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                        <circle cx="5.5" cy="18.5" r="2.5"></circle>
                        <circle cx="18.5" cy="18.5" r="2.5"></circle>
                    </svg>
                </div>
                <h3 class="features__title">Fast Shipping</h3>
                <p class="features__description">Reliable delivery worldwide with careful packaging</p>
            </div>

            <div class="features__item">
                <div class="features__icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                    </svg>
                </div>
                <h3 class="features__title">Expert Curation</h3>
                <p class="features__description">Handpicked selection of traditional and contemporary items</p>
            </div>
        </div>
    </section> -->





        <!-- Product Categories - Bento Grid -->
        <section class="products">
            <div class="products__container">
                <div class="products__header">
                    <h2 class="products__title">Shop by Category</h2>
                    <p class="products__subtitle">
                        Explore our carefully curated selection of authentic Japanese products,
                        from traditional crafts to modern essentials.
                    </p>
                </div>

                <div class="bento-grid">
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
                        <!-- Ceramics - Large featured -->
                        <a href="<?php echo esc_url($link); ?>" class=" bento-grid__item">
                            <?php if ($image) : ?>
                                <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($category->name); ?>">
                            <?php endif; ?>
                            <div class="bento-grid__overlay">
                                <h3 class="bento-grid__title"><?php echo esc_html($category->name); ?></h3>
                                <!-- <p class="bento-grid__description">
                                <?php echo esc_html($category->description); ?>
                            </p> -->
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

    </div>
    <?php get_template_part('template-parts/footers/main-footer'); ?>
</body>

</html>