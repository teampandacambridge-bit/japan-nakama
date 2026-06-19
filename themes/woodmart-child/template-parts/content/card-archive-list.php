<?php $page_cat = get_query_var('page_cat', ['id']) ?>
<?php $cat_id = $page_cat['id']; ?>
<div class="list-container">
    <h2>More From Our <?php echo $page_cat['name'] ?> Archive</h2>
    <!-- <?php echo 'CAT ID' . $cat_id ?> -->
    <div id="card-archive-list">
        <?php
        $paged          = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $posts_per_page = 8;
        $skip           = 6; // Skip the most recent posts (shown above the archive list)

        $args = array(
            'post_type'      => 'post',
            'posts_per_page' => $posts_per_page,
            // Manual offset that folds pagination together with the skipped posts.
            // (WP_Query's `paged` and `offset` cannot be combined reliably.)
            'offset'         => $skip + ($paged - 1) * $posts_per_page,
            'category__in'   => [$cat_id],
            'orderby'        => 'date',
            'order'          => 'DESC',
        );
        $query = new WP_Query($args);

        // Total pages available after skipping the most recent posts.
        $available  = max(0, $query->found_posts - $skip);
        $max_pages  = (int) ceil($available / $posts_per_page);

        wp_localize_script('load-more-posts', 'ajax_object', array(
            'ajax_url'  => admin_url('admin-ajax.php'),
            'max_pages' => $max_pages,
            'page_cat'  => $cat_id,
        ));
        ?>

        <ul>
            <?php if ($query->have_posts()) : ?>
                <?php while ($query->have_posts()) : $query->the_post(); ?>
                    <li>
                        <a href="<?php the_permalink() ?>">
                            <div class="image">
                                <?php
                                if (has_post_thumbnail()) {
                                    $featured_image = get_the_post_thumbnail(get_the_ID(), 'medium');
                                    echo $featured_image;
                                }
                                ?>
                            </div>
                            <div class="text">
                                <h3><?php the_title(); ?></h3>
                                <!-- <?php echo $cat_id ?> -->
                                <div class="date-author">

                                    <p class="author">
                                        By:
                                        <span>
                                            <?php echo get_the_author() ?>
                                        </span>
                                    </p>

                                    <time class="date" datetime="<?php echo get_the_date('c'); ?>">
                                        <?php echo get_the_date(); ?>
                                    </time>
                                </div>
                            </div>
                        </a>

                    </li>
                <?php endwhile; ?>
            <?php endif; ?>
        </ul>
        <div class="pagination-controls">
            <button id="prev-page" disabled>Previous</button>
            <p>Page <span> <?php echo $paged ?> </span> of <span><?php echo $max_pages ?></span></p>
            <button id="next-page">Next</button>
        </div>
    </div>


</div>