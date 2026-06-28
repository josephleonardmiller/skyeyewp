<?php get_header(); ?>

<div class="min-h-screen flex items-center justify-center text-center px-6">
    <div>
        <h1 class="font-heading text-8xl text-black mb-4">404</h1>
        <p class="font-body text-black/60 text-lg mb-8">Page not found.</p>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-primary">Go home</a>
    </div>
</div>

<?php get_footer(); ?>
