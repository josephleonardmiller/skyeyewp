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

// ── Grid posts (dedicated query so each post object is independent) ───────────
$paged      = max( 1, (int) get_query_var( 'paged' ) );
$exclude    = $featured ? [ $featured->ID ] : [];

$grid_query = new WP_Query( [
    'post_type'           => 'post',
    'post_status'         => 'publish',
    'posts_per_page'      => 6,
    'paged'               => $paged,
    'post__not_in'        => $exclude,
    'ignore_sticky_posts' => 1,
    'no_found_rows'       => false,
] );

$grid_posts = $grid_query->posts; // array of independent WP_Post objects

// If nothing is pinned, promote the first grid post to featured
if ( ! $featured && $grid_posts ) {
    $featured = array_shift( $grid_posts );
}

$large_grid = array_slice( $grid_posts, 0, 2 );
$small_grid = array_slice( $grid_posts, 2 );

// Let the_posts_pagination() use our query's page count
global $wp_query;
$wp_query->max_num_pages = $grid_query->max_num_pages;
?>

<!-- Blog hero header -->
<section class="bg-brand-100 pt-40 pb-16 lg:pt-48 lg:pb-20 text-center px-6">
    <div class="container mx-auto">
        <h1 class="font-heading text-5xl lg:text-[3rem] text-black mb-4 leading-tight">
            Wedding video tips &amp; guides
        </h1>
        <p class="font-body text-[1.0625rem] font-light text-black/60 max-w-lg mx-auto leading-relaxed">
            Your go-to resource for wedding film inspiration, planning tips, and behind-the-scenes stories.
        </p>
    </div>
</section>

<div class="bg-white pb-24">
    <div class="container mx-auto px-6 lg:px-16">

        <?php if ( $featured ) : ?>

        <!-- Featured post -->
        <?php
        global $post;
        $post = $featured;
        setup_postdata( $post );
        ?>
        <article class="py-16 border-b border-black/10">
            <a href="<?php the_permalink(); ?>" class="grid lg:grid-cols-2 gap-8 lg:gap-16 items-center group">
                <?php if ( has_post_thumbnail() ) : ?>
                <div class="overflow-hidden rounded-xl flex-shrink-0" style="height:439px;">
                    <?php the_post_thumbnail( 'large', [
                        'class' => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-[1.03]',
                    ] ); ?>
                </div>
                <?php endif; ?>
                <div>
                    <p class="font-body text-xs text-brand-200 mb-3 uppercase tracking-widest">
                        <?php echo esc_html( get_the_date( 'F j, Y' ) ); ?>
                    </p>
                    <h2 class="font-heading text-[1.75rem] lg:text-[2.25rem] text-black mb-4 leading-tight">
                        <?php the_title(); ?>
                    </h2>
                    <p class="font-body text-base text-black/60 leading-relaxed">
                        <?php echo esc_html( wp_trim_words( get_the_excerpt(), 28, '…' ) ); ?>
                    </p>
                </div>
            </a>
        </article>

        <?php endif; ?>

        <!-- Large 2-col grid (posts 2–3) -->
        <?php if ( $large_grid ) : ?>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 pt-12 mb-12">
            <?php foreach ( $large_grid as $grid_post ) :
                global $post;
                $post = $grid_post;
                setup_postdata( $post );
            ?>
            <article>
                <a href="<?php the_permalink(); ?>" class="group block">
                    <?php if ( has_post_thumbnail() ) : ?>
                    <div class="overflow-hidden rounded-xl mb-5" style="height:420px;">
                        <?php the_post_thumbnail( 'large', [
                            'class' => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-[1.03]',
                        ] ); ?>
                    </div>
                    <?php endif; ?>
                    <p class="font-body text-xs text-brand-200 mb-2 uppercase tracking-widest">
                        <?php echo esc_html( get_the_date( 'F j, Y' ) ); ?>
                    </p>
                    <h3 class="font-heading text-[1.375rem] text-black leading-snug">
                        <?php the_title(); ?>
                    </h3>
                </a>
            </article>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- Small 3-col grid (posts 4+) -->
        <?php if ( $small_grid ) : ?>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <?php foreach ( $small_grid as $grid_post ) :
                global $post;
                $post = $grid_post;
                setup_postdata( $post );
            ?>
            <article>
                <a href="<?php the_permalink(); ?>" class="group block">
                    <?php if ( has_post_thumbnail() ) : ?>
                    <div class="overflow-hidden rounded-xl mb-4" style="height:267px;">
                        <?php the_post_thumbnail( 'medium_large', [
                            'class' => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-[1.03]',
                        ] ); ?>
                    </div>
                    <?php endif; ?>
                    <p class="font-body text-xs text-brand-200 mb-2 uppercase tracking-widest">
                        <?php echo esc_html( get_the_date( 'F j, Y' ) ); ?>
                    </p>
                    <h3 class="font-heading text-[1.375rem] text-black leading-snug">
                        <?php the_title(); ?>
                    </h3>
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
