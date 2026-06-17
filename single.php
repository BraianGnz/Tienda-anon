<?php get_header(); ?>

<main>

  <div class="container">
    <?php while (have_posts()) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
      <?php if (has_post_thumbnail()) : ?>
      <?php the_post_thumbnail('large'); ?>
      <?php endif; ?>
      <div class="blog-content">
        <h1 class="title"><?php the_title(); ?></h1>
        <p class="blog-meta"><?php echo esc_html(get_the_date()); ?> &mdash; <?php esc_html_e('by', 'anon-theme'); ?> <?php the_author(); ?></p>
        <?php the_content(); ?>
        <?php
        the_post_navigation(array(
          'prev_text' => '<span class="nav-prev">&larr; ' . esc_html__('Anterior', 'anon-theme') . '</span>',
          'next_text' => '<span class="nav-next">' . esc_html__('Siguiente', 'anon-theme') . ' &rarr;</span>',
        ));
        ?>
      </div>
    </article>
    <?php endwhile; ?>
  </div>

</main>

<?php get_footer(); ?>
