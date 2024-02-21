<?php
// Add a new tab to the product data meta box
add_filter('woocommerce_product_data_tabs', 'mspa_add_product_addon_sections_tab', 99, 1);
function mspa_add_product_addon_sections_tab($product_data_tabs) {
    $product_data_tabs['product_addon_sections_tab'] = array(
        'label' => __('Product Addon', 'msp-addons'),
        'target' => 'product_addon_sections_product_data',
    );
    return $product_data_tabs;
}

// Add the content to the new tab
add_action('woocommerce_product_data_panels', 'mspa_product_addon_sections_product_data_content');
function mspa_product_addon_sections_product_data_content() {
    global $post;
    ?>
    <div id='product_addon_sections_product_data' class='panel woocommerce_options_panel'>
        <div class='options_group'>
            <?php
            $mspa_options = get_option('mspa_general_options');
            if (!empty($mspa_options['product_addon_sections'])) {
                $product_addon_sections = $mspa_options['product_addon_sections'];
            } else {
                $product_addon_sections = [];
            }

            // check if sections exist in the settings
            if (!empty($product_addon_sections)) {
                foreach ($product_addon_sections as $section) {
                    $addon_items = get_post_meta($post->ID, '_mspa_section_' . sanitize_text_field($section['product_addon_section_id']) . '_items', true);

                    // If empty, add a blank item to the array so that the repeater field is displayed
                    if (empty($addon_items)) {
                        $addon_items = [
                            [
                                'name' => '',
                                'price' => ''
                            ]
                        ];
                    }
                    ?>
                    <div class='accordion-title'><?php echo esc_html($section['product_addon_section_name']); ?></div>
                    <div class='accordion-content'>
                        <div class="mspa-repeater">
                            <div data-repeater-list="<?php echo esc_attr('mspa-section-'. $section['product_addon_section_id'] . '-fields') ?>">
                                <?php
                                if (!empty($addon_items)) {
                                    foreach ($addon_items as $item) {
                                    ?>
                                        <div data-repeater-item class="options-group">
                                            <p class="form-field">
                                                <label for='mspa_addon_item_name'><?php echo esc_html_e('Name', 'msp-addons'); ?></label>
                                                <input type='text' class='short' name="mspa_addon_item_name" value="<?php echo esc_attr($item['name']); ?>" />
                                            </p>
                                            <p class="form-field">
                                                <label for='mspa_addon_item_price'><?php _e('Price', 'msp-addons'); ?></label>
                                                <input type='number' class='short' name="mspa_addon_item_price" value="<?php echo esc_attr($item['price']); ?>" min="0.01" step="0.01"/>
                                            </p>
                                            <input data-repeater-delete type="button" value="Delete"/>
                                        </div>
                                    <?php
                                    }
                                }
                                ?>
                            </div>
                            <input data-repeater-create type="button" value="Add"/>
                        </div>
                    </div>
                    
                    <?php
                }
            }
            ?>
        </div>
    </div>
    <?php
}

// Save the data from the product addon tab
add_action('woocommerce_process_product_meta', 'mspa_save_product_addon_sections_product_data');
function mspa_save_product_addon_sections_product_data($post_id) {
    $mspa_options = get_option('mspa_general_options');
    if (!empty($mspa_options['product_addon_sections'])) {
        $product_addon_sections = $mspa_options['product_addon_sections'];
        foreach ($product_addon_sections as $section) {
            $section_id = sanitize_text_field($section['product_addon_section_id']);
            if (isset($_POST['mspa-section-' . $section_id . '-fields'])) {
                $addon_items = array();
                foreach ($_POST['mspa-section-' . $section_id . '-fields'] as $item) {
                    $item_name = sanitize_text_field($item['mspa_addon_item_name']);
                    $item_price = sanitize_text_field($item['mspa_addon_item_price']);

                    $addon_items[] = array(
                        'name' => $item_name,
                        'price' => $item_price
                    );
                }
                update_post_meta($post_id, '_mspa_section_' . $section_id . '_items', $addon_items);
            }
        }
    }
}

// Add the necessary JavaScript to make the sections collapsible
add_action('admin_footer', 'mspa_product_addon_sections_accordion_js');
function mspa_product_addon_sections_accordion_js() {
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        $('.accordion-title').click(function() {
            $(this).next('.accordion-content').slideToggle();
        });
    });
    </script>
    <?php
}