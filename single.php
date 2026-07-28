<?php
/**
 * Template: Single blog post
 */
get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>

<?php
$categories  = get_the_category();
$primary_cat = $categories ? $categories[0] : null;

$related_args = [
    'posts_per_page'      => 3,
    'post__not_in'        => [ get_the_ID() ],
    'ignore_sticky_posts' => 1,
    'orderby'             => 'rand',
];
if ( $categories ) {
    $related_args['category__in'] = array_map( fn( $c ) => (int) $c->term_id, $categories );
}
$related_query = new WP_Query( $related_args );
?>

<!-- Dark hero — post title + date -->
<section class="relative bg-black pt-40 pb-[220px] lg:pt-48 lg:pb-[280px] text-center px-6">
    <div class="container mx-auto" style="max-width:900px;">
        <?php if ( $primary_cat ) : ?>
        <a href="<?php echo esc_url( get_category_link( $primary_cat->term_id ) ); ?>"
           class="inline-block font-body text-xs text-white/50 uppercase tracking-widest mb-6 hover:text-white/80 transition-colors duration-200">
            <?php echo esc_html( $primary_cat->name ); ?>
        </a>
        <?php endif; ?>
        <h1 class="font-heading text-4xl md:text-5xl lg:text-[3.5rem] text-[#f8f5ef] mb-6 leading-tight">
            <?php the_title(); ?>
        </h1>
        <p class="font-body text-[1.125rem] text-brand-200">
            <?php echo esc_html( get_the_date( 'F j, Y' ) ); ?>
        </p>
    </div>
</section>

<!-- Cream content area -->
<section class="bg-brand-100">

    <!-- Featured image — pulls up into dark hero via negative margin -->
    <?php if ( has_post_thumbnail() ) : ?>
    <div class="relative px-6 lg:px-[8%] -mt-[220px] lg:-mt-[280px] mb-16 lg:mb-20">
        <div class="overflow-hidden rounded-xl h-[280px] md:h-[440px] lg:h-[560px] max-w-[1040px] mx-auto">
            <?php the_post_thumbnail( 'full', ['class' => 'w-full h-full object-cover'] ); ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Article body -->
    <div class="container mx-auto px-6 lg:px-16 pb-20 lg:pb-28">
        <article class="post-content mx-auto" style="max-width:780px;">
            <?php the_content(); ?>
        </article>
    </div>

</section>

<!-- Related blogs -->
<?php if ( $related_query->have_posts() ) : ?>
<section class="bg-white py-20">
    <div class="container mx-auto px-6 lg:px-16">
        <div class="flex items-center justify-between mb-12">
            <h2 class="font-heading text-[2.25rem] text-black tracking-[0.3px]">Related blogs</h2>
            <?php
            $blog_url = get_permalink( get_option( 'page_for_posts' ) );
            if ( $blog_url ) :
            ?>
            <a href="<?php echo esc_url( $blog_url ); ?>"
               class="font-body text-[1.125rem] text-white bg-black rounded-[50px] px-10 py-3.5 hover:bg-brand-400 transition-colors duration-300 whitespace-nowrap">
                View all
            </a>
            <?php endif; ?>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-16">
            <?php while ( $related_query->have_posts() ) : $related_query->the_post(); ?>
            <article>
                <a href="<?php the_permalink(); ?>" class="group block">
                    <?php if ( has_post_thumbnail() ) : ?>
                    <div class="overflow-hidden rounded-xl mb-6 h-[220px] lg:h-[296px]">
                        <?php the_post_thumbnail( 'medium_large', [
                            'class' => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-[1.03]',
                        ] ); ?>
                    </div>
                    <?php endif; ?>
                    <h3 class="font-heading text-[1.5rem] text-black leading-snug mb-2">
                        <?php the_title(); ?>
                    </h3>
                    <p class="font-body text-[1.125rem] font-light text-black/60 leading-relaxed mb-2">
                        <?php echo esc_html( wp_trim_words( get_the_excerpt(), 14, '…' ) ); ?>
                    </p>
                    <p class="font-body text-[1.125rem] text-brand-200">
                        <?php echo esc_html( get_the_date( 'F j, Y' ) ); ?>
                    </p>
                </a>
            </article>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php endwhile; ?>

<?php get_footer(); ?>
