<?php
$posts = get_sub_field( 'testimonial_items' ) ?: [];

?>

<section class="testimonials relative overflow-hidden bg-brand-100 pt-[6.25rem] pb-[11.875rem]" data-testimonials>
    <div class="container mx-auto px-6 lg:px-16">

        <div class="flex flex-col md:flex-row">

            <!-- Left: quote text -->
            <div class="w-full md:grow">
                <div class="max-w-[935px] pt-[1.875rem]">

                    <!-- Opening quote SVG -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="42" height="28" viewBox="0 0 42 28" aria-hidden="true">
                        <path fill="#bbab8b" d="M22.724 16.168c0-1.776.276-3.552.94-5.328.627-1.84 1.515-3.552 2.664-5.015C27.582 4.362 29 3.16 30.716 2.22 32.493 1.28 34.53.81 36.828.81v.314c-.522 0-1.149.209-1.88.626-.627.418-1.202.993-1.724 1.724-.523.627-.888 1.41-1.097 2.35-.21.837-.127 1.725.313 2.665 2.717 0 4.963.94 6.74 2.821C41.06 13.086 42 15.333 42 18c0 2.765-.94 5.064-2.82 6.944-1.777 1.776-4.023 2.664-6.74 2.664-3.343 0-5.798-1.149-7.365-3.447-1.568-2.299-2.351-4.963-2.351-7.993zM0 16.168c0-1.776.313-3.552.94-5.328C1.567 9 2.455 7.288 3.604 5.825A16.123 16.123 0 0 1 8 2.22C9.769 1.28 11.806.81 14.104.81v.314c-.522 0-1.104.209-1.88.626A6.403 6.403 0 0 0 10.5 3.474c-.5.627-.888 1.41-1.097 2.35-.209.837-.105 1.725.313 2.665 2.717 0 4.963.94 6.74 2.821 1.88 1.776 2.82 4.023 2.82 6.69 0 2.765-.94 5.064-2.82 6.944-1.777 1.776-4.023 2.664-6.74 2.664-3.343 0-5.798-1.149-7.365-3.447C.784 21.862 0 19.198 0 16.168z"/>
                    </svg>

                    <!-- Quote text — slides stacked, animated in/out -->
                    <div class="relative mt-[2.5rem] overflow-hidden text-left" data-testi-quote-area>
                        <!-- Spacer to give the area height (first slide, hidden) -->
                        <div class="invisible font-heading text-[1.625rem] leading-[2.2] tracking-[0.5px]" aria-hidden="true">
                            <?php echo esc_html( $posts[0]->post_title ); ?>
                        </div>
                        <?php foreach ( $posts as $i => $item ) :
                            $quote = get_field( 'quote', $item->ID );
                        ?>
                        <div
                            class="testimonial-quote <?php echo $i === 0 ? '' : 'absolute inset-0'; ?> font-heading text-[1.625rem] leading-[2.2] tracking-[0.5px] opacity-0 translate-y-full"
                            data-testi-quote
                            data-index="<?php echo esc_attr( $i ); ?>"
                        >
                            <?php echo esc_html( $quote ); ?>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Name -->
                    <div class="relative mt-[2.5rem] overflow-hidden text-left" data-testi-name-area>
                        <div class="invisible text-[1.25rem] leading-[1.45] text-brand-400" aria-hidden="true">
                            <?php echo esc_html( $posts[0]->post_title ); ?>
                        </div>
                        <?php foreach ( $posts as $i => $item ) : ?>
                        <div
                            class="testimonial-name <?php echo $i === 0 ? '' : 'absolute inset-0'; ?> text-[1.25rem] leading-[1.45] text-brand-400 opacity-0 translate-y-full"
                            data-testi-name
                            data-index="<?php echo esc_attr( $i ); ?>"
                        >
                            <?php echo esc_html( $item->post_title ); ?>
                        </div>
                        <?php endforeach; ?>
                    </div>

                </div>
            </div>

            <!-- Right: images -->
            <div class="mt-[2.5rem] flex justify-center gap-[1.25rem] md:mt-0 md:block md:w-[400px] md:shrink-0 md:pl-[5rem]">

                <!-- Image 1 -->
                <div class="relative h-[160px] w-[calc(50%-10px)] overflow-hidden md:h-[215px] md:w-[320px] md:translate-x-[1.25rem]">
                    <?php foreach ( $posts as $i => $item ) :
                        $image_1 = get_field( 'image_1', $item->ID );
                        if ( ! $image_1 ) continue;
                    ?>
                    <div
                        class="absolute inset-0 overflow-hidden"
                        data-testi-image
                        data-index="<?php echo esc_attr( $i ); ?>"
                        style="mask-image:repeating-linear-gradient(to left,rgba(0,0,0,0) 0px,rgba(0,0,0,0) 320px,rgba(0,0,0,1) 320px,rgba(0,0,0,1) 320px);-webkit-mask-image:repeating-linear-gradient(to left,rgba(0,0,0,0) 0px,rgba(0,0,0,0) 320px,rgba(0,0,0,1) 320px,rgba(0,0,0,1) 320px);"
                    >
                        <img src="<?php echo esc_url( $image_1['url'] ); ?>" alt="<?php echo esc_attr( $image_1['alt'] ?: $item->post_title ); ?>" class="absolute inset-0 w-full h-full object-cover object-center">
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Image 2 -->
                <div class="relative h-[160px] w-[calc(50%-10px)] overflow-hidden md:mt-[65px] md:h-[215px] md:w-[320px] md:-translate-x-[2.5rem]">
                    <?php foreach ( $posts as $i => $item ) :
                        $image_2 = get_field( 'image_2', $item->ID );
                        if ( ! $image_2 ) continue;
                    ?>
                    <div
                        class="absolute inset-0 overflow-hidden"
                        data-testi-image
                        data-index="<?php echo esc_attr( $i ); ?>"
                        style="mask-image:repeating-linear-gradient(to left,rgba(0,0,0,0) 0px,rgba(0,0,0,0) 320px,rgba(0,0,0,1) 320px,rgba(0,0,0,1) 320px);-webkit-mask-image:repeating-linear-gradient(to left,rgba(0,0,0,0) 0px,rgba(0,0,0,0) 320px,rgba(0,0,0,1) 320px,rgba(0,0,0,1) 320px);"
                    >
                        <img src="<?php echo esc_url( $image_2['url'] ); ?>" alt="<?php echo esc_attr( $image_2['alt'] ?: $item->post_title ); ?>" class="absolute inset-0 w-full h-full object-cover object-center">
                    </div>
                    <?php endforeach; ?>
                </div>

            </div>
        </div>

        <!-- Dot / bar navigation -->
        <?php if ( count( $posts ) > 1 ) : ?>
        <div class="flex items-center justify-center pt-[5rem]" role="tablist" data-testi-nav>
            <?php foreach ( $posts as $i => $item ) : ?>
            <button
                class="testi-dot mx-[0.625rem] h-[1.5rem] w-[6.25rem] border-b-[0.625rem] border-t-[0.625rem] border-brand-100 transition-colors duration-300 <?php echo $i === 0 ? 'bg-brand-400' : 'bg-black'; ?>"
                data-dot="<?php echo esc_attr( $i ); ?>"
                aria-label="Testimonial <?php echo esc_attr( $i + 1 ); ?>"
                role="tab"
            ></button>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

    </div>
</section>
