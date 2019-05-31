<?php
 function woo_comm_coupon_restrictions(){
    // Only for admin users (not accessible) for other users)
    if( ! current_user_can( 'manage_options' ) ) return;

    global $wpdb;

    // Set HERE the product IDs without discount
    $product_ids = array( 37, 67 );

    $product_ids = implode( ',', $product_ids );  // String conversion

    // SQL query: Bulk update coupons "excluded product" restrictions
    $wpdb->query( "
        UPDATE {$wpdb->prefix}postmeta as pm
        SET pm.meta_value = '$product_ids'
        WHERE pm.meta_key = 'exclude_product_ids'
        AND post_id IN (
            SELECT p.ID
            FROM {$wpdb->prefix}posts as p
            WHERE p.post_type = 'shop_coupon'
            AND p.post_status = 'publish'
        )
    " );
}
// Run this function once (and comment it or remove it)
woo_comm_coupon_restrictions();

  ?>
