<?php
$items = get_field( 'testimonials' ) ?: [];
?>

<section class="testimonials py-24 lg:py-32 bg-brand-100 overflow-hidden" data-testimonials>
    <div class="container mx-auto px-6 lg:px-16">

        <div class="relative min-h-[500px]">
            <?php foreach ( $items as $i => $item ) :
                $active = $i === 0 ? 'is-active' : '';
            ?>
            <div
                class="testimonial-slide absolute inset-0 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center <?php echo esc_attr( $active ); ?>"
                data-slide="<?php echo esc_attr( $i ); ?>"
                aria-hidden="<?php echo $i === 0 ? 'false' : 'true'; ?>"
            >
                <!-- Quote / Text -->
                <div class="testimonial-text-col">
                    <div class="overflow-hidden mb-6">
                        <blockquote class="testimonial-quote font-body text-xl lg:text-2xl text-black leading-relaxed opacity-0 translate-y-full" data-testi-quote>
                            &ldquo;<?php echo esc_html( $item['quote'] ); ?>&rdquo;
                        </blockquote>
                    </div>
                    <div class="overflow-hidden">
                        <p class="testimonial-name font-heading text-2xl text-black/50 opacity-0 translate-y-full" data-testi-name>
                            &mdash; <?php echo esc_html( $item['couple_name'] ); ?>
                        </p>
                    </div>
                </div>

                <!-- Images -->
                <div class="testimonial-images-col grid grid-cols-2 gap-4">
                    <?php if ( $item['image_1'] ) : ?>
                    <div
                        class="overflow-hidden aspect-[3/4]"
                        style="mask-image: repeating-linear-gradient(to left, rgba(0,0,0,0) 0px, rgba(0,0,0,0) 320px, rgba(0,0,0,1) 320px, rgba(0,0,0,1) 320px); -webkit-mask-image: repeating-linear-gradient(to left, rgba(0,0,0,0) 0px, rgba(0,0,0,0) 320px, rgba(0,0,0,1) 320px, rgba(0,0,0,1) 320px);"
                        data-testi-image
                        data-delay="0"
                    >
                        <img src="<?php echo esc_url( $item['image_1']['url'] ); ?>" alt="<?php echo esc_attr( $item['image_1']['alt'] ); ?>" class="w-full h-full object-cover">
                    </div>
                    <?php endif; ?>
                    <?php if ( $item['image_2'] ) : ?>
                    <div
                        class="overflow-hidden aspect-[3/4] mt-8"
                        style="mask-image: repeating-linear-gradient(to left, rgba(0,0,0,0) 0px, rgba(0,0,0,0) 320px, rgba(0,0,0,1) 320px, rgba(0,0,0,1) 320px); -webkit-mask-image: repeating-linear-gradient(to left, rgba(0,0,0,0) 0px, rgba(0,0,0,0) 320px, rgba(0,0,0,1) 320px, rgba(0,0,0,1) 320px);"
                        data-testi-image
                        data-delay="0.2"
                    >
                        <img src="<?php echo esc_url( $item['image_2']['url'] ); ?>" alt="<?php echo esc_attr( $item['image_2']['alt'] ); ?>" class="w-full h-full object-cover">
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Navigation dots -->
        <?php if ( count( $items ) > 1 ) : ?>
        <div class="flex gap-3 mt-12" role="tablist" data-testi-nav>
            <?php foreach ( $items as $i => $item ) : ?>
            <button
                class="testi-dot w-2 h-2 rounded-full bg-black/30 transition-all duration-300 <?php echo $i === 0 ? 'bg-black w-6' : ''; ?>"
                data-dot="<?php echo esc_attr( $i ); ?>"
                aria-label="Testimonial <?php echo esc_attr( $i + 1 ); ?>"
                role="tab"
            ></button>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

    </div>
</section>
