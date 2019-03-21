<?php

//enqueue parent theme
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    etheme_child_styles();
}

//enqueue custom scripts
add_action( 'wp_enqueue_scripts', 'empdev_custom_scripts_frontend', 99 );

function empdev_custom_scripts_frontend(){
	wp_enqueue_script( 'custom-script', get_stylesheet_directory_uri() . '/js/custom-script.js', array('jquery'), '3.4.3', false );
    wp_enqueue_style( 'custom-style', get_stylesheet_directory_uri() . '/css/custom-style.css', array(), '3.8.4' );

	if (is_front_page() ) {
		wp_enqueue_style('font-lobster-css-style', 'https://fonts.googleapis.com/css?family=Lobster+Two', array(), '2.1.1');
		wp_enqueue_style('home-custom-style', get_stylesheet_directory_uri() . '/css/home-custom-style.css' , array(), '2.2.1');
	}

    wp_enqueue_style( 'cart-style', get_stylesheet_directory_uri() . '/css/cart-view.css', array(), '2.1.0' );
    wp_enqueue_style( 'checkout-style', get_stylesheet_directory_uri() . '/css/checkout.css', array(), '2.1.3' );

    wp_enqueue_style( 'myaccount-style', get_stylesheet_directory_uri() . '/css/my-account-view.css', array(), '2.0.2' );

    wp_enqueue_style( 'register-view-style', get_stylesheet_directory_uri() . '/css/register-view.css', array(), '2.0.1' );

    wp_enqueue_style( 'product-custom-style', get_stylesheet_directory_uri() . '/css/product-view.css' , array(), '2.3.1' );
    wp_enqueue_style( 'single-product-custom-style', get_stylesheet_directory_uri() . '/css/single-product-view.css' , array(), '2.2.2' );

	wp_enqueue_style( 'bootstrap-select', get_stylesheet_directory_uri() . '/plugins/bootstrap-select/css/bootstrap-select.css' );
	wp_enqueue_script( 'bootstrap-core', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js', false, false );
	wp_enqueue_script( 'bootstrap-select', get_stylesheet_directory_uri() . '/plugins/bootstrap-select/js/bootstrap-select.js', array( 'jquery' ), false, false );

	wp_enqueue_script( 'landingmap-scripts', get_stylesheet_directory_uri() . '/assets/main-global.js', array( 'jquery' ), '2.2.1', false );
	wp_enqueue_style( 'global-styles', get_stylesheet_directory_uri() . '/assets/main-style.css', false, '1.1.2' );

}

add_action( 'pmpro_after_checkout', 'sync_woo_billing_func' );

if ( ! function_exists( 'sync_woo_billing_func' ) ) {
	function sync_woo_billing_func() {
		global $current_user;
		$user_id = get_current_user_id();

		update_user_meta( $user_id, 'billing_first_name', $_REQUEST['bfirstname'] );
		update_user_meta( $user_id, 'billing_last_name', $_REQUEST['blastname'] );
		update_user_meta( $user_id, 'billing_address_1', $_REQUEST['baddress1'] );
		update_user_meta( $user_id, 'billing_address_2', $_REQUEST['baddress2'] );
		update_user_meta( $user_id, 'billing_city', $_REQUEST['bcity'] );
		update_user_meta( $user_id, 'billing_state', $_REQUEST['bstate'] );
		update_user_meta( $user_id, 'billing_postcode', $_REQUEST['bzipcode'] );
		update_user_meta( $user_id, 'billing_country', $_REQUEST['bcountry'] );
		update_user_meta( $user_id, 'billing_email', $_REQUEST['bconfirmemail'] );
		update_user_meta( $user_id, 'billing_phone', $_REQUEST['bphone'] );

		update_user_meta( $user_id, 'shipping_first_name', $_REQUEST['bfirstname'] );
		update_user_meta( $user_id, 'shipping_last_name', $_REQUEST['blastname'] );
		update_user_meta( $user_id, 'shipping_address_1', $_REQUEST['baddress1'] );
		update_user_meta( $user_id, 'shipping_address_2', $_REQUEST['baddress2'] );
		update_user_meta( $user_id, 'shipping_city', $_REQUEST['bcity'] );
		update_user_meta( $user_id, 'shipping_state', $_REQUEST['bstate'] );
		update_user_meta( $user_id, 'shipping_postcode', $_REQUEST['bzipcode'] );
		update_user_meta( $user_id, 'shipping_country', $_REQUEST['bcountry'] );

	}
}

function wc_ninja_remove_password_strength() {
	if ( wp_script_is( 'wc-password-strength-meter', 'enqueued' ) ) {
		wp_dequeue_script( 'wc-password-strength-meter' );
	}
}

add_action( 'wp_print_scripts', 'wc_ninja_remove_password_strength', 100 );

add_filter( "pmpro_registration_checks", "check_username" );

function check_username( $pmpro_continue_registration ) {
	$isValid                     = preg_match( '/^[-a-zA-Z0-9 .]+$/', $_REQUEST['username'] );
	$pmpro_error_fields[]        = "";
	$pmpro_continue_registration = true;
	if ( ! $isValid ) {
		pmpro_setMessage( __( "Invalid username. White space and Special character is not allowed.", 'paid-memberships-pro' ), "pmpro_error" );
		$pmpro_error_fields[]        = "username";
		$pmpro_continue_registration = false;
	}

	return $pmpro_continue_registration;
}

//conversio recommendation widget
//if ( function_exists( 'Receiptful' ) && method_exists( Receiptful()->recommendations, 'get_recommendations' ) ) {
//	add_action( 'woocommerce_after_single_product_summary', array(
//		Receiptful()->recommendations,
//		'display_recommendations'
//	), 12 );
//}


//woocommerce custom hooks
require_once( get_stylesheet_directory() . '/inc/class-empdev-woocommerce-hooks.php' );

//wholesale notice filter
if( class_exists( 'WWP_Wholesale_Prices' ) ) {
	require_once( get_stylesheet_directory() . '/woocommerce-wholesale-prices-premium/class-wwpp-wholesale-price-requirement.php' );
}

//au landing page map widgets
add_action( 'widgets_init', 'empdev_widgets_top_sidebar_map_left' );
function empdev_widgets_top_sidebar_map_left() {
	register_sidebar( array(
		'name' => __( 'Top Sidebar Map - Left', 'empassion' ),
		'id' => 'map-top-left-corner',
		'description' => __( 'Widgets in this area will be shown on map landing page.', 'empassion' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'empdev_widgets_top_sidebar_map_right' );
function empdev_widgets_top_sidebar_map_right() {
	register_sidebar( array(
		'name' => __( 'Top Sidebar Map - Right', 'empassion' ),
		'id' => 'map-top-right-corner',
		'description' => __( 'Widgets in this area will be shown on map landing page.', 'empassion' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
	) );
}

// **********************************************************************//
// ! Show shop navbar
// **********************************************************************//
function etheme_shop_navbar( $location = 'header', $exclude = array(), $force = false ) {

	$args['wishlist'] = ( ! in_array( 'wishlist', $exclude ) && etheme_woocommerce_installed() && etheme_get_option( 'top_wishlist_widget' ) == $location ) ? true : false ;
	$args['search'] = ( ! in_array( 'search', $exclude ) && etheme_get_option( 'search_form' ) == $location ) ? true : false;
	$args['cart'] = ( ! in_array( 'cart', $exclude ) && etheme_woocommerce_installed() && ! etheme_get_option( 'just_catalog' ) && etheme_get_option( 'cart_widget' ) == $location ) ? true : false ;

	if ( ! $args['wishlist'] && ! $args['search'] && ! $args['cart'] && ! $force ) return;

	//do_action( 'etheme_before_shop_navbar' );

	echo '<div class="navbar-header show-in-' . $location . '">';
	//if( $args['search'] ) etheme_search_form();
	if( $args['wishlist'] ) etheme_wishlist_widget();
	if( $args['cart'] ) etheme_top_cart();
	echo '</div>';

	//do_action( 'etheme_after_shop_navbar' );

}

//EMP Dev Woocommerce
require_once( get_stylesheet_directory() . '/emp-dev-wc/emp-dev-theme-functions.php' );
require_once( get_stylesheet_directory() . '/emp-dev-wc/class-emp-dev-wc-meta-option.php' );
require_once( get_stylesheet_directory() . '/emp-dev-wc/class-emp-dev-wc-static-helper.php' );
require_once( get_stylesheet_directory() . '/emp-dev-wc/emp-dev-wc-hooks.php' );
require_once( get_stylesheet_directory() . '/emp-dev-wc/emp-dev-login.php' );
require_once( get_stylesheet_directory() . '/emp-dev-wc/emp-meta.php' );
/*double check*/
if ( ! function_exists( 'rwmb_meta' ) ) {
    function rwmb_meta( $key, $args = '', $post_id = null ) {
        return false;
    }
}