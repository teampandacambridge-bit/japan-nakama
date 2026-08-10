<?php

/**
 * Template Name: Contact Us
 * Template Post Type: page
 *
 * Based on Nakama Default. Centred intro text + the page content (add the
 * contact form to the page in the editor, it renders via the_content()).
 */

?>
<?php get_template_part('template-parts/headers/nakama-head'); ?>


</header>
<div class="container-medium">
    <main id="post-content" class="contact-page" role="main">



        <p class="contact-page__intro">
            <?php
            printf(
                /* translators: %s: email address link */
                esc_html__('For general information, content suggestions, or business inquiries, please email %s.', 'woodmart'),
                '<a href="mailto:info@japannakama.co.uk">info@japannakama.co.uk</a>'
            );
            ?>
        </p>

        <div class="contact-page__content">
            <?php the_content(); ?>
        </div>

    </main>
</div>
<?php get_template_part('template-parts/footers/main-footer'); ?>
</body>

</html>