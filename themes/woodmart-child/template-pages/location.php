<?php

/**
 * Template Name: LLG
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
    <?php get_template_part('template-parts/navs/primary-nav'); ?>

    <div class="inner-grid">

        <?php get_template_part('template-parts/sidebar/table-of-content'); ?>

        <main class="main-content dev-border">
            <?php echo the_content() ?>

        </main>
        <aside class="sidebar-two dev-border">
            <?php get_template_part('template-parts/ads/ad-sidebar-top'); ?>
            <div class="sidebar-link-large">
                <h3>Unlock Your Japan Adventure</h3>
                <p>Travel tips, hidden gems & fresh inspiration</p>
                <a href="/travel">Read More</a>
            </div>
            <div class="fixed-container">
                <div class="fixed-target">
                    <?php get_template_part('template-parts/ads/ad-sidebar-bottom'); ?>
                </div>
            </div>

        </aside>

    </div>

    <?php get_template_part('template-parts/footers/main-footer'); ?>

</body

    </html>