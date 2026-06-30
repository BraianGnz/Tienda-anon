<div class="product-main">

  <?php
  $front_id = (int) get_option('page_on_front');
  $grid_title = $front_id ? get_field('home_new_products_title', $front_id) : '';
  if (!$grid_title) {
      $grid_title = __('Nuevos productos', 'anon-theme');
  }
  ?>
  <h2 class="title"><?php echo esc_html($grid_title); ?></h2>

  <div class="product-grid">

    <?php
    $new_products = new WP_Query(array(
      'post_type'      => 'product',
      'posts_per_page' => 12,
      'orderby'        => 'date',
      'order'          => 'DESC',
    ));

    if ($new_products->have_posts()) :
      while ($new_products->have_posts()) : $new_products->the_post();
        global $product;

        $badge_html = '';

        if (!$product->is_in_stock()) {
          $badge_html = '<span class="showcase-badge out-of-stock">' . esc_html__('Out of stock', 'woocommerce') . '</span>';
        }
        elseif ($product->is_on_sale()) {
          $sale_price    = $product->get_sale_price();
          $regular_price = $product->get_regular_price();
          if ($sale_price && $regular_price && $regular_price > 0) {
            $discount = round((($regular_price - $sale_price) / $regular_price) * 100);
            $badge_html = '<span class="showcase-badge discount">' . $discount . esc_html__('% OFF', 'anon-theme') . '</span>';
          }
        }
        else {
          $post_date = get_post_time('U', false, get_the_ID());
          $thirty_days_ago = strtotime('-30 days');
          if ($post_date && $post_date > $thirty_days_ago) {
            $badge_html = '<span class="showcase-badge new">' . esc_html__('Nuevo', 'anon-theme') . '</span>';
          }
        }

        $categories = wp_get_post_terms(get_the_ID(), 'product_cat');
        $cat_name   = '';
        $cat_link   = '#';
        if (!empty($categories) && !is_wp_error($categories)) {
          $cat_name = esc_html($categories[0]->name);
          $cat_link = esc_url(get_term_link($categories[0]));
        }
        ?>
        <div class="showcase">
          <div class="showcase-banner">
            <?php echo woocommerce_get_product_thumbnail('woocommerce_catalog', array('class' => 'product-img default')); ?>
            <?php
            $attachment_ids = $product->get_gallery_image_ids();
            if (!empty($attachment_ids)) {
              echo wp_get_attachment_image($attachment_ids[0], 'woocommerce_catalog', false, array('class' => 'product-img hover'));
            } else {
              echo woocommerce_get_product_thumbnail('woocommerce_catalog', array('class' => 'product-img hover'));
            }
            ?>
            <?php echo $badge_html; ?>
          </div>
          <div class="showcase-content">
            <?php if ($cat_name) : ?>
              <a href="<?php echo $cat_link; ?>" class="showcase-category"><?php echo $cat_name; ?></a>
            <?php endif; ?>
            <h3>
              <a href="<?php the_permalink(); ?>" class="showcase-title"><?php the_title(); ?></a>
            </h3>
            <div class="showcase-rating">
              <?php echo wc_get_rating_html($product->get_average_rating()); ?>
            </div>
            <div class="price-box">
              <?php echo $product->get_price_html(); ?>
            </div>
          </div>
        </div>
        <?php
      endwhile;
      wp_reset_postdata();
    endif;
    ?>

  </div>

</div>
