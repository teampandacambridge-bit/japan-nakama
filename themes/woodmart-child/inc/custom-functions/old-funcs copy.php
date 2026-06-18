<?php
// function enqueue_google_fonts()
// {
//     // Preconnect to Google Fonts to improve loading performance
//     add_action('wp_head', function () {
//         echo '<link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>';
//         echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
//         echo '<link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Afacad+Flux:wght@100..1000&family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap">';
//     }, 1);

//     // Enqueue Google Fonts CSS asynchronously
//     wp_enqueue_style(
//         'google-fonts',
//         'https://fonts.googleapis.com/css2?family=Afacad+Flux:wght@100..1000&family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap',
//         [],
//         null
//     );

//     // Modify the style tag to load Google Fonts asynchronously
//     add_filter('style_loader_tag', function ($html, $handle) {
//         if ('google-fonts' === $handle) {
//             return str_replace("rel='stylesheet'", "rel='stylesheet' media='print' onload=\"this.onload=null;this.removeAttribute('media');\"", $html);
//         }
//         return $html;
//     }, 10, 2);
// }
// add_action('wp_enqueue_scripts', 'enqueue_google_fonts');


function preload_hero_image()
{
    if (is_singular()) { // Ensure it's a single post or page
        $hero_image_id = get_post_thumbnail_id();
        $hero_image_url = wp_get_attachment_image_url($hero_image_id, 'full');

        if ($hero_image_url) {
            echo '<link rel="preload" fetchpriority="high" as="image" href="' . esc_url($hero_image_url) . '" type="image/' . pathinfo($hero_image_url, PATHINFO_EXTENSION) . '">' . "\n";
        }
    }
}
add_action('wp_head', 'preload_hero_image', 5);




function enqueue_ajax_script()
{
    wp_enqueue_script('load-more-posts', get_template_directory_uri() . '/../woodmart-child/assets/js/load-more-posts.js', array('jquery'), '2.0', true);
    wp_localize_script('load-more-posts', 'ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'next_page' => get_next_posts_link()
    ));
}

add_action('wp_enqueue_scripts', 'enqueue_ajax_script');


//   <link rel="stylesheet" href="">



add_filter('use_widgets_block_editor', '__return_false');

add_action('admin_init', function () {

    global $pagenow;
    $user = wp_get_current_user();

    # Check current admin page.
    if ($pagenow == 'index.php' && in_array('dc_vendor', $user->roles)) {

        wp_redirect(admin_url('/dashboard'));
        exit;
    }
});


/**

// removes weekly order stats report from WCMp - Zia added this on 03.08.2021
add_action('init','remove_weekly_order_stats');
function remove_weekly_order_stats(){
    global $WCMp;
    remove_action('vendor_weekly_order_stats', array( $WCMp->cron_job, 'vendor_weekly_order_stats_report' ) ); // remove weekly report
    add_filter('wcmp_send_vendor_monthly_zero_order_stats_report', '__return_false' ); //send monthly report when vendor sell minimum 1 item in a month.
}

 */


/**
 * Remove product data tabs
 */
add_filter('woocommerce_product_tabs', 'woo_remove_product_tabs', 99);

function woo_remove_product_tabs($tabs)
{

    unset($tabs['wcmp_customer_qna']);
    unset($tabs['additional_information']);
    return $tabs;
}


/**
 * Rename product data tabs
 */
add_filter('woocommerce_product_tabs', 'woo_rename_tabs', 98);
function woo_rename_tabs($tabs)
{

    // $tabs['vendor']['title'] = __( '' );		// Rename the description tab
    $tabs['policies']['title'] = __('Shipping Times & Returns');        // Rename the policies tab
    $tabs['vendor']['title'] = __('Brand');    // Rename the vendor tab

    return $tabs;
}



add_filter('wcmp_sold_by_text', 'filter_wcmp_sold_by_text');
function filter_wcmp_sold_by_text()
{
    $sold_by_text = 'Brand: ';
    return $sold_by_text;
}


/**
 * Add the custom tab
 */

add_filter('woocommerce_product_tabs', 'woo_edit_tabs');
function woo_edit_tabs($tabs)
{

    // Adds the new tab

    $tabs['enquiry_form'] = array(
        'title'     => __('Ask a question', 'woocommerce'),
        'priority'     => 50,
        'callback'     => 'woo_enquiry_form'
    );

    return $tabs;
}
function woo_enquiry_form()
{
    echo '<h2>' . __('Do you have a question?', 'woocommerce') . '</h2>';
    echo '<p>' . __('Drop us an email with your product query at <a href="mailto:info@japannakama.co.uk">info@japannakama.co.uk</a>', 'woocommerce') . '</p>';
}

add_filter('gettext', 'translate_text');
add_filter('ngettext', 'translate_text');
function translate_text($translated)
{
    $translated = str_ireplace('basket', 'cart', $translated);
    return $translated;
}


add_filter('wcmp_vendor_store_header_hide_store_email', '__return_true');



// add mailchimp pop up to header
function ns_mailchimp_popup()
{ ?>
    <script id="mcjs">
        ! function(c, h, i, m, p) {
            m = c.createElement(h), p = c.getElementsByTagName(h)[0], m.async = 1, m.src = i, p.parentNode.insertBefore(m, p)
        }(document, "script", "https://chimpstatic.com/mcjs-connected/js/users/7ea4cbd55e449718588be1e2a/25fd3ee0409696339589c7f56.js");
    </script>
<?php
}

add_action('wp_head', 'ns_mailchimp_popup', 10);

// add_filter('woocommerce_get_breadcrumb', 'wcmp_vendor_shop_page_breadcrumbs', 9999, 2);
// function wcmp_vendor_shop_page_breadcrumbs($crumbs, $breadcrumb)
// {
//     global $WCMp;
//     if (is_tax($WCMp->taxonomy->taxonomy_name)) {
//         $index = count($crumbs) - 2;
//         $crumbs[$index][0] = 'brands';
//     }
//     return $crumbs;
// }

function lw_woocommerce_gpf_description($description, $product_id)
{
    return get_post_meta($product_id, '_yoast_wpseo_metadesc', true);
}
add_filter('woocommerce_gpf_description', 'lw_woocommerce_gpf_description', 10, 3);

/*The code below checks if the commission is unpaid and then pays 10 commissions. Normally it is set to 5 and I wasn't sure about the status - Zia 25.06.2022

add_action('init', 'wcmp_vendor_commission_masspay');
function wcmp_vendor_commission_masspay(){
  global $WCMp;
  remove_action('masspay_cron_start', array($WCMp->cron_job, 'do_mass_payment'));
  add_action('masspay_cron_start',  'do_mass_payment');
}

function do_mass_payment() {
    global $WCMp;
    $payment_admin_settings = get_option('wcmp_payment_settings_name');
    if (!isset($payment_admin_settings['wcmp_disbursal_mode_admin'])) {
      return;
    }
    $commission_to_pay = array();
    $commissions = get_query_commission();
    if ($commissions && is_array($commissions)) {
        foreach ($commissions as $commission) {
            $commission_id = $commission->ID;
            $vendor_term_id = get_post_meta($commission_id, '_commission_vendor', true);
            $order_id = get_post_meta( $commission_id ,'_commission_order_id', true );
            $order = wc_get_order( $order_id );
            if( is_a( $order, 'WC_Order' ) && !in_array( $order->get_status(), apply_filters( 'wcmp_cron_mass_payment_exclude_order_statuses',array( 'failed', 'cancelled' ) ) ) ) {
                $commission_to_pay[$vendor_term_id][] = $commission_id;
            }
        }
    }
    foreach ($commission_to_pay as $vendor_term_id => $commissions) {
        $vendor = get_wcmp_vendor_by_term($vendor_term_id);
        if ($vendor) {
            $payment_method = get_user_meta($vendor->id, '_vendor_payment_mode', true);
            if ($payment_method && $payment_method != 'direct_bank') {
                if (array_key_exists($payment_method, $WCMp->payment_gateway->payment_gateways)) {
                  $WCMp->payment_gateway->payment_gateways[$payment_method]->process_payment($vendor, $commissions);
                }
            }
        }
    }
}

function get_query_commission() {
    $args = array(
        'post_type' => 'dc_commission',
        'post_status' => array('publish', 'private'),
        'meta_key' => '_paid_status',
        'meta_value' => 'unpaid',
        'posts_per_page' => 10 // change as per your requirement.
    );
    $commissions = get_posts($args);
    return $commissions;
}
*/


// add_filter('woocommerce_attribute_show_in_nav_menus', 'wc_reg_for_menus', 1, 2);
// function wc_reg_for_menus($register, $name = '')
// {
//     if ($name == 'pa_brands') $register = true;
//     return $register;
// }



function aaa_custom_function()
{
?>
    <meta name="google-site-verification" content="Yb5EpaXawjH5rEGNUso9r1-F9NOZ2Clm9we7Ujez8gg" />
    <?php
}


/* Klaviyo form code snippet 
add_action('wp_footer', 'klaviyo_formcode'); 
function klaviyo_formcode() { ?> 
<script async type="text/javascript" src="https://static.klaviyo.com/onsite/js/klaviyo.js?company_id=Wcb9eg"></script>
<?php }

*/
add_action('mvx_vendor_commission_paid', 'prevent_duplicate_payments');

function prevent_duplicate_payments($order_id)
{
    // retrieve the vendor's commission amount
    $commission = get_user_option('mvx_vendor_commission', get_current_user_id());
    if ($commission > 0) {
        // retrieve the vendor's paid status
        $paid = get_user_option('mvx_vendor_commission_paid', get_current_user_id());
        if ($paid) {
            // the commission has already been paid, so stop the payment process
            wp_die('This commission has already been paid.');
        } else {
            // the commission has not been paid, so update the paid status
            update_user_option(get_current_user_id(), 'mvx_vendor_commission_paid', true);
        }
    }
}
add_filter('perfmatters_delay_js_timeout', function ($timeout) {
    return '3';
});

// Automatically Delete Woocommerce Images After Deleting a Product
add_action('before_delete_post', 'delete_product_images', 10, 1);

function delete_product_images($post_id)
{
    $product = wc_get_product($post_id);

    if (!$product) {
        return;
    }

    $featured_image_id = $product->get_image_id();
    $image_galleries_id = $product->get_gallery_image_ids();

    if (!empty($featured_image_id)) {
        wp_delete_post($featured_image_id);
    }

    if (!empty($image_galleries_id)) {
        foreach ($image_galleries_id as $single_image_id) {
            wp_delete_post($single_image_id);
        }
    }
}

//Custom code written by Zia on 02.03.2022 to hide the vendor dashboard top-menu for all user roles and users that are not logged in except for vendor
//we originally used a plugin called nav menu roles but it was conflicting with other plugins that could not be disabled

add_action('wp_head', function () {
    $user = wp_get_current_user();
    if (! is_user_logged_in()) {
    ?>
        <style>
            .wd-header-nav.wd-header-secondary-nav.text-right.wd-full-height {
                display: none;
            }
        </style>
    <?php
    } elseif (! in_array('dc_vendor', (array) $user->roles)) {
    ?>
        <style>
            .wd-header-nav.wd-header-secondary-nav.text-right.wd-full-height {
                display: none;
            }
        </style>
    <?php
    }
});

function sv_remove_product_page_skus($enabled)
{
    if (! is_admin() && is_product()) {
        return false;
    }

    return $enabled;
}
add_filter('wc_product_sku_enabled', 'sv_remove_product_page_skus');

//disable SKU functionality
// add_filter( 'wc_product_sku_enabled', '__return_false' );

// hides vendor brand name
add_filter('comment_flood_filter', '__return_false');





function lw_woocommerce_gpf_feed_item_google($feed_item, $product)
{
    $current_currency = get_woocommerce_currency();

    // Append &currency=GBP to the purchase link if the currency is GBP
    if ($current_currency == 'GBP') {
        // Check if URL already has a query string
        if (strpos($feed_item->purchase_link, '?') !== false) {
            $feed_item->purchase_link .= '&currency=GBP';
        } else {
            $feed_item->purchase_link .= '?currency=GBP';
        }
    }

    // Append _usa to the guid and possibly item_group_id if the currency is USD
    /*  if ($current_currency == 'USD') {
        $feed_item->guid .= '_usa';

        // Check and adjust the item_group_id if it's a variable product
        if ($product->is_type('variable')) {
            $feed_item->item_group_id .= '_usa';
        }
    }*/

    return $feed_item;
}
add_filter('woocommerce_gpf_feed_item_google', 'lw_woocommerce_gpf_feed_item_google', 11, 2);



// restrict dubmail which is the stupid failed orders hacker
// 
function restrict_email_domains_at_checkout()
{
    if (isset($_POST['billing_email'])) {
        // List of restricted domains
        $restricted_domains = array('restricteddomain.com', 'dubumail.uk');

        // Extract the domain from the email
        $email_parts = explode('@', $_POST['billing_email']);
        if (count($email_parts) > 1) {
            $domain = end($email_parts);

            // Check if the domain is in the list of restricted domains
            if (in_array($domain, $restricted_domains)) {
                wc_add_notice(__('Sorry, email addresses from this domain are not allowed.', 'woocommerce'), 'error');
            }
        }
    }
}
add_action('woocommerce_checkout_process', 'restrict_email_domains_at_checkout');


//add email column to woo

function add_email_address_column($columns)
{
    $new_columns = (is_array($columns)) ? $columns : array();
    $new_columns['billing_email'] = 'Billing Email';  // Set 'Billing Email' as the column title

    return $new_columns;
}
add_filter('manage_edit-shop_order_columns', 'add_email_address_column');

function show_email_address_column_data($column)
{
    global $post;

    if ('billing_email' === $column) {
        $order = wc_get_order($post->ID);
        echo $order->get_billing_email();
    }
}
add_action('manage_shop_order_posts_custom_column', 'show_email_address_column_data');

//restricts sub orders via the API - created on 11.04.2024
add_filter('woocommerce_rest_prepare_shop_order_object', 'filter_out_child_orders', 10, 3);

function filter_out_child_orders($response, $order, $request)
{
    // Check if the order is a child order. In WooCommerce, child orders have a non-zero parent_id.
    if ($order->get_parent_id() != 0) {
        // If it's a child order, we return an error or an empty response.
        return new WP_Error('rest_forbidden', esc_html__('Child orders are not accessible.', 'my-text-domain'), array('status' => 403));
    }

    // For parent orders, return the normal response.
    return $response;
}

/**
 * wc_shipment_tracking_add_custom_provider
 *
 * adding custom providers to deal with the issue with printful tracking not working correctly. The one I needed to add was "Royalmail Tracked Signature", the others are just encase. We will need to add others as we start shipping and they don't work. 
 * 


add_filter( 'wc_shipment_tracking_get_providers' , 'wc_shipment_tracking_add_custom_provider' );

function wc_shipment_tracking_add_custom_provider( $providers ) {
	
	$providers['United Kingdom']['Royalmail'] = 'https://www.royalmail.com/track-your-item/?trackNumber=%1$s'; 
    $providers['United Kingdom']['Royalmail signature'] = 'https://www.royalmail.com/track-your-item/?trackNumber=%1$s';
    $providers['United Kingdom']['Royal mail signature'] = 'https://www.royalmail.com/track-your-item/?trackNumber=%1$s';
    $providers['United Kingdom']['Royalmail 48'] = 'https://www.royalmail.com/track-your-item/?trackNumber=%1$s';
    $providers['United Kingdom']['Royalmail 24'] = 'https://www.royalmail.com/track-your-item/?trackNumber=%1$s';
    $providers['United Kingdom']['Royalmail Tracked Signature'] = 'https://www.royalmail.com/track-your-item/?trackNumber=%1$s'; //this is the current one coming from printful for UK
    $providers['United Kingdom']['Royalmail Tracked'] = 'https://www.royalmail.com/track-your-item/?trackNumber=%1$s';
    $providers['United Kingdom']['Royal mail Tracked'] = 'https://www.royalmail.com/track-your-item/?trackNumber=%1$s';
    $providers['United Kingdom']['Royal mail Tracked Signature'] = 'https://www.royalmail.com/track-your-item/?trackNumber=%1$s';
	return $providers;
}



 */



function my_register_ad_settings()
{
    // Register the settings so WordPress can store them
    register_setting('general', 'my_ad_image_url', ['type' => 'string', 'sanitize_callback' => 'esc_url']);
    register_setting('general', 'my_ad_link_url', ['type' => 'string', 'sanitize_callback' => 'esc_url']);

    // Add settings fields to General Settings page
    add_settings_field(
        'my_ad_image_url',
        'Ad Image URL',
        'my_ad_image_url_callback',
        'general'
    );

    add_settings_field(
        'my_ad_link_url',
        'Ad Link URL',
        'my_ad_link_url_callback',
        'general'
    );
}
add_action('admin_init', 'my_register_ad_settings');

// Field input: Ad Image URL
function my_ad_image_url_callback()
{
    $value = esc_url(get_option('my_ad_image_url', ''));
    echo '<input type="url" id="my_ad_image_url" name="my_ad_image_url" value="' . $value . '" class="regular-text">';
    echo '<p class="description">Enter the full URL of the ad image.</p>';
}

// Field input: Ad Link URL
function my_ad_link_url_callback()
{
    $value = esc_url(get_option('my_ad_link_url', ''));
    echo '<input type="url" id="my_ad_link_url" name="my_ad_link_url" value="' . $value . '" class="regular-text">';
    echo '<p class="description">Enter the URL the ad should link to.</p>';
}



function add_custom_code_before_h2_headers($content)
{
    if (is_singular() && false !== strpos($content, '<h2')) {
        $ad_image = get_option('my_ad_image_url');
        $ad_link = get_option('my_ad_link_url');

        if ($ad_image && $ad_link) {
            $ad_code = '<div class="custom-ad" style="text-align:center; margin:20px 0;">
                            <a href="' . esc_url($ad_link) . '" target="_blank" rel="noopener noreferrer">
                                <img src="' . esc_url($ad_image) . '" alt="Ad" style="max-width:100%; height:auto;">
                            </a>
                        </div>';
        } else {
            $ad_code = '';
        }

        $ad_code_with_spacing = $ad_code . '<div style="height:40px;"></div>';

        $pattern = '/(<h2.*?>)/i';
        $counter = 0;

        $content = preg_replace_callback($pattern, function ($matches) use (&$counter, $ad_code_with_spacing) {
            $counter++;
            return ($counter % 3 === 0)
                ? $ad_code_with_spacing . $matches[0]
                : $matches[0];
        }, $content);
    }

    return $content;
}
add_filter('the_content', 'add_custom_code_before_h2_headers');

function add_ad_below_post_title($content)
{
    if (is_single()) {
        $ad_image = get_option('my_ad_image_url');
        $ad_link = get_option('my_ad_link_url');

        if ($ad_image && $ad_link) {
            $ad_html = '<div class="custom-ad" style="text-align:center; margin:20px 0;">
                            <a href="' . esc_url($ad_link) . '" target="_blank" rel="noopener noreferrer">
                                <img src="' . esc_url($ad_image) . '" alt="Ad" style="max-width:100%; height:auto;">
                            </a>
                        </div>';
            $content = $ad_html . $content;
        }
    }

    return $content;
}
add_filter('the_content', 'add_ad_below_post_title');


// add_filter('the_content', 'add_ad_below_post_title');

// function custom_content_before_category_description() {
//     if (is_category()) {
//         // Output the shortcode and add space below
//         echo do_shortcode('[adsanity_group align="aligncenter" num_ads=1 num_columns=1 group_ids=13189]');
//     }
// }
// add_action('woodmart_main_loop', 'custom_content_before_category_description', 9);

// function custom_content_before_tag_description() {
//     if (is_tag()) {
//         // Output the shortcode and add space below
//          echo do_shortcode('[adsanity_group align="aligncenter" num_ads=1 num_columns=1 group_ids=13189]');
//     }
// }
// add_action('woodmart_main_loop', 'custom_content_before_tag_description', 9);

// ************************************ ADD ARTICLE CPT ************************************

// Function to register the 'Article' custom post type with template support
function create_article_post_type()
{
    $labels = array(
        'name'                  => _x('Articles', 'Post type general name', 'textdomain'),
        'singular_name'         => _x('Article', 'Post type singular name', 'textdomain'),
        'menu_name'             => _x('Articles', 'Admin Menu text', 'textdomain'),
        'name_admin_bar'        => _x('Article', 'Add New on Toolbar', 'textdomain'),
        'add_new'               => __('Add New Article', 'textdomain'),
        'add_new_item'          => __('Add New Article', 'textdomain'),
        'new_item'              => __('New Article', 'textdomain'),
        'edit_item'             => __('Edit Article', 'textdomain'),
        'view_item'             => __('View Article', 'textdomain'),
        'all_items'             => __('All Articles', 'textdomain'),
        'search_items'          => __('Search Articles', 'textdomain'),
        'not_found'             => __('No articles found.', 'textdomain'),
        'not_found_in_trash'    => __('No articles found in Trash.', 'textdomain'),
        'featured_image'        => _x('Article Featured Image', 'Overrides the "Featured Image" phrase for this post type', 'textdomain'),
        'set_featured_image'    => _x('Set featured image', 'Overrides the "Set featured image" phrase', 'textdomain'),
        'remove_featured_image' => _x('Remove featured image', 'Overrides the "Remove featured image" phrase', 'textdomain'),
        'use_featured_image'    => _x('Use as featured image', 'Overrides the "Use as featured image" phrase', 'textdomain'),
        'archives'              => _x('Article Archives', 'The post type archive label', 'textdomain'),
        'insert_into_item'      => _x('Insert into article', 'Overrides the "Insert into post" phrase', 'textdomain'),
        'uploaded_to_this_item' => _x('Uploaded to this article', 'Overrides the "Uploaded to this post" phrase', 'textdomain'),
        'filter_items_list'     => _x('Filter articles list', 'Screen reader text for filter controls', 'textdomain'),
        'items_list_navigation' => _x('Articles list navigation', 'Screen reader text for pagination', 'textdomain'),
        'items_list'            => _x('Articles list', 'Screen reader text for the articles list', 'textdomain'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'article'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'page-attributes'),
        'menu_icon'          => 'dashicons-media-document',
    );

    register_post_type('article', $args);
}

add_action('init', 'create_article_post_type');


// Hooking up the custom post type into WordPress
add_action('init', 'create_article_post_type');

function add_page_attributes_to_posts()
{
    add_post_type_support('post', 'page-attributes');
}
add_action('init', 'add_page_attributes_to_posts');

// ************************************ ADD CATS TO PAGES ************************************

//Add Category Support for pages
function add_categories_to_pages()
{
    register_taxonomy_for_object_type('category', 'page');
}
add_action('init', 'add_categories_to_pages');

//Add Category Meta Box To Page Admin
function add_category_meta_box_to_pages()
{
    add_meta_box(
        'categorydiv', // Meta box ID
        'Categories',  // Meta box title
        'post_categories_meta_box', // Meta box callback
        'page', // Post type
        'side', // Context
        'default' // Priority
    );
}
add_action('add_meta_boxes', 'add_category_meta_box_to_pages');

// ************************************ RETURN POST CATEGORY INFROMATION ************************************


function get_post_categories_data($post_id = null)
{
    $post_id = $post_id ?: get_the_ID(); // Use current post ID if none is provided
    $categories = get_the_category($post_id);

    if (empty($categories)) {
        return [];
    }

    $category_data = [];
    foreach ($categories as $category) {
        $category_data[] = [
            'id'    => $category->term_id,
            'name'  => $category->cat_name,
            'slug'  => $category->slug,
            'url'   => get_category_link($category->term_id),
        ];
    }

    return $category_data;
}


// ************************************ RESTRICT CHARACTERS IN USERNAMES & EMAIL ************************************

// function restrict_usernames($username, $raw_username, $strict)
// {
//     // Restrict usernames containing special characters
//     if (preg_match('/[^a-zA-Z0-9_]/', $username)) {
//         return new WP_Error('invalid_username', __('Usernames can only contain letters, numbers, and underscores.'));
//     }

//     // Restrict specific usernames
//     $restricted_usernames = ['admin', 'test', 'demo'];
//     if (in_array(strtolower($username), $restricted_usernames)) {
//         return new WP_Error('invalid_username', __('This username is not allowed.'));
//     }

//     return $username;
// }
// add_filter('validate_username', 'restrict_usernames', 10, 3);

// function restrict_email_domains($errors, $sanitized_user_login, $user_email)
// {
//     // List of blocked email domains
//     $blocked_domains = ['dubumail.uk', 'test.com'];

//     $domain = substr(strrchr($user_email, '@'), 1);
//     if (in_array($domain, $blocked_domains)) {
//         $errors->add('invalid_email', __('Email addresses from this domain are not allowed.'));
//     }

//     return $errors;
// }
// add_filter('registration_errors', 'restrict_email_domains', 10, 3);

// if (preg_match('/[^a-zA-Z0-9@._-]/', $user_email)) {
//     $errors->add('invalid_email', __('Email addresses cannot contain special characters.'));
// }

// ************************************ AJAX TO LOAD MORE POSTS ON CAT LANDING PAGE ************************************

function load_more_posts()
{

    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $page_cat = isset($_POST['page_cat']) ? intval($_POST['page_cat']) : 1;


    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 8,
        'paged' => $paged,
        'category__in' =>
        $page_cat,
        'orderby' => 'title',
        'order'   => 'DESC',
        // 'offset'         => 7,
    );

    $query = new WP_Query($args); ?>
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
                            <!-- <?php echo $page_cat; ?> -->

                            <div class="date-author">
                                <p class="author"> By <span class="red"> <?php echo get_the_author() ?> </span> </p>
                                <p class="date"><?php echo get_the_date() ?> </p>
                            </div>
                        </div>
                    </a>
                </li>
            <?php endwhile; ?>
        <?php endif; ?>
    </ul>
    <div class="pagination-controls">
        <button id="prev-page" disabled>Previous</button>
        <p>Page <span> <?php echo $paged ?> </span> of <span><?php echo $query->max_num_pages ?></span></p>
        <button id="next-page">Next</button>
    </div>
<?php
    wp_reset_postdata();
    wp_die();
}

add_action('wp_ajax_load_more_posts', 'load_more_posts');
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts');

add_action('wp_ajax_load_more_posts', 'load_more_posts');
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts');

// ************************************ Block Email Form WC ************************************

add_action('woocommerce_after_checkout_validation', 'block_email_addresses_from_checkout', 10, 2);

function block_email_addresses_from_checkout($fields, $errors)
{
    // List of blocked email addresses or domains
    $blocked_emails = array(

        '@storebotmail.joonix.net'
    );

    $email = isset($fields['billing_email']) ? $fields['billing_email'] : '';

    foreach ($blocked_emails as $blocked_email) {
        // Check if the email matches the blocked list
        if (strpos($email, $blocked_email) !== false) {
            $errors->add('validation', __('Sorry, this email address is not allowed to place orders.', 'woocommerce'));
            break;
        }
    }
}



// add_filter('wp_sitemaps_enabled', '__return_false');

add_filter('wp_sitemaps_taxonomies', function ($taxonomies) {
    // Exclude the 'dc_vendor_shop' taxonomy from the sitemap
    unset($taxonomies['dc_vendor_shop']);
    return $taxonomies;
});


add_filter('wp_sitemaps_taxonomies', function ($taxonomies) {
    // Exclude the 'dc_vendor_shop' taxonomy from the sitemap
    unset($taxonomies['pa_brands']);
    return $taxonomies;
});

// Exclude specific taxonomies from the Yoast SEO sitemap
add_filter('wpseo_sitemap_exclude_taxonomy', function ($exclude, $taxonomy) {
    // List of taxonomies to exclude
    $taxonomies_to_exclude = [
        'dc_vendor_shop',   // Exclude a custom taxonomy
    ];

    // Exclude the taxonomy if it's in the list
    if (in_array($taxonomy, $taxonomies_to_exclude)) {
        return true;
    }

    return $exclude;
}, 10, 2);



//// post views

function get_post_views($postID)
{
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    return ($count == '') ? 0 : $count;
}



//SUB CCAT ARCH

function use_custom_subcategory_template($template)
{
    $category = get_queried_object();

    if (is_category() && $category->parent != 0) {
        $custom_template = locate_template('category-sub.php');
        if ($custom_template) {
            return $custom_template;
        }
    }

    return $template;
}
add_filter('category_template', 'use_custom_subcategory_template');
