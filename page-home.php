<?php
/**
 * Template Name: Home
 */

get_header();

if ( have_posts() ) : while ( have_posts() ) : the_post();
    if ( have_rows( 'page_builder' ) ) :
        while ( have_rows( 'page_builder' ) ) : the_row();
            $layout = get_row_layout();
            $template = SKYEYE_DIR . '/templates/sections/' . str_replace( '_', '-', $layout ) . '.php';
            if ( file_exists( $template ) ) {
                include $template;
            }
        endwhile;
    endif;
endwhile; endif;

get_footer();
