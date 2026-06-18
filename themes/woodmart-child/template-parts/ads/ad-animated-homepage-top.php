<?php
$ad_destination = 'https://example.com'; // Update this URL at any time
?>
<section class="ad-animated-hompage-top" data-theme-uri="<?php echo esc_url(get_stylesheet_directory_uri()); ?>">
    <a class="ad-link" href="<?php echo esc_url($ad_destination); ?>" target="_blank" rel="noopener sponsored">
        <img class="ad-img ad-img--sm" src="" alt="Advertisement" />
        <img class="ad-img ad-img--md" src="" alt="Advertisement" />
        <img class="ad-img ad-img--lg" src="" alt="Advertisement" />
    </a>
</section>