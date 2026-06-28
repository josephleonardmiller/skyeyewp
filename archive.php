<?php get_header(); ?>

<main class="pt-32 pb-24">
  <div class="container">
    <h1 class="font-heading text-4xl mb-12"><?php the_archive_title(); ?></h1>

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
      <article class="mb-10 pb-10 border-b border-brand-200/30">
        <a href="<?php the_permalink(); ?>" class="block group">
          <h2 class="font-heading text-2xl mb-2 group-hover:text-brand-400 transition-colors"><?php the_title(); ?></h2>
          <p class="text-sm text-brand-400 mb-4"><?php echo get_the_date(); ?></p>
          <div class="text-brand-200/80"><?php the_excerpt(); ?></div>
        </a>
      </article>
    <?php endwhile; endif; ?>

    <?php the_posts_pagination(); ?>
  </div>
</main>

<?php get_footer(); ?>
