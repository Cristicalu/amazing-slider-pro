<?php

// Add featured image url in wp api
add_action('rest_api_init', 'register_rest_images' );
function register_rest_images(){
    register_rest_field( array('slides'),
        'fimg_url',
        array(
            'get_callback'    => 'asp_get_rest_featured_image',
            'update_callback' => null,
            'schema'          => null,
        )
    );
}
function asp_get_rest_featured_image( $object, $field_name, $request ) {
    if( $object['featured_media'] ){
        $img = wp_get_attachment_image_src( $object['featured_media'], 'app-thumb' );
        return $img[0];
    }
    return false;
}

// Add URL custom field in wp api
function asp_create_custom_meta_in_REST()
{
    $post_types = ["slides"]; //post types that will include custom fields
    foreach ($post_types as $post_type) {
        register_rest_field(
            $post_type,
            'custom_fields',
            [
                'get_callback'    => 'expose_custom_fields',
                'schema'          => null,
            ]
        );
    }
}
function expose_custom_fields($object)
{
    $fields = ["asp_meta_value_key"]; 
    $post_ID = $object['id'];
    $return_value = [];
    foreach ($fields as $field) {
        $field = strval($field);
        $meta = get_post_meta($post_ID, $field);
        if (count($meta) > 1)
            $return_value[$field] = $meta;
        else if ($meta[0])
            $return_value[$field] = $meta[0];
        else
            $return_value[$field] = ""; 
    }
    if ($return_value)
        return $return_value;
    return [];
}
add_action('rest_api_init', 'asp_create_custom_meta_in_REST');
