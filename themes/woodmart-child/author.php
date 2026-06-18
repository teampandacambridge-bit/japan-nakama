<?php

/**
 * Template Name: Nakama Default
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


    <?php $author = get_queried_object(); ?>

    <header id="page-header">
        <?php get_template_part('template-parts/navs/primary-nav'); ?>

        <h1 class="homepage-title"> Authors </h1>

    </header>
    <div class="container-medium">
        <main id="post-content" class="col-12" role="main">
            <div class="bio">
                <?php
                if ($author instanceof WP_User) {
                    echo get_avatar($author->ID, 96, '', esc_attr($author->display_name));
                    $bio = get_user_meta($author->ID, 'description', true);
                    if ($bio) {
                        echo '<h2> About ' . esc_html($author->display_name) . '</h2>';
                        echo '<p>' . esc_html($bio) . '</p>';
                    }
                }
                ?>


            </div>

            <div class="posts">
                <h2>Recent Posts</h2>

                <?php $args = array(
                    'post_type'      => 'post',
                    'author'         => $author->ID,
                    'posts_per_page' => 5,
                    'post_status'    => 'publish'
                ); ?>

                <?php

                $author_query = new WP_Query($args);

                // Start the loop
                if ($author_query->have_posts()) :
                    while ($author_query->have_posts()) : $author_query->the_post(); ?>

                        <a href="<?php the_permalink(); ?>" class="post-card">
                            <div class="image">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('medium'); ?>
                                <?php endif; ?>
                            </div>

                            <div class="text">
                                <h3><?php the_title(); ?></h3>

                            </div>
                        </a>

                <?php
                    endwhile;
                else :
                    echo 'No posts found for this author.';
                endif;

                // Reset post data
                wp_reset_postdata();
                ?>




            </div>







        </main>
    </div>
    <?php get_template_part('template-parts/footers/main-footer'); ?>
</body>

</html>