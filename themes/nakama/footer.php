<?php

/**
 * The template for displaying the footer
 */
?>

<footer class="site-footer">
    <div class="container">

        <div class="footer-top">
            <div class="footer-col">
                <h3><?php bloginfo('name'); ?></h3>
                <p>&copy; <?php echo date('Y'); ?> All rights reserved.</p>
            </div>

            <div class="footer-col">
                <h4>Navigation</h4>
                <?php
                wp_nav_menu([
                    'theme_location' => 'footer',
                    'menu_class' => 'footer-menu',
                    'container' => false,
                ]);
                ?>
            </div>

            <div class="footer-col">
                <h4>Contact</h4>
                <p>Email: info@example.com</p>
            </div>
        </div>

    </div>
</footer>

<?php wp_footer(); ?>
</body>

</html>