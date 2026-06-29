<?php
/**
 * Template Name: Contact
 */

get_header();

$video_url   = get_field( 'background_video_url' ) ?: 'https://res.cloudinary.com/dbpg2xuhs/video/upload/q_auto,vc_vp9,w_1280,c_limit,f_auto/Websiteheader_fbordq.mp4';
$form_id     = (int) get_field( 'form_id' ) ?: 1;
$ireland_img = SKYEYE_URI . '/assets/images/ireland.png';
?>

<div class="contact-page relative min-h-screen" data-contact>

    <!-- Right panel: form (always in DOM, revealed after video wipe) -->
    <div class="contact-content relative flex opacity-0">
        <div class="flex min-h-screen w-full flex-col justify-center bg-brand-200 px-5 pb-15 pt-[6.25rem] md:ml-auto md:w-1/2 md:px-[5.625rem] md:pb-[7.5rem] md:pt-[11.25rem]">
            <h2 class="font-heading text-[3rem] leading-tight text-white mb-8">Get in touch</h2>

            <?php if ( function_exists( 'gravity_form' ) ) : ?>
                <div data-form-section>
                    <?php gravity_form( $form_id, false, false, false, null, true ); ?>
                </div>
            <?php else : ?>
                <?php get_template_part( 'templates/partials/contact-form' ); ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Left panel: video (absolutely positioned, clip-path animated) -->
    <div class="contact-frame absolute inset-x-0 top-0 h-full overflow-hidden z-20"
         style="clip-path: polygon(0 0, 0 0, 0 100%, 0 100%);"
         data-contact-frame>

        <div class="absolute inset-x-0 contact-parallax-wrap" style="top:-3.125rem;bottom:-3.125rem;">
            <video
                autoplay muted loop playsinline
                class="absolute inset-0 w-full h-full object-cover object-center">
                <source src="<?php echo esc_url( $video_url ); ?>">
            </video>
        </div>

        <!-- Top gradient -->
        <div class="absolute inset-x-0 top-0 h-[66%]"
             style="background:linear-gradient(0deg,rgba(0,0,0,0) 0%,#000 100%);"></div>
        <!-- Bottom gradient -->
        <div class="absolute inset-x-0 bottom-0 h-[66%]"
             style="background:linear-gradient(180deg,rgba(0,0,0,0) 0%,#000 100%);"></div>
    </div>

    <!-- Spinning badge (appears after animation) -->
    <div class="contact-spinner absolute z-20 opacity-0"
         style="bottom:13%;left:calc(50% - 8.125rem);"
         data-contact-spinner>
        <img src="<?php echo esc_url( $ireland_img ); ?>" alt="Made in Ireland" width="165" height="165"
             style="animation:spin 15s linear infinite;">
    </div>

</div>

<?php get_footer(); ?>
