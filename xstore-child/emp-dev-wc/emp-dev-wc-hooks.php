<?php

add_action( 'woocommerce_init', 'empdev_woocommerce_redirect_product_url' );

function empdev_woocommerce_redirect_product_url() {

	if ( is_user_logged_in() ) {

		if ( isset( $_GET['redirect_permalink'] ) ) {
			wp_safe_redirect( $_GET['redirect_permalink'], 302 );
			exit;
		}
	}
}

add_action('woocommerce_add_to_cart', 'empdev_new_customers_redirect_purchase', 100);
function empdev_new_customers_redirect_purchase() {

	if( ! is_user_logged_in() ){
		if ( ! WC()->cart->is_empty()  ) {

			$cart = WC()->cart->get_cart();
			$empdev_limit_new_customers_ids = get_option( 'empdev_limit_new_customers_ids', false );
			$blog_link = get_bloginfo('url');

			foreach ( $cart as $cart_item_key => $cart_item ) {

				$cart_item_id = $cart_item['product_id'];

				if ( in_array( $cart_item_id, $empdev_limit_new_customers_ids ) ) {

					wp_redirect( $blog_link . '/my-account/?redirect_permalink='.$blog_link.'/cart/');
					die;

				}

			}
		}
	}

}


add_action('woocommerce_after_cart', 'empdev_new_customers_cart_restriction');

add_action('woocommerce_after_checkout_form', 'empdev_new_customers_cart_restriction');

function empdev_new_customers_cart_restriction(){

	if ( ! WC()->cart->is_empty()  ) {

		$empdev_limit_new_customers_ids = get_option( 'empdev_limit_new_customers_ids', false );
		$customer_orders = EMPDEV_WC_Static_Helper::get_recent_order();
		$blog_link = get_bloginfo('url');

		if ( ( is_cart() || is_checkout () ) && ! empty ( $empdev_limit_new_customers_ids ) && count( $customer_orders ) > 0 ){

			$cart = WC()->cart->get_cart();
			//var_dump($cart);
			$cart_item_id = null;
			$send_error_notice = false;
			foreach ( $cart as $cart_item_key => $cart_item ) {

				$cart_item_id = $cart_item['product_id'];

				if ( in_array( $cart_item_id, $empdev_limit_new_customers_ids ) ) {

					$send_error_notice = true;
					break;
				}

			}

			if($send_error_notice){
				wc_clear_notices();
				$product_title = get_the_title($cart_item_id);

				if( is_user_logged_in() ){
					$message_title = "Sorry, ".$product_title." is only valid for new customers! ";
				} else {
					$message_title = "Login is required to purchase ".$product_title . ". <span><a href='".$blog_link."/my-account/?redirect_permalink=".$blog_link."/cart'>Click here to login.</a></span>";
				}

				$message = __( $message_title, "woocommerce" );
				wc_add_notice( $message, 'error' );
			}

		}

	}

}

if ( class_exists( 'WJECF_Wrap' ) ) {

	add_filter( 'woocommerce_coupon_is_valid', 'empdev_exclude_sale_free_products', 20, 2 );

	function empdev_exclude_sale_free_products( $valid, $coupon ) {

		$wrap_coupon          = WJECF_Wrap( $coupon );
		$exclude_sales_items  = $wrap_coupon->get_meta( 'exclude_sale_items' );
		$get_free_product_ids = WJECF_API()->get_coupon_free_product_ids( $coupon );

		if ( ! empty( $get_free_product_ids ) && $exclude_sales_items === true ) {

			$get_coupon_minimum_amount = $wrap_coupon->get_meta( 'minimum_amount' );

			$cart = WC()->cart->get_cart();

			//var_dump(WC()->cart->get_totals());
			//reference meta abstract-wc-product.php

			$calculate_regular_price = 0;
			foreach ( $cart as $cart_item_key => $cart_item ) {

				$cart_item_id = $cart_item['product_id'];

				if ( ! in_array( $cart_item_id, $get_free_product_ids ) ) {
					$sale_price         = $cart_item['data']->get_sale_price();
					$cart_item_quantity = $cart_item['quantity'];

					if ( empty( $sale_price ) ) {

						$regular_price = $cart_item['data']->get_regular_price();

						$calculate_regular_price += (float) $regular_price * (int) $cart_item_quantity;
					}
				}

			}

			if ( $calculate_regular_price < (float) $get_coupon_minimum_amount ) {
				return false;
			}

		}

		return $valid;
	}
}

// -------------------------- > wence
add_action('woocommerce_after_shop_loop_item_title', 'empdev_add_category_loop_item' , 3 );
function empdev_add_category_loop_item()
{
    global $product;
    echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">' . _n( count( $product->get_category_ids() ) ) . ' ', '</span>' );
}
add_action('woocommerce_after_shop_loop_item_title', 'empdev_add_star_rating' , 4 );
function empdev_add_star_rating()
{
    global $woocommerce, $product;
    $average = $product->get_average_rating();
    echo '<div class="star-rating"><span style="width:'.( ( $average / 5 ) * 100 ).'%"><strong itemprop="ratingValue" class="rating">'.$average.'</strong> '.__( 'out of 5', 'woocommerce' ).'</span></div>';
}
add_action( 'woocommerce_after_shop_loop_item_title', 'empdev_after_shop_loop_item' , 15 );
function empdev_after_shop_loop_item() {
    global $post , $product;
    $stock = get_post_meta( $post->ID, '_stock', true );
    if( $product->is_in_stock() ) {
        echo "<span class='i-stock'>In Stock</span>";
    } else {
        echo "<span class='o-stock' style='color:#f7931e;'>Out of Stock</span>";
    }
}
add_action( 'woocommerce_after_shop_loop_item_title', 'quick_view_after_shop_loop_item' , 18 );
function quick_view_after_shop_loop_item() {
    global $post;
    echo "<span class='show-quickly' data-prodid=".$post->ID."></span>";
}
function empdev_quick_view_outofstock() {
    global $post;
    $stock = get_post_meta( $post->ID, '_stock', true );
    if( $stock <= 0 ) {
        echo "<div class='qv-out-of-stock'><span class='stock' style='color:#f7931e;'>Out of Stock</span></div>";
    }
}

function add_something() {
    echo "";
}

add_action('woocommerce_checkout_order_review','add_something');

function empdev_myaccount_nav_icon($nav_id){
    switch ($nav_id) {
        case "Dashboard":
            echo "pie-chart";
            break;
        case "Orders":
            echo "shopping-basket";
            break;
        case "Subscriptions":
            echo "envelope";
            break;
        case "Downloads":
            echo "download";
            break;
        case "Coupons":
            echo "ticket";
            break;
        case "Addresses":
            echo "home";
            break;
        case "Payment methods":
            echo "money";
            break;
        case "Account details":
            echo "user-circle";
            break;
        case "Logout":
            echo "sign-out";
            break;
    }
}