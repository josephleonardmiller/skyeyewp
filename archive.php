<?php
/**
 * Template: Category / tag / date / author archives
 */
get_header();
?>

<!-- Archive hero -->
<section class="bg-brand-100 pt-40 pb-16 lg:pt-48 lg:pb-20 text-center px-6">
    <div class="container mx-auto">
        <h1 class="font-heading text-5xl lg:text-[3rem] text-black mb-4 leading-tight">
            <?php the_archive_title(); ?>
        </h1>
        <?php the_archive_description( '<p class="font-body text-[1.0625rem] font-light text-black/60 max-w-lg mx-auto leading-relaxed">', '</p>' ); ?>
    </div>
</section>

<div class="bg-white pb-24">
    <div class="container mx-auto px-6 lg:px-16 pt-12">

        <?php if ( have_posts() ) : ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            <?php while ( have_posts() ) : the_post(); ?>
            <article>
                <a href="<?php the_permalink(); ?>" class="group block">
                    <?php if ( has_post_thumbnail() ) : ?>
                    <div class="overflow-hidden rounded-xl mb-5" style="height:300px;">
                        <?php the_post_thumbnail( 'medium_large', [
                            'class' => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-[1.03]',
                        ] ); ?>
                    </div>
                    <?php endif; ?>
                    <p class="font-body text-xs text-brand-200 mb-2 uppercase tracking-widest">
                        <?php echo esc_html( get_the_date( 'F j, Y' ) ); ?>
                    </p>
                    <h2 class="font-heading text-[1.375rem] text-black leading-snug"><?php the_title(); ?></h2>
                </a>
            </article>
            <?php endwhile; ?>
        </div>

        <?php the_posts_pagination( [
            'mid_size'           => 2,
            'prev_text'          => '&#8592;',
            'next_text'          => '&#8594;',
            'screen_reader_text' => ' ',
        ] ); ?>

        <?php else : ?>
        <p class="text-center py-24 font-body text-lg text-black/50">No posts found.</p>
        <?php endif; ?>

    </div>
</div>

<?php get_footer(); ?>
