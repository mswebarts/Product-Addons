<?php
function mspa_settings() {
	global $mspa_dir, $mspa_options;

	// check if form submitted.
	if ( isset( $_POST['mspa_general_form_submitted'] ) ) {

		// check nonce.
		if ( ! isset( $_POST['mspa_general_form_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['mspa_general_form_nonce'] ) ), 'mspa_general_form_action' ) ) {
			return;
		}
		$submitted = sanitize_text_field( wp_unslash( $_POST['mspa_general_form_submitted'] ) );

		// if submitted is set to Y.
		if ( 'Y' == $submitted ) {

			// display add review form.
			if ( isset( $_POST['mspa_enable_product_addon'] ) ) {
				$mspa_enable_product_addon = intval( $_POST['mspa_enable_product_addon'] );
			} else {
				$mspa_enable_product_addon = intval( 0 );
			}

			if ( isset( $_POST['product_addon_sections'] ) && is_array( $_POST['product_addon_sections'] ) ) {
				$raw_data = filter_input( INPUT_POST, 'product_addon_sections', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY );
				if ( ! empty( $raw_data ) ) {
					foreach ( $raw_data as $item ) {
						$product_addon_sections_new[] = array(
							'product_addon_section_id'   => sanitize_text_field( $item['product_addon_section_id'] ),
							'product_addon_section_name' => sanitize_text_field( $item['product_addon_section_name'] ),
						);
					}
				}
			}

			// assign value to array.
			$mspa_options['mspa_enable_product_addon'] = $mspa_enable_product_addon;
			// only add the sanitized fields.
			$mspa_options['product_addon_sections'] = $product_addon_sections_new;

			// save options.
			update_option( 'mspa_general_options', $mspa_options );
		}
	}

	// retrive the options to use in general.php.
	$mspa_options = get_option( 'mspa_general_options' );

	if ( ! empty( $mspa_options['mspa_enable_product_addon'] ) ) {
		$mspa_enable_product_addon = intval( $mspa_options['mspa_enable_product_addon'] );
	} else {
		$mspa_enable_product_addon = intval( 0 );
	}

	if ( ! empty( $mspa_options['product_addon_sections'] ) ) {
		$product_addon_sections = $mspa_options['product_addon_sections'];
	} else {
		$product_addon_sections = array();
	}

	include_once $mspa_dir . 'inc/admin/options-panel/pages/settings.php';
}
