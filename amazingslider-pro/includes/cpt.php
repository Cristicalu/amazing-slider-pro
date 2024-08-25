<?php

// Create slides CPT
function asp_slides_post_type() {
    register_post_type( 'slides',
        array(
            'label' => __( 'Slides' ),
            'public' => true,
            'show_in_rest' => true,
      		'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
            'has_archive' => true,
            'rewrite'   => array( 'slug' => 'my-slides' ),
            'menu_position' => 5,
            'taxonomies' => array('slider')
        )
    );
}
add_action( 'init', 'asp_slides_post_type' );


// Add Slider taxonomy
function asp_create_slider_taxonomy() {
    register_taxonomy('slider', 'slides', array(
        'hierarchical' => false,
        'labels' => array(
            'name' => _x( 'Slider', 'taxonomy general name' ),
            'singular_name' => _x( 'Slider', 'taxonomy singular name' ),
            'menu_name' => __( 'Slider' ),
            'all_items' => __( 'All Sliders' ),
            'edit_item' => __( 'Edit Slider' ), 
            'update_item' => __( 'Update Slider' ),
            'add_new_item' => __( 'Add Slider' ),
            'new_item_name' => __( 'New Slider' )
        ),
    'show_ui' => true,
    'show_in_rest' => true,
    'show_admin_column' => true,
    ));

}
add_action( 'init', 'asp_create_slider_taxonomy', 0 );