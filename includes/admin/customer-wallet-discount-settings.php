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
                'id'        => 'customer_wallet_settings',
                'type'      => 'title',
            ),
            array(
                'title'     => __( 'Credits on Registration', 'domain' ),
                'desc'      => __( 'Give bonus credit when a customer register on the site', 'domain' ),
                'id'        => 'credits_on_registration',
                'type'      => 'number',
                'desc_tip'  => true,
                'default'   => '0'
            ),

            array(
                'type'     => 'sectionend',
                'id'       => 'customer_wallet_settings'
            ),

            array(
                'title'     => __( 'Credit Calculation System', 'domain' ),
                'id'        => 'credit_settings',
                'type'      => 'title'
            ),
            array(
                'title'     => __( 'Credit on Order Basis', 'domain' ),
                'desc'      => __( 'Enable/Disable', 'dokan' ),
                'id'        => 'credit_on_order_enabled',
                'type'      => 'checkbox',
                'default'   => 'yes'
            ),
            array(
                'title'     => __( 'Credit Rate Per Order', 'domain' ),
                'id'        => 'credit_per_order',
                'type'      => 'number',
                'desc'      => __( 'Credit per order', 'domain' ),
                'desc_tip'  => true,
            ),
            array(
                'title'     => __( 'Credit on Order Total', 'domain' ),
                'desc'      => __( 'Enable/Disable', 'dokan' ),
                'id'        => 'credit_on_order_total_enabled',
                'type'      => 'checkbox',
            ),
            array(
                'title'     => __( 'Credit Rate on Order Total', 'domain' ),
                'id'        => 'credit_on_order_total',
                'type'      => 'number',
                'desc'      => __( 'How much credit a customer will get based on the cart total', 'domain' ),
                'desc_tip'  => true,
                'placeholder' => __( 'Percentage', 'domain' ),
            ),

            array(
                'type'   => 'sectionend',
                'id' => 'credit_settings'
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
