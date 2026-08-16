<?php

defined( 'ABSPATH' ) || exit;

// Disable Gutenberg for Pages — ACF flexible content is the page builder
add_filter( 'use_block_editor_for_post', function ( $use_editor, $post ) {
    if ( in_array( $post->post_type, [ 'page', 'portfolio' ], true ) ) return false;
    return $use_editor;
}, 10, 2 );

add_action( 'acf/init', 'skyeye_register_acf_fields' );

function skyeye_register_acf_fields() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    // ─── Page Builder (Flexible Content) ──────────────────────────────────────
    acf_add_local_field_group( [
        'key'      => 'group_page_builder',
        'title'    => 'Page Builder',
        'fields'   => [
            [
                'key'          => 'field_page_builder',
                'label'        => 'Sections',
                'name'         => 'page_builder',
                'type'         => 'flexible_content',
                'button_label' => 'Add Section',
                'layouts'      => [

                    // ── Hero ──────────────────────────────────────────────
                    'layout_hero' => [
                        'key'        => 'layout_hero',
                        'name'       => 'hero',
                        'label'      => 'Hero',
                        'display'    => 'block',
                        'sub_fields' => [
                            [ 'key' => 'field_pb_hero_heading',   'label' => 'Heading',              'name' => 'heading',              'type' => 'text',     'default_value' => 'Unforgettable' ],
                            [ 'key' => 'field_pb_hero_subheading','label' => 'Subheading',           'name' => 'subheading',           'type' => 'text',     'default_value' => 'moments' ],
                            [ 'key' => 'field_pb_hero_desc',      'label' => 'Description',          'name' => 'description',          'type' => 'textarea', 'rows' => 3, 'default_value' => 'Sky Eye Wedding Films is a wedding videography company based in Carlow, Ireland.' ],
                            [ 'key' => 'field_pb_hero_video',     'label' => 'Background Video URL', 'name' => 'background_video_url', 'type' => 'url',      'default_value' => 'https://res.cloudinary.com/dbpg2xuhs/video/upload/q_auto,vc_vp9,w_1280,c_limit,f_auto/Websiteheader_fbordq.mp4' ],
                        ],
                    ],

                    // ── Callout ───────────────────────────────────────────
                    'layout_callout' => [
                        'key'        => 'layout_callout',
                        'name'       => 'callout',
                        'label'      => 'Callout',
                        'display'    => 'block',
                        'sub_fields' => [
                            [ 'key' => 'field_pb_callout_heading',   'label' => 'Heading',   'name' => 'heading',   'type' => 'textarea', 'rows' => 3, 'default_value' => 'We specialize in creating beautiful, cinematic wedding films that capture all the emotions and special moments of your big day.' ],
                            [ 'key' => 'field_pb_callout_cta_label', 'label' => 'CTA Label', 'name' => 'cta_label', 'type' => 'text',     'default_value' => 'Get in touch' ],
                            [ 'key' => 'field_pb_callout_cta_link',  'label' => 'CTA URL',   'name' => 'cta_link',  'type' => 'url',      'default_value' => '/contact' ],
                            [
                                'key'        => 'field_pb_callout_images',
                                'label'      => 'Decorative Images',
                                'name'       => 'decorative_images',
                                'type'       => 'repeater',
                                'min'        => 0,
                                'max'        => 6,
                                'layout'     => 'block',
                                'button_label' => 'Add Image',
                                'sub_fields' => [
                                    [ 'key' => 'field_pb_callout_img', 'label' => 'Image', 'name' => 'image', 'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium' ],
                                ],
                            ],
                            [
                                'key'        => 'field_pb_callout_videos',
                                'label'      => 'Video Overlays',
                                'name'       => 'video_overlays',
                                'type'       => 'repeater',
                                'min'        => 0,
                                'max'        => 2,
                                'layout'     => 'block',
                                'button_label' => 'Add Video',
                                'sub_fields' => [
                                    [ 'key' => 'field_pb_callout_vid', 'label' => 'Video URL', 'name' => 'video_url', 'type' => 'url' ],
                                ],
                            ],
                        ],
                    ],

                    // ── Recent Work ───────────────────────────────────────
                    'layout_recent_work' => [
                        'key'        => 'layout_recent_work',
                        'name'       => 'recent_work',
                        'label'      => 'Recent Work',
                        'display'    => 'block',
                        'sub_fields' => [
                            [ 'key' => 'field_pb_rw_heading', 'label' => 'Section Heading', 'name' => 'section_heading', 'type' => 'text', 'default_value' => 'Recent work' ],
                            [ 'key' => 'field_pb_rw_label1', 'label' => 'Section Label 1', 'name' => 'section_label_1', 'type' => 'text', 'default_value' => 'Happy' ],
                            [ 'key' => 'field_pb_rw_label2', 'label' => 'Section Label 2', 'name' => 'section_label_2', 'type' => 'text', 'default_value' => 'couples' ],
                            [
                                'key'           => 'field_pb_rw_posts',
                                'label'         => 'Portfolio Items',
                                'name'          => 'portfolio_items',
                                'type'          => 'relationship',
                                'post_type'     => [ 'portfolio' ],
                                'filters'       => [ 'search' ],
                                'return_format' => 'object',
                                'min'           => 0,
                                'max'           => 0,
                                'instructions'  => 'Select portfolio posts to display in this section.',
                            ],
                        ],
                    ],

                    // ── About ─────────────────────────────────────────────
                    'layout_about' => [
                        'key'        => 'layout_about',
                        'name'       => 'about',
                        'label'      => 'About',
                        'display'    => 'block',
                        'sub_fields' => [
                            [ 'key' => 'field_pb_about_title',     'label' => 'Section Title', 'name' => 'section_title', 'type' => 'text',     'default_value' => 'About Skyeye' ],
                            [ 'key' => 'field_pb_about_para1',     'label' => 'Paragraph 1',  'name' => 'paragraph_1',   'type' => 'textarea', 'rows' => 4 ],
                            [ 'key' => 'field_pb_about_para2',     'label' => 'Paragraph 2',  'name' => 'paragraph_2',   'type' => 'textarea', 'rows' => 4 ],
                            [ 'key' => 'field_pb_about_image',     'label' => 'Featured Image','name' => 'featured_image','type' => 'image',    'return_format' => 'array', 'preview_size' => 'medium' ],
                            [ 'key' => 'field_pb_about_cta_label', 'label' => 'CTA Label',    'name' => 'cta_label',     'type' => 'text',     'default_value' => 'Learn more' ],
                            [ 'key' => 'field_pb_about_cta_url',   'label' => 'CTA URL',      'name' => 'cta_url',       'type' => 'url',      'default_value' => '/about' ],
                            [ 'key' => 'field_pb_about_signature', 'label' => 'Signature SVG', 'name' => 'signature',    'type' => 'image',    'return_format' => 'array', 'preview_size' => 'thumbnail', 'instructions' => 'Upload an SVG signature image. Displayed beside the CTA button.' ],
                        ],
                    ],

                    // ── Testimonials ──────────────────────────────────────
                    'layout_testimonials' => [
                        'key'        => 'layout_testimonials',
                        'name'       => 'testimonials',
                        'label'      => 'Testimonials',
                        'display'    => 'block',
                        'sub_fields' => [
                            [
                                'key'           => 'field_pb_testi_posts',
                                'label'         => 'Testimonials',
                                'name'          => 'testimonial_items',
                                'type'          => 'relationship',
                                'post_type'     => [ 'testimonial' ],
                                'filters'       => [ 'search' ],
                                'return_format' => 'object',
                                'min'           => 0,
                                'max'           => 0,
                                'instructions'  => 'Select testimonials to display in this section.',
                            ],
                        ],
                    ],

                    // ── Contact Section ───────────────────────────────────
                    'layout_contact_section' => [
                        'key'        => 'layout_contact_section',
                        'name'       => 'contact_section',
                        'label'      => 'Contact Section',
                        'display'    => 'block',
                        'sub_fields' => [
                            [ 'key' => 'field_pb_contact_heading', 'label' => 'Heading',              'name' => 'heading',              'type' => 'text', 'default_value' => 'Get in touch' ],
                            [ 'key' => 'field_pb_contact_video',   'label' => 'Background Video URL', 'name' => 'background_video_url', 'type' => 'url',  'default_value' => 'https://res.cloudinary.com/dbpg2xuhs/video/upload/q_auto,vc_vp9,w_1280,c_limit,f_auto/Websiteheader_fbordq.mp4' ],
                        ],
                    ],

                    // ── Form Section ──────────────────────────────────────
                    'layout_form_section' => [
                        'key'        => 'layout_form_section',
                        'name'       => 'form_section',
                        'label'      => 'Form Section',
                        'display'    => 'block',
                        'sub_fields' => [
                            [ 'key' => 'field_pb_form_line1', 'label' => 'Heading Line 1', 'name' => 'heading_line_1', 'type' => 'text',   'default_value' => 'Get in' ],
                            [ 'key' => 'field_pb_form_line2', 'label' => 'Heading Line 2', 'name' => 'heading_line_2', 'type' => 'text',   'default_value' => 'touch' ],
                            [ 'key' => 'field_pb_form_sub',   'label' => 'Subheading',     'name' => 'subheading',     'type' => 'text',   'default_value' => 'We just need a few details' ],
                            [ 'key' => 'field_pb_form_id',    'label' => 'Gravity Form ID', 'name' => 'form_id',        'type' => 'number', 'min' => 1, 'step' => 1, 'instructions' => 'Enter the ID of the Gravity Form to display (found in Forms → ID column).' ],
                        ],
                    ],

                ],
            ],
        ],
        'location' => [ [ [ 'param' => 'post_type', 'operator' => '==', 'value' => 'page' ] ] ],
        'menu_order'  => 0,
        'position'    => 'normal',
        'style'       => 'default',
        'label_placement' => 'top',
    ] );

    // ─── Testimonial Post Type Fields ─────────────────────────────────────────
    acf_add_local_field_group( [
        'key'    => 'group_testimonial',
        'title'  => 'Testimonial',
        'fields' => [
            [
                'key'          => 'field_testi_quote',
                'label'        => 'Quote',
                'name'         => 'quote',
                'type'         => 'textarea',
                'rows'         => 5,
                'instructions' => 'The testimonial text — no need to add quote marks, they are added automatically.',
                'placeholder'  => 'I always knew I wanted a wedding video...',
            ],
            [
                'key'           => 'field_testi_image_1',
                'label'         => 'Image 1',
                'name'          => 'image_1',
                'type'          => 'image',
                'return_format' => 'array',
                'preview_size'  => 'medium',
            ],
            [
                'key'           => 'field_testi_image_2',
                'label'         => 'Image 2',
                'name'          => 'image_2',
                'type'          => 'image',
                'return_format' => 'array',
                'preview_size'  => 'medium',
            ],
        ],
        'location' => [ [ [ 'param' => 'post_type', 'operator' => '==', 'value' => 'testimonial' ] ] ],
        'menu_order'      => 0,
        'position'        => 'normal',
        'style'           => 'default',
        'label_placement' => 'top',
    ] );

    // ─── Portfolio Post Type Fields ───────────────────────────────────────────
    acf_add_local_field_group( [
        'key'    => 'group_portfolio',
        'title'  => 'Portfolio Details',
        'fields' => [
            [
                'key'          => 'field_portfolio_location',
                'label'        => 'Location',
                'name'         => 'location',
                'type'         => 'text',
                'placeholder'  => 'e.g. Waterford Castle, Co. Waterford',
                'instructions' => 'The venue or location of the wedding.',
            ],
            [
                'key'          => 'field_portfolio_text_1',
                'label'        => 'Text 1 (Lead)',
                'name'         => 'text_1',
                'type'         => 'textarea',
                'rows'         => 4,
                'instructions' => 'Intro paragraph — displayed bold above the gallery.',
            ],
            [
                'key'          => 'field_portfolio_text_2',
                'label'        => 'Text 2',
                'name'         => 'text_2',
                'type'         => 'textarea',
                'rows'         => 4,
                'instructions' => 'Second paragraph — displayed above the gallery.',
            ],
            [
                'key'          => 'field_portfolio_text_3',
                'label'        => 'Text 3',
                'name'         => 'text_3',
                'type'         => 'textarea',
                'rows'         => 4,
                'instructions' => 'Third paragraph — displayed below text 2.',
            ],
            [
                'key'          => 'field_portfolio_quote',
                'label'        => 'Quote',
                'name'         => 'quote',
                'type'         => 'textarea',
                'rows'         => 4,
                'instructions' => 'Client testimonial — displayed in the middle of the photo gallery.',
            ],
            [
                'key'          => 'field_portfolio_quote_attribution',
                'label'        => 'Quote Attribution',
                'name'         => 'quote_attribution',
                'type'         => 'text',
                'placeholder'  => 'e.g. Alwyn & Paul',
                'instructions' => 'Name displayed below the quote.',
            ],
            [
                'key'          => 'field_portfolio_wedding_date',
                'label'        => 'Wedding Date',
                'name'         => 'wedding_date',
                'type'         => 'text',
                'placeholder'  => 'e.g. June 2025',
                'instructions' => 'Month and year of the wedding, displayed in the hero.',
            ],
            [
                'key'          => 'field_portfolio_film_url',
                'label'        => 'Film URL',
                'name'         => 'film_url',
                'type'         => 'url',
                'instructions' => 'Vimeo URL for the wedding film (e.g. https://vimeo.com/123456789). Shows a Play button that opens the film in an overlay.',
            ],
            [
                'key'           => 'field_portfolio_video_thumbnail',
                'label'         => 'Video Thumbnail',
                'name'          => 'video_thumbnail',
                'type'          => 'image',
                'return_format' => 'array',
                'preview_size'  => 'medium',
                'instructions'  => 'Hero image shown on the detail page with the Play button. The Featured Image is used for archive/listing thumbnails.',
            ],
            [
                'key'           => 'field_portfolio_gallery',
                'label'         => 'Photo Gallery',
                'name'          => 'gallery',
                'type'          => 'gallery',
                'return_format' => 'array',
                'preview_size'  => 'medium',
                'instructions'  => 'Wedding photos displayed in the staggered gallery below the film.',
            ],
            [
                'key'          => 'field_portfolio_video_id',
                'label'        => 'Cloudinary Video ID',
                'name'         => 'cloudinary_video_id',
                'type'         => 'text',
                'instructions' => 'The Cloudinary video ID (filename without extension) used for the hover preview.',
                'placeholder'  => 'e.g. marie_niall_highlight',
            ],
        ],
        'location' => [ [ [ 'param' => 'post_type', 'operator' => '==', 'value' => 'portfolio' ] ] ],
        'menu_order'      => 0,
        'position'        => 'side',
        'style'           => 'default',
        'label_placement' => 'top',
    ] );

    // ─── Site Settings (Options Page) ─────────────────────────────────────────
    acf_add_local_field_group( [
        'key'      => 'group_site_settings',
        'title'    => 'Site Settings',
        'fields'   => [
            [ 'key' => 'field_ss_logo',         'label' => 'Site Logo',     'name' => 'site_logo',     'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium' ],
            [ 'key' => 'field_ss_company',      'label' => 'Company Name',  'name' => 'company_name',  'type' => 'text',  'default_value' => 'Sky Eye Wedding Films' ],
            [
                'key'        => 'field_ss_nav',
                'label'      => 'Navigation Links',
                'name'       => 'nav_links',
                'type'       => 'repeater',
                'layout'     => 'table',
                'button_label' => 'Add Link',
                'sub_fields' => [
                    [ 'key' => 'field_ss_nav_label', 'label' => 'Label', 'name' => 'label', 'type' => 'text' ],
                    [ 'key' => 'field_ss_nav_url',   'label' => 'URL',   'name' => 'url',   'type' => 'url' ],
                ],
            ],
            [
                'key'        => 'field_ss_footer_links',
                'label'      => 'Footer Links',
                'name'       => 'footer_links',
                'type'       => 'repeater',
                'layout'     => 'table',
                'button_label' => 'Add Link',
                'sub_fields' => [
                    [ 'key' => 'field_ss_footer_label', 'label' => 'Label', 'name' => 'label', 'type' => 'text' ],
                    [ 'key' => 'field_ss_footer_url',   'label' => 'URL',   'name' => 'url',   'type' => 'url' ],
                ],
            ],
            [ 'key' => 'field_ss_facebook',   'label' => 'Facebook URL',  'name' => 'social_facebook',  'type' => 'url' ],
            [ 'key' => 'field_ss_twitter',    'label' => 'Twitter URL',   'name' => 'social_twitter',   'type' => 'url' ],
            [ 'key' => 'field_ss_instagram',  'label' => 'Instagram URL', 'name' => 'social_instagram', 'type' => 'url' ],
            [ 'key' => 'field_ss_footer_note','label' => 'Footer Note',   'name' => 'footer_note',      'type' => 'text', 'default_value' => 'Made in Ireland' ],
        ],
        'location' => [ [ [ 'param' => 'options_page', 'operator' => '==', 'value' => 'skyeye-settings' ] ] ],
    ] );

    // ─── Contact Page Fields ──────────────────────────────────────────────────
    acf_add_local_field_group( [
        'key'    => 'group_contact_page',
        'title'  => 'Contact Page',
        'fields' => [
            [
                'key'           => 'field_cp_video_url',
                'label'         => 'Background Video URL',
                'name'          => 'background_video_url',
                'type'          => 'url',
                'default_value' => 'https://res.cloudinary.com/dbpg2xuhs/video/upload/q_auto,vc_vp9,w_1280,c_limit,f_auto/Websiteheader_fbordq.mp4',
                'instructions'  => 'Cloudinary URL for the full-screen video on the left panel.',
            ],
            [
                'key'          => 'field_cp_form_id',
                'label'        => 'Gravity Form ID',
                'name'         => 'form_id',
                'type'         => 'number',
                'min'          => 1,
                'step'         => 1,
                'instructions' => 'Enter the ID of the Gravity Form to display on the contact page.',
            ],
        ],
        'location' => [ [ [
            'param'    => 'page_template',
            'operator' => '==',
            'value'    => 'page-contact.php',
        ] ] ],
        'menu_order'      => 0,
        'position'        => 'normal',
        'style'           => 'default',
        'label_placement' => 'top',
    ] );

    // ─── About Page Fields ────────────────────────────────────────────────────
    acf_add_local_field_group( [
        'key'    => 'group_about_page',
        'title'  => 'About Page',
        'fields' => [
            [ 'key' => 'field_about_hero_subtitle', 'label' => 'Hero Subtitle', 'name' => 'about_hero_subtitle', 'type' => 'text', 'default_value' => 'Wedding cinematography built on one simple belief: real moments, honestly captured.' ],

            // About Skyeye section
            [ 'key' => 'field_about_s1_heading', 'label' => 'Section 1 Heading', 'name' => 'about_s1_heading', 'type' => 'text', 'default_value' => 'About Skyeye' ],
            [ 'key' => 'field_about_s1_body', 'label' => 'Section 1 Body', 'name' => 'about_s1_body', 'type' => 'textarea', 'rows' => 5, 'default_value' => "Sky Eye Wedding Films is a wedding cinematography service built on one simple belief: real moments, honestly captured, make the most lasting films. Based in Ireland and shooting across Ireland and abroad, Sky Eye has spent years documenting weddings — not just the big set pieces, but the quiet glances, the nervous laughs, the tears nobody planned for. The kind of details that make your story yours." ],
            [ 'key' => 'field_about_s1_image', 'label' => 'Section 1 Image', 'name' => 'about_s1_image', 'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium' ],
            [ 'key' => 'field_about_s1_button',     'label' => 'Section 1 Button Label', 'name' => 'about_s1_button',     'type' => 'text', 'default_value' => 'View portfolio' ],
            [ 'key' => 'field_about_s1_button_url', 'label' => 'Section 1 Button URL',   'name' => 'about_s1_button_url', 'type' => 'url',  'instructions' => 'Leave blank to use the Portfolio archive URL.' ],

            // Approach section
            [ 'key' => 'field_about_s2_heading', 'label' => 'Section 2 Heading', 'name' => 'about_s2_heading', 'type' => 'text', 'default_value' => 'Approach' ],
            [ 'key' => 'field_about_s2_body', 'label' => 'Section 2 Body', 'name' => 'about_s2_body', 'type' => 'textarea', 'rows' => 5, 'default_value' => "Every wedding is different, and so is every film we make. We take the time to get to know you — your story, your style, your day — so that when we're on the ground, we're invisible where we need to be and present for the moments that matter. The result is a film that feels like you." ],
            [ 'key' => 'field_about_s2_image', 'label' => 'Section 2 Image', 'name' => 'about_s2_image', 'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium' ],
            [ 'key' => 'field_about_s2_button',     'label' => 'Section 2 Button Label', 'name' => 'about_s2_button',     'type' => 'text', 'default_value' => 'Get in touch' ],
            [ 'key' => 'field_about_s2_button_url', 'label' => 'Section 2 Button URL',   'name' => 'about_s2_button_url', 'type' => 'url',  'instructions' => 'Leave blank to use the Contact page URL.' ],

            // Gallery break
            [
                'key'          => 'field_about_gallery',
                'label'        => 'Gallery Images',
                'name'         => 'about_gallery',
                'type'         => 'repeater',
                'instructions' => 'Images 1–3: large centre, left portrait, right portrait. Images 4–6: shown as a 3-column row below.',
                'min'          => 0,
                'max'          => 6,
                'layout'       => 'block',
                'button_label' => 'Add Image',
                'sub_fields'   => [
                    [ 'key' => 'field_about_gallery_img', 'label' => 'Image', 'name' => 'image', 'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium' ],
                ],
            ],
            [ 'key' => 'field_about_gal_cta',     'label' => 'Gallery — CTA Link Label', 'name' => 'about_gal_cta',     'type' => 'text', 'default_value' => 'Get in touch ↗' ],
            [ 'key' => 'field_about_gal_cta_url', 'label' => 'Gallery — CTA Link URL',   'name' => 'about_gal_cta_url', 'type' => 'url',  'instructions' => 'Leave blank to use the Contact page URL.' ],

            // Aerial Cinematography section
            [ 'key' => 'field_about_s3_heading', 'label' => 'Section 3 Heading', 'name' => 'about_s3_heading', 'type' => 'text', 'default_value' => 'Aerial Cinematography' ],
            [ 'key' => 'field_about_s3_body', 'label' => 'Section 3 Body', 'name' => 'about_s3_body', 'type' => 'textarea', 'rows' => 5, 'default_value' => "Sky Eye started with a drone. A love of technology and a curiosity about aerial perspectives led to professional drone operator training — and the discovery that the right aerial shot can completely transform how a wedding story is told. It's a dimension most videographers can't offer, and it's been part of the Sky Eye signature ever since. What began as a passion for flight grew into a full wedding film service, built on craft, creativity, and a genuine belief that your day is worth telling beautifully." ],
            [ 'key' => 'field_about_s3_image', 'label' => 'Section 3 Image', 'name' => 'about_s3_image', 'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium' ],
            [ 'key' => 'field_about_s3_button',     'label' => 'Section 3 Button Label', 'name' => 'about_s3_button',     'type' => 'text', 'default_value' => 'Get in touch' ],
            [ 'key' => 'field_about_s3_button_url', 'label' => 'Section 3 Button URL',   'name' => 'about_s3_button_url', 'type' => 'url',  'instructions' => 'Leave blank to use the Contact page URL.' ],

            // Get In Touch
            [ 'key' => 'field_about_cta_bg', 'label' => 'Get In Touch — Background Image', 'name' => 'about_cta_bg', 'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium', 'instructions' => 'Dark photo displayed behind the Get In Touch section.' ],
            [ 'key' => 'field_about_form_id', 'label' => 'Get In Touch — Gravity Form ID', 'name' => 'about_form_id', 'type' => 'number', 'min' => 1, 'step' => 1, 'default_value' => 1 ],
        ],
        'location' => [ [ [
            'param'    => 'page_template',
            'operator' => '==',
            'value'    => 'page-about.php',
        ] ] ],
        'menu_order'      => 0,
        'position'        => 'normal',
        'style'           => 'default',
        'label_placement' => 'top',
    ] );
}
