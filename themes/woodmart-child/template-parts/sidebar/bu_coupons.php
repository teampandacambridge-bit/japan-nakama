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
        echo '<div class="nakama-coupon-card"">';

        if (!empty($coupon['heading'])) {
            echo '<h3 class="coupon_heading">' . esc_html($coupon['heading']) . '</h2>';
        }

        if (!empty($coupon['type'])) {
            echo '<p class="coupon_type">' . esc_html($coupon['type']) . '</p>';
        }

        if (!empty($coupon['description'])) {
            echo '<p class="coupon_desc">' . esc_html($coupon['description']) . '</p>';
        }

        if (!empty($coupon['discount'])) {
            echo '<p class="coupon_discount">' . esc_html($coupon['discount']) . '</p>';
        }

        if (!empty($coupon['code'])) {
            echo '<p class="coupon_code">' . 'Use code : <span>' . esc_html($coupon['code']) . '</span> </p>';
        }

        if (! empty($coupon['cta'])) {
            echo '<a href="' . esc_url($coupon['link']) . '" class="coupon_cta" target="_blank" rel="sponsored nofollow noopener noreferrer">'
                . esc_html($coupon['cta']) .
                '</a>';
        }


?>

<?php echo '</div>'; // .nakama-coupon-card
    }
    echo '</div>'; // .nakama-coupons-grid
}

echo '</div>'; // .sidebar-coupons-wrapper
