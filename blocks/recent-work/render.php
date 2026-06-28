<?php
$label1 = get_field( 'section_label_1' ) ?: 'Happy';
$label2 = get_field( 'section_label_2' ) ?: 'couples';
$items  = get_field( 'portfolio_items' ) ?: [];

$cloudinary_base = 'https://res.cloudinary.com/dbpg2xuhs/video/upload/q_auto,vc_vp9,w_1280,c_limit,f_auto/skyeye/';
?>

<section class="recent-work py-24 lg:py-32 bg-white overflow-hidden" data-recent-work>
    <div class="container mx-auto px-6 lg:px-16">

        <!-- Section heading -->
        <div class="flex items-baseline gap-4 mb-16">
            <h2 class="font-heading text-5xl lg:text-8xl text-black"><?php echo esc_html( $label1 ); ?></h2>
            <span class="font-heading text-5xl lg:text-8xl text-black/30"><?php echo esc_html( $label2 ); ?></span>
        </div>

        <!-- Video grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-1">
            <?php foreach ( $items as $i => $item ) :
                $video_id = $item['cloudinary_video_id'];
                $video_url = $video_id ? $cloudinary_base . $item['cloudinary_video_id'] . '.mp4' : '';
                $thumb = $item['thumbnail'];
                $direction = ( $i % 2 === 0 ) ? 'left' : 'right';
                $translate = $direction === 'left' ? '-20%' : '20%';
            ?>
            <article
                class="work-item relative overflow-hidden aspect-video cursor-none group"
                data-work-item
                data-direction="<?php echo esc_attr( $direction ); ?>"
            >
                <!-- Mask reveal wrapper -->
                <div
                    class="work-item-mask absolute inset-0"
                    data-work-mask
                    data-direction="<?php echo esc_attr( $direction ); ?>"
                    style="mask-image: repeating-linear-gradient(to <?php echo esc_attr( $direction === 'left' ? 'right' : 'left' ); ?>, rgba(0,0,0,0) 0px, rgba(0,0,0,0) 650px, rgba(0,0,0,1) 650px, rgba(0,0,0,1) 650px); -webkit-mask-image: repeating-linear-gradient(to <?php echo esc_attr( $direction === 'left' ? 'right' : 'left' ); ?>, rgba(0,0,0,0) 0px, rgba(0,0,0,0) 650px, rgba(0,0,0,1) 650px, rgba(0,0,0,1) 650px);"
                >
                    <!-- Thumbnail -->
                    <?php if ( $thumb ) : ?>
                    <img
                        src="<?php echo esc_url( $thumb['url'] ); ?>"
                        alt="<?php echo esc_attr( $thumb['alt'] ); ?>"
                        class="work-item-thumb absolute inset-0 w-full h-full object-cover"
                    >
                    <?php endif; ?>

                    <!-- Video (plays on hover) -->
                    <?php if ( $video_url ) : ?>
                    <video
                        class="work-item-video absolute inset-0 w-full h-full object-cover opacity-0 transition-opacity duration-300"
                        muted
                        loop
                        playsinline
                        preload="none"
                        data-src="<?php echo esc_url( $video_url ); ?>"
                        style="transform: translateX(<?php echo esc_attr( $translate ); ?>);"
                    >
                        <source src="<?php echo esc_url( $video_url ); ?>">
                    </video>
                    <?php endif; ?>

                    <!-- Dark overlay (scales on hover) -->
                    <div class="work-item-overlay absolute inset-0 bg-black/20"></div>
                </div>

                <!-- Text info -->
                <div class="absolute bottom-0 left-0 right-0 p-6 z-10">
                    <div class="overflow-hidden">
                        <h3 class="work-item-title font-heading text-white text-2xl lg:text-3xl opacity-0 translate-y-4" data-work-title>
                            <?php echo esc_html( $item['title'] ); ?>
                        </h3>
                    </div>
                    <div class="overflow-hidden">
                        <p class="work-item-location font-body text-white/70 text-sm mt-1 opacity-0 translate-y-4" data-work-location>
                            <?php echo esc_html( $item['location'] ); ?>
                        </p>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>

    </div>
</section>
