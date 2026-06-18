<?php

// Function to register the 'Article' custom post type with template support
function create_article_post_type()
{
    $labels = array(
        'name' => _x('Articles', 'Post type general name', 'textdomain'),
        'singular_name' => _x('Article', 'Post type singular name', 'textdomain'),
        'menu_name' => _x('Articles', 'Admin Menu text', 'textdomain'),
        'name_admin_bar' => _x('Article', 'Add New on Toolbar', 'textdomain'),
        'add_new' => __('Add New Article', 'textdomain'),
        'add_new_item' => __('Add New Article', 'textdomain'),
        'new_item' => __('New Article', 'textdomain'),
        'edit_item' => __('Edit Article', 'textdomain'),
        'view_item' => __('View Article', 'textdomain'),
        'all_items' => __('All Articles', 'textdomain'),
        'search_items' => __('Search Articles', 'textdomain'),
        'not_found' => __('No articles found.', 'textdomain'),
        'not_found_in_trash' => __('No articles found in Trash.', 'textdomain'),
        'featured_image' => _x('Article Featured Image', 'Overrides the "Featured Image" phrase for this post type', 'textdomain'),
        'set_featured_image' => _x('Set featured image', 'Overrides the "Set featured image" phrase', 'textdomain'),
        'remove_featured_image' => _x('Remove featured image', 'Overrides the "Remove featured image" phrase', 'textdomain'),
        'use_featured_image' => _x('Use as featured image', 'Overrides the "Use as featured image" phrase', 'textdomain'),
        'archives' => _x('Article Archives', 'The post type archive label', 'textdomain'),
        'insert_into_item' => _x('Insert into article', 'Overrides the "Insert into post" phrase', 'textdomain'),
        'uploaded_to_this_item' => _x('Uploaded to this article', 'Overrides the "Uploaded to this post" phrase', 'textdomain'),
        'filter_items_list' => _x('Filter articles list', 'Screen reader text for filter controls', 'textdomain'),
        'items_list_navigation' => _x('Articles list navigation', 'Screen reader text for pagination', 'textdomain'),
        'items_list' => _x('Articles list', 'Screen reader text for the articles list', 'textdomain'),
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'article'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'page-attributes'),
        'menu_icon' => 'dashicons-media-document',
    );

    register_post_type('article', $args);
}

add_action('init', 'create_article_post_type');



add_action('init', 'create_article_post_type');



function add_page_attributes_to_posts()
{
    add_post_type_support('post', 'page-attributes');
}
add_action('init', 'add_page_attributes_to_posts');





//Meta Box used to connect post to page for breadlinks

add_action('add_meta_boxes', 'add_post_custom_meta_box');

function add_post_custom_meta_box()
{
    add_meta_box(
        'post_custom_meta_box',     // Meta box ID
        'Post Parent Page',       // Title
        'render_post_custom_meta_box', // Callback
        'post',                      // IMPORTANT: post (not page)
        'side',
        'default'
    );
}
function render_post_custom_meta_box($post)
{

    // Security nonce
    wp_nonce_field('save_post_custom_meta', 'post_custom_meta_nonce');

    // Get saved value
    $custom_value = get_post_meta($post->ID, '_post_custom_value', true);
?>


    <div class="components-panel__body">
        <input
            type="text"
            id="post_custom_value"
            name="post_custom_value"
            value="<?php echo esc_attr($custom_value) ?>"
            class=" widefat" />
    </div>

<?php
}

add_action('save_post', 'save_post_custom_meta_box');

function save_post_custom_meta_box($post_id)
{

    // Verify nonce
    if (
        !isset($_POST['post_custom_meta_nonce']) ||
        !wp_verify_nonce($_POST['post_custom_meta_nonce'], 'save_post_custom_meta')
    ) {
        return;
    }

    // Prevent autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Restrict to POSTS ONLY
    if (get_post_type($post_id) !== 'post') {
        return;
    }

    // Permission check
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save value
    if (isset($_POST['post_custom_value'])) {
        update_post_meta(
            $post_id,
            '_post_custom_value',
            sanitize_text_field($_POST['post_custom_value'])
        );
    }
}
