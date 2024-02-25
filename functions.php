<?php
/**
 * Astra child Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Astra child
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define( 'CHILD_THEME_ASTRA_CHILD_VERSION', '1.0.0' );

/**
 * Enqueue styles
 */
function child_enqueue_styles() {

	wp_enqueue_style( 'astra-child-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_ASTRA_CHILD_VERSION, 'all' );

}

add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );

function mytheme_add_woocommerce_support() {
  add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );


function premier_contractors_cpts()
{
    
	register_post_type(
		'current_campaigns',
		array(
			'labels' => array(
				'name' => __('Aktuella kampanjer'),
				'singular_name' => __('Aktuella kampanjer')
			),
			'public' => true,
			'show_in_menu' => true,
			'has_archive' => false,
			'supports' => array('title', 'thumbnail', 'editor')
		)
	);

}

add_action("init", "premier_contractors_cpts");


add_action( 'woocommerce_thankyou', 'bbloomer_redirectcustom');
  
function bbloomer_redirectcustom( $order_id ){
   
    $cart = WC()->cart;

  // Check if the cart is not empty
  if (! $cart->is_empty()) {
      // Clear the cart
      $cart->empty_cart();
  }

    $order = wc_get_order( $order_id );
	$retun_url='/my-account/view-order/'.$order_id;
    $url = site_url($retun_url);
    if ( ! $order->has_status( 'failed' ) ) {
        wp_safe_redirect( $url );
        exit;
    }

}

// function woocommerce_after_checkout_billing_form($order_id) {
//     // Replace 'billing_first_name' with the desired checkout field name
//     $field_name = 'billing_first_name';

//     // Replace 'John' with the desired static value
//     $field_value = 'John TEST PABNA';

//     // Set the field value
//     update_post_meta($order_id, '_' . $field_name, $field_value);
// }

// // Hook to set checkout field value after order is created
// add_action('woocommerce_after_checkout_billing_form', 'woocommerce_after_checkout_billing_form');

// Enqueue custom-date-script.js
// function enqueue_custom_date_script() {
//     wp_enqueue_script(
//         'custom-date-script', // Handle name
//         get_bloginfo( 'stylesheet_directory' ) . '/js/custom-date-script.js', // Path to your script file
//         array('jquery'), // Dependencies, if any
//         null, // Version (null will use the theme's version)
//         true // Load in footer
//     );
// }

// add_action('wp_enqueue_scripts', 'enqueue_custom_date_script');

function enqueue_datepicker() {
    // Enqueue jQuery UI library
    wp_enqueue_script('jquery-ui-core');

    // Enqueue jQuery UI Datepicker script
    wp_enqueue_script('jquery-ui-datepicker');

    // Enqueue the script for your custom functionality
    wp_enqueue_script('custom-date-script-child-theme', get_bloginfo( 'stylesheet_directory' ) . '/js/custom-date-script.js', array('jquery-ui-datepicker'), null, true);

    // Enqueue the stylesheet for jQuery UI Datepicker
    wp_enqueue_style('jquery-ui-datepicker-style', 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');

    wp_enqueue_style('custom-style-astra-child', get_bloginfo( 'stylesheet_directory' ) . '/css/style.css', array(), '1.0', 'all');

    wp_enqueue_script('child-theme-html2js', 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4', array(''), null, true);

}

add_action('wp_enqueue_scripts', 'enqueue_datepicker');

// Make custom column sortable


function custom_my_account_menu_items_child_theme( $items ) {
    unset($items['downloads']);
    return $items;
}
add_filter( 'woocommerce_account_menu_items', 'custom_my_account_menu_items_child_theme' );



// .your-class {
//     background-image: url('path/to/your/image.jpg');
//     background-size: cover; /* Adjust as needed */
//     background-position: center center; /* Adjust as needed */
//     background-repeat: no-repeat;
// }

// Rename My Account tabbed menu items
add_filter('woocommerce_account_menu_items', 'rename_orders_tab_in_my_account', 10, 1);

function rename_orders_tab_in_my_account($menu_items) {
    // Rename the "Beställning" tab to "Orderhistorik"
    if (isset($menu_items['orders'])) {
        $menu_items['orders'] = __('Orderhistorik', 'text-domain');
    }

    return $menu_items;
}

add_filter( 'woocommerce_purchase_note_order_statuses', 'remove_customer_order_notes' );
function remove_customer_order_notes( $order_statuses ){
return array();
}


function dd($variable)
{
    echo '<pre>';
    var_dump($variable);
    echo '</pre>';
    exit;
}

function get_the_contest_encoder_it_ltd()
{
    $one_week_ago = date('Y-m-d', strtotime('-1 week'));

    // Query to get the highest paid orders in the last week
    $args = array(
        'date_query' => array(
            array(
                'after'     => $one_week_ago,
                'inclusive' => true,
            ),
        ),
        'orderby'    => 'meta_value_num',
        'meta_key'   => '_order_total',
        'order'      => 'DESC',
        'limit'      => -1, // Set to -1 to retrieve all orders
    );
    
    $orders = wc_get_orders($args);
    $items_count_array=array();
$customer_id_array=array();
$price_array=array();
$customer_name_array=array();
$tem_array_cutomer_used=array();
$details_array_final=array();
foreach ($orders as $order) {
    $item_count=0;
    // $order_id    = $order->get_id();
    // $order_total = $order->get_total();
    $first_name = $order->get_billing_first_name();
    $last_name  = $order->get_billing_last_name();

    // Concatenate first and last name to get the full name
    $full_name = $first_name . ' ' . $last_name;
 
    if(empty($first_name))
    {
        
        $full_name=encoder_get_user_email_by_customer_id($order->get_customer_id());
    }
    foreach ($order->get_items() as $item) {
        $item_count += $item->get_quantity();
    }
    array_push($items_count_array,$item_count);
    array_push($price_array,$order->get_total());
    array_push($customer_id_array, $order->get_customer_id());
    //array_push($customer_name_array, $full_name);
    $details_array=[
        'count'=>$item_count,
        'price'=>$order->get_total(),
        'customer_id'=>$order->get_customer_id(),
        'customer_name'=>$full_name
    ];
    array_push($details_array_final,$details_array);

}
rsort($items_count_array);
//custom_dd($details_array_final);
$sl=1;
$details_array_best_five=array();
    foreach ($items_count_array as $key_count=>$value_count) {
    foreach($details_array_final as $key_details=>$value_details)
    {
        if($value_details['count'] == $value_count && !in_array($value_details['customer_id'],$tem_array_cutomer_used))
        {
            array_push($details_array_best_five,$value_details);
            array_push($tem_array_cutomer_used,$value_details['customer_id']);
            $sl++;
        } 
        if($sl>5)
        {
            break;
        }  
        //  }else
        //  {
        //     break;
        //  }
    }
    //    if(count($tem_array_cutomer_used)==5)
    //    {
    //     break;
    //    } 
    }

    return $details_array_best_five;
}
function encoder_get_user_email_by_customer_id($customer_id)
{
    
    global $wpdb;
    $wc_customer_lookup = $wpdb->prefix . 'wc_customer_lookup'; 
    $sql="SELECT *from $wc_customer_lookup where user_id=$customer_id";
    $result = $wpdb->get_row( $wpdb->prepare($sql));
   
    if(!empty( $result))
    {
        $full_name=$result->first_name.' '.$result->last_name;
        return $result->first_name ? $full_name : $result->email;
    }else
    {
        return ;
    }
}


add_filter( 'woocommerce_enable_order_notes_field', '__return_false', 9999 );


add_filter( 'woocommerce_checkout_fields' , 'bbloomer_custom_order_notes' );
 
function bbloomer_custom_order_notes( $fields ) {
   $fields['billing']['new_order_notes'] = array(
      'type' => 'textarea',
      'label' => 'Beställningsanteckningar',
      'class' => array('form-row-wide'),
      'clear' => true,
      'priority' => 999,
   );
   return $fields;
}
 
// 3. Save to existing order notes
 
add_action( 'woocommerce_checkout_update_order_meta', 'bbloomer_custom_field_value_to_order_notes', 10, 2 );
 
function bbloomer_custom_field_value_to_order_notes( $order_id, $data ) {
   if ( ! is_object( $order_id ) ) {
      $order = wc_get_order( $order_id );
   }
   $order->set_customer_note( isset( $data['new_order_notes'] ) ? $data['new_order_notes'] : '' );
   wc_create_order_note( $order_id, $data['new_order_notes'], true, true );
   $order->save();
}


function custom_remove_order_date_column( $columns ) {
    unset( $columns['order-date'] );
    unset( $columns['order-status'] );
    unset( $columns['order-total'] );
    return $columns;
}
add_filter( 'woocommerce_my_account_my_orders_columns', 'custom_remove_order_date_column' );



function custom_hide_order_date_column_css() {
    echo '<style>.woocommerce-orders-table .woocommerce-button.button.view { display: none; }</style>';
}
add_action( 'wp_head', 'custom_hide_order_date_column_css' );



function custom_my_account_orders_query( $query_args ) {
    // Set the pagination limit to 5
    $query_args['posts_per_page'] = 5;
    
    return $query_args;
}
add_filter( 'woocommerce_my_account_my_orders_query', 'custom_my_account_orders_query' );

add_action('woocommerce_before_customer_login_form','woocommerce_before_customer_login_form');

function woocommerce_before_customer_login_form()
{
    // wp_enqueue_script('custom-logout-script', get_bloginfo( 'stylesheet_directory' ) . '/js/clear.js', array('jquery-ui-datepicker'), null, true);
    echo '<img src="https://wordpress-474365-1656051.cloudwaysapps.com/wp-content/uploads/2023/03/logo_header.png" alt="">';
}



 
// Get the visitor's IP address, considering proxies or load balancers

function getTheIPAddress()
{
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ipAddress = $_SERVER['HTTP_CLIENT_IP'];
    } else {
        $ipAddress = $_SERVER['REMOTE_ADDR'];
    }
    
    // Display the IP address
    return  $ipAddress;
}
function get_display_name_else_user_name()
{
    global $wpdb;
    $user_id=get_current_user_id();
    $wc_customer_lookup = $wpdb->prefix . 'wc_customer_lookup'; 
    $sql="SELECT *from $wc_customer_lookup where user_id=$user_id";
    $result = $wpdb->get_row( $wpdb->prepare($sql));
   
    if(!empty( $result))
    {
        $full_name=$result->first_name.' '.$result->last_name;
        return $result->first_name ? $full_name : $result->email;
    }else
    {
        return ;
    }
}

function getLastFiveOderByCustomer()
{
    global $wpdb;
    $user=wp_get_current_user();
    $wp_posts=$wpdb->prefix . 'posts';
    $wp_postmeta=$wpdb->prefix . 'postmeta';

    $sql="SELECT $wp_posts.ID FROM $wp_posts INNER join $wp_postmeta on  $wp_posts.ID=$wp_postmeta.post_id and $wp_posts.post_type='shop_order' and $wp_posts.post_status not in ('trash') and $wp_postmeta.meta_key='_customer_user' and $wp_postmeta.meta_value=$user->ID ORDER BY $wp_posts.ID desc limit 5";
    return $wpdb->get_results($sql);

    //return $order_prev = wc_get_order( $order_id->ID);
}