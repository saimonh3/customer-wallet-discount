<?php

if ( ! defined( 'WPINC' ) ) exit;

class Customer_Wallet_Discount_Settings {
    public static $instance = null;

    public function __construct() {
        $this->init_hooks();
    }

    public function init_hooks() {
        if ( is_admin() ) {
            add_filter( 'woocommerce_settings_tabs_array', array( $this, 'add_customer_wallet_discount_tab' ), 99 );
            add_action( 'woocommerce_settings_customer_wallet', array( $this, 'output_settings' ) );
            add_action( 'woocommerce_update_options_customer_wallet', array( $this, 'update_options' ) );
        }
    }

    public function add_customer_wallet_discount_tab( $tabs ) {
        $tabs['customer_wallet'] = __( 'Customer Wallet', 'domain' );

        return $tabs;
    }

    public function output_settings() {
        woocommerce_admin_fields( $this->get_settings() );
    }

    public function get_settings() {
        $settings = array(
            array(
                'title'		=> __( 'Customer Wallet Discount Settings', 'domain' ),
                'desc'		=> __( 'Settings for customer wallet discount', 'domain' ),
                'id'        => 'customer_wallet_settings',
                'type'      => 'title',
            ),
            array(
                'title'     => __( 'Credits on Registration', 'domain' ),
                'desc'      => __( 'Give bonus credit when a customer register on the site', 'domain' ),
                'id'        => 'credits_on_registration',
                'type'      => 'text',
                'desc_tip'  => true,
                'default'   => '0'
            ),

	        array(
                'type'   => 'sectionend',
                'id' => 'customer_wallet_settings'
            ),
        );

        return $settings;
    }

    public function update_options() {
        woocommerce_update_options( $this->get_settings() );
    }

    public static function init() {
        if( is_null( self::$instance ) ) {
            self::$instance = new Self;
        }

        return self::$instance;
    }
}

Customer_Wallet_Discount_Settings::init();
