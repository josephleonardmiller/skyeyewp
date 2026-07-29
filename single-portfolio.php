<?php
get_header();

while ( have_posts() ) : the_post();

$location     = get_field( 'location' );
$wedding_date = get_field( 'wedding_date' );
$film_url         = get_field( 'film_url' );
$video_thumbnail  = get_field( 'video_thumbnail' );
$gallery          = get_field( 'gallery' );
$text_1       = get_field( 'text_1' );
$text_2       = get_field( 'text_2' );
$text_3       = get_field( 'text_3' );

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
    <div class="container mx-auto pb-12 lg:pb-16">
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
<?php
$hero_img_url = $video_thumbnail ? esc_url( $video_thumbnail['url'] ) : '';
$hero_img_alt = $video_thumbnail ? esc_attr( $video_thumbnail['alt'] ) : esc_attr( get_the_title() );
$has_hero     = $video_thumbnail || has_post_thumbnail();
?>
<?php if ( $has_hero ) : ?>
<div class="relative px-6 lg:px-[8.5%] -mt-[220px] lg:-mt-[280px] mb-12 lg:mb-16 z-10">
    <?php if ( $film_url ) : ?>
    <button id="vimeo-play-btn" type="button" data-vimeo-url="<?php echo esc_attr( $film_url ); ?>" class="group block relative w-full cursor-pointer">
    <?php else : ?>
    <div class="relative">
    <?php endif; ?>

        <div class="overflow-hidden rounded-xl" style="aspect-ratio:1414/778;">
            <?php if ( $video_thumbnail ) : ?>
            <img src="<?php echo $hero_img_url; ?>" alt="<?php echo $hero_img_alt; ?>" class="w-full h-full object-cover">
            <?php else : ?>
            <?php the_post_thumbnail( 'full', [ 'class' => 'w-full h-full object-cover' ] ); ?>
            <?php endif; ?>
        </div>

        <?php if ( $film_url ) : ?>
        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
            <div class="flex items-center justify-center rounded-full bg-[#bcac8e]/80 group-hover:bg-[#bcac8e] transition-colors duration-300" style="width:120px;height:120px;">
                <span class="font-heading text-white text-[1.25rem] leading-none tracking-[0.5px]">Play</span>
            </div>
        </div>
        <?php endif; ?>

    <?php if ( $film_url ) : ?>
    </button>
    <?php else : ?>
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>

<!-- Vimeo lightbox -->
<?php if ( $film_url ) : ?>
<div id="vimeo-lightbox" class="fixed inset-0 z-[200] bg-black/90 flex items-center justify-center hidden" aria-hidden="true" role="dialog" aria-label="Wedding film">
    <button id="vimeo-close" type="button" aria-label="Close video" class="absolute top-6 right-6 text-white opacity-70 hover:opacity-100 transition-opacity duration-200">
        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
            <path d="M24 8L8 24M8 8l16 16"/>
        </svg>
    </button>
    <div class="w-full max-w-[1100px] px-6">
        <div class="relative w-full rounded-xl overflow-hidden" style="aspect-ratio:16/9;">
            <iframe id="vimeo-iframe" src="" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen class="absolute inset-0 w-full h-full"></iframe>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Cream content area -->
<section class="bg-brand-100 px-6 lg:px-[8.5%] <?php echo $has_hero ? 'pt-0' : 'pt-20 lg:pt-28'; ?> pb-20 lg:pb-28">

    <!-- Text 1: lead paragraph (bold, above gallery) -->
    <?php if ( $text_1 ) : ?>
    <div class="max-w-[780px] mx-auto mb-16 lg:mb-20">
        <p class="font-body text-[1.25rem] font-semibold text-[#0d111d] leading-[1.7] tracking-[0.01em]">
            <?php echo nl2br( esc_html( $text_1 ) ); ?>
        </p>
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

    <!-- Text 2 + Text 3: body paragraphs below gallery -->
    <?php if ( $text_2 || $text_3 ) : ?>
    <div class="max-w-[780px] mx-auto mt-16 lg:mt-20">
        <?php if ( $text_2 ) : ?>
        <p class="font-body text-[1.125rem] font-light text-black leading-[1.556] mb-7">
            <?php echo nl2br( esc_html( $text_2 ) ); ?>
        </p>
        <?php endif; ?>
        <?php if ( $text_3 ) : ?>
        <p class="font-body text-[1.125rem] font-light text-black leading-[1.556]">
            <?php echo nl2br( esc_html( $text_3 ) ); ?>
        </p>
        <?php endif; ?>
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
