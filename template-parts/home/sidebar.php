<?php $img = get_template_directory_uri() . '/html-template/assets/images'; ?>
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

        <div class="showcase">

          <a href="#" class="showcase-img-box">
            <img src="<?php echo $img; ?>/products/1.jpg" alt="baby fabric shoes" width="75" height="75"
              class="showcase-img">
          </a>

          <div class="showcase-content">

            <a href="#">
              <h4 class="showcase-title">baby fabric shoes</h4>
            </a>

            <div class="showcase-rating">
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star"></ion-icon>
            </div>

            <div class="price-box">
              <del>$5.00</del>
              <p class="price">$4.00</p>
            </div>

          </div>

        </div>

        <div class="showcase">

          <a href="#" class="showcase-img-box">
            <img src="<?php echo $img; ?>/products/2.jpg" alt="men's hoodies t-shirt" class="showcase-img"
              width="75" height="75">
          </a>

          <div class="showcase-content">

            <a href="#">
              <h4 class="showcase-title">men's hoodies t-shirt</h4>
            </a>
            <div class="showcase-rating">
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star-half-outline"></ion-icon>
            </div>

            <div class="price-box">
              <del>$17.00</del>
              <p class="price">$7.00</p>
            </div>

          </div>

        </div>

        <div class="showcase">

          <a href="#" class="showcase-img-box">
            <img src="<?php echo $img; ?>/products/3.jpg" alt="girls t-shirt" class="showcase-img" width="75"
              height="75">
          </a>

          <div class="showcase-content">

            <a href="#">
              <h4 class="showcase-title">girls t-shirt</h4>
            </a>
            <div class="showcase-rating">
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star-half-outline"></ion-icon>
            </div>

            <div class="price-box">
              <del>$5.00</del>
              <p class="price">$3.00</p>
            </div>

          </div>

        </div>

        <div class="showcase">

          <a href="#" class="showcase-img-box">
            <img src="<?php echo $img; ?>/products/4.jpg" alt="woolen hat for men" class="showcase-img" width="75"
              height="75">
          </a>

          <div class="showcase-content">

            <a href="#">
              <h4 class="showcase-title">woolen hat for men</h4>
            </a>
            <div class="showcase-rating">
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star"></ion-icon>
            </div>

            <div class="price-box">
              <del>$15.00</del>
              <p class="price">$12.00</p>
            </div>

          </div>

        </div>

      </div>

    </div>

  </div>

</div>
