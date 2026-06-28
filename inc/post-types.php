<?php

defined( 'ABSPATH' ) || exit;

add_action( 'init', 'skyeye_register_post_types' );

function skyeye_register_post_types() {
    register_post_type( 'portfolio', [
        'labels' => [
            'name'               => 'Portfolio',
            'singular_name'      => 'Portfolio Item',
            'add_new'            => 'Add New',
            'add_new_item'       => 'Add New Portfolio Item',
            'edit_item'          => 'Edit Portfolio Item',
            'new_item'           => 'New Portfolio Item',
            'view_item'          => 'View Portfolio Item',
            'search_items'       => 'Search Portfolio',
            'not_found'          => 'No portfolio items found',
            'not_found_in_trash' => 'No portfolio items found in Trash',
        ],
        'public'            => true,
        'has_archive'       => 'portfolio',
        'rewrite'           => [ 'slug' => 'portfolio' ],
        'menu_icon'         => 'dashicons-video-alt',
        'menu_position'     => 5,
        'supports'          => [ 'title', 'thumbnail' ],
        'show_in_rest'      => false,
    ] );
}

add_action( 'init', 'skyeye_register_testimonial_post_type' );

function skyeye_register_testimonial_post_type() {
    register_post_type( 'testimonial', [
        'labels' => [
            'name'               => 'Testimonials',
            'singular_name'      => 'Testimonial',
            'add_new'            => 'Add New',
            'add_new_item'       => 'Add New Testimonial',
            'edit_item'          => 'Edit Testimonial',
            'new_item'           => 'New Testimonial',
            'view_item'          => 'View Testimonial',
            'search_items'       => 'Search Testimonials',
            'not_found'          => 'No testimonials found',
            'not_found_in_trash' => 'No testimonials found in Trash',
        ],
        'public'        => false,
        'show_ui'       => true,
        'show_in_menu'  => true,
        'menu_icon'     => 'dashicons-format-quote',
        'menu_position' => 6,
        'supports'      => [ 'title' ],
        'show_in_rest'  => false,
    ] );
}

// Disable Gutenberg for portfolio and testimonial posts
add_filter( 'use_block_editor_for_post', function( $use_editor, $post ) {
    if ( in_array( $post->post_type, [ 'portfolio', 'testimonial' ], true ) ) return false;
    return $use_editor;
}, 10, 2 );
