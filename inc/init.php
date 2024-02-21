<?php
global $mspa_dir;

// including options panel
include_once $mspa_dir . 'inc/admin/options-panel/options-panel.php';

// include plugin files
// include_once $mspa_dir . 'inc/functions/hooks-actions.php';

// check if enable product addon is enabled
$mspa_options = get_option('mspa_general_options');
if (!empty($mspa_options['mspa_enable_product_addon'])) {
    include_once $mspa_dir . 'inc/functions/product-settings.php';
    include_once $mspa_dir . 'inc/functions/product-frontend.php';
}

// including template loader
include_once $mspa_dir . 'inc/classes/class-mspa-template-loader.php';
