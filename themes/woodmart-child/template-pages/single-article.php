<?php

/**
 * Template Name: Split Hero Article
 * Template Post Type: post
 */

?>

<?php
$post_id        = get_queried_object_id();
$author_id      = get_post_field('post_author', $post_id);
$author_name    = get_the_author_meta('display_name', $author_id);
$author_url     = get_author_posts_url($author_id);
$author_bio = get_the_author_meta('description', $author_id);
$author_avatar = get_avatar($author_name, 96);
?>

<?php get_template_part('template-parts/headers/header-post'); ?>

<div id="article" class="container container-medium">

    <?php get_template_part('template-parts/content/post', 'main'); ?>
    <?php get_template_part('template-parts/sidebar/sidebar', 'post'); ?>


</div>

<?php get_template_part('template-parts/footers/main-footer'); ?>


</body>

</html>