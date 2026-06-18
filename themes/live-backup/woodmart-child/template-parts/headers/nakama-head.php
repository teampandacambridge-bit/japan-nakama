<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>

    <!-- <script type="module">
        import {
            onCLS
        } from 'https://unpkg.com/web-vitals@4/dist/web-vitals.attribution.js';

        onCLS((metric) => {

            const attribution = metric.attribution;

            console.log('CLS:', metric.value);
            console.log('Largest shift target:', attribution?.largestShiftTarget);

            if (!attribution?.largestShiftTarget) return;

            const el = document.querySelector(
                attribution.largestShiftTarget
            );

            if (!el) return;

            // Highlight shifting element
            el.style.outline = '4px solid red';
            el.style.outlineOffset = '4px';
            el.style.transition = 'outline 0.3s ease';

            // Floating debug label
            const badge = document.createElement('div');
            badge.textContent = `CLS Shift`;
            badge.style.position = 'absolute';
            badge.style.zIndex = 999999;
            badge.style.background = 'red';
            badge.style.color = 'white';
            badge.style.fontSize = '12px';
            badge.style.padding = '4px 6px';
            badge.style.fontFamily = 'monospace';

            const rect = el.getBoundingClientRect();
            badge.style.top = window.scrollY + rect.top + 'px';
            badge.style.left = window.scrollX + rect.left + 'px';

            document.body.appendChild(badge);

        }, {
            reportAllChanges: true
        });
    </script> -->

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
            echo '<h1 class="homepage-title">' . esc_html($h1) . '</h1>';
        }
        ?>