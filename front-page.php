<?php get_header(); ?>

  <main>

    <h1 class="sr-only"><?php bloginfo('name'); ?></h1>

    <?php get_template_part('template-parts/home/hero'); ?>

    <?php get_template_part('template-parts/home/categories'); ?>

    <div class="product-container">

      <div class="container">

        <?php get_template_part('template-parts/home/sidebar'); ?>

        <div class="product-box">

          <?php get_template_part('template-parts/home/product-minimal'); ?>

          <?php get_template_part('template-parts/home/product-featured'); ?>

          <?php get_template_part('template-parts/home/product-grid'); ?>

        </div>

      </div>

    </div>

    <div>

      <div class="container">

        <div class="testimonials-box">

          <?php get_template_part('template-parts/home/testimonials'); ?>

          <?php get_template_part('template-parts/home/banners'); ?>

        </div>

      </div>

    </div>

    <?php get_template_part('template-parts/home/blog'); ?>

  </main>

<?php get_footer(); ?>
