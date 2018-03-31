<?php

if ( ! defined( 'WPINC' ) ) exit;

class Customer_Discount_Public {
    public static $instance = null;

    public function __construct() {
        $this->init_hooks();
    }

    public function init_hooks() {
        add_action( 'woocommerce_account_content', array( $this, 'customer_discount_details' ), 1 );
    }

    public function customer_discount_details() {
        $customer = new WC_Customer( get_current_user_id() );
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
                    <?php printf( __( 'Credits: <span>$</span>%s', 'domain' ), $customer->get_total_spent() ); ?>
                </div>
                <div class="customer-badge">
                    <i class="far fa-gem"></i>
                </div>
            </div>
            <div class="other-info">
                <div class="total-spent">
                    Total Spent
                    <span>$55</span>
                </div>
                <div class="total-order">
                    Total Order
                    <span>55</span>
                </div>
            </div>
        </div>
        <?php

        // $html = '<div class="customer-discount">';
        // $html .= '<h2> Your Discount </h2>';
        // $html .= '<h3> You are a lite user </h3>';
        // $html .= '<p> Total Orders: ' . wc_get_customer_order_count( get_current_user_id() ) . '</p>';
        // $html .= '<p> Total Spent: ' . wc_get_customer_total_spent( get_current_user_id() ) . '</p>';
        // $html .= '<p> You will get $50 discount when your total spent will be greater than $500';
        // $html .= '</div>';
        //
        // echo $html;
    }

    public static function init() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new Self;
        }

        return self::$instance;
    }
}

Customer_Discount_Public::init();
