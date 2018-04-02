<?php

if ( ! defined( 'WPINC' ) ) exit;

class Customer_Wallet_Discount_Public {
    public static $instance = null;

    public function __construct() {
        $this->init_hooks();
    }

    public function init_hooks() {
        add_action( 'woocommerce_account_content', array( $this, 'customer_discount_details' ), 1 );

        // give credits on customer registration
        add_action( 'woocommerce_created_customer', array( $this, 'give_credits_on_customer_registration' ), 10, 2 );
        // give credits on a new order
        // add_action( 'woocommerce_payment_complete', array( $this, 'give_credits_on_new_order' ) );
        add_action( 'woocommerce_order_status_on-hold', array( $this, 'give_credits_on_new_order' ) );
        add_action( 'woocommerce_order_status_pending', array( $this, 'give_credits_on_new_order' ) );
        add_action( 'woocommerce_order_status_completed', array( $this, 'give_credits_on_new_order' ) );
    }

    public function customer_discount_details() {
        $customer = new WC_Customer( get_current_user_id() );
        $customer_credits = $this->get_credits();
        ?>
        <div class="customer-wallet">
            <h2 class="ribbon">
                <strong class="ribbon-content">Your Wallet</strong>
            </h2>
            <div class="wallet-details">
                <div class="avatar">
                    <img src="<?php echo $customer->get_avatar_url() ?>" alt="Customer Avatar">
                </div>
                <div class="customer-balance">
                    <?php printf( __( 'Credits: %s', 'domain' ), wc_price( esc_attr__( $customer_credits, 'domain' ) ) ); ?>
                </div>
                <div class="customer-badge">
                    <i class="far fa-gem"></i>
                </div>
            </div>
            <div class="other-info">
                <div class="total-spent">
                    Total Spent
                    <span><?php echo $customer->get_total_spent(); ?></span>
                </div>
                <div class="total-order">
                    Total Order
                    <span><?php echo $customer->get_order_count(); ?></span>
                </div>
            </div>
            <div class="customer-message">
                Get 1 Credit Per Order or Per $50 Spent.
            </div>
        </div>
        <?php
    }

    public function give_credits_on_customer_registration( $user_id, $data ) {
        if ( $data['role'] !== 'customer' ) return;

        $cwd_credits = get_option( 'credits_on_registration', 0 );

        if ( empty( $cwd_credits ) ) return;

        update_user_meta( $user_id, 'cwd_credits', wc_clean( $cwd_credits ) );
    }

    public function give_credits_on_new_order( $order_id ) {
        $credit_on_order_enabled = get_option( 'credit_on_order_enabled', 0 );
        $credit_on_order_total_enabled = get_option( 'credit_on_order_total_enabled', 0 );

        if ( ! $credit_on_order_enabled && ! $credit_on_order_total_enabled ) {
            return;
        }

        $customer_id      = get_current_user_id();
        $current_credits  = $this->get_current_credits( $customer_id );

        update_user_meta( $customer_id, 'cwd_credits', wc_clean( $current_credits ) );

        do_action( 'give_credits_on_new_order', $order_id );
    }

    public function get_current_credits( $user_id ) {
        $credits = get_user_meta( $user_id, 'cwd_credits', true );
        $credit_per_order = get_option( 'credit_per_order' );

        $total_credits = $credit_per_order + $credits;

        return $total_credits;
    }

    public function get_credits() {
        $credits = get_user_meta( get_current_user_id(), 'cwd_credits', true );

        return $credits;
    }

    public static function init() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new Self;
        }

        return self::$instance;
    }
}

Customer_Wallet_Discount_Public::init();
