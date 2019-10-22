<?php
/**
 * @package Urban Angels WooCommerce
 * @version 1.0
 */
/*
Plugin Name: Urban Angels WooCommerce
Plugin URI: http://urbanangels.co.uk/
Description: Features for WooCommerce
Author: Sue Johnson
Version: 1.0
Author URI: http://suesdesign.co.uk/
*/


/**
 * Change 'Add to Basket' to 'Buy Now' or 'Book now' on classes category
 */


// Change add to basket button text per category
add_filter( 'woocommerce_product_single_add_to_cart_text', 'urbanangels_custom_cart_button_text' );
function urbanangels_custom_cart_button_text() {
	global $product;
		if ( has_term( 'Classes', 'product_cat', $product->get_id() ) && $product->is_in_stock() ) {           
		return 'Book now';
	} else {
		return 'Buy now';
	}
}

// Change add to basket button text per category archive pages
add_filter( 'woocommerce_product_add_to_cart_text', 'urbanangels_archive_custom_cart_button_text' );
function urbanangels_archive_custom_cart_button_text() {
	global $product;
			if ( has_term( 'Classes', 'product_cat', $product->get_id() ) && $product->is_in_stock() ) {           
		return 'Book now';
	} else if ( !$product->is_in_stock() ) {           
		return 'Sold out';
	} else {
		return 'Buy now';
	}
}

/**
 * Remove the breadcrumbs
 */

add_action( 'init', 'woo_remove_wc_breadcrumbs' );
function woo_remove_wc_breadcrumbs() {
    remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
}

/**
 * Remove the sidebar
 */
add_action('init', 'disable_woo_commerce_sidebar');

function disable_woo_commerce_sidebar() {
	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10); 
}


/**
 * Exclude categories from showing
 */

add_action('init', 'urbanangels_disable_meta');

function urbanangels_disable_meta() {
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
}

/**
 * Change 'in stock' and 'out of stock' to 'available' and 'sold out'
 */

add_filter( 'woocommerce_get_availability_text', 'urbanangels_custom_get_availability_text', 99, 2 );
 
function urbanangels_custom_get_availability_text( $availability, $product ) {
$stock = $product->get_stock_quantity();
if ( $product->is_in_stock() && $product->managing_stock() && get_option( 'woocommerce_stock_format' ) == '' ){
	$availability = __( $stock . ' Available', 'woocommerce' );
	return $availability;
	} else if ( !$product->is_in_stock() ) {
		return 'Sold out';
	}
}

/**
 * Remove product data tabs
 */

add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );

function woo_remove_product_tabs( $tabs ) {

    unset( $tabs['description'] );      	// Remove the description tab
    unset( $tabs['reviews'] ); 			// Remove the reviews tab
    unset( $tabs['additional_information'] );  	// Remove the additional information tab

    return $tabs;
}

