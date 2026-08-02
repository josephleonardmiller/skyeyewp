<?php get_header(); ?>

<!-- Dark hero -->
<section class="bg-black text-center px-6 pt-40 lg:pt-48 pb-16 lg:pb-20">
    <div class="container mx-auto">
        <h1 class="font-heading text-[2rem] lg:text-[4rem] text-[#f8f5ef] leading-tight mb-3" style="letter-spacing:-2px;">
            <?php the_title(); ?>
        </h1>
        <p class="font-body text-[1.125rem] text-[#bbab8b]">This page is in design</p>
    </div>
</section>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <?php if ( have_rows( 'page_builder' ) ) : ?>
        <?php while ( have_rows( 'page_builder' ) ) : the_row();
            $layout   = get_row_layout();
            $template = SKYEYE_DIR . '/templates/sections/' . str_replace( '_', '-', $layout ) . '.php';
            if ( file_exists( $template ) ) include $template;
        endwhile; ?>
    <?php endif; ?>
<?php endwhile; endif; ?>

<?php get_footer(); ?>
