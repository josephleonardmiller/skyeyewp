<?php
$heading   = get_field( 'heading' )              ?: 'Unforgettable';
$subheading = get_field( 'subheading' )           ?: 'moments';
$description = get_field( 'description' )         ?: '';
$video_url = get_field( 'background_video_url' )  ?: '';
?>

<section class="hero relative w-full h-screen overflow-hidden bg-black" data-hero>
    <!-- Page transition overlays -->
    <div class="loader-overlay-top absolute inset-0 bg-brand-100 z-50 origin-right" style="width:0%"></div>
    <div class="loader-overlay-bottom absolute inset-0 bg-brand-100 z-40 origin-right" style="width:0%"></div>

    <!-- Video background -->
    <?php if ( $video_url ) : ?>
    <div class="hero-video-wrapper absolute inset-0 z-0" data-hero-parallax>
        <video
            class="absolute inset-0 w-full h-full object-cover"
            autoplay
            muted
            loop
            playsinline
            preload="metadata"
        >
            <source src="<?php echo esc_url( $video_url ); ?>">
        </video>
        <div class="absolute inset-0 bg-black/30"></div>
    </div>
    <?php endif; ?>

    <!-- Content -->
    <div class="relative z-10 flex flex-col justify-end h-full px-6 pb-16 lg:px-16 lg:pb-24">
        <div class="overflow-hidden">
            <h1 class="hero-top-title font-heading text-white text-[clamp(3rem,10vw,9rem)] leading-none tracking-tight translate-y-full opacity-0">
                <?php echo esc_html( $heading ); ?>
            </h1>
        </div>
        <div class="overflow-hidden">
            <h1 class="hero-bottom-title font-heading text-white text-[clamp(3rem,10vw,9rem)] leading-none tracking-tight translate-y-full opacity-0">
                <?php echo esc_html( $subheading ); ?>
            </h1>
        </div>
        <?php if ( $description ) : ?>
        <div class="overflow-hidden mt-6">
            <p class="hero-description font-body text-white/80 text-base lg:text-lg max-w-md translate-y-full opacity-0">
                <?php echo esc_html( $description ); ?>
            </p>
        </div>
        <?php endif; ?>
    </div>
</section>
