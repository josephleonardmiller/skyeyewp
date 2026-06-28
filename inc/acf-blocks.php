<?php

defined( 'ABSPATH' ) || exit;

function skyeye_register_acf_blocks() {
    if ( ! function_exists( 'acf_register_block_type' ) ) {
        return;
    }

    $blocks = [ 'hero', 'about', 'callout', 'recent-work', 'testimonials', 'contact-section', 'form-section' ];

    foreach ( $blocks as $block ) {
        register_block_type( SKYEYE_DIR . '/blocks/' . $block );
    }
}
add_action( 'init', 'skyeye_register_acf_blocks' );
