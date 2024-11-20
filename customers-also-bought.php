<?php
/*
Plugin Name: Customers Also Bought Woocommerce Plugin
Description: Displays a section of products that customers also bought when viewing a product.
Version: 1.0
Author: Sumit Jha
Author URI: http://sumitjha.info.np/
*/

// Prevent direct access to the file
if (!defined('ABSPATH')) {
    exit;
}

// Setup
define('CAB_PLUGIN_URL', plugin_dir_url(__FILE__));

// Includes
include('includes/enqueue.php');
include('includes/shortcode.php');

// Hooks
add_action('wp_enqueue_scripts', 'cab_frontend_scripts', 100);
add_action('wp_enqueue_scripts', 'cab_enqueue_slick_carousel_assets');