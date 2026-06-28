<?php
$heading     = get_sub_field( 'heading' )              ?: 'Unforgettable';
$subheading  = get_sub_field( 'subheading' )           ?: 'moments';
$description = get_sub_field( 'description' )          ?: '';
$video_url   = get_sub_field( 'background_video_url' ) ?: '';
?>

<section class="hero relative w-full h-screen overflow-hidden bg-black" data-hero>
    <div class="loader-overlay-top absolute inset-0 bg-brand-100 z-50 origin-right" style="width:0%"></div>
    <div class="loader-overlay-bottom absolute inset-0 bg-brand-100 z-40 origin-right" style="width:0%"></div>

    <?php if ( $video_url ) : ?>
    <div class="absolute inset-0 z-0" data-hero-parallax>
        <video class="absolute inset-0 w-full h-full object-cover object-center" autoplay muted loop playsinline preload="metadata">
            <source src="<?php echo esc_url( $video_url ); ?>">
        </video>
    </div>
    <?php endif; ?>

    <!-- Gradient: black at top fading to transparent -->
    <div class="absolute inset-x-0 top-0 h-[66%] z-[1]" style="background: linear-gradient(180deg, #000000 0%, rgba(0,0,0,0) 100%);"></div>
    <!-- Gradient: transparent at top fading to black at bottom -->
    <div class="absolute inset-x-0 bottom-0 h-[66%] z-[1]" style="background: linear-gradient(180deg, rgba(0,0,0,0) 0%, #000000 100%);"></div>

    <div class="absolute inset-0 z-10 flex flex-col justify-end pb-[1.875rem] md:pb-[4.0625rem]">
        <div class="container mx-auto px-6 lg:px-16">

            <!-- "Unforgettable" — full-width row -->
            <div class="overflow-hidden">
                <h2 class="hero-top-title font-heading text-white text-[10vw] md:text-[7.25rem] leading-normal translate-y-full opacity-0">
                    <?php echo esc_html( $heading ); ?>
                </h2>
            </div>

            <!-- Second row: description LEFT + "moments" RIGHT on desktop -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between md:-mt-[2.8125rem]">

                <?php if ( $description ) : ?>
                <!-- Description: last on mobile, first on desktop -->
                <div class="overflow-hidden order-last md:order-first">
                    <p class="hero-description font-body text-white font-light text-base md:text-xl leading-[1.45] max-w-[315px] translate-y-full opacity-0">
                        <?php echo esc_html( $description ); ?>
                    </p>
                </div>
                <?php endif; ?>

                <!-- "moments": first on mobile (-order-1), last on desktop -->
                <div class="overflow-hidden -order-1 md:order-last">
                    <h2 class="hero-bottom-title font-heading text-brand-200 text-[10vw] md:text-[7.25rem] leading-normal translate-y-full opacity-0">
                        <?php echo esc_html( $subheading ); ?>
                    </h2>
                </div>

            </div>
        </div>
    </div>
</section>
