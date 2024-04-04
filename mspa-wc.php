<?php

/**
 * Plugin Name: MS Product Addons
 * Description: Let customers choose product addons while buying for WooCommerce websites.
 * Version: 1.
 * Plugin URI: https://www.mswebarts.com/products/msp-addons/
 * Author: MS Web Arts
 * Author URI: https://www.mswebarts.com/
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Tested up to: 6.2
 * Requires at least: 5.5
 * Requires PHP: 7.4
 * Text Domain: msp-addons
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'MSProductAddons_DIR', plugin_dir_path( __FILE__ ) );

global $mspa_dir, $mspa_url, $mspa_options;
$mspa_dir     = plugin_dir_path( __FILE__ );
$mspa_url     = plugins_url( '/', __FILE__ );
$mspa_options = array();

class MSP_Addons_Lite {
	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'mspa_on_plugin_load' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'mspa_register_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'mspa_register_scripts' ) );
		add_action( 'admin_menu', array( $this, 'mspa_add_menu_page' ) );
		add_action( 'mswa_overview_content', array( $this, 'mspa_overview_content' ), 10 );
		add_action( 'mswa_overview_sidebar', array( $this, 'mspa_overview_sidebar' ), 10 );
		add_action( 'admin_enqueue_scripts', array( $this, 'mspa_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'mspa_admin_js' ) );
		add_action( 'init', array( $this, 'mspa_load_textdomain' ) );
	}
	function mspa_on_plugin_load() {
		global $mspa_dir;

		if ( ! defined( 'WC_VERSION' ) ) {
			add_action( 'admin_notices', array( $this, 'mspa_woocommerce_dependency_error' ) );
			return;
		}

		// include plugin files
		include_once $mspa_dir . 'inc/init.php';
	}

	function mspa_woocommerce_dependency_error() {
		$class   = 'notice notice-error';
		$message = __( 'You must need to install and activate woocommerce for Product Addons to work', 'msp-addons' );

		printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
	}

	function mspa_register_styles() {
		// register and enqueue css
		wp_register_style( 'mspa-style', plugins_url( 'assets/css/style.css', __FILE__ ) );
		wp_register_style( 'mspa-responsive', plugins_url( 'assets/css/responsive.css', __FILE__ ) );

		wp_enqueue_style( 'mspa-style' );
		wp_enqueue_style( 'mspa-responsive' );
	}

	function mspa_register_scripts() {
		// register and enqueue javascript
		wp_register_script( 'mspa-script', plugins_url( 'assets/js/main.js', __FILE__ ), array( 'jquery' ), '1.0.0', true );
		wp_enqueue_script( 'mspa-script' );

		if ( is_product() ) {
			global $product;
			$product_id = get_queried_object_id();

			wp_localize_script(
				'mspa-script',
				'mspa_script_vars',
				array(
					'ajaxurl'    => admin_url( 'admin-ajax.php' ),
					'product_id' => $product_id,
				)
			);
		}
	}

	// add_menu_page
	function mspa_add_menu_page() {
		global $mspa_url;
		// add parent settings page only if not added by other plugin from us
		if ( empty( $GLOBALS['admin_page_hooks']['mswebarts-overview'] ) ) {
			add_menu_page(
				'MS Web Arts Overview',
				'MS Web Arts',
				'manage_options',
				'mswebarts-overview',
				'mspa_overview_page',
				$mspa_url . 'inc/admin/assets/images/icon.png',
				100
			);
		}

		add_submenu_page(
			'mswebarts-overview',
			'Product Addons Settings',
			'Product Addons',
			'manage_options',
			'msp-addons',
			'mspa_settings',
			10
		);
	}

	function mspa_overview_content() {
		global $mspa_dir;
		include_once $mspa_dir . 'inc/admin/options-panel/pages/overview-content.php';
	}

	function mspa_overview_sidebar() {
		global $mspa_dir;
		include_once $mspa_dir . 'inc/admin/options-panel/pages/overview-sidebar.php';
	}

	// add admin styles and js
	function mspa_admin_styles() {
		wp_register_style( 'mswa-global-style', 'https://mswebarts.b-cdn.net/plugins-global/global.css' );
		wp_enqueue_style( 'mswa-global-style' );

		wp_register_style( 'mspa-admin-style', plugins_url( 'inc/admin/assets/css/style.css', __FILE__ ) );
		wp_enqueue_style( 'mspa-admin-style' );
	}

	function mspa_admin_js() {
		global $mspa_url;
		wp_register_script( 'mswa-jquery-repeater', 'https://mswebarts.b-cdn.net/plugins-global/jquery.repeater.min.js', array( 'jquery' ), '1.0.0', true );
		wp_register_script( 'mswa-global-script', 'https://mswebarts.b-cdn.net/plugins-global/global.js', array( 'jquery', 'mswa-jquery-repeater' ), '1.0.0', true );

		wp_register_script( 'mspa-admin-script', $mspa_url . 'inc/admin/assets/js/script.js', array( 'jquery', 'mswa-jquery-repeater', 'mswa-global-script' ), '1.0.0', true );
	}

	// load translations
	function mspa_load_textdomain() {
		load_plugin_textdomain( 'msp-addons', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}
}

// initialize the plugin and make sure headers already sent error is not returned
new MSP_Addons_Lite();
