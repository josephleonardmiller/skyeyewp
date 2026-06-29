<?php
/**
 * One-time setup tool — accessible from WP Admin → Tools → Sky Eye Setup
 * DELETE this file and remove the require_once from functions.php after setup is complete.
 */

defined( 'ABSPATH' ) || exit;

add_action( 'admin_menu', function () {
    add_management_page(
        'Sky Eye Setup',
        'Sky Eye Setup',
        'manage_options',
        'skyeye-setup',
        'skyeye_setup_tool_page'
    );
} );

function skyeye_setup_tool_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    $action = $_POST['skyeye_action'] ?? '';
    $nonce  = $_POST['skyeye_nonce'] ?? '';
    $log    = [];

    if ( $action && wp_verify_nonce( $nonce, 'skyeye_setup' ) ) {
        if ( $action === 'fix_menus' ) {
            $log = skyeye_run_fix_menus();
        } elseif ( $action === 'import_gf' ) {
            $log = skyeye_run_import_gf();
        }
    }

    ?>
    <div class="wrap">
        <h1>Sky Eye Setup Tool</h1>
        <p style="color:#666;">Run each action once, then delete <code>inc/setup-tool.php</code> and remove it from <code>functions.php</code>.</p>

        <?php if ( $log ) : ?>
        <div class="notice notice-info" style="padding:12px 16px;">
            <?php foreach ( $log as $line ) : ?>
                <p style="margin:4px 0;font-family:monospace;"><?php echo esc_html( $line ); ?></p>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <hr>

        <h2>1. Fix Navigation Menus</h2>
        <p>Creates Primary and Footer navigation menus with Home, About, Portfolio, Contact links.</p>
        <form method="post">
            <?php wp_nonce_field( 'skyeye_setup', 'skyeye_nonce' ); ?>
            <input type="hidden" name="skyeye_action" value="fix_menus">
            <button class="button button-primary">Run: Fix Menus</button>
        </form>

        <hr>

        <h2>2. Import Gravity Form</h2>
        <p>Imports the "Get in touch" contact form and wires it to the home and contact pages.</p>
        <form method="post">
            <?php wp_nonce_field( 'skyeye_setup', 'skyeye_nonce' ); ?>
            <input type="hidden" name="skyeye_action" value="import_gf">
            <button class="button button-primary">Run: Import Form</button>
        </form>
    </div>
    <?php
}

function skyeye_run_fix_menus() {
    $log   = [];
    $pages = [
        'Home'      => get_page_by_path( 'home' ),
        'About'     => get_page_by_path( 'about' ),
        'Portfolio' => get_page_by_path( 'portfolio' ),
        'Contact'   => get_page_by_path( 'contact' ),
    ];

    foreach ( $pages as $label => $page ) {
        if ( ! $page ) {
            $log[] = "ERROR: Page not found: $label";
            return $log;
        }
        $log[] = "Found page: $label (ID {$page->ID})";
    }

    // Delete existing menus
    foreach ( wp_get_nav_menus() as $menu ) {
        wp_delete_nav_menu( $menu->term_id );
        $log[] = "Deleted existing menu: {$menu->name}";
    }

    // Primary Navigation
    $primary_id = wp_create_nav_menu( 'Primary Navigation' );
    $log[] = "Created Primary Navigation (ID $primary_id)";
    foreach ( $pages as $label => $page ) {
        wp_update_nav_menu_item( $primary_id, 0, [
            'menu-item-title'     => $label,
            'menu-item-object-id' => $page->ID,
            'menu-item-object'    => 'page',
            'menu-item-type'      => 'post_type',
            'menu-item-status'    => 'publish',
        ] );
        $log[] = "  Added: $label";
    }

    // Footer Navigation
    $footer_id = wp_create_nav_menu( 'Footer Navigation' );
    $log[] = "Created Footer Navigation (ID $footer_id)";
    foreach ( $pages as $label => $page ) {
        wp_update_nav_menu_item( $footer_id, 0, [
            'menu-item-title'     => $label,
            'menu-item-object-id' => $page->ID,
            'menu-item-object'    => 'page',
            'menu-item-type'      => 'post_type',
            'menu-item-status'    => 'publish',
        ] );
        $log[] = "  Added: $label";
    }

    // Assign locations
    $locations             = get_theme_mod( 'nav_menu_locations', [] );
    $locations['primary']  = $primary_id;
    $locations['footer']   = $footer_id;
    set_theme_mod( 'nav_menu_locations', $locations );
    $log[] = 'Assigned menus to theme locations.';
    $log[] = 'DONE: Navigation menus created successfully.';

    return $log;
}

function skyeye_run_import_gf() {
    $log = [];

    if ( ! class_exists( 'GFAPI' ) ) {
        $log[] = 'ERROR: Gravity Forms is not active.';
        return $log;
    }

    // Check if form already exists
    foreach ( GFAPI::get_forms() as $f ) {
        if ( $f['title'] === 'Get in touch' ) {
            $log[] = "Form already exists: 'Get in touch' (ID {$f['id']})";
            skyeye_wire_form_id( $f['id'], $log );
            return $log;
        }
    }

    $form = [
        'title'         => 'Get in touch',
        'description'   => '',
        'version'       => '2.9.5',
        'markupVersion' => 2,
        'button'        => [
            'type'     => 'text',
            'text'     => 'Submit enquiry',
            'imageUrl' => '',
            'width'    => 'auto',
            'location' => 'bottom',
            'layoutGridColumnSpan' => 12,
            'id'       => 'submit',
        ],
        'confirmations' => [
            '6a4149c6deed9' => [
                'id'        => '6a4149c6deed9',
                'name'      => 'Default Confirmation',
                'isDefault' => true,
                'type'      => 'message',
                'message'   => 'Thanks for contacting us! We will get in touch with you shortly.',
                'url'       => '',
                'pageId'    => '',
                'queryString' => '',
            ],
        ],
        'notifications' => [
            '6a4149c6de03b' => [
                'id'      => '6a4149c6de03b',
                'isActive' => true,
                'to'      => '{admin_email}',
                'name'    => 'Admin Notification',
                'event'   => 'form_submission',
                'toType'  => 'email',
                'subject' => 'New submission from {form_title}',
                'message' => '{all_fields}',
            ],
        ],
        'fields' => [
            [ 'type' => 'name',     'id' => 10, 'label' => 'First name',                       'isRequired' => false, 'size' => 'large', 'nameFormat' => 'advanced', 'cssClass' => 'gf-half', 'layoutGridColumnSpan' => 6,  'layoutGroupId' => '90389e7e', 'inputs' => [ ['id'=>'10.2','label'=>'Prefix','isHidden'=>true,'inputType'=>'radio'], ['id'=>'10.3','label'=>'First','customLabel'=>'First name'], ['id'=>'10.4','label'=>'Middle','isHidden'=>true], ['id'=>'10.6','label'=>'Last','isHidden'=>true], ['id'=>'10.8','label'=>'Suffix','isHidden'=>true] ], 'pageNumber' => 1 ],
            [ 'type' => 'name',     'id' => 1,  'label' => 'Last name',                        'isRequired' => true,  'size' => 'large', 'nameFormat' => 'advanced', 'cssClass' => 'gf-half', 'layoutGridColumnSpan' => 6,  'layoutGroupId' => '90389e7e', 'inputs' => [ ['id'=>'1.2','label'=>'Prefix','isHidden'=>true,'inputType'=>'radio'], ['id'=>'1.3','label'=>'First','isHidden'=>true], ['id'=>'1.4','label'=>'Middle','isHidden'=>true], ['id'=>'1.6','label'=>'Last','isHidden'=>false,'customLabel'=>'Last name'], ['id'=>'1.8','label'=>'Suffix','isHidden'=>true] ], 'pageNumber' => 1 ],
            [ 'type' => 'email',    'id' => 3,  'label' => 'Email',                            'isRequired' => true,  'size' => 'large', 'layoutGroupId' => 'df366be0', 'pageNumber' => 1 ],
            [ 'type' => 'phone',    'id' => 4,  'label' => 'Phone',                            'isRequired' => false, 'size' => 'large', 'phoneFormat' => 'international', 'layoutGridColumnSpan' => 12, 'layoutGroupId' => '3ff7fc12', 'pageNumber' => 1 ],
            [ 'type' => 'date',     'id' => 5,  'label' => 'Wedding date',                     'isRequired' => false, 'size' => 'large', 'dateType' => 'datepicker', 'dateFormat' => 'mdy', 'calendarIconType' => 'none', 'layoutGroupId' => 'af54d0df', 'pageNumber' => 1 ],
            [ 'type' => 'text',     'id' => 6,  'label' => 'Photographers name (if booked)',   'isRequired' => false, 'size' => 'large', 'layoutGroupId' => 'ea9409da', 'pageNumber' => 1 ],
            [ 'type' => 'text',     'id' => 8,  'label' => 'How did you hear about us?',       'isRequired' => false, 'size' => 'large', 'layoutGroupId' => '5d7a4a46', 'pageNumber' => 1 ],
            [ 'type' => 'textarea', 'id' => 9,  'label' => 'Tell us a little about your big day?', 'isRequired' => true, 'size' => 'large', 'layoutGroupId' => '3c4ccb0e', 'pageNumber' => 1 ],
        ],
        'is_active' => '1',
        'is_trash'  => '0',
    ];

    $form_id = GFAPI::add_form( $form );
    if ( is_wp_error( $form_id ) ) {
        $log[] = 'ERROR: ' . $form_id->get_error_message();
        return $log;
    }
    $log[] = "Created form 'Get in touch' (ID $form_id)";
    skyeye_wire_form_id( $form_id, $log );

    return $log;
}

function skyeye_wire_form_id( $form_id, &$log ) {
    $home_id    = (int) get_option( 'page_on_front' );
    $contact    = get_page_by_path( 'contact' );
    $contact_id = $contact ? $contact->ID : 0;

    // Find form_section row index in flexible content
    if ( $home_id && have_rows( 'page_builder', $home_id ) ) {
        $idx = 0;
        while ( have_rows( 'page_builder', $home_id ) ) {
            the_row();
            if ( get_row_layout() === 'form_section' ) {
                update_post_meta( $home_id, "page_builder_{$idx}_form_id", $form_id );
                update_post_meta( $home_id, "_page_builder_{$idx}_form_id", 'field_pb_form_id' );
                $log[] = "  Wired home page_builder_{$idx}_form_id → $form_id";
            }
            $idx++;
        }
    }

    if ( $contact_id ) {
        update_post_meta( $contact_id, 'form_id', $form_id );
        update_post_meta( $contact_id, '_form_id', 'field_cp_form_id' );
        $log[] = "  Wired contact page form_id → $form_id";
    }

    $log[] = 'DONE: Form wired to pages.';
}
