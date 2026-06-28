<?php
$heading   = get_sub_field( 'heading' )   ?: 'We specialize in creating beautiful, cinematic wedding films that capture all the emotions and special moments of your big day.';
$cta_label = get_sub_field( 'cta_label' ) ?: 'Get in touch';
$cta_url   = get_sub_field( 'cta_link' )  ?: get_permalink( get_page_by_path( 'contact' ) );
$images    = get_sub_field( 'decorative_images' ) ?: [];
$videos    = get_sub_field( 'video_overlays' )    ?: [];

// ACF images with fallback to theme assets
$img1 = !empty( $images[0]['image']['url'] ) ? $images[0]['image']['url'] : SKYEYE_URI . '/assets/images/callout1.jpg';
$img2 = !empty( $images[1]['image']['url'] ) ? $images[1]['image']['url'] : SKYEYE_URI . '/assets/images/callout2.jpg';
$img3 = !empty( $images[2]['image']['url'] ) ? $images[2]['image']['url'] : SKYEYE_URI . '/assets/images/callout3.jpg';
$img4 = !empty( $images[3]['image']['url'] ) ? $images[3]['image']['url'] : SKYEYE_URI . '/assets/images/callout4.jpg';

$vid1 = !empty( $videos[0]['video_url'] ) ? $videos[0]['video_url'] : '';
$vid2 = !empty( $videos[1]['video_url'] ) ? $videos[1]['video_url'] : '';

$badge_url   = SKYEYE_URI . '/assets/images/made-in-ireland.svg';
$ireland_url = SKYEYE_URI . '/assets/images/irelandalt.png';
?>

<section class="callout relative bg-brand-100 pt-[7.5rem] pb-[6.25rem] md:pt-[24.375rem] md:pb-[17.5rem] overflow-hidden text-center" data-callout>
    <div class="container-sm">
        <div class="relative" data-callout-container>

            <?php
            // ─── Image 1: upper-left, landscape ─────────────────────────────────────
            // position: right:calc(100%+50px), top:-170px, 200×135
            ?>
            <div class="absolute" style="width:200px;height:135px;top:-170px;right:calc(100% + 50px);">
                <div class="absolute inset-0"
                     data-callout-mask
                     data-dir="to left"
                     data-delay="0.2"
                     data-width="200"
                     style="mask-image:repeating-linear-gradient(to left,rgba(0,0,0,0) 0px,rgba(0,0,0,0) 200px,rgba(0,0,0,1) 200px,rgba(0,0,0,1) 200px);-webkit-mask-image:repeating-linear-gradient(to left,rgba(0,0,0,0) 0px,rgba(0,0,0,0) 200px,rgba(0,0,0,1) 200px,rgba(0,0,0,1) 200px);">
                    <img src="<?php echo esc_url( $img1 ); ?>" alt="" class="w-full h-full object-cover">
                </div>
                <?php // Spinning badge: top-right corner of Image 1 ?>
                <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/2 opacity-0 animate-[spin_15s_linear_infinite]"
                     data-callout-badge
                     style="width:165px;height:165px;">
                    <img src="<?php echo esc_url( $badge_url ); ?>" alt="Made in Ireland" class="w-full h-full">
                </div>
            </div>

            <?php // ─── Image 2: upper-left, portrait ── right:calc(100%+170px), top:20px, 222×334 ?>
            <div class="absolute" style="width:222px;height:334px;top:20px;right:calc(100% + 170px);">
                <div class="absolute inset-0"
                     data-callout-mask
                     data-dir="to left"
                     data-delay="0.8"
                     data-width="222"
                     style="mask-image:repeating-linear-gradient(to left,rgba(0,0,0,0) 0px,rgba(0,0,0,0) 222px,rgba(0,0,0,1) 222px,rgba(0,0,0,1) 222px);-webkit-mask-image:repeating-linear-gradient(to left,rgba(0,0,0,0) 0px,rgba(0,0,0,0) 222px,rgba(0,0,0,1) 222px,rgba(0,0,0,1) 222px);">
                    <img src="<?php echo esc_url( $img2 ); ?>" alt="" class="w-full h-full object-cover">
                </div>
            </div>

            <?php // ─── Image 3: upper-right, portrait ── left:calc(100%+170px), top:-85px, 222×334 ?>
            <div class="absolute" style="width:222px;height:334px;top:-85px;left:calc(100% + 170px);">
                <div class="absolute inset-0"
                     data-callout-mask
                     data-dir="to right"
                     data-delay="0.6"
                     data-width="222"
                     style="mask-image:repeating-linear-gradient(to right,rgba(0,0,0,0) 0px,rgba(0,0,0,0) 222px,rgba(0,0,0,1) 222px,rgba(0,0,0,1) 222px);-webkit-mask-image:repeating-linear-gradient(to right,rgba(0,0,0,0) 0px,rgba(0,0,0,0) 222px,rgba(0,0,0,1) 222px,rgba(0,0,0,1) 222px);">
                    <img src="<?php echo esc_url( $img3 ); ?>" alt="" class="w-full h-full object-cover">
                </div>
            </div>

            <?php // ─── Image 4: lower-right, landscape ── left:calc(100%+50px), bottom:-135px, 200×135 ?>
            <div class="absolute" style="width:200px;height:135px;bottom:-135px;left:calc(100% + 50px);">
                <div class="absolute inset-0"
                     data-callout-mask
                     data-dir="to right"
                     data-delay="1.0"
                     data-width="200"
                     style="mask-image:repeating-linear-gradient(to right,rgba(0,0,0,0) 0px,rgba(0,0,0,0) 200px,rgba(0,0,0,1) 200px,rgba(0,0,0,1) 200px);-webkit-mask-image:repeating-linear-gradient(to right,rgba(0,0,0,0) 0px,rgba(0,0,0,0) 200px,rgba(0,0,0,1) 200px,rgba(0,0,0,1) 200px);">
                    <img src="<?php echo esc_url( $img4 ); ?>" alt="" class="w-full h-full object-cover">
                </div>
            </div>

            <?php if ( $vid1 ) : ?>
            <?php // ─── Video 1: below-left ── left:-120px, top:calc(100%+30px), 320×215, desktop only ?>
            <div class="absolute hidden md:block overflow-hidden" style="width:320px;height:215px;left:-120px;top:calc(100% + 30px);">
                <div class="absolute inset-0"
                     data-callout-mask
                     data-dir="to left"
                     data-delay="1.2"
                     data-width="320"
                     style="mask-image:repeating-linear-gradient(to left,rgba(0,0,0,0) 0px,rgba(0,0,0,0) 320px,rgba(0,0,0,1) 320px,rgba(0,0,0,1) 320px);-webkit-mask-image:repeating-linear-gradient(to left,rgba(0,0,0,0) 0px,rgba(0,0,0,0) 320px,rgba(0,0,0,1) 320px,rgba(0,0,0,1) 320px);">
                    <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover object-center">
                        <source src="<?php echo esc_url( $vid1 ); ?>">
                    </video>
                </div>
            </div>
            <?php endif; ?>

            <?php if ( $vid2 ) : ?>
            <?php // ─── Video 2: above-right ── right:-120px, bottom:calc(100%+70px), 320×215, desktop only ?>
            <div class="absolute hidden md:block overflow-hidden" style="width:320px;height:215px;right:-120px;bottom:calc(100% + 70px);">
                <div class="absolute inset-0"
                     data-callout-mask
                     data-dir="to right"
                     data-delay="0.4"
                     data-width="320"
                     style="mask-image:repeating-linear-gradient(to right,rgba(0,0,0,0) 0px,rgba(0,0,0,0) 320px,rgba(0,0,0,1) 320px,rgba(0,0,0,1) 320px);-webkit-mask-image:repeating-linear-gradient(to right,rgba(0,0,0,0) 0px,rgba(0,0,0,0) 320px,rgba(0,0,0,1) 320px,rgba(0,0,0,1) 320px);">
                    <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover object-center">
                        <source src="<?php echo esc_url( $vid2 ); ?>">
                    </video>
                </div>
            </div>
            <?php endif; ?>

            <?php // ─── Central text content ?>
            <div class="relative overflow-hidden">
                <h2 class="callout-heading font-heading text-[1.25rem] leading-[1.8] tracking-[0.5px] md:text-[1.875rem] md:leading-[2.2] opacity-0 translate-y-full"
                    data-callout-heading>
                    <?php echo wp_kses_post( $heading ); ?>
                </h2>
            </div>
            <div class="relative mt-[2.8125rem] overflow-hidden">
                <div class="callout-cta opacity-0 translate-y-full" data-callout-cta>
                    <a href="<?php echo esc_url( $cta_url ); ?>" class="btn-primary" data-transition-link>
                        <span class="btn-inner"><?php echo esc_html( $cta_label ); ?></span>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>
