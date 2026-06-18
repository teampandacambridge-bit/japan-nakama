<?php
$coupons      = get_option('nakama_coupons', []);
$main_heading = get_option('nakama_coupon_heading', '');
?>

<div class="sidebar-coupons-wrapper">

    <?php if ($main_heading) : ?>
        <h2 class="nakama-main-heading">
            <?php echo esc_html($main_heading); ?>
        </h2>
    <?php endif; ?>

    <?php if (!empty($coupons)) : ?>
        <div class="nakama-coupons-grid">

            <?php foreach ($coupons as $coupon) : ?>
                <div class="nakama-coupon-card">

                    <?php if (!empty($coupon['heading'])) : ?>
                        <h3 class="coupon_heading">
                            <?php echo esc_html($coupon['heading']); ?>
                        </h3>
                    <?php endif; ?>

                    <?php if (!empty($coupon['type'])) : ?>
                        <p class="coupon_type">
                            <?php echo esc_html($coupon['type']); ?>
                        </p>
                    <?php endif; ?>

                    <?php if (!empty($coupon['description'])) : ?>
                        <p class="coupon_desc">
                            <?php echo esc_html($coupon['description']); ?>
                        </p>
                    <?php endif; ?>

                    <?php if (!empty($coupon['discount'])) : ?>
                        <p class="coupon_discount">
                            <?php echo esc_html($coupon['discount']); ?>
                        </p>
                    <?php endif; ?>

                    <?php if (!empty($coupon['code'])) : ?>
                        <p class="coupon_code">
                            Use code:
                            <span><?php echo esc_html($coupon['code']); ?></span>
                        </p>
                    <?php endif; ?>

                    <?php if (!empty($coupon['cta']) && !empty($coupon['link'])) : ?>
                        <a
                            href="<?php echo esc_url($coupon['link']); ?>"
                            class="coupon_cta"
                            target="_blank"
                            rel="sponsored nofollow noopener noreferrer">
                            <?php echo esc_html($coupon['cta']); ?>
                        </a>
                    <?php endif; ?>

                </div>
            <?php endforeach; ?>

        </div>
    <?php endif; ?>

</div>