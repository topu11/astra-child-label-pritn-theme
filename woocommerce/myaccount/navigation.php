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
 * @package WooCommerce\Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
do_action( 'woocommerce_before_account_navigation' );
?>

<nav class="woocommerce-MyAccount-navigation">
	<ul>
		<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
			<li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
				<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( $label ); ?></a>
			</li>
		<?php endforeach; ?>
	</ul>
	
	<ul style="margin-top: 20px;">
		<li style="
    color: #fffff !important;
    display: block;
    background: #205B38;
    padding: 10px;
    text-align: center;
">
          <a href="<?=site_url('/aktuella-kampanjer')?>" style="color: #ffffff !important;
    display: block;
    background: #205B38;
    padding: 10px;
    text-align: center">Aktuella kampanjer</a>
		</li>
	   <?php
	 global $wpdb;
$posttable=$wpdb->prefix.'posts';
$current_campaigns = $wpdb->get_results("SELECT * from $posttable as wp_posts where wp_posts.post_type='current_campaigns' and wp_posts.post_status = 'publish'  ORDER BY wp_posts.menu_order, wp_posts.post_date desc;");

	 foreach ( $current_campaigns as $key=>$value )
	 {
        ?>
	         <li>
				<a href="<?=get_permalink($value->ID)?>">
				<h5 style="color:#528000;"><?=$value->post_title?></h5>
				<?=$value->post_content;?>
				</a>
				
			  </li> 
	    <?php
	 }
	
	 ?>
	</ul>
</nav>

<?php do_action( 'woocommerce_after_account_navigation' ); ?>