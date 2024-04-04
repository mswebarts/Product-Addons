<?php
function mspa_overview_page() {
    global $mspa_dir;
    include_once $mspa_dir . 'inc/admin/options-panel/pages/overview.php';
}
function mspa_settings() {
    global $mspa_dir, $mspa_options;

    // check if form submitted
    if (isset($_POST['mspa_general_form_submitted'])) {
        $submitted = sanitize_text_field($_POST['mspa_general_form_submitted']);

        // if submitted is set to Y
        if ($submitted == 'Y') {

            // display add review form
            if (isset($_POST['mspa_enable_product_addon'])) {
                $mspa_enable_product_addon = intval($_POST['mspa_enable_product_addon']);
            } else {
                $mspa_enable_product_addon = intval(0);
            }

            // save product addons sections
            if (isset($_POST['product_addon_sections'])) {
                $product_addon_sections = $_POST['product_addon_sections'];
            }

            // sanitize the array
            foreach($product_addon_sections as $section) {
                $section_id = sanitize_text_field(stripslashes($section['product_addon_section_id']));
                $section_name = sanitize_text_field(stripslashes($section['product_addon_section_name']));

                $product_addon_sections_new[] = array(
                    'product_addon_section_id' => $section_id,
                    'product_addon_section_name' => $section_name
                );
            }

            // assign value to array
            $mspa_options['mspa_enable_product_addon'] = $mspa_enable_product_addon;
            // only add the sanitized fields
            $mspa_options['product_addon_sections']          = $product_addon_sections_new;

            // save options
            update_option('mspa_general_options', $mspa_options);
        }
    }

    // retrive the options to use in general.php
    $mspa_options = get_option('mspa_general_options');

    if (!empty($mspa_options['mspa_enable_product_addon'])) {
        $mspa_enable_product_addon = intval($mspa_options['mspa_enable_product_addon']);
    } else {
        $mspa_enable_product_addon = intval(0);
    }

    if (!empty($mspa_options['product_addon_sections'])) {
        $product_addon_sections = $mspa_options['product_addon_sections'];
    } else {
        $product_addon_sections = [];
    }

    include_once $mspa_dir . 'inc/admin/options-panel/pages/settings.php';
}
