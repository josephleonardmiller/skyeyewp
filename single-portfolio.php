<?php
get_header();

while ( have_posts() ) : the_post();

$location     = get_field( 'location' );
$wedding_date = get_field( 'wedding_date' );
$film_url     = get_field( 'film_url' );
$gallery      = get_field( 'gallery' );

$related = new WP_Query( [
    'post_type'      => 'portfolio',
    'post_status'    => 'publish',
    'posts_per_page' => 4,
    'post__not_in'   => [ get_the_ID() ],
    'orderby'        => 'menu_order date',
    'order'          => 'ASC',
] );
?>

<!-- Dark hero — couple name + location/date -->
<section class="bg-black text-center px-6 pt-40 lg:pt-48 pb-[220px] lg:pb-[280px]">
    <div class="container mx-auto">
        <h1 class="font-heading text-[3rem] lg:text-[4rem] text-[#f8f5ef] leading-tight mb-3" style="letter-spacing:-2px;">
            <?php the_title(); ?>
        </h1>
        <?php
        $meta = array_filter( [ $location, $wedding_date ] );
        if ( $meta ) :
        ?>
        <p class="font-body text-[1.125rem] text-[#bbab8b]">
            <?php echo esc_html( implode( ' · ', $meta ) ); ?>
        </p>
        <?php endif; ?>
    </div>
</section>

<!-- Hero image — pulled up over black hero, transitions into cream below -->
<?php if ( has_post_thumbnail() ) : ?>
<div class="relative px-6 lg:px-[8.5%] -mt-[220px] lg:-mt-[280px] mb-12 lg:mb-16 z-10">
    <?php if ( $film_url ) : ?>
    <a href="<?php echo esc_url( $film_url ); ?>" target="_blank" rel="noopener" class="group block relative">
    <?php else : ?>
    <div class="relative">
    <?php endif; ?>

        <div class="overflow-hidden rounded-xl" style="aspect-ratio:1414/778;">
            <?php the_post_thumbnail( 'full', [ 'class' => 'w-full h-full object-cover' ] ); ?>
        </div>

        <?php if ( $film_url ) : ?>
        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
            <div class="flex items-center justify-center rounded-full bg-[#bcac8e]/80 group-hover:bg-[#bcac8e] transition-colors duration-300" style="width:120px;height:120px;">
                <span class="font-heading text-white text-[1.25rem] leading-none tracking-[0.5px]">Play</span>
            </div>
        </div>
        <?php endif; ?>

    <?php if ( $film_url ) : ?>
    </a>
    <?php else : ?>
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>

<!-- Cream content area -->
<section class="bg-brand-100 px-6 lg:px-[8.5%] <?php echo has_post_thumbnail() ? 'pt-0' : 'pt-20 lg:pt-28'; ?> pb-20 lg:pb-28">

    <!-- Body text -->
    <?php if ( get_the_content() ) : ?>
    <div class="portfolio-content max-w-[780px] mx-auto mb-16 lg:mb-20">
        <?php the_content(); ?>
    </div>
    <?php endif; ?>

    <!-- Photo gallery — staggered 2-column -->
    <?php if ( $gallery ) :
        $left_imgs  = [];
        $right_imgs = [];
        foreach ( $gallery as $i => $img ) {
            if ( $i % 2 === 0 ) $left_imgs[] = $img;
            else $right_imgs[] = $img;
        }
    ?>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-[7%]">

        <div class="flex flex-col gap-8 lg:gap-12">
            <?php foreach ( $left_imgs as $img ) : ?>
            <div class="overflow-hidden rounded-xl" style="aspect-ratio:650/433;">
                <img
                    src="<?php echo esc_url( $img['sizes']['large'] ?? $img['url'] ); ?>"
                    alt="<?php echo esc_attr( $img['alt'] ); ?>"
                    class="w-full h-full object-cover"
                    loading="lazy"
                >
            </div>
            <?php endforeach; ?>
        </div>

        <div class="flex flex-col gap-8 lg:gap-12 mt-8 lg:mt-[118px]">
            <?php foreach ( $right_imgs as $img ) : ?>
            <div class="overflow-hidden rounded-xl" style="aspect-ratio:650/433;">
                <img
                    src="<?php echo esc_url( $img['sizes']['large'] ?? $img['url'] ); ?>"
                    alt="<?php echo esc_attr( $img['alt'] ); ?>"
                    class="w-full h-full object-cover"
                    loading="lazy"
                >
            </div>
            <?php endforeach; ?>
        </div>

    </div>
    <?php endif; ?>

</section>

<!-- Other Happy Couples -->
<?php if ( $related->have_posts() ) :
    $rel_items = $related->posts;
    $rel_left  = [];
    $rel_right = [];
    foreach ( $rel_items as $i => $item ) {
        if ( $i % 2 === 0 ) $rel_left[] = $item;
        else $rel_right[] = $item;
    }
    $archive_url = get_post_type_archive_link( 'portfolio' );
?>
<section class="bg-brand-100 px-6 lg:px-[8.5%] pb-20 lg:pb-28">

    <div class="flex items-center justify-between mb-12">
        <h2 class="font-heading text-[2.25rem] text-black tracking-[0.3px]">Other happy couples</h2>
        <?php if ( $archive_url ) : ?>
        <a href="<?php echo esc_url( $archive_url ); ?>"
           class="font-body text-[1.125rem] text-white bg-black rounded-[50px] px-10 py-3.5 hover:bg-brand-400 transition-colors duration-300 whitespace-nowrap">
            View all
        </a>
        <?php endif; ?>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-[7%]">

        <div class="flex flex-col gap-16 lg:gap-[100px]">
            <?php foreach ( $rel_left as $item ) : ?>
            <article>
                <a href="<?php echo esc_url( get_permalink( $item->ID ) ); ?>" class="group block">
                    <?php if ( has_post_thumbnail( $item->ID ) ) : ?>
                    <div class="overflow-hidden rounded-xl mb-4" style="aspect-ratio:650/433;">
                        <?php echo get_the_post_thumbnail( $item->ID, 'large', [
                            'class' => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-[1.03]',
                        ] ); ?>
                    </div>
                    <?php endif; ?>
                    <h3 class="font-heading text-[1.5rem] text-black leading-snug tracking-[0.5px] mb-1">
                        <?php echo esc_html( get_the_title( $item->ID ) ); ?>
                    </h3>
                    <?php $loc = get_field( 'location', $item->ID ); if ( $loc ) : ?>
                    <p class="font-body text-[1.125rem] text-[#bbab8b]"><?php echo esc_html( $loc ); ?></p>
                    <?php endif; ?>
                </a>
            </article>
            <?php endforeach; ?>
        </div>

        <div class="flex flex-col gap-16 lg:gap-[100px] mt-12 lg:mt-[100px]">
            <?php foreach ( $rel_right as $item ) : ?>
            <article>
                <a href="<?php echo esc_url( get_permalink( $item->ID ) ); ?>" class="group block">
                    <?php if ( has_post_thumbnail( $item->ID ) ) : ?>
                    <div class="overflow-hidden rounded-xl mb-4" style="aspect-ratio:650/433;">
                        <?php echo get_the_post_thumbnail( $item->ID, 'large', [
                            'class' => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-[1.03]',
                        ] ); ?>
                    </div>
                    <?php endif; ?>
                    <h3 class="font-heading text-[1.5rem] text-black leading-snug tracking-[0.5px] mb-1">
                        <?php echo esc_html( get_the_title( $item->ID ) ); ?>
                    </h3>
                    <?php $loc = get_field( 'location', $item->ID ); if ( $loc ) : ?>
                    <p class="font-body text-[1.125rem] text-[#bbab8b]"><?php echo esc_html( $loc ); ?></p>
                    <?php endif; ?>
                </a>
            </article>
            <?php endforeach; ?>
        </div>

    </div>
</section>
<?php endif; ?>

<?php endwhile; ?>
<?php get_footer(); ?>
