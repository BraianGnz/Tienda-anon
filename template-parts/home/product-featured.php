<div class="product-featured">

  <h2 class="title">Deal of the day</h2>

  <div class="showcase-wrapper has-scrollbar">

    <?php
    $featured_products = new WP_Query(array(
      'post_type'      => 'product',
      'posts_per_page' => 4,
      'meta_query'     => array(
        array(
          'key'     => '_featured',
          'value'   => 'yes',
          'compare' => '=',
        ),
      ),
    ));

    if ($featured_products->have_posts()) :
      while ($featured_products->have_posts()) : $featured_products->the_post();
        global $product;
        ?>
        <div class="showcase-container">
          <div class="showcase">
            <div class="showcase-banner">
              <?php echo woocommerce_get_product_thumbnail('woocommerce_single', array('class' => 'showcase-img')); ?>
            </div>
            <div class="showcase-content">
              <div class="showcase-rating">
                <?php echo wc_get_rating_html($product->get_average_rating()); ?>
              </div>
              <h3 class="showcase-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
              </h3>
              <p class="showcase-desc">
                <?php echo wp_trim_words($product->get_short_description() ?: $product->get_description(), 15); ?>
              </p>
              <div class="price-box">
                <?php echo $product->get_price_html(); ?>
              </div>
              <?php if ($product->is_purchasable() && $product->is_in_stock()) : ?>
                <form action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post" class="cart">
                  <input type="hidden" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>">
                  <button type="submit" class="add-cart-btn">add to cart</button>
                </form>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <?php
      endwhile;
      wp_reset_postdata();
    else :
      $fallback = new WP_Query(array(
        'post_type'      => 'product',
        'posts_per_page' => 4,
        'orderby'        => 'rand',
      ));
      if ($fallback->have_posts()) :
        while ($fallback->have_posts()) : $fallback->the_post();
          global $product;
          ?>
          <div class="showcase-container">
            <div class="showcase">
              <div class="showcase-banner">
                <?php echo woocommerce_get_product_thumbnail('woocommerce_single', array('class' => 'showcase-img')); ?>
              </div>
              <div class="showcase-content">
                <div class="showcase-rating">
                  <?php echo wc_get_rating_html($product->get_average_rating()); ?>
                </div>
                <h3 class="showcase-title">
                  <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h3>
                <p class="showcase-desc">
                  <?php echo wp_trim_words($product->get_short_description() ?: $product->get_description(), 15); ?>
                </p>
                <div class="price-box">
                  <?php echo $product->get_price_html(); ?>
                </div>
                <?php if ($product->is_purchasable() && $product->is_in_stock()) : ?>
                  <form action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post" class="cart">
                    <input type="hidden" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>">
                    <button type="submit" class="add-cart-btn">add to cart</button>
                  </form>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <?php
        endwhile;
        wp_reset_postdata();
      endif;
    endif;
    ?>

  </div>

</div>
