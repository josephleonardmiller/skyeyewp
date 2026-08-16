<?php
/**
 * Template Name: About
 */

get_header();

$hero_subtitle  = get_field( 'about_hero_subtitle' );
$s1_heading     = get_field( 'about_s1_heading' )    ?: 'About Skyeye';
$s1_body        = get_field( 'about_s1_body' );
$s1_image       = get_field( 'about_s1_image' );
$s1_button      = get_field( 'about_s1_button' )     ?: 'View portfolio';
$s1_button_url  = get_field( 'about_s1_button_url' );
$s2_heading     = get_field( 'about_s2_heading' )    ?: 'Approach';
$s2_body        = get_field( 'about_s2_body' );
$s2_image       = get_field( 'about_s2_image' );
$s2_button      = get_field( 'about_s2_button' )     ?: 'Get in touch';
$s2_button_url  = get_field( 'about_s2_button_url' );
$gal_rows       = get_field( 'about_gallery' ) ?: [];
$gal_center     = $gal_rows[0]['image'] ?? null;
$gal_left       = $gal_rows[1]['image'] ?? null;
$gal_right      = $gal_rows[2]['image'] ?? null;
$gal_extra      = array_slice( array_column( $gal_rows, 'image' ), 3 );
$gal_cta        = get_field( 'about_gal_cta' )       ?: 'Get in touch ↗';
$gal_cta_url    = get_field( 'about_gal_cta_url' );
$testimonial_post = get_field( 'about_testimonial_post' );
$gal_quote      = ( $testimonial_post ? get_field( 'quote', $testimonial_post->ID ) : null ) ?: get_field( 'about_quote' );
$gal_quote_attr = $testimonial_post ? get_the_title( $testimonial_post->ID ) : get_field( 'about_quote_attribution' );
$s3_heading     = get_field( 'about_s3_heading' )    ?: 'Aerial Cinematography';
$s3_body        = get_field( 'about_s3_body' );
$s3_image       = get_field( 'about_s3_image' );
$s3_button      = get_field( 'about_s3_button' )     ?: 'Get in touch';
$s3_button_url  = get_field( 'about_s3_button_url' );
$cta_bg         = get_field( 'about_cta_bg' ) ?: '#000000';
$form_id        = (int) ( get_field( 'about_form_id' ) ?: 1 );

if ( have_posts() ) { while ( have_posts() ) { the_post(); } }

$contact_url = get_permalink( get_page_by_path( 'contact' ) ) ?: '/contact';
$portfolio_url = get_post_type_archive_link( 'portfolio' ) ?: '/portfolio';
?>

<!-- ── Hero ─────────────────────────────────────────────────────────────── -->
<section class="bg-black text-center px-6 pt-40 lg:pt-48 pb-8 lg:pb-20">
    <div class="container mx-auto">
        <h1 class="font-heading text-[2.25rem] lg:text-[4rem] text-[#f8f5ef] leading-tight mb-6 lg:mb-8" style="letter-spacing:-2px;">
            <?php the_title(); ?>
        </h1>
        <?php if ( $hero_subtitle ) : ?>
        <p class="font-body text-base lg:text-[1.125rem] font-light text-white max-w-[600px] mx-auto leading-[1.5]">
            <?php echo esc_html( $hero_subtitle ); ?>
        </p>
        <?php endif; ?>
    </div>
</section>

<!-- ── About Skyeye — image left, text right ─────────────────────────────── -->
<section class="bg-brand-100 px-6 lg:px-[8.5%] pt-10 lg:pt-28 pb-20 lg:pb-24">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-y-10 gap-x-[7%] items-start">

        <!-- Image -->
        <?php if ( $s1_image ) : ?>
        <div class="overflow-hidden rounded-xl" style="aspect-ratio:9/10;">
            <img src="<?php echo esc_url( $s1_image['sizes']['large'] ?? $s1_image['url'] ); ?>"
                 alt="<?php echo esc_attr( $s1_image['alt'] ); ?>"
                 class="w-full h-full object-cover">
        </div>
        <?php else : ?>
        <div class="overflow-hidden rounded-xl bg-[#e8e2d9]" style="aspect-ratio:9/10;"></div>
        <?php endif; ?>

        <!-- Text -->
        <div class="lg:pt-6">
            <h2 class="font-heading text-[1.75rem] lg:text-[2.25rem] text-black tracking-[0.5px] mb-6" style="letter-spacing:0.5px;">
                <?php echo esc_html( $s1_heading ); ?>
            </h2>
            <?php if ( $s1_body ) : ?>
            <p class="font-body text-base lg:text-[1.125rem] font-light text-black leading-[1.5] lg:leading-[1.7] mb-10">
                <?php echo nl2br( esc_html( $s1_body ) ); ?>
            </p>
            <?php endif; ?>
            <a href="<?php echo esc_url( $s1_button_url ?: $portfolio_url ); ?>"
               class="font-body text-[1.125rem] text-white bg-black rounded-[50px] px-10 py-3.5 inline-block hover:bg-brand-400 transition-colors duration-300">
                <?php echo esc_html( $s1_button ); ?>
            </a>
        </div>

    </div>
</section>

<!-- ── Approach — text left, image right ─────────────────────────────────── -->
<section class="bg-brand-100 px-6 lg:px-[8.5%] pb-20 lg:pb-24">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-y-10 gap-x-[7%] items-start">

        <!-- Text (first on mobile, first on desktop = left col) -->
        <div class="lg:pt-6">
            <h2 class="font-heading text-[1.75rem] lg:text-[2.25rem] text-black tracking-[0.5px] mb-6" style="letter-spacing:0.5px;">
                <?php echo esc_html( $s2_heading ); ?>
            </h2>
            <?php if ( $s2_body ) : ?>
            <p class="font-body text-base lg:text-[1.125rem] font-light text-black leading-[1.5] lg:leading-[1.7] mb-10">
                <?php echo nl2br( esc_html( $s2_body ) ); ?>
            </p>
            <?php endif; ?>
            <a href="<?php echo esc_url( $s2_button_url ?: $contact_url ); ?>"
               class="font-body text-[1.125rem] text-white bg-black rounded-[50px] px-10 py-3.5 inline-block hover:bg-brand-400 transition-colors duration-300">
                <?php echo esc_html( $s2_button ); ?>
            </a>
        </div>

        <!-- Image (second on mobile, second on desktop = right col) -->
        <?php if ( $s2_image ) : ?>
        <div class="overflow-hidden rounded-xl lg:order-last order-first" style="aspect-ratio:9/10;">
            <img src="<?php echo esc_url( $s2_image['sizes']['large'] ?? $s2_image['url'] ); ?>"
                 alt="<?php echo esc_attr( $s2_image['alt'] ); ?>"
                 class="w-full h-full object-cover">
        </div>
        <?php else : ?>
        <div class="overflow-hidden rounded-xl bg-[#e8e2d9] lg:order-last order-first" style="aspect-ratio:9/10;"></div>
        <?php endif; ?>

    </div>
</section>

<?php if ( $gal_rows || $gal_quote ) : ?>
<!-- ── Gallery break ──────────────────────────────────────────────────────── -->
<section class="bg-brand-100 pb-20 lg:pb-24 overflow-hidden">

    <?php
    // Slot positions (desktop scattered layout): left, top, width, aspect-ratio
    $slots = [
        [ 'left:17%',    'top:4%',    'width:22%', '3/2' ],  // 0: upper-left landscape
        [ 'right:14%',   'top:0%',    'width:22%', '3/2' ],  // 1: upper-right landscape
        [ 'right:-2%',   'top:27%',   'width:14%', '2/3' ],  // 2: far-right portrait
        [ 'left:-2%',    'top:38%',   'width:14%', '2/3' ],  // 3: far-left portrait
        [ 'left:18%',    'bottom:4%', 'width:24%', '3/2' ],  // 4: lower-centre landscape
        [ 'right:6%',    'bottom:6%', 'width:13%', '2/3' ],  // 5: lower-right portrait
    ];
    ?>

    <!-- Desktop: scattered absolute layout -->
    <div class="hidden lg:block relative" style="padding-bottom:72%;">

        <?php foreach ( $gal_rows as $i => $row ) :
            if ( ! isset( $slots[$i] ) || empty( $row['image'] ) ) continue;
            $img  = $row['image'];
            $slot = $slots[$i];
            $style = implode( ';', array_slice( $slot, 0, 3 ) ) . ';aspect-ratio:' . $slot[3] . ';';
        ?>
        <div class="absolute overflow-hidden rounded-xl" style="<?php echo $style; ?>">
            <img src="<?php echo esc_url( $img['sizes']['large'] ?? $img['url'] ); ?>"
                 alt="<?php echo esc_attr( $img['alt'] ); ?>"
                 class="w-full h-full object-cover">
        </div>
        <?php endforeach; ?>

        <!-- Quote: centred over the composition -->
        <?php if ( $gal_quote ) : ?>
        <div class="absolute text-center" style="left:21%;right:21%;top:50%;transform:translateY(-50%);">
            <p class="font-heading text-[#bcac8e] text-[3rem] leading-none mb-5">"</p>
            <p class="font-heading text-[1.25rem] text-black leading-[1.667] tracking-[0.5px]">
                <?php echo esc_html( $gal_quote ); ?>
            </p>
            <?php if ( $gal_quote_attr ) : ?>
            <p class="font-body text-[1.125rem] text-[#bbab8b] tracking-[0.5px] mt-5">
                <?php echo esc_html( $gal_quote_attr ); ?>
            </p>
            <?php endif; ?>
        </div>
        <?php endif; ?>

    </div>

    <!-- Mobile: stacked images + quote -->
    <div class="lg:hidden flex flex-col gap-4 px-6">
        <?php foreach ( $gal_rows as $row ) :
            if ( empty( $row['image'] ) ) continue;
            $img = $row['image'];
        ?>
        <div class="overflow-hidden rounded-xl" style="aspect-ratio:4/3;">
            <img src="<?php echo esc_url( $img['sizes']['large'] ?? $img['url'] ); ?>"
                 alt="<?php echo esc_attr( $img['alt'] ); ?>"
                 class="w-full h-full object-cover">
        </div>
        <?php endforeach; ?>

        <?php if ( $gal_quote ) : ?>
        <div class="text-center py-8">
            <p class="font-heading text-[#bcac8e] text-[3rem] leading-none mb-4">"</p>
            <p class="font-heading text-[1.125rem] text-black leading-[1.7] tracking-[0.5px]">
                <?php echo esc_html( $gal_quote ); ?>
            </p>
            <?php if ( $gal_quote_attr ) : ?>
            <p class="font-body text-[0.875rem] text-[#bbab8b] tracking-[0.5px] mt-4">
                <?php echo esc_html( $gal_quote_attr ); ?>
            </p>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>


</section>
<?php endif; ?>

<!-- ── Aerial Cinematography — image left, text right ────────────────────── -->
<section class="bg-brand-100 px-6 lg:px-[8.5%] pb-20 lg:pb-28">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-y-10 gap-x-[7%] items-start">

        <!-- Image -->
        <?php if ( $s3_image ) : ?>
        <div class="overflow-hidden rounded-xl" style="aspect-ratio:9/10;">
            <img src="<?php echo esc_url( $s3_image['sizes']['large'] ?? $s3_image['url'] ); ?>"
                 alt="<?php echo esc_attr( $s3_image['alt'] ); ?>"
                 class="w-full h-full object-cover">
        </div>
        <?php else : ?>
        <div class="overflow-hidden rounded-xl bg-[#e8e2d9]" style="aspect-ratio:9/10;"></div>
        <?php endif; ?>

        <!-- Text -->
        <div class="lg:pt-6">
            <h2 class="font-heading text-[1.75rem] lg:text-[2.25rem] text-black tracking-[0.5px] mb-6" style="letter-spacing:0.5px;">
                <?php echo esc_html( $s3_heading ); ?>
            </h2>
            <?php if ( $s3_body ) : ?>
            <p class="font-body text-base lg:text-[1.125rem] font-light text-black leading-[1.5] lg:leading-[1.7] mb-10">
                <?php echo nl2br( esc_html( $s3_body ) ); ?>
            </p>
            <?php endif; ?>
            <a href="<?php echo esc_url( $s3_button_url ?: $contact_url ); ?>"
               class="font-body text-[1.125rem] text-white bg-black rounded-[50px] px-10 py-3.5 inline-block hover:bg-brand-400 transition-colors duration-300">
                <?php echo esc_html( $s3_button ); ?>
            </a>
        </div>

    </div>
</section>

<!-- ── Get In Touch ───────────────────────────────────────────────────────── -->
<section class="relative overflow-hidden" style="background-color:<?php echo esc_attr( $cta_bg ?: '#000000' ); ?>;">

    <div class="relative z-10 px-6 lg:px-[8.5%] py-24 lg:py-32">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-[7%] items-start">

            <!-- Left: heading -->
            <div>
                <p class="font-heading text-[2.625rem] lg:text-[6.75rem] text-white leading-none" style="letter-spacing:-2px;">Get in</p>
                <p class="font-heading text-[2.625rem] lg:text-[6.75rem] text-white leading-none mb-8" style="letter-spacing:-2px;">touch</p>
                <p class="font-body text-[1.125rem] text-white/70">We just need a few details</p>
            </div>

            <!-- Right: Gravity Form -->
            <div class="about-contact-form" data-form-section>
                <?php if ( function_exists( 'gravity_form' ) ) : ?>
                    <?php gravity_form( $form_id, false, false, false, null, true ); ?>
                <?php else : ?>
                    <p class="font-body text-white/70 text-[1.125rem]">
                        <a href="<?php echo esc_url( $contact_url ); ?>"
                           class="text-[#bcac8e] underline underline-offset-4">
                            Visit our contact page →
                        </a>
                    </p>
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>

<?php get_footer(); ?>
