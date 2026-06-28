<?php
$line1 = get_field( 'heading_line_1' ) ?: 'Get in';
$line2 = get_field( 'heading_line_2' ) ?: 'touch';
$sub   = get_field( 'subheading' )     ?: 'We just need a few details';
?>

<section class="form-section py-24 lg:py-32 bg-brand-100 overflow-hidden" data-form-section>
    <div class="container mx-auto px-6 lg:px-16">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">

            <!-- Heading column -->
            <div>
                <div class="overflow-hidden">
                    <h2 class="form-heading-line font-heading text-5xl lg:text-8xl text-black opacity-0 translate-y-full" data-form-heading>
                        <?php echo esc_html( $line1 ); ?>
                    </h2>
                </div>
                <div class="overflow-hidden">
                    <h2 class="form-heading-line font-heading text-5xl lg:text-8xl text-black opacity-0 translate-y-full" data-form-heading>
                        <?php echo esc_html( $line2 ); ?>
                    </h2>
                </div>
                <div class="overflow-hidden mt-6">
                    <p class="form-sub font-body text-black/60 text-lg opacity-0 translate-y-full" data-form-sub>
                        <?php echo esc_html( $sub ); ?>
                    </p>
                </div>
            </div>

            <!-- Form column -->
            <div class="form-col opacity-0 translate-y-8" data-form-col>
                <?php get_template_part( 'templates/partials/contact-form' ); ?>
            </div>

        </div>
    </div>
</section>
