<?php get_template_part('template-parts/headers/nakama-head'); ?>
<header id="post-header" <?php woodmart_get_header_classes(); ?>>

    <div class="heading-hero container container-md">
        <div class="row">
            <div class="hero col-12 col-lg-6">
                <div class="image-wrap">
                    <?php

                    $hero_image_id = get_post_thumbnail_id();
                    $hero_image_url = wp_get_attachment_image_url($hero_image_id, 'full');
                    $hero_image_srcset = wp_get_attachment_image_srcset($hero_image_id, 'full');
                    $hero_image_sizes = '(max-width: 900 px) 100vw, 1200px';
                    $alt_text = get_post_meta($hero_image_id, '_wp_attachment_image_alt', true);
                    ?>
                    <!-- lazy load ?-->
                    <img
                        src="<?php echo esc_url($hero_image_url); ?>"
                        srcset="<?php echo esc_attr($hero_image_srcset); ?>"
                        sizes="<?php echo esc_attr($hero_image_sizes); ?>"
                        alt="<?php echo $alt_text ?>"
                        loading="eager"
                        class="no-lazy">
                </div>
            </div>
            <div class="heading col-12 col-lg-6 ">
                <h1>
                    <?php echo get_the_title() ?>
                </h1>

                <p class="sub-copy">
                    <?php echo get_the_excerpt() ?>
                </p>

                <div class="author-tags row">
                    <div class="author-time col-12 col-md-6">
                        <?php
                        $post_id = get_the_ID();
                        $author_id = get_post_field('post_author', $post_id);
                        $author_name = get_the_author_meta('display_name', $author_id);
                        $author_url = get_author_posts_url($author_id);
                        ?>
                        <p class="author" itemprop="author" itemscope itemtype="https://schema.org/Person">
                            Written by:
                            <span>
                                <a href="<?php echo $author_url; ?>" itemprop="url">
                                    <span itemprop="name"><?php echo $author_name; ?></span>
                                </a>
                            </span>
                        </p>

                        <time class="date" datetime="<?php echo get_the_date('c'); ?>">
                            <?php echo get_the_date(); ?>
                        </time>
                    </div>



                    <?php
                    $tags = get_the_tags();
                    if ($tags) {

                        echo '    
                        <div class="header-tags col-12 col-md-6"> 
                        <ul>';

                        $tag_count = 0;
                        foreach ($tags as $tag) {
                            if ($tag_count >= 8) break;

                            echo '<li> <a href="' . get_tag_link($tag->term_id) . '">' . $tag->name . '</a> </li>';
                            $tag_count++;
                        }

                        echo '
                        </ul>      
                        </div>';
                    }
                    ?>




                    <div class="social">
                        <!-- <p>Share</p> -->
                        <div class="
                           <div class=" single-post-social">
                            <?php
                            if (function_exists('woodmart_shortcode_social')) {
                                echo woodmart_shortcode_social(
                                    array(
                                        'type'    => 'share',
                                        'tooltip' => 'no',
                                        'style'   => 'colored',
                                    )
                                );
                            }
                            ?>
                        </div>
                    </div>

                </div>

                <div class="bread-links">
                    <?php custom_breadcrumbs(); ?>
                </div>
            </div>
        </div>
    </div>
</header>