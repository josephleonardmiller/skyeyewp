<?php
/**
 * Template: Single blog post
 */
get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>

<?php
$categories  = get_the_category();
$primary_cat = $categories ? $categories[0] : null;
$author_id   = (int) get_the_author_meta( 'ID' );
$author_name = get_the_author();
$author_bio  = get_the_author_meta( 'description' );
$prev_post   = get_previous_post();
$next_post   = get_next_post();
?>

<!-- Post header -->
<section class="bg-brand-100 pt-40 pb-16 lg:pt-48 lg:pb-20 text-center px-6">
    <div class="container mx-auto" style="max-width:900px;">
        <?php if ( $primary_cat ) : ?>
        <div class="mb-6">
            <a href="<?php echo esc_url( get_category_link( $primary_cat->term_id ) ); ?>"
               class="inline-block font-body text-xs text-brand-200 uppercase tracking-widest border border-brand-200 rounded-full px-4 py-1.5 hover:bg-brand-200 hover:text-white transition-colors duration-200">
                <?php echo esc_html( $primary_cat->name ); ?>
            </a>
        </div>
        <?php endif; ?>
        <h1 class="font-heading text-4xl lg:text-[3rem] text-black mb-6 leading-tight">
            <?php the_title(); ?>
        </h1>
        <p class="font-body text-sm text-black/40 uppercase tracking-widest">
            <?php echo esc_html( get_the_date( 'F j, Y' ) ); ?>
        </p>
    </div>
</section>

<!-- White content area -->
<div class="bg-white">

    <!-- Hero image -->
    <?php if ( has_post_thumbnail() ) : ?>
    <div class="container mx-auto px-6 lg:px-16 pt-12">
        <div class="overflow-hidden rounded-xl" style="height: clamp(320px, 45vw, 750px);">
            <?php the_post_thumbnail( 'full', ['class' => 'w-full h-full object-cover'] ); ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Article body -->
    <div class="container mx-auto px-6 lg:px-16 py-16">
        <div class="post-content mx-auto" style="max-width:837px;">
            <?php the_content(); ?>
        </div>
    </div>

    <!-- Author bio -->
    <?php if ( $author_name ) : ?>
    <div class="container mx-auto px-6 lg:px-16 pb-12">
        <div class="mx-auto" style="max-width:837px;">
            <hr class="border-black/10 mb-10">
            <div class="flex items-start gap-5">
                <div class="flex-shrink-0 w-16 h-16 overflow-hidden rounded-full bg-brand-200/30">
                    <?php echo get_avatar( $author_id, 64, '', $author_name, ['class' => 'w-16 h-16 object-cover rounded-full'] ); ?>
                </div>
                <div>
                    <p class="font-body text-sm font-medium text-black mb-1"><?php echo esc_html( $author_name ); ?></p>
                    <?php if ( $author_bio ) : ?>
                    <p class="font-body text-sm text-black/60 leading-relaxed"><?php echo esc_html( $author_bio ); ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <hr class="border-black/10 mt-10">
        </div>
    </div>
    <?php endif; ?>

    <!-- Prev / Next navigation -->
    <?php if ( $prev_post || $next_post ) : ?>
    <div class="container mx-auto px-6 lg:px-16 pb-16">
        <div class="mx-auto flex gap-8" style="max-width:837px;">
            <?php if ( $prev_post ) : ?>
            <a href="<?php echo esc_url( get_permalink( $prev_post ) ); ?>" class="group flex-1">
                <p class="font-body text-xs text-black/40 uppercase tracking-widest mb-1">&#8592; Previous</p>
                <p class="font-heading text-lg text-black leading-snug group-hover:text-brand-400 transition-colors duration-200">
                    <?php echo esc_html( get_the_title( $prev_post ) ); ?>
                </p>
            </a>
            <?php endif; ?>
            <?php if ( $next_post ) : ?>
            <a href="<?php echo esc_url( get_permalink( $next_post ) ); ?>" class="group flex-1 text-right ml-auto">
                <p class="font-body text-xs text-black/40 uppercase tracking-widest mb-1">Next &#8594;</p>
                <p class="font-heading text-lg text-black leading-snug group-hover:text-brand-400 transition-colors duration-200">
                    <?php echo esc_html( get_the_title( $next_post ) ); ?>
                </p>
            </a>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

</div>

<!-- Related articles -->
<?php
$cat_ids = $categories ? array_map( function( $c ) { return (int) $c->term_id; }, $categories ) : [];
$related_args = [
    'posts_per_page'      => 3,
    'post__not_in'        => [ get_the_ID() ],
    'ignore_sticky_posts' => 1,
    'orderby'             => 'rand',
];
if ( $cat_ids ) {
    $related_args['category__in'] = $cat_ids;
}
$related_query = new WP_Query( $related_args );
?>

<?php if ( $related_query->have_posts() ) : ?>
<section class="bg-brand-100 py-20">
    <div class="container mx-auto px-6 lg:px-16">
        <h2 class="font-heading text-3xl text-black mb-10">Related articles</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php while ( $related_query->have_posts() ) : $related_query->the_post(); ?>
            <article>
                <a href="<?php the_permalink(); ?>" class="group block">
                    <?php
                    $rel_cats = get_the_category();
                    if ( $rel_cats ) :
                    ?>
                    <span class="inline-block font-body text-xs text-brand-200 uppercase tracking-widest border border-brand-200 rounded-full px-3 py-1 mb-3">
                        <?php echo esc_html( $rel_cats[0]->name ); ?>
                    </span>
                    <?php endif; ?>
                    <?php if ( has_post_thumbnail() ) : ?>
                    <div class="overflow-hidden rounded-xl mb-4" style="height:220px;">
                        <?php the_post_thumbnail( 'medium_large', [
                            'class' => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-[1.03]',
                        ] ); ?>
                    </div>
                    <?php endif; ?>
                    <h3 class="font-heading text-xl text-black leading-snug"><?php the_title(); ?></h3>
                </a>
            </article>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php endwhile; ?>

<?php get_footer(); ?>
