<?php get_header(); ?>

<main>

  <div class="container">
    <?php
    if (have_posts()) :
      while (have_posts()) :
        the_post();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
          <?php
          if (has_post_thumbnail()) :
            the_post_thumbnail('large', array('class' => 'banner-img'));
          endif;
          ?>
          <div class="blog-content">
            <?php the_title('<h2 class="title">', '</h2>'); ?>
            <?php the_content(); ?>
          </div>
        </article>
        <?php
      endwhile;

      the_posts_pagination();
    else :
      ?>
      <p><?php esc_html_e('No content found.', 'anon-theme'); ?></p>
    <?php endif; ?>
  </div>

</main>

<?php get_footer(); ?>
