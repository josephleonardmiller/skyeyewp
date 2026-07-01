<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <?php wp_head(); ?>
</head>
<body <?php body_class( 'bg-brand-100 antialiased overflow-x-hidden' ); ?>>
<?php wp_body_open(); ?>

<!-- Page transition overlay -->
<div class="page-transition-overlay fixed inset-0 bg-brand-100 z-[9999] pointer-events-none" style="clip-path: inset(0 100% 0 0);"></div>

<!-- Custom cursor -->
<div id="cursor" class="fixed top-0 left-0 pointer-events-none z-[9998] -translate-x-1/2 -translate-y-1/2 flex items-center justify-center rounded-full bg-[rgb(188,172,142)]" style="width:10px;height:10px;" aria-hidden="true">
    <span id="cursor-text" class="relative top-[2px] font-heading text-white text-[1.5rem] leading-none select-none opacity-0">View</span>
</div>

<?php
$logo        = get_field( 'site_logo', 'option' );
$logo_url    = $logo ? esc_url( $logo['url'] ) : esc_url( SKYEYE_URI . '/assets/images/logo.png' );
$logo_alt    = $logo ? esc_attr( $logo['alt'] ) : 'Sky Eye Wedding Films';
$company     = get_field( 'company_name', 'option' ) ?: 'Sky Eye Wedding Films';
$contact_url = esc_url( get_permalink( get_page_by_path( 'contact' ) ) ?: home_url( '/contact' ) );
?>

<!-- Header -->
<header id="site-header" class="fixed inset-x-0 top-0 z-[150] bg-transparent" data-header>
    <div class="container mx-auto px-6 lg:px-16 py-3 md:py-5">
        <div class="flex items-center justify-between">

            <!-- Logo -->
            <a
                href="<?php echo esc_url( home_url( '/' ) ); ?>"
                class="inline-flex items-center hover:opacity-60 transition-opacity duration-300"
                data-transition-link
            >
                <div class="flex h-12 w-12 md:h-16 md:w-16 items-center justify-center rounded-full border border-white flex-shrink-0">
                    <img
                        src="<?php echo $logo_url; ?>"
                        alt="<?php echo $logo_alt; ?>"
                        width="32"
                        height="32"
                        class="w-8 h-8 object-contain"
                    >
                </div>
                <span class="ml-[0.9375rem] md:ml-5 text-[0.75rem] md:text-[1.125rem] uppercase tracking-[2px] md:tracking-[2.5px] text-white leading-tight">
                    <?php echo esc_html( $company ); ?>
                </span>
            </a>

            <!-- Desktop nav + CTA -->
            <div class="hidden md:flex items-center">
                <?php wp_nav_menu( [
                    'theme_location' => 'primary',
                    'container'      => 'nav',
                    'container_attr' => [ 'aria-label' => 'Primary' ],
                    'menu_class'     => 'flex items-center gap-[1.875rem] lg:gap-10 xl:gap-[3.125rem]',
                    'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
                    'link_class'     => 'nav-link text-[1.125rem] tracking-normal text-white',
                    'depth'          => 1,
                    'fallback_cb'    => false,
                ] ); ?>

                <div class="ml-10 lg:ml-[3.125rem] xl:ml-[3.75rem]">
                    <a href="<?php echo $contact_url; ?>" class="btn-primary" data-transition-link>
                        <span class="btn-inner">Get in touch</span>
                    </a>
                </div>
            </div>

            <!-- Mobile hamburger -->
            <button
                id="mobile-menu-btn"
                class="md:hidden relative z-10 flex flex-col gap-[6px] items-center justify-center w-8 h-8"
                aria-expanded="false"
                aria-controls="mobile-menu"
                aria-label="Open menu"
            >
                <span class="hamburger-line block w-[22px] h-px bg-white origin-center"></span>
                <span class="hamburger-line block w-[22px] h-px bg-white origin-center"></span>
                <span class="hamburger-line block w-[22px] h-px bg-white origin-center"></span>
            </button>

        </div>
    </div>
</header>

<!-- Mobile menu — full-screen overlay matching Next.js design -->
<div
    id="mobile-menu"
    class="fixed inset-0 z-[160] flex flex-col items-center justify-center bg-black translate-x-full md:hidden"
    aria-hidden="true"
>
    <button id="mobile-menu-close" class="absolute top-[46px] right-[30px] text-white" aria-label="Close menu">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
            <path d="M18 6L6 18M6 6l12 12"/>
        </svg>
    </button>

    <?php wp_nav_menu( [
        'theme_location' => 'primary',
        'container'      => 'nav',
        'container_attr' => [ 'aria-label' => 'Mobile' ],
        'menu_class'     => 'flex flex-col items-center gap-[1.4375rem] text-center',
        'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
        'link_class'     => 'font-heading text-[1.75rem] leading-tight text-white hover:opacity-60 transition-opacity duration-300',
        'depth'          => 1,
        'fallback_cb'    => false,
    ] ); ?>

    <div class="mt-10">
        <a href="<?php echo $contact_url; ?>" class="btn-primary" data-transition-link>
            <span class="btn-inner">Get in touch</span>
        </a>
    </div>
</div>

<main id="main" class="relative z-10 min-h-screen bg-brand-100">
