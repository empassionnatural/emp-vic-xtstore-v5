<?php
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css', array('bootstrap'));
    

    if ( is_rtl() ) {
    	wp_enqueue_style( 'rtl-style', get_template_directory_uri() . '/rtl.css');
    }
    
    $timestamp = strtotime("now");
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('parent-style', 'bootstrap'),'0.1.'.$timestamp
    );

    //wp_enqueue_script( 'custom-js', get_stylesheet_directory_uri() . '/js/custom.js', array(), '', true );

}

add_action('pmpro_after_checkout', 'sync_woo_billing_func');

if(!function_exists('sync_woo_billing_func')){
	function sync_woo_billing_func(){
		global $current_user;
		$user_id = get_current_user_id();

		update_user_meta($user_id, 'billing_first_name', $_REQUEST['bfirstname']);
		update_user_meta($user_id, 'billing_last_name', $_REQUEST['blastname']);
		update_user_meta($user_id, 'billing_address_1', $_REQUEST['baddress1']);
		update_user_meta($user_id, 'billing_address_2', $_REQUEST['baddress2']);
		update_user_meta($user_id, 'billing_city', $_REQUEST['bcity']);
		update_user_meta($user_id, 'billing_state', $_REQUEST['bstate']);
		update_user_meta($user_id, 'billing_postcode', $_REQUEST['bzipcode']);
		update_user_meta($user_id, 'billing_country', $_REQUEST['bcountry']);
		update_user_meta($user_id, 'billing_email', $_REQUEST['bconfirmemail']);
		update_user_meta($user_id, 'billing_phone', $_REQUEST['bphone']);

		update_user_meta($user_id, 'shipping_first_name', $_REQUEST['bfirstname']);
		update_user_meta($user_id, 'shipping_last_name', $_REQUEST['blastname']);
		update_user_meta($user_id, 'shipping_address_1', $_REQUEST['baddress1']);
		update_user_meta($user_id, 'shipping_address_2', $_REQUEST['baddress2']);
		update_user_meta($user_id, 'shipping_city', $_REQUEST['bcity']);
		update_user_meta($user_id, 'shipping_state', $_REQUEST['bstate']);
		update_user_meta($user_id, 'shipping_postcode', $_REQUEST['bzipcode']);
		update_user_meta($user_id, 'shipping_country', $_REQUEST['bcountry']);

	}
}

/*Check the billing address if its PO BOX*/
/*
add_filter('woocommerce_update_order_review_fragments', 'check_pobox_address_ajax');
function check_pobox_address_ajax($array){
	
    $address  = ( isset( $_REQUEST['s_address'] ) ) ? $_REQUEST['s_address'] : $_REQUEST['address'];
    $address2  = ( isset( $_REQUEST['s_address_2'] ) ) ? $_REQUEST['s_address_2'] : $_REQUEST['address_2'];
    $postcode = ( isset( $_REQUEST['s_postcode'] ) ) ? $_REQUEST['s_postcode'] : $_REQUEST['postcode'];
    $city = ( isset( $_REQUEST['s_city'] ) ) ? $_REQUEST['s_city'] : $_REQUEST['city'];
    	
    $replace  = array(" ", ".", ",", "-");
    $address  = strtolower( str_replace( $replace, '', $address ) );
    $address2  = strtolower( str_replace( $replace, '', $address2 ) );
    $postcode = strtolower( str_replace( $replace, '', $postcode ) );
    $city = strtolower( str_replace( $replace, '', $city ) );
    $array['city'] = $city;
    $array['postcode'] = $postcode;
    $array['address2'] = $address2;
    $array['address'] = $address;
    $array['is_pobox'] = false;
    if ( strstr( $address, 'pobox' ) || strstr( $address2, 'pobox' ) || strstr( $postcode, 'pobox' )  || strstr( $city, 'pobox' ) || strstr( $address, 'pob' ) || strstr( $address2, 'pob' ) || strstr( $postcode, 'pob' ) || strstr( $city, 'pob' ) ) {
		$array['is_pobox'] = true;
	}
	return $array;

}


add_filter('woocommerce_after_checkout_validation', 'check_pobox_address');

function check_pobox_address( $posted ) {
  global $woocommerce;

  $address  = ( isset( $posted['shipping_address_1'] ) ) ? $posted['shipping_address_1'] : $posted['billing_address_1'];
  $address2  = ( isset( $posted['shipping_address_2'] ) ) ? $posted['shipping_address_2'] : $posted['billing_address_2'];
  $postcode = ( isset( $posted['shipping_postcode'] ) ) ? $posted['shipping_postcode'] : $posted['billing_postcode'];
  $city = ( isset( $posted['shipping_city'] ) ) ? $posted['shipping_city'] : $posted['billing_city'];
  	
  $replace  = array(" ", ".", ",", "-");
  $address  = strtolower( str_replace( $replace, '', $address ) );
  $address2  = strtolower( str_replace( $replace, '', $address2 ) );
  $postcode = strtolower( str_replace( $replace, '', $postcode ) );
  $city = strtolower( str_replace( $replace, '', $city ) );

   if ( strstr( $address, 'pobox' ) || strstr( $address2, 'pobox' ) || strstr( $postcode, 'pobox' )  || strstr( $city, 'pobox' ) || strstr( $address, 'pob' ) || strstr( $address2, 'pob' ) || strstr( $postcode, 'pob' ) || strstr( $city, 'pob' ) ) {

    
    $chosen_methods = WC()->session->get( 'chosen_shipping_methods' );
  	$chosen_shipping = $chosen_methods[0]; 
  	$packages = WC()->shipping->get_packages();
  	foreach ($packages as $i => $package) {
	    $chosen_method = isset($chosen_shipping) ? $package['rates'][$chosen_shipping]->label : '';
	}
	if($chosen_method != 'PO Box'){
		WC_add_notice( "<strong> YOU NEED TO SELECT PO BOX SHIPPING. </strong>",'error' );
	}

  }
}
*/
function wc_ninja_remove_password_strength() {
  if ( wp_script_is( 'wc-password-strength-meter', 'enqueued' ) ) {
    wp_dequeue_script( 'wc-password-strength-meter' );
  }
}
add_action( 'wp_print_scripts', 'wc_ninja_remove_password_strength', 100 );

add_filter( "pmpro_registration_checks", "check_username" );

function check_username($pmpro_continue_registration){
  $isValid = preg_match('/^[-a-zA-Z0-9 .]+$/',$_REQUEST['username']);
  $pmpro_error_fields[] = ""; 
  $pmpro_continue_registration = true;  
  if(!$isValid){
      pmpro_setMessage( __( "Invalid username. White space and Special character is not allowed.", 'paid-memberships-pro' ), "pmpro_error" );
      $pmpro_error_fields[] = "username";
      $pmpro_continue_registration = false; 
  }

  return $pmpro_continue_registration;  
}


