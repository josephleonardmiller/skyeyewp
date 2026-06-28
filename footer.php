</main>

<?php
$logo          = get_field( 'site_logo', 'option' );
$logo_url      = $logo ? esc_url( $logo['url'] ) : esc_url( SKYEYE_URI . '/assets/images/logo.png' );
$logo_alt      = $logo ? esc_attr( $logo['alt'] ) : 'Sky Eye Wedding Films';
$company       = get_field( 'company_name', 'option' ) ?: 'Sky Eye Wedding Films';
$footer_note   = get_field( 'footer_note', 'option' ) ?: 'Made in Ireland';
$facebook_url  = get_field( 'social_facebook', 'option' );
$twitter_url   = get_field( 'social_twitter', 'option' );
$instagram_url = get_field( 'social_instagram', 'option' );
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
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>
                        </svg>
                    </a>
                    <?php endif; ?>

                    <?php if ( $twitter_url ) : ?>
                    <a
                        href="<?php echo esc_url( $twitter_url ); ?>"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="flex h-9 w-9 items-center justify-center rounded-full border border-white text-white hover:bg-white hover:text-black transition-all duration-300"
                        aria-label="Twitter / X"
                    >
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
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
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                            <circle cx="12" cy="12" r="4"/>
                            <circle cx="17.5" cy="6.5" r="1.5" fill="currentColor" stroke="none"/>
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
