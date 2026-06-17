<?php get_header(); ?>

<main>

  <div class="container">
    <h1 class="title"><?php printf(esc_html__('Resultados para: "%s"', 'anon-theme'), get_search_query()); ?></h1>

    <?php if (have_posts()) : ?>

    <div class="blog-content">
      <?php while (have_posts()) : the_post(); ?>
      <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <h2 class="title"><?php the_title(); ?></h2>
        <?php the_excerpt(); ?>
      </article>
      <?php endwhile; ?>
      <?php the_posts_pagination(); ?>
    </div>

    <?php else : ?>

    <p><?php printf(esc_html__('No encontramos resultados para: "%s"', 'anon-theme'), get_search_query()); ?></p>
    <?php get_search_form(); ?>

    <?php endif; ?>
  </div>

</main>

<?php get_footer(); ?>
