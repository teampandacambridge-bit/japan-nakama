<?php
function nakama_admin_enqueue($hook)
{
    if ($hook === 'settings_page_nakama-sidebar-coupons') {
        wp_enqueue_script('jquery-ui-sortable');
    }
}
add_action('admin_enqueue_scripts', 'nakama_admin_enqueue');


function nakama_sidebar_coupons_page()
{
    $coupons = get_option('nakama_coupons', []);
    $heading = get_option('nakama_coupon_heading', '');
?>
    <div class="wrap">
        <h1>Sidebar Coupons</h1>
        <form method="post" action="options.php">
            <?php settings_fields('nakama_sidebar_group'); ?>

            <h2>Section Heading</h2>
            <input type="text" name="nakama_coupon_heading" value="<?php echo esc_attr($heading); ?>" style="width: 400px;" />

            <h2 style="margin-top:30px;">Coupons</h2>
            <table id="nakama-coupons-table" class="form-table">
                <thead>
                    <tr>
                        <th>Heading</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Discount</th>
                        <th>Code</th>
                        <th>CTA</th>
                        <th>Link</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($coupons)) : ?>
                        <?php foreach ($coupons as $index => $coupon) : ?>
                            <tr>
                                <td><input type="text" name="nakama_coupons[<?php echo $index; ?>][heading]" value="<?php echo esc_attr($coupon['heading'] ?? ''); ?>" /></td>
                                <td><input type="text" name="nakama_coupons[<?php echo $index; ?>][type]" value="<?php echo esc_attr($coupon['type'] ?? ''); ?>" /></td>
                                <td><input type="text" name="nakama_coupons[<?php echo $index; ?>][description]" value="<?php echo esc_attr($coupon['description'] ?? ''); ?>" /></td>
                                <td><input type="text" name="nakama_coupons[<?php echo $index; ?>][discount]" value="<?php echo esc_attr($coupon['discount'] ?? ''); ?>" /></td>
                                <td><input type="text" name="nakama_coupons[<?php echo $index; ?>][code]" value="<?php echo esc_attr($coupon['code'] ?? ''); ?>" /></td>
                                <td><input type="text" name="nakama_coupons[<?php echo $index; ?>][cta]" value="<?php echo esc_attr($coupon['cta'] ?? ''); ?>" /></td>
                                <td><input type="text" name="nakama_coupons[<?php echo $index; ?>][link]" value="<?php echo esc_attr($coupon['link'] ?? ''); ?>" /></td>
                                <td><button type="button" class="button remove-coupon">Remove</button></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            <p>
                <button type="button" class="button" id="add-coupon">Add Coupon</button>
            </p>

            <?php submit_button(); ?>
        </form>
    </div>

    <script>
        jQuery(document).ready(function($) {
            const tableBody = $("#nakama-coupons-table tbody");

            // Enable drag-and-drop sorting
            tableBody.sortable({
                items: "tr",
                cursor: "move",
                axis: "y",
                update: function() {
                    reindexCoupons();
                }
            });

            // Reindex coupons after drag-drop or remove
            function reindexCoupons() {
                tableBody.find("tr").each(function(index) {
                    $(this).find("input").each(function() {
                        const name = $(this).attr("name");
                        if (name) {
                            const updatedName = name.replace(/\[\d+\]/, `[${index}]`);
                            $(this).attr("name", updatedName);
                        }
                    });
                });
            }

            // Add new coupon row
            $("#add-coupon").on("click", function() {
                const rowCount = tableBody.find("tr").length;
                const row = $(`
                <tr>
                    <td><input type="text" name="nakama_coupons[${rowCount}][heading]" value="" /></td>
                    <td><input type="text" name="nakama_coupons[${rowCount}][type]" value="" /></td>
                    <td><input type="text" name="nakama_coupons[${rowCount}][description]" value="" /></td>
                    <td><input type="text" name="nakama_coupons[${rowCount}][discount]" value="" /></td>
                    <td><input type="text" name="nakama_coupons[${rowCount}][code]" value="" /></td>
                    <td><input type="text" name="nakama_coupons[${rowCount}][cta]" value="" /></td>
                    <td><input type="text" name="nakama_coupons[${rowCount}][link]" value="" /></td>
                    <td><button type="button" class="button remove-coupon">Remove</button></td>
                </tr>
            `);
                tableBody.append(row);
            });

            // Remove coupon row
            tableBody.on("click", ".remove-coupon", function() {
                $(this).closest("tr").remove();
                reindexCoupons();
            });
        });
    </script>
<?php
}

function nakama_settings_init()
{
    register_setting('nakama_sidebar_group', 'nakama_coupon_heading');
    register_setting('nakama_sidebar_group', 'nakama_coupons');
}
add_action('admin_init', 'nakama_settings_init');
