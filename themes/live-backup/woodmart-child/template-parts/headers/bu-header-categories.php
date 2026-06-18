<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-KPJK8T');</script>
<!-- End Google Tag Manager -->
	
    <meta charset="<?php bloginfo('charset'); ?>">
    <?php wp_head(); ?>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8891471400782288"
        crossorigin="anonymous">
    </script>
	

    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Afacad+Flux:wght@100..1000&family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">

</head>

<body <?php body_class(); ?>>
	<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KPJK8T"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
    <?php if (function_exists('wp_body_open')) : ?>
        <?php wp_body_open(); ?>
    <?php endif; ?>
    <?php do_action('woodmart_after_body_open'); ?>

    <header id="post-header" <?php woodmart_get_header_classes(); ?>>
        <div id="post-nav">
            <?php whb_generate_header(); ?>
        </div>
    </header>
    <div class="container-md border-bt--grey">
        <div class="row">
            <div class="col-12">

                <h1 class="heading"><?php echo $page_cat['name'] ?></h1>
            </div>
        </div>
    </div>