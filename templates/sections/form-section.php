<?php
$line1   = get_sub_field( 'heading_line_1' ) ?: 'Get in';
$line2   = get_sub_field( 'heading_line_2' ) ?: 'touch';
$sub     = get_sub_field( 'subheading' )     ?: 'We just need a few details';
?>

<section class="form-section bg-brand-200 py-[3.75rem] md:py-[8.125rem] overflow-hidden" data-form-section>
    <div class="container mx-auto px-6 lg:px-16">
        <div class="flex flex-wrap items-start">

            <!-- Left: heading + subheading -->
            <div class="flex w-full md:w-1/2">
                <div class="relative">
                    <h2 class="mt-[0.1875rem] font-heading text-[3.25rem] md:text-[6.75rem] leading-normal tracking-[-2.5px] text-white">
                        <div class="relative overflow-hidden">
                            <div class="opacity-0 translate-y-full" data-form-heading>
                                <?php echo esc_html( $line1 ); ?>
                            </div>
                        </div>
                        <div class="relative -mt-[1.5rem] overflow-hidden">
                            <div class="opacity-0 translate-y-full md:pl-[10rem]" data-form-heading>
                                <?php echo esc_html( $line2 ); ?>
                            </div>
                        </div>
                    </h2>
                    <div class="relative mt-[0.625rem] md:absolute md:inset-x-0 md:top-full md:mt-0">
                        <div class="relative overflow-hidden">
                            <p class="text-[1.125rem] text-white md:text-right opacity-0 translate-y-full" data-form-sub>
                                <?php echo esc_html( $sub ); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Studio Ninja form -->
            <div class="mt-[1.875rem] w-full md:-mt-[0.9375rem] md:w-1/2 opacity-0 translate-y-8" data-form-col>
                <iframe height="782"
                        style="min-width:100%;max-width:none;border:0;"
                        id="sn-form-footer"
                        src="https://app.studioninja.co/contactform/parser/0a800fc9-708b-1066-8170-bf1aac6d3b5f/0a800fc9-708b-1066-8170-bf23161a3ba0"
                        allowfullscreen>
                </iframe>
                <script type="text/javascript"
                        data-iframe-id="sn-form-footer"
                        src="https://app.studioninja.co/client-assets/form-render/assets/scripts/iframeResizer.js"></script>
            </div>

        </div>
    </div>
</section>
