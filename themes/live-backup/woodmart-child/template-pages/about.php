<?php

/**
 * Template Name: About
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

        <!-- <div class="image-heading" style="background-image: url('<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>');"> -->

        <div class="image-heading">

            <h1>About Japan Nakama</h1>
            <p>Your trusted companions on the journey through Japan</p>
        </div>
    </header>


    <main>

        <section class="intro">
            <div class="container-medium">
                <?php the_content(); ?>
            </div>


        </section>


        <section class="authors">
            <div class="container-medium">
                <h2>Meet Our Authors</h2>
                <p> Our diverse team of Japan experts brings you authentic insights from every corner of Japanese culture, society, and daily life. </p>

                <div class="author-cards">


                    <?php
                    $user_ids = array(
                        5,
                        5813,
                        71,
                        28,
                        22,
                        5641,
                        102,
                        5593,
                        6133,
                        6152,
                    );

                    $authors = get_users(array(
                        'include'    => $user_ids,
                        'orderby'    => 'display_name',
                        'order'      => 'ASC',
                    ));

                    foreach ($authors as $author) :
                        $author_id = $author->ID;
                    ?>

                        <div class="author-card">

                            <div class="author-avatar">
                                <?php echo get_avatar($author_id, 96); ?>
                            </div>


                            <h2><?php echo esc_html($author->display_name); ?></h2>


                            <p class="author-bio">
                                <?php echo esc_html(get_the_author_meta('description', $author_id)); ?>
                            </p>


                            <a href="<?php echo esc_url(get_author_posts_url($author_id)); ?>">
                                Read Articles
                            </a>




                        </div>

                    <?php endforeach; ?>
                    <!-- <div class="author-card">

                        <div class="author-avatar">
                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/img/cookie.png'; ?>" alt="cookie">
                        </div>


                        <h2>Cookie</h2>


                        <p class="author-bio">
                            Cookie-chan is Japan Nakama’s pawfect mascot and fluffball-in-chief! This cheeky Maltipoo loves park zoomies, matcha walks, and bringing kawaii energy to every adventure. Always ready to add a dash of pawsome energy to the Nakama crew!

                        </p>


                        <a href="https://www.instagram.com/iamcookiethemaltipoo/" target="_blank" rel="noopener noreferrer">
                            Visit Profile
                        </a>

                    </div> -->



                </div>

            </div>

        </section>

        <section class="banner-explore">
            <h2>Ready to Explore Japan?</h2>
            <p>Join thousands of readers who trust Japan Nakama for authentic insights, practical advice, and inspiring stories about Japan.</p>
            <div class="links">
                <a href="/" class="btn-primary">View All Articles</a>
            </div>
        </section>
    </main>
    <?php get_template_part('template-parts/footers/main-footer'); ?>

</body>

</html>