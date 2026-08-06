<?php
get_header();

while ( have_posts() ) : the_post();

$location     = get_field( 'location' );
$wedding_date = get_field( 'wedding_date' );
$film_url         = get_field( 'film_url' );
$video_thumbnail  = get_field( 'video_thumbnail' );
$gallery          = get_field( 'gallery' );
$text_1             = get_field( 'text_1' );
$text_2             = get_field( 'text_2' );
$text_3             = get_field( 'text_3' );
$quote              = get_field( 'quote' );
$quote_attribution  = get_field( 'quote_attribution' );

$related = new WP_Query( [
    'post_type'      => 'portfolio',
    'post_status'    => 'publish',
    'posts_per_page' => 2,
    'post__not_in'   => [ get_the_ID() ],
    'orderby'        => 'menu_order date',
    'order'          => 'ASC',
] );
?>

<!-- Dark hero — couple name + location/date -->
<section class="bg-black text-center px-6 pt-40 lg:pt-48 pb-[220px] lg:pb-[280px]">
    <div class="container mx-auto pb-12 lg:pb-16">
        <h1 class="font-heading text-[2.625rem] lg:text-[4rem] text-[#f8f5ef] leading-tight mb-3" style="letter-spacing:-2px;">
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
preg_match( '/vimeo\.com\/(\d+)/', $film_url ?? '', $vid_match );
$vimeo_id = $vid_match[1] ?? null;
$has_hero  = $vimeo_id || $video_thumbnail || has_post_thumbnail();
?>
<?php if ( $has_hero ) : ?>
<div class="relative px-6 lg:px-[8.5%] -mt-[220px] lg:-mt-[280px] mb-12 lg:mb-16 z-10">
    <div class="relative overflow-hidden rounded-xl" style="aspect-ratio:1414/778;">

        <?php if ( $vimeo_id ) : ?>
        <iframe id="portfolio-vimeo"
            src="https://player.vimeo.com/video/<?php echo esc_attr( $vimeo_id ); ?>?title=0&byline=0&portrait=0&dnt=1"
            style="position:absolute;inset:0;width:100%;height:100%;border:0;"
            allow="autoplay; fullscreen; picture-in-picture"
            allowfullscreen
        ></iframe>

        <!-- Play overlay — custom thumbnail poster + play button, removed by JS on click -->
        <div id="portfolio-play-overlay" class="group/play absolute inset-0 z-10 flex items-center justify-center cursor-pointer">
            <?php if ( $video_thumbnail ) : ?>
            <img src="<?php echo esc_url( $video_thumbnail['sizes']['large'] ?? $video_thumbnail['url'] ); ?>"
                 alt="<?php echo esc_attr( $video_thumbnail['alt'] ); ?>"
                 class="absolute inset-0 w-full h-full object-cover">
            <?php endif; ?>
            <div class="relative flex items-center justify-center rounded-full bg-[#bcac8e]/80 group-hover/play:bg-[#bcac8e] transition-colors duration-300 w-20 h-20 lg:w-[120px] lg:h-[120px]">
                <span class="font-heading text-white text-[1.25rem] leading-none tracking-[0.5px]">Play</span>
            </div>
        </div>
        <?php elseif ( $video_thumbnail ) : ?>
        <img src="<?php echo $hero_img_url; ?>" alt="<?php echo $hero_img_alt; ?>" class="absolute inset-0 w-full h-full object-cover">
        <?php else : ?>
        <?php the_post_thumbnail( 'full', [ 'class' => 'absolute inset-0 w-full h-full object-cover' ] ); ?>
        <?php endif; ?>

    </div>
</div>
<?php endif; ?>

<!-- Cream content area -->
<section class="bg-brand-100 px-6 lg:px-[8.5%] <?php echo $has_hero ? 'pt-8 lg:pt-0' : 'pt-20 lg:pt-28'; ?> pb-20 lg:pb-28">

    <!-- Text 1: lead paragraph (bold, above gallery) -->
    <?php if ( $text_1 ) : ?>
    <div class="max-w-[780px] mx-auto mb-10 lg:mb-12">
        <p class="font-body text-[1.25rem] font-semibold text-[#0d111d] leading-[1.7] tracking-[0.01em]">
            <?php echo nl2br( esc_html( $text_1 ) ); ?>
        </p>
    </div>
    <?php endif; ?>

    <!-- Text 2: body paragraph above gallery -->
    <?php if ( $text_2 ) : ?>
    <div class="max-w-[780px] mx-auto mb-16 lg:mb-20">
        <p class="font-body text-[1.125rem] font-light text-black leading-[1.556]">
            <?php echo nl2br( esc_html( $text_2 ) ); ?>
        </p>
    </div>
    <?php endif; ?>

    <!-- Photo gallery — scattered 5-image layout + 2-col overflow -->
    <?php if ( $gallery ) :
        $feature = array_slice( $gallery, 0, 5 );
        $extra   = array_slice( $gallery, 5, 2 );
    ?>

    <!-- Mobile: stacked column -->
    <div class="lg:hidden flex flex-col gap-6">
        <?php foreach ( $feature as $img ) : ?>
        <div class="overflow-hidden rounded-xl" style="aspect-ratio:3/2;">
            <img
                src="<?php echo esc_url( $img['sizes']['large'] ?? $img['url'] ); ?>"
                alt="<?php echo esc_attr( $img['alt'] ); ?>"
                class="w-full h-full object-cover"
                loading="lazy"
            >
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Desktop: scattered absolute layout -->
    <?php
    $slots  = [
        'left:27%;top:7%;width:46%;z-index:1;',   // 0: centre (large, behind corners)
        'left:0%;top:0%;width:23%;z-index:2;',     // 1: upper-left
        'right:0%;top:0%;width:23%;z-index:2;',    // 2: upper-right
        'left:0%;top:61%;width:23%;z-index:2;',    // 3: lower-left
        'right:0%;top:61%;width:23%;z-index:2;',   // 4: lower-right
    ];
    $ratios = ['3/2', '7/4', '7/4', '7/4', '7/4'];
    ?>
    <div class="hidden lg:block relative" style="padding-bottom:41%;">
        <?php foreach ( $feature as $i => $img ) :
            if ( ! isset($slots[$i]) ) continue;
        ?>
        <div class="absolute overflow-hidden rounded-xl"
             style="<?php echo $slots[$i]; ?>aspect-ratio:<?php echo $ratios[$i]; ?>;">
            <img
                src="<?php echo esc_url( $img['sizes']['large'] ?? $img['url'] ); ?>"
                alt="<?php echo esc_attr( $img['alt'] ); ?>"
                class="w-full h-full object-cover"
                loading="lazy"
            >
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Quote -->
    <?php if ( $quote ) : ?>
    <div class="max-w-[700px] mx-auto py-16 lg:py-20 text-center">
        <p class="font-heading text-[#bcac8e] text-[3rem] leading-none mb-6">"</p>
        <p class="font-heading text-[1.125rem] lg:text-[1.5rem] text-black leading-[1.7] lg:leading-[46px] tracking-[0.5px]">
            <?php echo esc_html( $quote ); ?>
        </p>
        <?php if ( $quote_attribution ) : ?>
        <p class="font-body text-[0.875rem] text-[#bbab8b] tracking-[0.5px] mt-5">
            <?php echo esc_html( $quote_attribution ); ?>
        </p>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <!-- Extra images (6+): 2-column staggered -->
    <?php if ( $extra ) :
        $left_extra = []; $right_extra = [];
        foreach ( $extra as $i => $img ) {
            if ( $i % 2 === 0 ) $right_extra[] = $img;
            else $left_extra[] = $img;
        }
    ?>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-[8.5%] gap-y-6 lg:gap-y-0 mt-8 lg:mt-12">
        <div class="flex flex-col gap-8 lg:gap-12 mt-8 lg:mt-[118px]">
            <?php foreach ( $left_extra as $img ) : ?>
            <div class="overflow-hidden rounded-xl" style="aspect-ratio:3/2;">
                <img
                    src="<?php echo esc_url( $img['sizes']['large'] ?? $img['url'] ); ?>"
                    alt="<?php echo esc_attr( $img['alt'] ); ?>"
                    class="w-full h-full object-cover"
                    loading="lazy"
                >
            </div>
            <?php endforeach; ?>
        </div>
        <div class="flex flex-col gap-8 lg:gap-12">
            <?php foreach ( $right_extra as $img ) : ?>
            <div class="overflow-hidden rounded-xl" style="aspect-ratio:3/2;">
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
