<?php
/**
 * Template: Blog index (used when Settings → Reading → Posts page is set)
 */
get_header();

// ── Featured post ─────────────────────────────────────────────────────────────
$pinned_id = (int) get_option( '_skyeye_featured_post' );
$featured  = ( $pinned_id && get_post_status( $pinned_id ) === 'publish' )
    ? get_post( $pinned_id )
    : null;

// ── Grid posts ────────────────────────────────────────────────────────────────
$paged       = max( 1, (int) get_query_var( 'paged' ) );
$exclude     = $featured ? [ $featured->ID ] : [];
$sort_filter = isset( $_GET['sort'] ) ? sanitize_text_field( $_GET['sort'] ) : '';

$allowed_sorts = [ 'oldest' => [ 'orderby' => 'date', 'order' => 'ASC' ], 'popular' => [ 'orderby' => 'comment_count', 'order' => 'DESC' ] ];
$sort_args     = isset( $allowed_sorts[ $sort_filter ] ) ? $allowed_sorts[ $sort_filter ] : [ 'orderby' => 'date', 'order' => 'DESC' ];

$query_args = [
    'post_type'           => 'post',
    'post_status'         => 'publish',
    'posts_per_page'      => 6,
    'paged'               => $paged,
    'post__not_in'        => $exclude,
    'ignore_sticky_posts' => 1,
    'no_found_rows'       => false,
    'orderby'             => $sort_args['orderby'],
    'order'               => $sort_args['order'],
];

$grid_query = new WP_Query( $query_args );
$grid_posts = $grid_query->posts;

if ( ! $featured && $grid_posts ) {
    $featured = array_shift( $grid_posts );
}

$large_grid = array_slice( $grid_posts, 0, 2 );
$small_grid = array_slice( $grid_posts, 2 );

global $wp_query;
$wp_query->max_num_pages = $grid_query->max_num_pages;
?>

<!-- Blog hero — dark background, cream text -->
<section class="relative bg-black min-h-[500px] flex flex-col items-center justify-center text-center px-6 pt-40 lg:pt-48">
    <div class="container mx-auto">
        <h1 class="font-heading text-5xl lg:text-[4rem] text-[#f8f5ef] mb-6 leading-tight">
            Wedding video tips &amp; guides
        </h1>
        <p class="font-body text-lg lg:text-[1.25rem] font-light text-white/60 max-w-lg mx-auto leading-relaxed">
            Your go-to resource for wedding film inspiration, planning tips, and behind-the-scenes stories.
        </p>
    </div>
</section>

<!-- Featured post — white background -->
<section class="bg-white">
    <div class="container mx-auto px-6 lg:px-16 py-16 lg:py-20">

        <?php if ( $featured ) : ?>
        <?php
        global $post;
        $post = $featured;
        setup_postdata( $post );
        ?>
        <article>
            <a href="<?php the_permalink(); ?>" class="grid lg:grid-cols-[63fr_37fr] gap-10 lg:gap-20 items-center group">
                <?php if ( has_post_thumbnail() ) : ?>
                <div class="overflow-hidden rounded-xl h-[300px] lg:h-[480px]">
                    <?php the_post_thumbnail( 'large', [
                        'class' => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-[1.03]',
                    ] ); ?>
                </div>
                <?php endif; ?>
                <div>
                    <h2 class="font-heading text-[1.75rem] lg:text-[2rem] text-black mb-4 leading-tight">
                        <?php the_title(); ?>
                    </h2>
                    <p class="font-body text-[1.125rem] font-light text-black/60 leading-relaxed mb-6">
                        <?php echo esc_html( wp_trim_words( get_the_excerpt(), 30, '…' ) ); ?>
                    </p>
                    <p class="font-body text-[1.125rem] text-brand-200 mb-8">
                        <?php echo esc_html( get_the_date( 'F j, Y' ) ); ?>
                    </p>
                    <span class="font-body text-sm uppercase tracking-widest text-black border-b border-black/30 pb-0.5 transition-colors duration-300 group-hover:border-black">
                        Read article
                    </span>
                </div>
            </a>
        </article>
        <?php endif; ?>

    </div>
</section>

<!-- Grid posts — white background -->
<div class="bg-white pb-24">
    <div class="container mx-auto px-6 lg:px-16">

        <?php if ( $large_grid || $small_grid ) : ?>
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between pt-14 pb-10 gap-4">
            <h2 class="font-heading text-[2.25rem] text-black tracking-[0.3px]">Latest blogs</h2>

            <form method="get" class="flex items-center gap-3">
                <span class="font-body text-[1.125rem] text-black">Sort by</span>
                <div class="relative">
                    <select name="sort" onchange="this.form.submit()"
                        class="font-body text-[1.125rem] text-black border border-[#c2b293]/60 px-4 py-2.5 bg-transparent appearance-none pr-10 focus:outline-none cursor-pointer">
                        <option value="" <?php selected( $sort_filter, '' ); ?>>Latest</option>
                        <option value="oldest" <?php selected( $sort_filter, 'oldest' ); ?>>Oldest</option>
                        <option value="popular" <?php selected( $sort_filter, 'popular' ); ?>>Popular</option>
                    </select>
                    <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-black/50 text-xs">▾</span>
                </div>
            </form>
        </div>
        <?php endif; ?>

        <!-- Large 2-col grid (posts 1–2) -->
        <?php if ( $large_grid ) : ?>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-20 mb-16">
            <?php foreach ( $large_grid as $grid_post ) :
                global $post;
                $post = $grid_post;
                setup_postdata( $post );
            ?>
            <article>
                <a href="<?php the_permalink(); ?>" class="group block">
                    <?php if ( has_post_thumbnail() ) : ?>
                    <div class="overflow-hidden rounded-xl mb-6 h-[260px] lg:h-[440px]">
                        <?php the_post_thumbnail( 'large', [
                            'class' => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-[1.03]',
                        ] ); ?>
                    </div>
                    <?php endif; ?>
                    <h3 class="font-heading text-[1.5rem] text-black leading-snug mb-2">
                        <?php the_title(); ?>
                    </h3>
                    <p class="font-body text-[1.125rem] font-light text-black/60 leading-relaxed mb-2">
                        <?php echo esc_html( wp_trim_words( get_the_excerpt(), 18, '…' ) ); ?>
                    </p>
                    <p class="font-body text-[1.125rem] text-brand-200">
                        <?php echo esc_html( get_the_date( 'F j, Y' ) ); ?>
                    </p>
                </a>
            </article>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- Small 3-col grid (posts 3+) -->
        <?php if ( $small_grid ) : ?>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-16 mb-12">
            <?php foreach ( $small_grid as $grid_post ) :
                global $post;
                $post = $grid_post;
                setup_postdata( $post );
            ?>
            <article>
                <a href="<?php the_permalink(); ?>" class="group block">
                    <?php if ( has_post_thumbnail() ) : ?>
                    <div class="overflow-hidden rounded-xl mb-6 h-[220px] lg:h-[296px]">
                        <?php the_post_thumbnail( 'medium_large', [
                            'class' => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-[1.03]',
                        ] ); ?>
                    </div>
                    <?php endif; ?>
                    <h3 class="font-heading text-[1.5rem] text-black leading-snug mb-2">
                        <?php the_title(); ?>
                    </h3>
                    <p class="font-body text-[1.125rem] font-light text-black/60 leading-relaxed mb-2">
                        <?php echo esc_html( wp_trim_words( get_the_excerpt(), 14, '…' ) ); ?>
                    </p>
                    <p class="font-body text-[1.125rem] text-brand-200">
                        <?php echo esc_html( get_the_date( 'F j, Y' ) ); ?>
                    </p>
                </a>
            </article>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <?php wp_reset_postdata(); ?>

        <?php if ( ! $featured ) : ?>
        <div class="text-center py-24">
            <p class="font-body text-lg text-black/50">No posts yet. Check back soon!</p>
        </div>
        <?php endif; ?>

        <!-- Pagination -->
        <?php the_posts_pagination( [
            'mid_size'           => 2,
            'prev_text'          => '&#8592;',
            'next_text'          => '&#8594;',
            'screen_reader_text' => ' ',
        ] ); ?>

    </div>
</div>

<?php get_footer(); ?>
