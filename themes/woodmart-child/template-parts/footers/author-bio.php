<section id="author-bio-footer">

    <?php
    /**
     * The template for displaying Author bios
     */

    if (! woodmart_get_opt('blog_author_bio')) return;
    ?>
    <div class="author-bio">
        <div class="author-img">
            <?php
            $author_bio_avatar_size = apply_filters('woodmart_author_bio_avatar_size', 74);
            echo get_avatar(get_the_author_meta('user_email'), $author_bio_avatar_size, '', 'author-avatar');
            ?>
        </div><!-- .author-avatar -->
        <div class="author-desc">
            <h4 class=""><?php printf(esc_html__('About %s', 'woodmart'), get_the_author()); ?></h4>
            <p class="">
                <?php the_author_meta('description'); ?>
            </p>
        </div><!-- .author-description -->
    </div><!-- .author-info -->
</section>