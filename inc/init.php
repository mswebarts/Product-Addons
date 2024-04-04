<?php
global $mspa_dir;

// including options panel.
require_once $mspa_dir . 'inc/admin/options-panel/options-panel.php';

// check if enable product addon is enabled.
$mspa_options = get_option( 'mspa_general_options' );
if ( ! empty( $mspa_options['mspa_enable_product_addon'] ) ) {
	include_once $mspa_dir . 'inc/functions/product-settings.php';
	include_once $mspa_dir . 'inc/functions/product-frontend.php';
}
