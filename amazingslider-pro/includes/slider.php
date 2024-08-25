<?php

// Slider PRO
function asp_function($attr) {
	
	//Shortcode params
	$default = array(
		'dots' => true,
		'slidestoshow' => '1',
		'slidestoscroll' => '1'
	);

	$option = shortcode_atts( $default, $attr, 'asp-shortcode' );
	
	wp_enqueue_script('asp_script');
	
	$init_swiper = '
	var slider = new Swiper(".gallery-slider", {
    speed: 900,
	slidesPerView: '.$option['slidestoshow'].',
	slidesPerGroup:'.$option['slidestoscroll'].',
    loop: true,
    loopedSlides: 10,
    noSwiping: true,
    keyboard: {
        enabled: true
    },
    mousewheel: {
        thresholdDelta: 70
    },
    noSwipingClass: "swiper-slide",
  	pagination: {
   	    el: ".swiper-pagination",
    	clickable: true,  	  
	 }
	});';

	wp_add_inline_script( 'asp_script', $init_swiper, 'before' );

	
	// Output
	$result .= '<div class="amazing-slider">';
	$result .= '<div class="swiper-container gallery-slider">';
	$result .= '<div class="swiper-wrapper">';

	// Standard API query arguments
	$args = array(
	  'orderby' => 'date',
	);

	// Put into the `add_query_arg();` to build a URL for use
	// Just an alternative to manually typing the query string
	$url = add_query_arg( $args, rest_url('wp/v2/slides') );

	// A standard GET request the WordPress way
	$stuff = wp_remote_get($url);

	// Get just the body of that request (if successful)
	$body = wp_remote_retrieve_body($stuff);

	// Turn the returned JSON object into a PHP object
	$posts = json_decode($body);

	// loop slides
	if (!empty($posts)) : 
		foreach ($posts as $post) : 
			$showfi = $post->fimg_url;	
			$showtitle = $post->title->rendered;
			$url_cf = $post->custom_fields->asp_meta_value_key;	
			$result .='<div class="swiper-slide"><img title="'. esc_html($showtitle) .'" src="' . esc_url($showfi) . '" alt="'.esc_html($showtitle) .'"/>';
			$result .='<div class="content"><h1 class="blur-anim">'. esc_html($showtitle) .'</h1><a class="blur-anim" href="' . esc_url($url_cf) . '">View more →</a></div>';
			$result .='</div>';
	 	endforeach;
	endif; 
	
	$result .='</div>';
	$result .='</div>';
	$result .='<div class="swiper swiper-container gallery-thumbs">';
	$result .='<div class="swiper-wrapper">';

	//loop thumbs
	if (!empty($posts)) : 
		foreach ($posts as $post) : 
			$showfi = $post->fimg_url;	
			$showtitle = $post->title->rendered;
			$result .='<div class="swiper-slide"><img title="'. esc_html($showtitle) .'" src="' . esc_url($showfi) . '" alt="'.esc_html($showtitle) .'"/></div>';
		endforeach;
	endif; 

	$result .='</div>';
	
	if ( $option['dots'] == 'true' ) {
		$result .='<div class="swiper-pagination"></div>';
    }

	$result .='</div>';	
	$result .='</div>';

	return $result;
	
}