<?php
/* 
Plugin Name: Amazing Slider PRO
Description: Lightweight slider with shortcode control
Author: Cristian Calu 
Version: 1.0
*/

if (!defined('ABSPATH')) exit; // Exit if accessed directly

// Includes
include_once(__DIR__ . '/includes/cpt.php');
include_once(__DIR__ . '/includes/api.php');
include_once(__DIR__ . '/includes/metabox.php');
include_once(__DIR__ . '/includes/slider.php');


// Register and enqueue scripts and styles
add_action('wp_print_scripts', 'asp_register_scripts');
add_action('wp_print_styles', 'asp_register_styles');

function asp_register_scripts() {
	if (!is_admin()) {
		// register 
		wp_register_script('swiper-bundle-js', plugins_url('assets/js/swiper-bundle.min.js', __FILE__), array( 'jquery' ), '', true);
		wp_register_script('asp_script', plugins_url('assets/js/script.js', __FILE__), array( 'jquery' ), '', true);
		// enqueue 
		wp_enqueue_script('swiper-bundle-js');
	}
}
function asp_register_styles() {
	// register 
		wp_register_style('swiper-bundle-css', plugins_url('assets/css/swiper-bundle.min.css', __FILE__));
		wp_register_style('asp_styles', plugins_url('assets/css/style.css', __FILE__));
	// enqueue 
		wp_enqueue_style('swiper-bundle-css');
		wp_enqueue_style('asp_styles');
}


// Slider Shortcode
add_shortcode('asp-shortcode', 'asp_function');








