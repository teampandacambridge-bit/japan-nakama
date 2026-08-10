<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <?php if (wp_get_environment_type() === 'production') : ?>
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
    <?php endif; ?>


    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>


</head>

<body <?php body_class(); ?>>

    <?php if (wp_get_environment_type() === 'production') : ?>
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KPJK8T"
                height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
    <?php endif; ?>

    <header id="page-header">
        <?php get_template_part('template-parts/navs/primary-nav'); ?>
        <?php
        // The events archive renders its own <h1> in #page-title, so skip the
        // generic header title there to avoid a duplicate heading.
        if (!is_singular('post') && !is_category('events')) {
            $h1 = is_category() ? single_cat_title('', false) : get_the_title();
            echo '<h1 class="homepage-title">' . esc_html($h1) . '</h1>';
        }
        ?>