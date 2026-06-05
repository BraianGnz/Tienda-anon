<div class="sidebar has-scrollbar" data-mobile-menu>

  <div class="sidebar-category">

    <div class="sidebar-top">
      <h2 class="sidebar-title">Category</h2>

      <button class="sidebar-close-btn" data-mobile-menu-close-btn>
        <ion-icon name="close-outline"></ion-icon>
      </button>
    </div>

    <ul class="sidebar-menu-category-list">

      <?php
      $product_cats = get_terms(array(
        'taxonomy'   => 'product_cat',
        'hide_empty' => true,
      ));
      if (!empty($product_cats) && !is_wp_error($product_cats)) :
        foreach ($product_cats as $cat) :
      ?>
      <li class="sidebar-menu-category">
        <a href="<?php echo esc_url(get_term_link($cat)); ?>" class="sidebar-accordion-menu">
          <div class="menu-title-flex">
            <p class="menu-title"><?php echo esc_html($cat->name); ?></p>
          </div>
          <data value="<?php echo esc_attr($cat->count); ?>" class="stock" title="Available Stock"><?php echo esc_html($cat->count); ?></data>
        </a>
      </li>
      <?php
        endforeach;
      endif;
      ?>

    </ul>

  </div>

  <div class="product-showcase">

    <h3 class="showcase-heading">best sellers</h3>

    <div class="showcase-wrapper">

      <div class="showcase-container">

        <?php
        $best_sellers = new WP_Query(array(
          'post_type'      => 'product',
          'posts_per_page' => 4,
          'meta_key'       => 'total_sales',
          'orderby'        => 'meta_value_num',
          'order'          => 'DESC',
          'post_status'    => 'publish',
          'no_found_rows'  => true,
        ));

        if ($best_sellers->have_posts()) :
          while ($best_sellers->have_posts()) : $best_sellers->the_post();
            global $product;
        ?>
        <div class="showcase">

          <a href="<?php the_permalink(); ?>" class="showcase-img-box">
            <?php echo woocommerce_get_product_thumbnail('thumbnail', array('class' => 'showcase-img', 'width' => 75, 'height' => 75)); ?>
          </a>

          <div class="showcase-content">

            <a href="<?php the_permalink(); ?>">
              <h4 class="showcase-title"><?php the_title(); ?></h4>
            </a>

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
        endif;

        $shown = $best_sellers->post_count;
        $remaining = 4 - $shown;

        if ($remaining > 0) {
          $exclude = $shown > 0 ? wp_list_pluck($best_sellers->posts, 'ID') : array();
          $fallback = new WP_Query(array(
            'post_type'      => 'product',
            'posts_per_page' => $remaining,
            'post_status'    => 'publish',
            'post__not_in'   => $exclude,
            'orderby'        => 'date',
            'order'          => 'DESC',
            'no_found_rows'  => true,
          ));
          if ($fallback->have_posts()) :
            while ($fallback->have_posts()) : $fallback->the_post();
              global $product;
        ?>
        <div class="showcase">

          <a href="<?php the_permalink(); ?>" class="showcase-img-box">
            <?php echo woocommerce_get_product_thumbnail('thumbnail', array('class' => 'showcase-img', 'width' => 75, 'height' => 75)); ?>
          </a>

          <div class="showcase-content">

            <a href="<?php the_permalink(); ?>">
              <h4 class="showcase-title"><?php the_title(); ?></h4>
            </a>

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
          endif;
          wp_reset_postdata();
        }

        wp_reset_postdata();
        ?>

      </div>

    </div>

  </div>

</div>
