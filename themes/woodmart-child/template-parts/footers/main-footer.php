<?php // The events archive has its own newsletter CTA, so hide this pre-footer there. ?>
<?php if (! is_category('events')) : ?>
    <section class="pre-footer">
        <h2>Stay in the Loop</h2>
        <p>Sign up to our newsletter to receive updates </p>

        <div class="c">
            <div class="klaviyo-form-RCvnrW form-input">
            </div>
        </div>
        <p class="terms">
            By subscribing, you agree to our
            <a href="https://www.japannakama.co.uk/privacy-policy/" target="_blank" rel="noopener noreferrer">Privacy Policy</a>
            and
            <a href="https://www.japannakama.co.uk/terms-and-conditions/" target="_blank" rel="noopener noreferrer">Terms of Service</a>
        </p>

    </section>
<?php endif; ?>
<footer class="main-footer">
    <div class="links">
        <div class="">
            <h2><a href="/about-us">About Us</a></h2>
            <p>We are Japan Nakama-your online lifestyle and Japanese culture magazine. Discover our guides for traveling to Japan, read about the Japanese way of life as well as fun facts about Japan!
                Also, don't miss our curated Japanese gift shop, where you can find handpicked items that bring a touch of Japan into your home.</p>
        </div>

        <div class="">
            <h2>Browse by category</h2>

            <ul class="footer-cat-links">
                <?php
                $categories = get_categories(array(
                    'orderby' => 'name',
                    'order'   => 'ASC',
                    'parent'  => 0
                ));

                foreach ($categories as $category) {
                    $category_link = get_category_link($category->term_id);
                    echo '<li><a href="' . esc_url($category_link) . '">' . esc_html($category->name) . '</a></li>';
                }
                ?>
            </ul>

        </div>

        <div class="">
            <h2><a href="/contact-us">Contact Us</a></h2>
            <ul>

                <li>
                    <p> Get in Touch :
                        <a href=""> info@japannakama.com</a>
                    </p>
                </li>
                <li>
                    <a href="https://www.instagram.com/japannakama/" target="_blank" rel="noopener noreferrer">Instagram</a>

                </li>
                <li>
                    <a href="https://www.youtube.com/@japannakama" target="_blank" rel="noopener noreferrer">YouTube</a>
                </li>
                <li>
                    <a href="https://facebook.com/JapanNakama" target="_blank" rel="noopener noreferrer">Facebook</a>
                </li>
                <li>
                    <a href="https://x.com/JapanNakama" target="_blank" rel="noopener noreferrer">X</a>

                </li>



        </div>
        <div class="">
            <h2>Store</h2>
            <ul>
                <li><a href="https://www.japannakama.co.uk/shop/">Browse Store</a></li>
                <li><a href="https://www.japannakama.co.uk/refunds-and-returns/">Refunds & Returns</a></li>
                <li><a href="https://www.japannakama.co.uk/faq/">Store FAQ</a></li>
            </ul>
        </div>
    </div>
    <div class="boiler">
        <p>© 2026 Japan Nakama. All rights reserved.</p>
        <ul>
            <li><a href="https://www.japannakama.co.uk/privacy-policy/">Privacy Policy</a></li>
            <li><a href="https://www.japannakama.co.uk/terms-and-conditions/">Terms of Service</a></li>
        </ul>
    </div>
</footer>
<?php wp_footer(); ?>