<?php get_header(); ?>

<?php $img = get_template_directory_uri() . '/html-template/assets/images'; ?>

  <main>

    <!--
      - BANNER
    -->

    <div class="banner">

      <div class="container">

        <div class="slider-container has-scrollbar">

          <div class="slider-item">

            <img src="<?php echo $img; ?>/banner-1.jpg" alt="women's latest fashion sale" class="banner-img">

            <div class="banner-content">

              <p class="banner-subtitle">Trending item</p>

              <h2 class="banner-title">Women's latest fashion sale</h2>

              <p class="banner-text">
                starting at &dollar; <b>20</b>.00
              </p>

              <a href="#" class="banner-btn">Shop now</a>

            </div>

          </div>

          <div class="slider-item">

            <img src="<?php echo $img; ?>/banner-2.jpg" alt="modern sunglasses" class="banner-img">

            <div class="banner-content">

              <p class="banner-subtitle">Trending accessories</p>

              <h2 class="banner-title">Modern sunglasses</h2>

              <p class="banner-text">
                starting at &dollar; <b>15</b>.00
              </p>

              <a href="#" class="banner-btn">Shop now</a>

            </div>

          </div>

          <div class="slider-item">

            <img src="<?php echo $img; ?>/banner-3.jpg" alt="new fashion summer sale" class="banner-img">

            <div class="banner-content">

              <p class="banner-subtitle">Sale Offer</p>

              <h2 class="banner-title">New fashion summer sale</h2>

              <p class="banner-text">
                starting at &dollar; <b>29</b>.99
              </p>

              <a href="#" class="banner-btn">Shop now</a>

            </div>

          </div>

        </div>

      </div>

    </div>

    <!--
      - CATEGORY
    -->

    <div class="category">

      <div class="container">

        <div class="category-item-container has-scrollbar">

          <div class="category-item">

            <div class="category-img-box">
              <img src="<?php echo $img; ?>/icons/dress.svg" alt="dress & frock" width="30">
            </div>

            <div class="category-content-box">

              <div class="category-content-flex">
                <h3 class="category-item-title">Dress & frock</h3>

                <p class="category-item-amount">(53)</p>
              </div>

              <a href="#" class="category-btn">Show all</a>

            </div>

          </div>

          <div class="category-item">

            <div class="category-img-box">
              <img src="<?php echo $img; ?>/icons/coat.svg" alt="winter wear" width="30">
            </div>

            <div class="category-content-box">

              <div class="category-content-flex">
                <h3 class="category-item-title">Winter wear</h3>

                <p class="category-item-amount">(58)</p>
              </div>

              <a href="#" class="category-btn">Show all</a>

            </div>

          </div>

          <div class="category-item">

            <div class="category-img-box">
              <img src="<?php echo $img; ?>/icons/glasses.svg" alt="glasses & lens" width="30">
            </div>

            <div class="category-content-box">

              <div class="category-content-flex">
                <h3 class="category-item-title">Glasses & lens</h3>

                <p class="category-item-amount">(68)</p>
              </div>

              <a href="#" class="category-btn">Show all</a>

            </div>

          </div>

          <div class="category-item">

            <div class="category-img-box">
              <img src="<?php echo $img; ?>/icons/shorts.svg" alt="shorts & jeans" width="30">
            </div>

            <div class="category-content-box">

              <div class="category-content-flex">
                <h3 class="category-item-title">Shorts & jeans</h3>

                <p class="category-item-amount">(84)</p>
              </div>

              <a href="#" class="category-btn">Show all</a>

            </div>

          </div>

          <div class="category-item">

            <div class="category-img-box">
              <img src="<?php echo $img; ?>/icons/tee.svg" alt="t-shirts" width="30">
            </div>

            <div class="category-content-box">

              <div class="category-content-flex">
                <h3 class="category-item-title">T-shirts</h3>

                <p class="category-item-amount">(35)</p>
              </div>

              <a href="#" class="category-btn">Show all</a>

            </div>

          </div>

          <div class="category-item">

            <div class="category-img-box">
              <img src="<?php echo $img; ?>/icons/jacket.svg" alt="jacket" width="30">
            </div>

            <div class="category-content-box">

              <div class="category-content-flex">
                <h3 class="category-item-title">Jacket</h3>

                <p class="category-item-amount">(16)</p>
              </div>

              <a href="#" class="category-btn">Show all</a>

            </div>

          </div>

          <div class="category-item">

            <div class="category-img-box">
              <img src="<?php echo $img; ?>/icons/watch.svg" alt="watch" width="30">
            </div>

            <div class="category-content-box">

              <div class="category-content-flex">
                <h3 class="category-item-title">Watch</h3>

                <p class="category-item-amount">(27)</p>
              </div>

              <a href="#" class="category-btn">Show all</a>

            </div>

          </div>

          <div class="category-item">

            <div class="category-img-box">
              <img src="<?php echo $img; ?>/icons/hat.svg" alt="hat & caps" width="30">
            </div>

            <div class="category-content-box">

              <div class="category-content-flex">
                <h3 class="category-item-title">Hat & caps</h3>

                <p class="category-item-amount">(39)</p>
              </div>

              <a href="#" class="category-btn">Show all</a>

            </div>

          </div>

        </div>

      </div>

    </div>

    <!--
      - PRODUCT
    -->

    <div class="product-container">

      <div class="container">

        <!--
          - SIDEBAR
        -->

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

        <div class="product-box">

          <!--
            - PRODUCT MINIMAL
          -->

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

          <!--
            - PRODUCT FEATURED
          -->

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

          <!--
            - PRODUCT GRID
          -->

          <div class="product-main">

            <h2 class="title">New Products</h2>

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

                  // ========================================
                  // BADGE LOGIC
                  // Priority: Out of Stock > Sale > New
                  // Only one badge is displayed per product
                  // ========================================

                  $badge_html = '';

                  // 1. Out of stock badge (highest priority)
                  if (!$product->is_in_stock()) {
                    $badge_html = '<span class="showcase-badge out-of-stock">Agotado</span>';
                  }
                  // 2. Sale discount badge
                  elseif ($product->is_on_sale()) {
                    $sale_price    = $product->get_sale_price();
                    $regular_price = $product->get_regular_price();
                    if ($sale_price && $regular_price && $regular_price > 0) {
                      $discount = round((($regular_price - $sale_price) / $regular_price) * 100);
                      $badge_html = '<span class="showcase-badge discount">' . $discount . '% OFF</span>';
                    }
                  }
                  // 3. New product badge (products published within last 30 days)
                  else {
                    $post_date = get_post_time('U', false, get_the_ID());
                    $thirty_days_ago = strtotime('-30 days');
                    if ($post_date && $post_date > $thirty_days_ago) {
                      $badge_html = '<span class="showcase-badge new">Nuevo</span>';
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
                      <div class="showcase-actions">
                        <button class="btn-action">
                          <ion-icon name="heart-outline"></ion-icon>
                        </button>
                        <button class="btn-action">
                          <ion-icon name="eye-outline"></ion-icon>
                        </button>
                        <button class="btn-action">
                          <ion-icon name="repeat-outline"></ion-icon>
                        </button>
                        <button class="btn-action">
                          <ion-icon name="bag-add-outline"></ion-icon>
                        </button>
                      </div>
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

        </div>

      </div>

    </div>

    <!--
      - TESTIMONIALS, CTA & SERVICE
    -->

    <div>

      <div class="container">

        <div class="testimonials-box">

          <!--
            - TESTIMONIALS
          -->

          <div class="testimonial">

            <h2 class="title">testimonial</h2>

            <div class="testimonial-card">

              <img src="<?php echo $img; ?>/testimonial-1.jpg" alt="alan doe" class="testimonial-banner" width="80" height="80">

              <p class="testimonial-name">Alan Doe</p>

              <p class="testimonial-title">CEO & Founder Invision</p>

              <img src="<?php echo $img; ?>/icons/quotes.svg" alt="quotation" class="quotation-img" width="26">

              <p class="testimonial-desc">
                Lorem ipsum dolor sit amet consectetur Lorem ipsum
                dolor dolor sit amet.
              </p>

            </div>

          </div>

          <!--
            - CTA
          -->

          <div class="cta-container">

            <img src="<?php echo $img; ?>/cta-banner.jpg" alt="summer collection" class="cta-banner">

            <a href="#" class="cta-content">

              <p class="discount">25% Discount</p>

              <h2 class="cta-title">Summer collection</h2>

              <p class="cta-text">Starting @ $10</p>

              <button class="cta-btn">Shop now</button>

            </a>

          </div>

          <!--
            - SERVICE
          -->

          <div class="service">

            <h2 class="title">Our Services</h2>

            <div class="service-container">

              <a href="#" class="service-item">

                <div class="service-icon">
                  <ion-icon name="boat-outline"></ion-icon>
                </div>

                <div class="service-content">

                  <h3 class="service-title">Worldwide Delivery</h3>
                  <p class="service-desc">For Order Over $100</p>

                </div>

              </a>

              <a href="#" class="service-item">

                <div class="service-icon">
                  <ion-icon name="rocket-outline"></ion-icon>
                </div>

                <div class="service-content">

                  <h3 class="service-title">Next Day delivery</h3>
                  <p class="service-desc">UK Orders Only</p>

                </div>

              </a>

              <a href="#" class="service-item">

                <div class="service-icon">
                  <ion-icon name="call-outline"></ion-icon>
                </div>

                <div class="service-content">

                  <h3 class="service-title">Best Online Support</h3>
                  <p class="service-desc">Hours: 8AM - 11PM</p>

                </div>

              </a>

              <a href="#" class="service-item">

                <div class="service-icon">
                  <ion-icon name="arrow-undo-outline"></ion-icon>
                </div>

                <div class="service-content">

                  <h3 class="service-title">Return Policy</h3>
                  <p class="service-desc">Easy & Free Return</p>

                </div>

              </a>

              <a href="#" class="service-item">

                <div class="service-icon">
                  <ion-icon name="ticket-outline"></ion-icon>
                </div>

                <div class="service-content">

                  <h3 class="service-title">30% money back</h3>
                  <p class="service-desc">For Order Over $100</p>

                </div>

              </a>

            </div>

          </div>

        </div>

      </div>

    </div>

    <!--
      - BLOG
    -->

    <div class="blog">

      <div class="container">

        <div class="blog-container has-scrollbar">

          <div class="blog-card">

            <a href="#">
              <img src="<?php echo $img; ?>/blog-1.jpg" alt="Clothes Retail KPIs 2021 Guide for Clothes Executives" width="300" class="blog-banner">
            </a>

            <div class="blog-content">

              <a href="#" class="blog-category">Fashion</a>

              <a href="#">
                <h3 class="blog-title">Clothes Retail KPIs 2021 Guide for Clothes Executives.</h3>
              </a>

              <p class="blog-meta">
                By <cite>Mr Admin</cite> / <time datetime="2022-04-06">Apr 06, 2022</time>
              </p>

            </div>

          </div>

          <div class="blog-card">

            <a href="#">
              <img src="<?php echo $img; ?>/blog-2.jpg" alt="Curbside fashion Trends: How to Win the Pickup Battle."
                class="blog-banner" width="300">
            </a>

            <div class="blog-content">

              <a href="#" class="blog-category">Clothes</a>

              <h3>
                <a href="#" class="blog-title">Curbside fashion Trends: How to Win the Pickup Battle.</a>
              </h3>

              <p class="blog-meta">
                By <cite>Mr Robin</cite> / <time datetime="2022-01-18">Jan 18, 2022</time>
              </p>

            </div>

          </div>

          <div class="blog-card">

            <a href="#">
              <img src="<?php echo $img; ?>/blog-3.jpg" alt="EBT vendors: Claim Your Share of SNAP Online Revenue."
                class="blog-banner" width="300">
            </a>

            <div class="blog-content">

              <a href="#" class="blog-category">Shoes</a>

              <h3>
                <a href="#" class="blog-title">EBT vendors: Claim Your Share of SNAP Online Revenue.</a>
              </h3>

              <p class="blog-meta">
                By <cite>Mr Selsa</cite> / <time datetime="2022-02-10">Feb 10, 2022</time>
              </p>

            </div>

          </div>

          <div class="blog-card">

            <a href="#">
              <img src="<?php echo $img; ?>/blog-4.jpg" alt="Curbside fashion Trends: How to Win the Pickup Battle."
                class="blog-banner" width="300">
            </a>

            <div class="blog-content">

              <a href="#" class="blog-category">Electronics</a>

              <h3>
                <a href="#" class="blog-title">Curbside fashion Trends: How to Win the Pickup Battle.</a>
              </h3>

              <p class="blog-meta">
                By <cite>Mr Pawar</cite> / <time datetime="2022-03-15">Mar 15, 2022</time>
              </p>

            </div>

          </div>

        </div>

      </div>

    </div>

  </main>

<?php get_footer(); ?>
