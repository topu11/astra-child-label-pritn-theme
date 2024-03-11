<?php
/**
 * Order details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.8.0
 */

defined( 'ABSPATH' ) || exit;

$order = wc_get_order( $order_id ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited

if ( ! $order ) {
	return;
}
$first_name = $order->get_billing_first_name();
$last_name  = $order->get_billing_last_name();
$total_quantity_in_order=0;
// Concatenate first and last name to get the full name
$full_name = $first_name . ' ' . $last_name;
$order_created_date = $order->get_date_created();
$customer_id = $order->get_customer_id(); // WooCommerce customer ID

// Get the WordPress user ID associated with the customer (if available)
$user_id = get_post_meta($order->get_id(), '_customer_user', true);
$order_items = $order->get_items();
$notes = $order->get_customer_order_notes();
?>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
<div id="div_to_print">
<div class="enc-shop-page-header">

<h2><span class="glyphicon glyphicon-shopping-cart"></span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Löpnummer #<?=$order_id?></font></font><button type="button" onclick="generatePDF()" class="btn btn-lg btn-default pull-right hidden-print"><span class="glyphicon glyphicon-print"></span> <span style="font-family:sans-serif;"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Skriv ut</font></font></span></button>
</h2>
</div>
<table style="border: none !important;">
	<tr>
		<td><p>Beställare : <?=$first_name ? $full_name : get_display_name_else_user_name($user_id)?></p></td>
		<td><p>Ordern skapades : <?=$order_created_date->format('Y-m-d H:i:s');?></p></td>
	</tr>
	<tr>
		<td><p>Kundnummer : <?php echo isset($user_id) ?$user_id:$customer_id ;?></p></td>
		<td><p>Önskat leveransdatum : <?= $order->get_meta( 'Önskat leveransdatum (åååå-mm-dd)' ) ?></p></td>
	</tr>
</table>




<table style="border: none !important;">
	<thead>
		<tr>
			<th>Artikelnummer</th>
			<th>Artikel</th>
			<th>Kommentar</th>
			<th>Vikt</th>
			<th>Antal i kartong</th>
			<th>Antal kartonger</th>
		</tr>
	</thead>
    <tbody>
		<?php
		foreach ($order_items as $item) {
			$product_id = $item->get_product_id(); // Get product ID
			$product = wc_get_product($product_id);
			$total_quantity_in_order=$total_quantity_in_order+$item->get_quantity();
            ?>
			<tr>
				<td><?=get_post_meta($product_id, 'Serial', true); ?></td>
				<td><?=$product->get_title();?></td>
				<td><?=$product->get_short_description();?></td>
				<td><?=get_post_meta($product_id,'_weight',true);?></td>
				<td><?=get_post_meta($product_id,'quantity-in-carton',true);?></td>
				<td><?=$item->get_quantity();?></td>
			</tr>
			<?php 

		}
		?>
	</tbody>
</table>
<div class="well">
              <p>Antal artiklar (allt utom glutenfritt &amp; tillbehör): <strong><?=$total_quantity_in_order;?></strong> kartonger</p>
              <p>Glutenfritt: <strong>0</strong> kartonger</p>
              <p>Tillbehör: <strong>0</strong> kartonger</p>
              <p>Önskat leveransdatum: <span id=""><?=get_post_meta($order->get_id(),'Önskat leveransdatum (åååå-mm-dd)',true)?></span></p>
              <p>Other comment <span id=""><?=$notes[array_key_last($notes)]->comment_content ?></span></p>
			  
</div>
</div>
<div>
<a href="<?=site_url('/my-account')?>"  class="btn btn-sm btn-success"><i class="fas fa-arrow-left"></i> Tillbaka</a>
<a href="<?=site_url('/my-account/re-order-page/').'?order_again='.$order_id ?>"  class="btn btn-sm btn-warning"><i class="fas fa-arrow-up"></i> Beställ igen</a>
</div>
<style>
/* 	.elementor-container.elementor-column-gap-default{
	background-color: white !important;
  }
  
  .btn-default
  {
	color: #333 !important;
    background-color: #fff !important;
    border-color: #ccc !important;
  } */
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.8.0/html2pdf.bundle.min.js" integrity="sha512-w3u9q/DeneCSwUDjhiMNibTRh/1i/gScBVp2imNVAMCt6cUHIw6xzhzcPFIaL3Q1EbI2l+nu17q2aLJJLo4ZYg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
	const generatePDF=()=>{
		var element = document.getElementById('div_to_print');
         var opt = {
		  margin:       1,
		  filename:     'order-details-<?=$order->get_id()?>.pdf',
		  image:        { type: 'jpeg', quality: 1 },
		  html2canvas:  { scale: 2 },
		  jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
		};

		// New Promise-based usage:
		//html2pdf().set(opt).from(element).save();

		// Old monolithic-style usage:
		html2pdf(element, opt);
	}
	localStorage.clear();
</script>