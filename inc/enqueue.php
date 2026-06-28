<?php

defined( 'ABSPATH' ) || exit;

function skyeye_enqueue_assets() {
    $dist = SKYEYE_DIR . '/dist';

    // CSS
    $css_file = $dist . '/app.css';
    $css_ver  = file_exists( $css_file ) ? filemtime( $css_file ) : SKYEYE_VERSION;
    wp_enqueue_style( 'skyeye-app', SKYEYE_URI . '/dist/app.css', [], $css_ver );

    // Local font — injected here so the URL resolves correctly via WP (Vite mangles it)
    $font_uri = SKYEYE_URI . '/fonts';
    wp_add_inline_style( 'skyeye-app', "@font-face {
  font-family: 'Tan';
  src: url('{$font_uri}/tan_-_waverly-webfont.woff2') format('woff2'),
       url('{$font_uri}/tan_-_waverly-webfont.woff') format('woff');
  font-weight: normal;
  font-display: swap;
  ascent-override: 90%;
  descent-override: 20%;
  line-gap-override: 0%;
}" );

    // Google Fonts — Hanken Grotesk
    wp_enqueue_style(
        'skyeye-fonts',
        'https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@300;400;500;600&display=swap',
        [],
        null
    );

    // GSAP (from CDN for reliability)
    wp_enqueue_script( 'gsap', 'https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js', [], '3.12.5', true );
    wp_enqueue_script( 'gsap-scroll-trigger', 'https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js', [ 'gsap' ], '3.12.5', true );
    wp_enqueue_script( 'gsap-custom-ease', 'https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/CustomEase.min.js', [ 'gsap' ], '3.12.5', true );

    // Theme JS
    $js_file = $dist . '/main.js';
    $js_ver  = file_exists( $js_file ) ? filemtime( $js_file ) : SKYEYE_VERSION;
    wp_enqueue_script( 'skyeye-app', SKYEYE_URI . '/dist/main.js', [ 'gsap', 'gsap-scroll-trigger', 'gsap-custom-ease' ], $js_ver, true );

    // Pass AJAX URL to JS
    wp_localize_script( 'skyeye-app', 'skyeyeData', [
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'skyeye_contact' ),
    ] );
}
add_action( 'wp_enqueue_scripts', 'skyeye_enqueue_assets' );

// Remove default block styles we don't want
function skyeye_dequeue_block_styles() {
    wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );
    wp_dequeue_style( 'global-styles' );
}
add_action( 'wp_enqueue_scripts', 'skyeye_dequeue_block_styles', 100 );

// Strip all Gravity Forms CSS — we provide our own styles
add_filter( 'gform_disable_css', '__return_true' );
add_action( 'wp_print_styles', function() {
    wp_dequeue_style( 'gform-theme' );
    wp_dequeue_style( 'gform-theme-ie11' );
    wp_dequeue_style( 'gforms_reset_css' );
    wp_dequeue_style( 'gforms_formsmain_css' );
    wp_dequeue_style( 'gforms_ready_class_css' );
    wp_dequeue_style( 'gforms_browsers_css' );
}, 100 );
