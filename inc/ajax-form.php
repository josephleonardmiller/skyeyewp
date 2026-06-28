<?php

defined( 'ABSPATH' ) || exit;

function skyeye_handle_contact_form() {
    check_ajax_referer( 'skyeye_contact', 'nonce' );

    $required = [ 'firstName', 'lastName', 'emailAddress', 'weddingDate', 'message' ];
    $data     = [];

    foreach ( $required as $field ) {
        $value = isset( $_POST[ $field ] ) ? sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) : '';
        if ( empty( $value ) ) {
            wp_send_json_error( [ 'message' => 'Please fill in all required fields.' ] );
        }
        $data[ $field ] = $value;
    }

    if ( ! is_email( $data['emailAddress'] ) ) {
        wp_send_json_error( [ 'message' => 'Please enter a valid email address.' ] );
    }

    if ( strlen( $data['message'] ) < 20 ) {
        wp_send_json_error( [ 'message' => 'Your message must be at least 20 characters.' ] );
    }

    $data['phoneNumber']      = sanitize_text_field( wp_unslash( $_POST['phoneNumber'] ?? '' ) );
    $data['photographersName'] = sanitize_text_field( wp_unslash( $_POST['photographersName'] ?? '' ) );
    $data['howDidYouHear']    = sanitize_text_field( wp_unslash( $_POST['howDidYouHear'] ?? '' ) );

    $to      = get_option( 'admin_email' );
    $subject = 'New wedding enquiry from ' . $data['firstName'] . ' ' . $data['lastName'];

    $body  = "Name: {$data['firstName']} {$data['lastName']}\n";
    $body .= "Email: {$data['emailAddress']}\n";
    $body .= "Phone: {$data['phoneNumber']}\n";
    $body .= "Wedding Date: {$data['weddingDate']}\n";
    $body .= "Photographer: {$data['photographersName']}\n";
    $body .= "How they found us: {$data['howDidYouHear']}\n\n";
    $body .= "Message:\n{$data['message']}\n";

    $headers = [
        'Content-Type: text/plain; charset=UTF-8',
        'Reply-To: ' . $data['emailAddress'],
    ];

    $sent = wp_mail( $to, $subject, $body, $headers );

    if ( $sent ) {
        wp_send_json_success( [ 'message' => 'Thank you! We\'ll be in touch soon.' ] );
    } else {
        wp_send_json_error( [ 'message' => 'Something went wrong. Please try again or email us directly.' ] );
    }
}

add_action( 'wp_ajax_skyeye_contact',        'skyeye_handle_contact_form' );
add_action( 'wp_ajax_nopriv_skyeye_contact', 'skyeye_handle_contact_form' );
