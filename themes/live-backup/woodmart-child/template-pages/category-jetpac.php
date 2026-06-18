<?php

/**
 * Template Name: Category Jetpac
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

    <!-- MS Clarity -->
    <script type="text/javascript">
        (function(c, l, a, r, i, t, y) {
            c[a] = c[a] || function() {
                (c[a].q = c[a].q || []).push(arguments)
            };
            t = l.createElement(r);
            t.async = 1;
            t.src = "https://www.clarity.ms/tag/" + i;
            y = l.getElementsByTagName(r)[0];
            y.parentNode.insertBefore(t, y);
        })(window, document, "clarity", "script", "buof6rigv3");
    </script>

    <!-- swiper -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />



    <!-- End Google Tag Manager -->
    <meta charset="<?php bloginfo('charset'); ?>">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <header id="page-header">
        <?php get_template_part('template-parts/navs/primary-nav'); ?>
        <?php
        if (!is_singular('post')) {
            $h1 = is_category() ? single_cat_title('', false) : get_the_title();
            echo '<h1 class="homepage-title">' . esc_html($h1) . '</h1>';
        }
        ?>
    </header>

    <div id="categories-landing" class="container-md">

        <a href="https://manage.kmail-lists.com/subscriptions/subscribe?a=Wcb9eg&g=Uy52gg&fbclid=PAQ0xDSwKtPzdleHRuA2FlbQIxMQABpzhU_3O5TNdBkk8q0xAfSABPiPsIyE-7WKS-Neu5SLvNBB_Qu82HOu0dHDTl_aem_fzA8ll7FsdcPMZJW3xJGwA" target="_blank" rel="noopener noreferrer">
            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/img/jetpac-banner-2.webp'; ?>" alt="jetpac logo">
        </a>

        <div class="row sub-copy">
            <div class="col-12">
                <!-- <p><?php echo category_description(); ?></p> -->
                <p>Planning a trip to Japan? We've teamed up with Jetpac to bring you more than just data—we’re delivering the digital essentials to help you explore Japan with confidence, convenience, and cultural know-how.</p>

                <p> <a href="https://circleslife.pxf.io/4PVG3Z">Jetpac’s travel eSIM </a> is the easiest way to get connected the moment you land. No queues, no physical SIM cards, no roaming fees—just fast, reliable data to power your maps, bookings, translations, and Insta-worthy moments across Japan.</p>

                <p> But this page isn’t just about staying online. It’s about staying informed. We’ve curated a collection of <a href="https://www.japannakama.co.uk/travel/travel-tips/">Japan travel tips</a>, budget hacks, and local insights aligned with Jetpac’s mission to support smarter, more connected travel.</p>

            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-6">

                <?php


                $args = array(

                    'posts_per_page' => 1,
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                    'tag_id'            => '15118',
                );



                $query = new WP_Query($args);

                if ($query->have_posts()) :
                    while ($query->have_posts()) : $query->the_post(); ?>
                        <div class="card-main">
                            <a href="<?php echo get_permalink(); ?>">
                                <div class="card-main__image">

                                    <?php if (has_post_thumbnail()) : ?>
                                        <?php echo get_the_post_thumbnail(get_the_ID(), 'medium'); ?>
                                    <?php endif; ?>


                                    <div class="card-main__tag tag tag_solid-red">
                                        <p>
                                            <?php $category = get_the_category();
                                            if (! empty($category)) {
                                                echo esc_html($category[0]->name);
                                            } ?>
                                        </p>
                                    </div>
                                </div>

                                <div class="card-main__text">
                                    <h2><?php the_title(); ?></h2>
                                    <p>

                                        <?php
                                        if (!empty(get_the_excerpt())) { ?>
                                    <p><?php echo mb_substr(get_the_excerpt(), 0, 200) . '...'; ?></p>
                                <?php
                                        } else { ?>
                                    <p>

                                    </p>

                                <?php } ?>

                                </p>

                                <p class="author">By <span class="red"><?php echo esc_html(get_the_author()); ?></span></p>
                                </div>
                            </a>
                        </div>
                <?php endwhile;
                endif;
                wp_reset_postdata();
                ?>
            </div>


            <div class="col-12 col-md-6">
                <?php $page_cat = get_query_var('page_cat', []) ?>

                <?php $args = array(

                    'posts_per_page' => 3,
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                    'offset'         => 1,
                    'tag_id'            => '15118',
                );

                $query = new WP_Query($args); ?>

                <?php if ($query->have_posts()) : ?>
                    <div class="card-stack_three">
                        <ul>

                            <?php while ($query->have_posts()) : $query->the_post(); ?>
                                <li>
                                    <a href="<?php the_permalink() ?>" class="stacked-card">

                                        <p class="tag tag-solid_red">
                                            <?php $category = get_the_category();
                                            if (! empty($category)) {
                                                echo esc_html($category[0]->name);
                                            } ?>
                                        </p>

                                        <div class="heading-image">
                                            <div class="heading">
                                                <h2> <?php the_title() ?> </h2>

                                                <div class="stacked-card__copy--desk">
                                                    <p> <?php echo mb_substr(get_the_excerpt(), 0, 50) . '...'; ?></p>
                                                </div>

                                            </div>

                                            <div class="image">
                                                <?php
                                                if (has_post_thumbnail()) {
                                                    $featured_image = get_the_post_thumbnail(get_the_ID(), 'medium');
                                                    echo $featured_image;
                                                }
                                                ?>
                                            </div>
                                        </div>

                                        <div class="stacked-card__copy--mobile">
                                            <?php echo mb_substr(get_the_excerpt(), 0, 50) . '...'; ?>


                                            <!-- <?php
                                                    if (!empty(get_the_excerpt())) { ?>
                                <p><?php echo mb_substr(get_the_excerpt(), 0, 100) . '...'; ?></p>
                            <?php
                                                    } else { ?>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium, eveniet minus. Expedita dolorum modi cupiditate quasi, assumenda voluptatibus cumque voluptate qui aut fuga sit inventore.
                                </p>

                            <?php } ?> -->
                                        </div>

                                        <div class="date-author">
                                            <div class="author">
                                                <p class="author"> By <span class="red"> <?php echo get_the_author() ?> </span> </p>
                                            </div>
                                            <div class="date">
                                                <?php echo get_the_date() ?>
                                            </div>
                                        </div>


                                    </a>
                                </li>


                            <?php endwhile; ?>
                        </ul>
                    </div>
                <?php endif;
                wp_reset_postdata(); ?>

            </div>
        </div>

        <div class="row">
            <main id="categories-content" class="col-12 col-md-9" role="main">


                <div class="card-stack__two">
                    <?php $args = array(
                        'posts_per_page' => 2,
                        'orderby'        => 'date',
                        'order'          => 'DESC',
                        'offset'         => 5,
                        'tag_id'            => '15118',
                    );
                    $query = new WP_Query($args); ?>

                    <?php if ($query->have_posts()) : ?>
                        <div class="stacked-cards__two">
                            <ul>

                                <?php while ($query->have_posts()) : $query->the_post(); ?>
                                    <li>
                                        <a href="<?php the_permalink() ?>">
                                            <div class="stacked-card">
                                                <div class="image">
                                                    <?php
                                                    if (has_post_thumbnail()) {
                                                        $featured_image = get_the_post_thumbnail(get_the_ID(), 'medium');
                                                        echo $featured_image;
                                                    }
                                                    ?>
                                                </div>
                                                <div class="text">
                                                    <div class="heading">
                                                        <h2> <?php the_title() ?> </h2>
                                                    </div>


                                                    <!-- <p class="excerpt"><?php echo mb_substr(get_the_excerpt(), 0, 100) . '...'; ?></p> -->


                                                    <?php
                                                    if (!empty(get_the_excerpt())) { ?>
                                                        <p class="excerpt"><?php echo mb_substr(get_the_excerpt(), 0, 100) . '...'; ?></p>
                                                    <?php
                                                    } else { ?>

                                                    <?php } ?>


                                                    <div class="date-author">

                                                        <p class="author"> By <span class="red"> <?php echo get_the_author() ?> </span> </p>


                                                        <p class="date">
                                                            <?php echo get_the_date() ?>
                                                        </p>
                                                    </div>

                                                </div>

                                            </div>
                                        </a>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        </div>
                    <?php endif;
                    wp_reset_postdata(); ?>
                </div>

                <!-- <?php get_template_part('template-parts/ads/ad', 'horizontal'); ?> -->

                <a href="https://manage.kmail-lists.com/subscriptions/subscribe?a=Wcb9eg&g=Uy52gg&fbclid=PAQ0xDSwKtPzdleHRuA2FlbQIxMQABpzhU_3O5TNdBkk8q0xAfSABPiPsIyE-7WKS-Neu5SLvNBB_Qu82HOu0dHDTl_aem_fzA8ll7FsdcPMZJW3xJGwA" target="_blank" rel="noopener noreferrer">
                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/img/jetpac-banner-1.webp'; ?>" alt="jetpac logo">
                </a>

                <!-- <?php $page_cat = get_query_var('page_cat', ['id']) ?>
            <?php $cat_id = $page_cat['id']; ?> -->

                <?php
                $category = get_queried_object();
                $cat_id = $category->term_id;
                ?>

            </main>
            <?php get_template_part('template-parts/sidebar/sidebar-categories-jetpac'); ?>


        </div>


    </div>

    <?php get_footer(); ?>