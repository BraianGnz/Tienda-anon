<?php get_header(); ?>

<main>

  <div class="container">

    <?php the_archive_title('<h1 class="title">', '</h1>'); ?>
    <?php the_archive_description('<div class="archive-description">', '</div>'); ?>

    <?php if (have_posts()) : ?>

      <?php while (have_posts()) : the_post(); ?>
      <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <?php if (has_post_thumbnail()) : ?>
          <?php the_post_thumbnail('medium', array('class' => 'blog-banner')); ?>
        <?php endif; ?>
        <div class="blog-content">
          <h2 class="title"><?php the_title(); ?></h2>
          <p class="blog-meta"><?php echo esc_html(get_the_date()); ?></p>
          <?php the_excerpt(); ?>
        </div>
      </article>
      <?php endwhile; ?>

      <?php the_posts_pagination(); ?>

    <?php else : ?>

      <p><?php esc_html_e('No se encontraron publicaciones en este archivo.', 'anon-theme'); ?></p>

    <?php endif; ?>

  </div>

</main>

<?php get_footer(); ?>
