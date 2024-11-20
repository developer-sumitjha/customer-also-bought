<?php

// Function to get products that were bought together with the current product
function cab_get_customers_also_bought($product_id) {
    global $wpdb;

    $results = $wpdb->get_results($wpdb->prepare("
        SELECT order_item_meta_2.meta_value as related_product_id, COUNT(*) as frequency
        FROM {$wpdb->prefix}woocommerce_order_items as order_items_1
        JOIN {$wpdb->prefix}woocommerce_order_itemmeta as order_item_meta_1
            ON order_items_1.order_item_id = order_item_meta_1.order_item_id
        JOIN {$wpdb->prefix}woocommerce_order_items as order_items_2
            ON order_items_1.order_id = order_items_2.order_id
        JOIN {$wpdb->prefix}woocommerce_order_itemmeta as order_item_meta_2
            ON order_items_2.order_item_id = order_item_meta_2.order_item_id
        WHERE order_item_meta_1.meta_key = '_product_id'
          AND order_item_meta_1.meta_value = %d
          AND order_item_meta_2.meta_key = '_product_id'
          AND order_item_meta_2.meta_value != %d
        GROUP BY related_product_id
        ORDER BY frequency DESC
        LIMIT 15
    ", $product_id, $product_id));

    $related_product_ids = [];

    if ($results) {
        foreach ($results as $result) {
            $related_product_ids[] = $result->related_product_id;
        }
    }

    return $related_product_ids;
}

// Function to generate the "Customers Also Bought" HTML content
function cab_customers_also_bought_shortcode() {
    if (!is_product()) return ''; // Make sure it's only displayed on product pages

    global $product;
    if (!$product) return '';

    $product_id = $product->get_id();

    // Get products bought together with the current product
    $related_products = cab_get_customers_also_bought($product_id);

    // Start generating the HTML output
    $output = '';

    if (!empty($related_products)) {
        $output .= '<div class="cab-customers-also-bought">';
        $output .= '<div class="cab-related-products">'; // Changed <ul> to <div> for Slick Carousel compatibility

        foreach ($related_products as $related_product_id) {
            $related_product = wc_get_product($related_product_id);
            if ($related_product) {
                $output .= '<div class="cab-carousel-item">'; // Changed <li> to <div>
                $output .= '<a href="' . get_permalink($related_product->get_id()) . '">';
                $output .= '<div class="img-cont">' . $related_product->get_image() . '</div>';
                $output .= '<h4>' . $related_product->get_name() . '</h4>';
                // Add product price
                $output .= '<p class="price">' . $related_product->get_price_html() . '</p>';
                $output .= '</a>';
                $output .= '</div>'; // Closing the carousel item
            }
        }

        $output .= '</div>'; // Closing .cab-related-products
        $output .= '</div>'; // Closing .cab-customers-also-bought
    }

    return $output;
}


// Register the shortcode
function cab_register_shortcode() {
    add_shortcode('customers_also_bought', 'cab_customers_also_bought_shortcode');
}
add_action('init', 'cab_register_shortcode');
