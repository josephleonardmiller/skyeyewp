<?php
$heading   = get_sub_field( 'heading' )              ?: 'Get in touch';
$video_url = get_sub_field( 'background_video_url' ) ?: '';
?>

<section class="contact-section relative min-h-screen flex items-center justify-center overflow-hidden bg-black" data-contact>
    <?php if ( $video_url ) : ?>
    <div class="contact-video-wrap absolute inset-0" data-contact-parallax>
        <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover opacity-60">
            <source src="<?php echo esc_url( $video_url ); ?>">
        </video>
    </div>
    <?php endif; ?>

    <div class="contact-frame absolute inset-0 bg-brand-100 z-10" style="clip-path: polygon(0 0, 100% 0, 100% 0%, 0% 0%);" data-contact-frame></div>

    <div class="relative z-20 text-center px-6">
        <h2 class="contact-heading font-heading text-5xl lg:text-8xl text-white opacity-0" data-contact-heading>
            <?php echo esc_html( $heading ); ?>
        </h2>
        <div class="contact-spinner mt-8 opacity-0" data-contact-spinner>
            <div class="w-12 h-12 border-2 border-white/30 border-t-white rounded-full animate-spin mx-auto"></div>
        </div>
        <div class="mt-12 max-w-xl mx-auto contact-form-embed opacity-0" data-contact-content>
            <?php get_template_part( 'templates/partials/contact-form' ); ?>
        </div>
    </div>
</section>
