<?php
$heading         = get_sub_field( 'section_heading' )  ?: 'Recent work';
$label1          = get_sub_field( 'section_label_1' )  ?: 'Happy';
$label2          = get_sub_field( 'section_label_2' )  ?: 'couples';
$posts           = get_sub_field( 'portfolio_items' )  ?: [];
$cloudinary_base = 'https://res.cloudinary.com/dbpg2xuhs/video/upload/q_auto,vc_vp9,w_1280,c_limit,f_auto/skyeye/';
?>

<section class="recent-work relative overflow-hidden bg-brand-100 py-[6.25rem]" data-recent-work>
    <div class="container mx-auto px-6 lg:px-16">

        <!-- Section header -->
        <div class="flex flex-wrap items-center">

            <!-- Left: "Recent work" label -->
            <div class="w-full md:w-1/2">
                <div class="relative mt-[0.375rem] overflow-hidden">
                    <h3 class="font-heading text-[1.5rem] md:text-[2.25rem] leading-normal opacity-0 translate-y-full" data-work-label>
                        <?php echo esc_html( $heading ); ?>
                    </h3>
                </div>
            </div>

            <!-- Right: big faded "Happy / couples" heading -->
            <div class="w-full md:w-1/2">
                <h2 class="flex flex-wrap font-heading text-[3.75rem] md:text-[6.75rem] leading-normal tracking-[-2.5px] text-brand-200" style="opacity:0.25">
                    <div class="relative w-full overflow-hidden">
                        <div class="opacity-0 translate-y-full" data-work-label1><?php echo esc_html( $label1 ); ?></div>
                    </div>
                    <div class="relative ml-auto overflow-hidden md:-mt-[1.4375rem]">
                        <div class="opacity-0 translate-y-full" data-work-label2><?php echo esc_html( $label2 ); ?></div>
                    </div>
                </h2>
            </div>

        </div>

        <!-- Cards -->
        <div class="mt-[1.25rem] flex flex-wrap md:-mx-[3.75rem] md:-mt-[3.125rem]">
            <?php foreach ( $posts as $i => $item ) :
                $title     = $item->post_title;
                $location  = get_field( 'location', $item->ID );
                $video_id  = get_field( 'cloudinary_video_id', $item->ID );
                $video_url = $video_id ? $cloudinary_base . $video_id . '.mp4' : '';
                $thumb_url = get_the_post_thumbnail_url( $item->ID, 'large' );
                $direction = ( $i % 2 === 0 ) ? 'left' : 'right';
                $translate = $direction === 'left' ? '-20%' : '20%';
                $mask_dir  = $direction === 'left' ? 'to right' : 'to left';
                $even_top  = ( $i % 2 === 1 ) ? 'md:top-[7.5rem]' : '';
            ?>
            <div class="relative w-full mb-[2.5rem] md:w-1/2 md:mb-[5rem] md:px-[3.75rem] <?php echo esc_attr( $even_top ); ?>">
                <article
                    class="work-item group relative block w-full cursor-none"
                    data-work-item
                    data-direction="<?php echo esc_attr( $direction ); ?>"
                >

                    <!-- Image / video with mask reveal -->
                    <div
                        class="work-item-mask relative w-full overflow-hidden aspect-[3/2]"
                        data-work-mask
                        data-direction="<?php echo esc_attr( $direction ); ?>"
                        style="mask-image:repeating-linear-gradient(<?php echo esc_attr( $mask_dir ); ?>,rgba(0,0,0,0) 0px,rgba(0,0,0,0) 650px,rgba(0,0,0,1) 650px,rgba(0,0,0,1) 650px);-webkit-mask-image:repeating-linear-gradient(<?php echo esc_attr( $mask_dir ); ?>,rgba(0,0,0,0) 0px,rgba(0,0,0,0) 650px,rgba(0,0,0,1) 650px,rgba(0,0,0,1) 650px);"
                    >
                        <?php if ( $video_url ) : ?>
                        <div class="work-item-video-wrap absolute inset-0" style="transform:translateX(<?php echo esc_attr( $translate ); ?>);">
                            <video
                                class="work-item-video absolute inset-0 w-full h-full object-cover object-center"
                                muted loop playsinline preload="none"
                            >
                                <source src="<?php echo esc_url( $video_url ); ?>">
                            </video>
                        </div>
                        <?php endif; ?>

                        <?php if ( $thumb_url ) : ?>
                        <div class="work-item-thumb-wrap absolute inset-0">
                            <img
                                src="<?php echo esc_url( $thumb_url ); ?>"
                                alt="<?php echo esc_attr( $title ); ?>"
                                class="work-item-thumb absolute inset-0 w-full h-full object-cover object-center"
                            >
                        </div>
                        <?php endif; ?>

                    </div>

                    <!-- Text below image -->
                    <div class="py-[1.875rem]">
                        <div class="relative overflow-hidden">
                            <h3
                                class="work-item-title font-heading text-[1.5rem] leading-normal tracking-[0.5px] opacity-0 translate-y-full group-hover:underline"
                                data-work-title
                            >
                                <?php echo esc_html( $title ); ?>
                            </h3>
                        </div>
                        <?php if ( $location ) : ?>
                        <div class="relative mt-4 overflow-hidden">
                            <p
                                class="work-item-location font-body text-[1.25rem] leading-normal text-brand-400 opacity-0 translate-y-full"
                                data-work-location
                            >
                                <?php echo esc_html( $location ); ?>
                            </p>
                        </div>
                        <?php endif; ?>
                    </div>

                </article>
            </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>
