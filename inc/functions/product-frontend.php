<?php
// display the values product of addons in the product details page before add to cart
add_action('woocommerce_before_add_to_cart_button', 'mspa_display_product_addon_sections');
function mspa_display_product_addon_sections() {
    global $product;
    $product_id = $product->get_id();
    $base_price = $product->get_price();

    // check if sections are available
    $mspa_options = get_option('mspa_general_options');
    if (!empty($mspa_options['product_addon_sections'])) {
        $product_addon_sections = $mspa_options['product_addon_sections'];

        foreach ($product_addon_sections as $section) {
            $addon_items = get_post_meta($product_id, '_mspa_section_' . sanitize_text_field($section['product_addon_section_id']) . '_items', true);
            
            // check if the addon items are available
            if (!empty($addon_items)) {
                $display_section = false;

                // show addon if name and price are available
                foreach ($addon_items as $item) {
                    if (!empty($item['name']) && !empty($item['price'])) {
                        $display_section = true;
                        break;
                    }
                }
                if ($display_section) {
                    ?>
                    <div class="mspa-product-addons" data-base-price="<?php echo esc_attr($base_price); ?>">
                        <h3><?php echo esc_html($section['product_addon_section_name']); ?></h3>
                        <table>
                            <tbody>
                                <?php
                                foreach ($addon_items as $item) {
                                    if (!empty($item['name']) && !empty($item['price'])) {
                                        ?>
                                        <tr>
                                            <td>
                                                <input type="checkbox" class="addon-checkbox" data-section="<?php echo esc_attr($section['product_addon_section_name']); ?>" data-price="<?php echo esc_attr($item['price']); ?>" name="addon-<?php echo sanitize_title($item['name']); ?>">
                                                <?php echo esc_html($item['name']); ?>
                                            </td>
                                            <td><?php echo wc_price($item['price']); ?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                }
            }
        }

    }

    echo '<input type="hidden" id="selected_addons" name="selected_addons" value="">';
}

add_action('wp_ajax_mspa_update_product_price', 'mspa_update_product_price');
add_action('wp_ajax_nopriv_mspa_update_product_price', 'mspa_update_product_price');
function mspa_update_product_price() {
    $selected_addons = json_decode(stripslashes($_POST['selected_addons']), true);
    $product_id = sanitize_text_field($_POST['product_id']);

    // Store the selected addons in a separate meta field
    update_post_meta($product_id, '_selected_addons', $selected_addons);

    // Calculate the new product price
    $base_price = get_post_meta($product_id, '_regular_price', true);
    $new_price = $base_price;
    foreach ($selected_addons as $addon) {
        $new_price += floatval($addon['price']);
    }

    // Return the new product price
    echo wc_price($new_price);

    wp_die();
}

// Add the selected addons to the cart item data
add_filter('woocommerce_add_cart_item_data', 'mspa_add_selected_addons_to_cart_item_data', 10, 3);
function mspa_add_selected_addons_to_cart_item_data($cart_item_data, $product_id, $variation_id) {
    if (isset($_POST['selected_addons'])) {
        $cart_item_data['addons'] = json_decode(stripslashes($_POST['selected_addons']), true);
    }
    return $cart_item_data;
}

add_filter('woocommerce_get_item_data', 'mspa_display_selected_addons_in_cart', 10, 2);
function mspa_display_selected_addons_in_cart($item_data, $cart_item) {
    if (!empty($cart_item['addons'])) {
        // Group the addons by their section
        $addons_by_section = array();
        foreach ($cart_item['addons'] as $addon) {
            $addons_by_section[sanitize_text_field($addon['section'])][] = wc_clean($addon['name']);
        }

        // Add the addons to the cart item data
        foreach ($addons_by_section as $section => $addons) {
            $item_data[] = array(
                'key'     => sanitize_text_field($section),
                'value'   => implode(', ', $addons),
                'display' => '',
            );
        }
    }

    return $item_data;
}

// Add the selected addons to the cart item price
add_action('woocommerce_before_calculate_totals', 'mspa_add_addons_price_to_cart', 10, 1);
function mspa_add_addons_price_to_cart($cart) {
    if (is_admin() && !defined('DOING_AJAX')) {
        return;
    }

    // make sure cart price is calculated only once
    if (did_action('woocommerce_before_calculate_totals') >= 2) {
        return;
    }

    // loop through the cart items
    foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
        if (isset($cart_item['addons'])) {
            $addons_price = 0;
            // calculate the total price of the addons
            foreach ($cart_item['addons'] as $addon) {
                $addons_price += floatval($addon['price']);
            }
            $new_price = $cart_item['data']->get_price() + $addons_price;

            // set the new price
            $cart->cart_contents[$cart_item_key]['data']->set_price($new_price);
        }
    }
}