<?php
/*
 * Template Name: Portfolio
 */

get_header();

$paged = max( 1, (int) ( get_query_var( 'page' ) ?: get_query_var( 'paged' ) ) );

$portfolio_query = new WP_Query( [
    'post_type'      => 'portfolio',
    'post_status'    => 'publish',
    'posts_per_page' => 6,
    'paged'          => $paged,
    'orderby'        => 'menu_order date',
    'order'          => 'ASC',
] );

$items = $portfolio_query->posts;
$left  = [];
$right = [];
foreach ( $items as $i => $item ) {
    if ( $i % 2 === 0 ) {
        $left[] = $item;
    } else {
        $right[] = $item;
    }
}
?>

<!-- Dark hero -->
<section class="bg-black text-center px-6 pt-40 lg:pt-48 pb-16 lg:pb-20">
    <div class="container mx-auto">
        <h1 class="font-heading text-[2rem] lg:text-[3rem] text-[#f8f5ef] mb-4 leading-tight" style="letter-spacing:-2px;">
            <?php the_title(); ?>
        </h1>
        <p class="font-body text-[1.125rem] lg:text-[1.25rem] font-light text-[#bbab8b] leading-relaxed">
            Your go-to resource for wedding film inspiration, planning tips, and behind-the-scenes stories.
        </p>
    </div>
</section>

<!-- Portfolio grid — cream background -->
<section class="bg-brand-100 px-6 lg:px-[8.5%] py-20 lg:py-28">

    <?php if ( $items ) : ?>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-[7%]">

        <!-- Left column -->
        <div class="flex flex-col gap-16 lg:gap-[100px]">
            <?php foreach ( $left as $item ) : ?>
            <article>
                <a href="<?php echo esc_url( get_permalink( $item->ID ) ); ?>" class="group block">
                    <?php if ( has_post_thumbnail( $item->ID ) ) : ?>
                    <div class="overflow-hidden rounded-xl mb-6" style="aspect-ratio:650/433;">
                        <?php echo get_the_post_thumbnail( $item->ID, 'large', [
                            'class' => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-[1.03]',
                        ] ); ?>
                    </div>
                    <?php endif; ?>
                    <h3 class="font-heading text-[1.5rem] text-black leading-snug tracking-[0.5px] mb-1">
                        <?php echo esc_html( get_the_title( $item->ID ) ); ?>
                    </h3>
                    <?php $location = get_field( 'location', $item->ID ); if ( $location ) : ?>
                    <p class="font-body text-[1.125rem] text-[#bbab8b]">
                        <?php echo esc_html( $location ); ?>
                    </p>
                    <?php endif; ?>
                </a>
            </article>
            <?php endforeach; ?>
        </div>

        <!-- Right column — staggered 100px down -->
        <div class="flex flex-col gap-16 lg:gap-[100px] mt-12 lg:mt-[100px]">
            <?php foreach ( $right as $item ) : ?>
            <article>
                <a href="<?php echo esc_url( get_permalink( $item->ID ) ); ?>" class="group block">
                    <?php if ( has_post_thumbnail( $item->ID ) ) : ?>
                    <div class="overflow-hidden rounded-xl mb-6" style="aspect-ratio:650/433;">
                        <?php echo get_the_post_thumbnail( $item->ID, 'large', [
                            'class' => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-[1.03]',
                        ] ); ?>
                    </div>
                    <?php endif; ?>
                    <h3 class="font-heading text-[1.5rem] text-black leading-snug tracking-[0.5px] mb-1">
                        <?php echo esc_html( get_the_title( $item->ID ) ); ?>
                    </h3>
                    <?php $location = get_field( 'location', $item->ID ); if ( $location ) : ?>
                    <p class="font-body text-[1.125rem] text-[#bbab8b]">
                        <?php echo esc_html( $location ); ?>
                    </p>
                    <?php endif; ?>
                </a>
            </article>
            <?php endforeach; ?>
        </div>

    </div>

    <!-- Pagination -->
    <?php if ( $portfolio_query->max_num_pages > 1 ) :
        global $wp_query;
        $wp_query->max_num_pages = $portfolio_query->max_num_pages;
        the_posts_pagination( [
            'mid_size'           => 2,
            'prev_text'          => '&#8592;',
            'next_text'          => '&#8594;',
            'screen_reader_text' => ' ',
        ] );
    endif; ?>

    <?php else : ?>
    <div class="text-center py-24">
        <p class="font-body text-lg text-black/50">No portfolio items yet.</p>
    </div>
    <?php endif; ?>

</section>

<?php get_footer(); ?>
