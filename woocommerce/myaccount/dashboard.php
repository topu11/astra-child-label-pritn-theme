<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$allowed_html = array(
	'a' => array(
		'href' => array(),
	),
);
?>
<div style="padding-bottom: 9px;
    margin: 40px 0 20px;
    border-bottom: 1px solid #eee;">
<h4>Kontrollpanelen</h2>
</div>
<div style="padding-bottom: 80px;border-bottom: 1px solid #eee;">
<p>
	<?php
      
	echo _e('Välkommen','woocommerce').' '.get_display_name_else_user_name();
	// printf(
	// 	/* translators: 1: user display name 2: logout url */
	// 	wp_kses( __( 'Hello %1$s (not %1$s? <a href="%2$s">Log out</a>)', 'woocommerce' ), $allowed_html ),
	// 	'<strong>' . esc_html( $current_user->display_name ) . '</strong>',
	// 	esc_url( wc_logout_url() )
	// );
	?>
</p>
<p>Ditt kundnummer är: <?=get_current_user_id()?></p>
</div>
<div>
	<img src="https://wordpress-474365-1656051.cloudwaysapps.com/wp-content/uploads/2023/03/logo_header.png" alt="">
</div>


<?php
	/**
	 * My Account dashboard.
	 *
	 * @since 2.6.0
	 */
	do_action( 'woocommerce_account_dashboard' );

	/**
	 * Deprecated woocommerce_before_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_before_my_account' );

	/**
	 * Deprecated woocommerce_after_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_after_my_account' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
