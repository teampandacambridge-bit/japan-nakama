<?php
$hero_image_id     = get_post_thumbnail_id();
$hero_image_url    = wp_get_attachment_image_url($hero_image_id, 'full');
$hero_image_srcset = wp_get_attachment_image_srcset($hero_image_id, 'full');
$hero_image_sizes  = '(max-width: 900px) 100vw, 1200px';
$alt_text          = get_post_meta($hero_image_id, '_wp_attachment_image_alt', true);
$heading_1 = 'your complete gudide to';
$heading_2 = 'Kyoto';
?>



<body <?php body_class(); ?>>
    <?php get_template_part('template-parts/navs/primary-nav'); ?>
    <header id="page-header" class="container container-md">

        <!-- <p class="location-title">Travel Guides</p> -->

        <img
            src="<?php echo esc_url($hero_image_url); ?>"
            srcset="<?php echo esc_attr($hero_image_srcset); ?>"
            sizes="<?php echo esc_attr($hero_image_sizes); ?>"
            alt="<?php echo esc_attr($alt_text); ?>"
            loading="eager"
            class="no-lazy">
        <h1>
            <?php echo esc_html($heading_1); ?>
            <?php echo !empty($heading_2) ? '<span>' . esc_html($heading_2) . '</span>' : ''; ?>
        </h1>

        <p class="header-lead">Kyoto, Japan’s ancient capital, is a city where centuries-old temples, tranquil gardens, and vibrant cultural traditions blend seamlessly with modern life. From the golden brilliance of Kinkaku-ji and the iconic torii-lined paths of Fushimi Inari Shrine to the quiet charm of hidden teahouses and historic wooden streets, Kyoto offers an experience unlike anywhere else. </br>

            Whether you’re seeking spiritual serenity, seasonal scenery, or a deeper understanding of Japanese culture, Kyoto invites you to slow down, explore mindfully, and discover its many layers. Wander through geisha districts, savor exquisite local cuisine, and feel the presence of history in every stone and sakura petal.
            </br>

            Start your journey here—and let Kyoto’s elegance and enduring spirit inspire your adventure.</p>

        <time datetime="<?php echo get_the_modified_time('c'); ?>">
            last updated: <?php echo get_the_modified_time('jS F Y'); ?>
        </time>

    </header>