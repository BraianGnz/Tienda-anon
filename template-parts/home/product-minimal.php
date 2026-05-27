<div class="product-minimal">

  <?php
  $new_arrivals = new WP_Query(array(
    'post_type'      => 'product',
    'posts_per_page' => 8,
    'orderby'        => 'date',
    'order'          => 'DESC',
  ));

  if ($new_arrivals->have_posts()) :
    $counter = 0;
    echo '<div class="product-showcase">';
    echo '<h2 class="title">New Arrivals</h2>';
    echo '<div class="showcase-wrapper has-scrollbar">';
    echo '<div class="showcase-container">';

    while ($new_arrivals->have_posts()) : $new_arrivals->the_post();
      global $product;
      if ($counter > 0 && $counter % 4 === 0) {
        echo '</div><div class="showcase-container">';
      }
      ?>
      <div class="showcase">
        <a href="<?php the_permalink(); ?>" class="showcase-img-box">
          <?php echo woocommerce_get_product_thumbnail('thumbnail', array('class' => 'showcase-img', 'width' => 70)); ?>
        </a>
        <div class="showcase-content">
          <a href="<?php the_permalink(); ?>">
            <h4 class="showcase-title"><?php the_title(); ?></h4>
          </a>
          <?php
          $categories = wp_get_post_terms(get_the_ID(), 'product_cat');
          if (!empty($categories) && !is_wp_error($categories)) {
            echo '<a href="' . esc_url(get_term_link($categories[0])) . '" class="showcase-category">' . esc_html($categories[0]->name) . '</a>';
          }
          ?>
          <div class="price-box">
            <?php echo $product->get_price_html(); ?>
          </div>
        </div>
      </div>
      <?php
      $counter++;
    endwhile;

    echo '</div></div></div>';
    wp_reset_postdata();
  endif;
  ?>

</div>
