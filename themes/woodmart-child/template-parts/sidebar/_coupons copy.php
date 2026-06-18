<?php
$coupons      = get_option('nakama_coupons', []);
$main_heading = get_option('nakama_coupon_heading', '');

echo '<div class="sidebar-coupons-wrapper">';

if ($main_heading) {
    echo '<h2 class="nakama-main-heading">' . esc_html($main_heading) . '</h2>';
}

if (!empty($coupons)) {
    echo '<div class="nakama-coupons-grid">';

    foreach ($coupons as $coupon) {
        echo '<div class="nakama-coupon-card">';



        if (!empty($coupon['heading'])) {
            echo '<h3 class="nakama-coupon-heading">' . esc_html($coupon['heading']) . '</h3>';
        }

        if (!empty($coupon['description'])) {
            echo '<p class="nakama-coupon-description">' . esc_html($coupon['description']) . '</p>';
        }

        if (!empty($coupon['link_text']) && !empty($coupon['link_url'])) {
            echo '<a href="' . esc_url($coupon['link_url']) . '" class="nakama-coupon-link" target="_blank" rel="nofollow">'
                . esc_html($coupon['link_text']) .
                '</a>';
        }

        echo '</div>'; // .nakama-coupon-card
    }
    echo '</div>'; // .nakama-coupons-grid
}

echo '</div>'; // .sidebar-coupons-wrapper
