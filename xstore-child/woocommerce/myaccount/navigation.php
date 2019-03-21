<?php
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_account_navigation' );
?>
<?php $user_info = get_userdata( get_current_user_id() ); ?>
<nav class="woocommerce-MyAccount-navigation">
	<ul>
        <li class="navigation-header" style="height: 121px;">
            <div class="user-icon">
                <i class="icon vc_icon_element-icon fa fa-user"></i>
            </div>
            <div class="user-detail">
                <h3><?php echo esc_attr( $user_info->first_name ); ?> <?php echo esc_attr( $user_info->last_name ); ?></h3>
                <p><?php echo esc_attr( $user_info->user_email ); ?></p>
            </div>
        </li>

		<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
			<li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">

                <a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><i class="icon vc_icon_element-icon fa fa-<?php empdev_myaccount_nav_icon($label);?>"></i><span><?php echo esc_html( $label ); ?></span></a>
			</li>
		<?php endforeach; ?>
	</ul>
</nav>

<?php do_action( 'woocommerce_after_account_navigation' ); ?>
