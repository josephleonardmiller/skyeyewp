<?php
$heading      = get_field( 'heading' )         ?: '';
$cta_label    = get_field( 'cta_label' )       ?: 'Get in touch';
$cta_link     = get_field( 'cta_link' );
$cta_url      = is_array( $cta_link ) ? $cta_link['url'] : get_permalink( get_page_by_path( 'contact' ) );
$images       = get_field( 'decorative_images' ) ?: [];
$videos       = get_field( 'video_overlays' )    ?: [];

// Map image indices to layout positions
$positions = [ 'top-left', 'center-left', 'center-right', 'bottom-right' ];
?>

<section class="callout relative py-32 lg:py-48 overflow-hidden bg-white" data-callout>
    <div class="container mx-auto px-6 lg:px-16 relative">

        <!-- Decorative images -->
        <?php foreach ( $images as $i => $row ) :
            $img  = $row['image'];
            $pos  = $positions[ $i ] ?? 'center-right';
            $delay = ( $i + 1 ) * 0.2;
            $dir  = ( $i % 2 === 0 ) ? 'to left' : 'to right';
        ?>
        <div
            class="callout-image callout-image--<?php echo esc_attr( $pos ); ?> absolute overflow-hidden"
            data-callout-image
            data-delay="<?php echo esc_attr( $delay ); ?>"
            data-direction="<?php echo esc_attr( $dir ); ?>"
            style="mask-image: repeating-linear-gradient(<?php echo esc_attr( $dir ); ?>, rgba(0,0,0,0) 0px, rgba(0,0,0,0) 650px, rgba(0,0,0,1) 650px, rgba(0,0,0,1) 650px); -webkit-mask-image: repeating-linear-gradient(<?php echo esc_attr( $dir ); ?>, rgba(0,0,0,0) 0px, rgba(0,0,0,0) 650px, rgba(0,0,0,1) 650px, rgba(0,0,0,1) 650px);"
        >
            <?php if ( $img ) : ?>
            <img src="<?php echo esc_url( $img['url'] ); ?>" alt="<?php echo esc_attr( $img['alt'] ); ?>" class="w-full h-full object-cover">
            <?php endif; ?>
        </div>
        <?php endforeach; ?>

        <!-- Video overlays -->
        <?php foreach ( $videos as $j => $row ) :
            $vurl  = $row['video_url'];
            $delay = ( $j + 1 ) * 0.4;
        ?>
        <?php if ( $vurl ) : ?>
        <div
            class="callout-video callout-video--<?php echo esc_attr( $j ); ?> absolute overflow-hidden"
            data-callout-image
            data-delay="<?php echo esc_attr( $delay ); ?>"
        >
            <video autoplay muted loop playsinline class="w-full h-full object-cover">
                <source src="<?php echo esc_url( $vurl ); ?>">
            </video>
        </div>
        <?php endif; ?>
        <?php endforeach; ?>

        <!-- Main content -->
        <div class="relative z-10 max-w-2xl mx-auto text-center">
            <?php if ( $heading ) : ?>
            <div class="overflow-hidden mb-12">
                <h2 class="callout-heading font-heading text-3xl lg:text-5xl text-black opacity-0 translate-y-8" data-callout-heading>
                    <?php echo esc_html( $heading ); ?>
                </h2>
            </div>
            <?php endif; ?>

            <div class="overflow-hidden">
                <a href="<?php echo esc_url( $cta_url ); ?>" class="callout-cta btn-primary opacity-0 translate-y-8" data-callout-cta>
                    <?php echo esc_html( $cta_label ); ?>
                </a>
            </div>
        </div>

    </div>
</section>
