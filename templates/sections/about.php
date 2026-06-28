<?php
$title     = get_sub_field( 'section_title' ) ?: 'About Skyeye';
$para1     = get_sub_field( 'paragraph_1' )   ?: '';
$para2     = get_sub_field( 'paragraph_2' )   ?: '';
$image     = get_sub_field( 'featured_image' );
$cta_label = get_sub_field( 'cta_label' )     ?: 'Learn more';
$cta_url   = get_sub_field( 'cta_url' )       ?: get_permalink( get_page_by_path( 'about' ) );
?>

<section class="about relative py-24 lg:py-32 overflow-hidden bg-brand-100" data-about>
    <div class="container mx-auto px-6 lg:px-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

            <?php if ( $image ) : ?>
            <div class="about-image-wrap relative overflow-hidden rounded-sm" data-about-image>
                <img
                    src="<?php echo esc_url( $image['url'] ); ?>"
                    alt="<?php echo esc_attr( $image['alt'] ); ?>"
                    width="<?php echo esc_attr( $image['width'] ); ?>"
                    height="<?php echo esc_attr( $image['height'] ); ?>"
                    class="w-full h-full object-cover"
                    style="mask-image: repeating-linear-gradient(to left, rgba(0,0,0,0) 0px, rgba(0,0,0,0) 560px, rgba(0,0,0,1) 560px, rgba(0,0,0,1) 560px); -webkit-mask-image: repeating-linear-gradient(to left, rgba(0,0,0,0) 0px, rgba(0,0,0,0) 560px, rgba(0,0,0,1) 560px, rgba(0,0,0,1) 560px);"
                >
                <div class="absolute bottom-6 right-6">
                    <img src="<?php echo esc_url( SKYEYE_URI . '/assets/images/ireland.png' ); ?>" alt="Made in Ireland" class="w-20 h-20 animate-[spin_15s_linear_infinite]">
                </div>
            </div>
            <?php endif; ?>

            <div class="about-content">
                <div class="overflow-hidden mb-6">
                    <h2 class="about-heading font-heading text-4xl lg:text-6xl text-black opacity-0 -translate-x-24" data-about-heading>
                        <?php echo esc_html( $title ); ?>
                    </h2>
                </div>

                <?php if ( $para1 ) : ?>
                <div class="overflow-hidden mb-4">
                    <p class="about-para font-body text-black/70 text-base lg:text-lg leading-relaxed opacity-0 translate-y-8" data-about-para>
                        <?php echo esc_html( $para1 ); ?>
                    </p>
                </div>
                <?php endif; ?>

                <?php if ( $para2 ) : ?>
                <div class="overflow-hidden mb-8">
                    <p class="about-para font-body text-black/70 text-base lg:text-lg leading-relaxed opacity-0 translate-y-8" data-about-para>
                        <?php echo esc_html( $para2 ); ?>
                    </p>
                </div>
                <?php endif; ?>

                <div class="overflow-hidden">
                    <a href="<?php echo esc_url( $cta_url ); ?>" class="about-cta btn-primary opacity-0 translate-y-8" data-about-cta data-transition-link>
                        <?php echo esc_html( $cta_label ); ?>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>
