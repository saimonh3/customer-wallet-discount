<?php
/**
 * Plugin Name: Customer Wallet & Discount
 * Plugin URI: www.saimonsplugins.com
 * Author: Mohammed saimon
 * Description: A simple plugin
 */

if ( ! defined( 'WPINC' ) ) exit;

class Customer_Wallet_Discount {
    public static $version;
    public static $instance;

    public function __construct() {
        self::$version = '1.0';
        $this->define_constants();
        $this->init_hooks();
        $this->includes();
    }

    public function define_constants() {
        define( 'CWD_DIR', plugin_dir_path( __FILE__ ) );
        define( 'CWD_INC', plugin_dir_path( __FILE__ ) . 'includes/' );
        define( 'CWD_ASSETS', plugin_dir_url( __FILE__ ) . 'assets/' );
    }

    public function init_hooks() {
        if ( is_admin() ) {

        } else {
            add_action( 'wp_enqueue_scripts', array( $this, 'load_customer_wallet_discount_scripts' ) );
        }
    }

    public function load_customer_wallet_discount_scripts() {
        if ( ! is_account_page() ) return;

        wp_enqueue_style( 'fontawesome', "https://use.fontawesome.com/releases/v5.0.9/css/all.css" );
        wp_enqueue_style( 'customer-wallet-discount', CWD_ASSETS . 'css/style.css' );
    }

    public function includes() {
        if ( is_admin() ) {
            require_once CWD_INC . 'admin/customer-wallet-discount-settings.php';
        } else {
            require_once CWD_INC . 'public/customer-wallet-discount-public.php';
        }

    }

    public static function init() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new Customer_Wallet_Discount();
        }

        return self::$instance;
    }
}

add_action( 'plugins_loaded', array( 'Customer_Wallet_Discount', 'init' ) );
