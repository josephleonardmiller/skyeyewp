</main>

<?php
$logo          = get_field( 'site_logo', 'option' );
$logo_url      = $logo ? esc_url( $logo['url'] ) : esc_url( SKYEYE_URI . '/assets/images/logo.png' );
$logo_alt      = $logo ? esc_attr( $logo['alt'] ) : 'Sky Eye Wedding Films';
$company       = get_field( 'company_name', 'option' ) ?: 'Sky Eye Wedding Films';
$footer_note   = get_field( 'footer_note', 'option' ) ?: 'Made in Ireland';
$facebook_url  = get_field( 'social_facebook', 'option' );
$instagram_url = get_field( 'social_instagram', 'option' );
$vimeo_url     = get_field( 'social_vimeo', 'option' );
?>

<footer class="sticky bottom-0 bg-black text-white pt-[4.0625rem] pb-[3.125rem]" data-footer>
    <div class="container mx-auto px-6 lg:px-16">

        <!-- Top row: logo left, nav right -->
        <div class="flex flex-wrap justify-between">

            <!-- Logo -->
            <div class="mb-10 flex w-full flex-col justify-between md:mb-0 md:w-auto">
                <a
                    href="<?php echo esc_url( home_url( '/' ) ); ?>"
                    class="inline-flex items-center hover:opacity-60 transition-opacity duration-300"
                    data-transition-link
                >
                    <div class="flex h-16 w-16 items-center justify-center rounded-full border border-white flex-shrink-0">
                        <img
                            src="<?php echo $logo_url; ?>"
                            alt="<?php echo $logo_alt; ?>"
                            width="32"
                            height="32"
                            class="w-8 h-8 object-contain"
                        >
                    </div>
                    <span class="ml-5 text-[1.125rem] uppercase tracking-[2.5px] text-white">
                        <?php echo esc_html( $company ); ?>
                    </span>
                </a>
            </div>

            <!-- Nav links -->
            <div class="w-full md:w-auto md:text-right">
                <?php wp_nav_menu( [
                    'theme_location' => 'footer',
                    'container'      => 'nav',
                    'container_attr' => [ 'aria-label' => 'Footer' ],
                    'menu_class'     => 'flex flex-col items-start md:items-end gap-[0.9375rem] pb-[1.875rem]',
                    'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
                    'link_class'     => 'nav-link text-[1.125rem] leading-[1.6] tracking-[0.5px] text-white inline-block',
                    'depth'          => 1,
                    'fallback_cb'    => false,
                ] ); ?>
            </div>

        </div>

        <!-- Bottom row: "Made in Ireland" + copyright left, social icons right -->
        <div class="flex flex-wrap items-center justify-between mt-8">

            <div class="w-full md:w-auto">
                <div class="flex items-center">
                    <span class="font-heading text-[0.875rem] leading-normal tracking-[0.5px] text-white/50 mr-[1.125rem]">
                        <?php echo esc_html( $footer_note ); ?>
                    </span>
                    <span class="text-[0.75rem] leading-normal tracking-[0.2px] text-white/50">
                        &copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php echo esc_html( $company ); ?>. All Rights Reserved.
                    </span>
                </div>
            </div>

            <div class="w-full md:w-auto md:text-right mt-6 md:mt-0">
                <div class="flex items-center md:justify-end gap-[1.25rem]">

                    <?php if ( $facebook_url ) : ?>
                    <a
                        href="<?php echo esc_url( $facebook_url ); ?>"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="flex h-9 w-9 items-center justify-center rounded-full border border-white text-white hover:bg-white hover:text-black transition-all duration-300"
                        aria-label="Facebook"
                    >
                        <svg viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4" aria-hidden="true">
                            <path d="M9.198 21.5h4v-8.01h3.604l.396-3.98h-4V7.5a1 1 0 0 1 1-1h3v-4h-3a5 5 0 0 0-5 5v2.01h-2l-.396 3.98h2.396v8.01Z"/>
                        </svg>
                    </a>
                    <?php endif; ?>

                    <?php if ( $instagram_url ) : ?>
                    <a
                        href="<?php echo esc_url( $instagram_url ); ?>"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="flex h-9 w-9 items-center justify-center rounded-full border border-white text-white hover:bg-white hover:text-black transition-all duration-300"
                        aria-label="Instagram"
                    >
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4" aria-hidden="true">
                            <rect x="2" y="2" width="20" height="20" rx="5"/>
                            <circle cx="12" cy="12" r="4"/>
                            <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/>
                        </svg>
                    </a>
                    <?php endif; ?>

                    <?php if ( $vimeo_url ) : ?>
                    <a
                        href="<?php echo esc_url( $vimeo_url ); ?>"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="flex h-9 w-9 items-center justify-center rounded-full border border-white text-white hover:bg-white hover:text-black transition-all duration-300"
                        aria-label="Vimeo"
                    >
                        <svg viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4" aria-hidden="true">
                            <path d="M22 7.42c-.09 2.01-1.5 4.77-4.2 8.28C15 19.33 12.55 21 10.56 21c-1.21 0-2.23-1.12-3.05-3.34l-1.67-6.08C5.17 9.36 4.46 8.18 3.7 8.18c-.16 0-.72.34-1.67.99L1 7.77c1.04-.91 2.07-1.82 3.07-2.73C5.4 3.88 6.4 3.15 7.08 3.09c1.62-.16 2.62.95 3 3.32.4 2.56.68 4.15.84 4.69.46 2.1.97 3.14 1.52 3.14.43 0 1.08-.68 1.94-2.03.86-1.35 1.32-2.38 1.38-3.09.12-1.17-.34-1.76-.97-1.76-.34 0-.7.08-1.07.24.71-2.33 2.07-3.46 4.07-3.4 1.49.05 2.19.99 2.21 2.21z"/>
                        </svg>
                    </a>
                    <?php endif; ?>

                </div>
            </div>

        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
