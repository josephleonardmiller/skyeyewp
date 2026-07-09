<?php

defined( 'ABSPATH' ) || exit;

define( 'SKYEYE_VERSION', '1.0.0' );
define( 'SKYEYE_DIR', get_template_directory() );
define( 'SKYEYE_URI', get_template_directory_uri() );

require_once SKYEYE_DIR . '/inc/enqueue.php';
require_once SKYEYE_DIR . '/inc/featured-post.php';
require_once SKYEYE_DIR . '/inc/post-types.php';
require_once SKYEYE_DIR . '/inc/acf-blocks.php';
require_once SKYEYE_DIR . '/inc/acf-fields.php';
require_once SKYEYE_DIR . '/inc/ajax-form.php';
require_once SKYEYE_DIR . '/inc/setup-tool.php'; // TODO: remove after Hostinger setup

function skyeye_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'editor-styles' );
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'align-wide' );

    register_nav_menus( [
        'primary' => __( 'Primary Navigation', 'skyeye' ),
        'footer'  => __( 'Footer Navigation', 'skyeye' ),
    ] );
}
add_action( 'after_setup_theme', 'skyeye_setup' );

// Pass custom link classes and data-transition-link to nav menu anchors
add_filter( 'nav_menu_link_attributes', function ( $atts, $item, $args, $depth ) {
    if ( ! empty( $args->link_class ) ) {
        $atts['class'] = trim( ( $atts['class'] ?? '' ) . ' ' . $args->link_class );
    }
    $atts['data-transition-link'] = '';
    return $atts;
}, 10, 4 );

// Strip default <li> classes for clean markup
add_filter( 'nav_menu_css_class', '__return_empty_array', 10, 4 );

// Allow SVG uploads to the media library
add_filter( 'upload_mimes', function( $mimes ) {
    $mimes['svg']  = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';
    return $mimes;
} );
add_filter( 'wp_check_filetype_and_ext', function( $data, $file, $filename, $mimes ) {
    if ( ! $data['type'] ) {
        $ext = strtolower( pathinfo( $filename, PATHINFO_EXTENSION ) );
        if ( $ext === 'svg' || $ext === 'svgz' ) {
            $data['type'] = 'image/svg+xml';
            $data['ext']  = $ext;
        }
    }
    return $data;
}, 10, 4 );

// ACF options page
add_action( 'acf/init', function() {
    if ( function_exists( 'acf_add_options_page' ) ) {
        acf_add_options_page( [
            'page_title' => 'Site Settings',
            'menu_title' => 'Site Settings',
            'menu_slug'  => 'skyeye-settings',
            'capability' => 'edit_posts',
            'redirect'   => false,
        ] );
    }
} );
