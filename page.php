<?php get_header(); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

    <?php if ( have_rows( 'page_builder' ) ) : ?>
        <?php while ( have_rows( 'page_builder' ) ) : the_row();
            $layout   = get_row_layout();
            $template = SKYEYE_DIR . '/templates/sections/' . str_replace( '_', '-', $layout ) . '.php';
            if ( file_exists( $template ) ) include $template;
        endwhile; ?>
    <?php else : ?>
        <main class="pt-32 pb-24">
            <div class="container mx-auto px-6 lg:px-16 max-w-3xl">
                <h1 class="font-heading text-5xl lg:text-7xl text-black mb-12"><?php the_title(); ?></h1>
                <div class="font-body text-black/70 text-lg leading-relaxed"><?php the_content(); ?></div>
            </div>
        </main>
    <?php endif; ?>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
