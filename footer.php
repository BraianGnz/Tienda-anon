  <footer>

    <div class="footer-category">

      <div class="container">

        <h2 class="footer-category-title">Brand directory</h2>

        <div class="footer-category-box">

          <h3 class="category-box-title">Fashion :</h3>

          <a href="#" class="footer-category-link">T-shirt</a>
          <a href="#" class="footer-category-link">Shirts</a>
          <a href="#" class="footer-category-link">shorts & jeans</a>
          <a href="#" class="footer-category-link">jacket</a>
          <a href="#" class="footer-category-link">dress & frock</a>
          <a href="#" class="footer-category-link">innerwear</a>
          <a href="#" class="footer-category-link">hosiery</a>

        </div>

        <div class="footer-category-box">
          <h3 class="category-box-title">footwear :</h3>

          <a href="#" class="footer-category-link">sport</a>
          <a href="#" class="footer-category-link">formal</a>
          <a href="#" class="footer-category-link">Boots</a>
          <a href="#" class="footer-category-link">casual</a>
          <a href="#" class="footer-category-link">cowboy shoes</a>
          <a href="#" class="footer-category-link">safety shoes</a>
          <a href="#" class="footer-category-link">Party wear shoes</a>
          <a href="#" class="footer-category-link">Branded</a>
          <a href="#" class="footer-category-link">Firstcopy</a>
          <a href="#" class="footer-category-link">Long shoes</a>
        </div>

        <div class="footer-category-box">
          <h3 class="category-box-title">jewellery :</h3>

          <a href="#" class="footer-category-link">Necklace</a>
          <a href="#" class="footer-category-link">Earrings</a>
          <a href="#" class="footer-category-link">Couple rings</a>
          <a href="#" class="footer-category-link">Pendants</a>
          <a href="#" class="footer-category-link">Crystal</a>
          <a href="#" class="footer-category-link">Bangles</a>
          <a href="#" class="footer-category-link">bracelets</a>
          <a href="#" class="footer-category-link">nosepin</a>
          <a href="#" class="footer-category-link">chain</a>
          <a href="#" class="footer-category-link">Earrings</a>
          <a href="#" class="footer-category-link">Couple rings</a>
        </div>

        <div class="footer-category-box">
          <h3 class="category-box-title">cosmetics :</h3>

          <a href="#" class="footer-category-link">Shampoo</a>
          <a href="#" class="footer-category-link">Bodywash</a>
          <a href="#" class="footer-category-link">Facewash</a>
          <a href="#" class="footer-category-link">makeup kit</a>
          <a href="#" class="footer-category-link">liner</a>
          <a href="#" class="footer-category-link">lipstick</a>
          <a href="#" class="footer-category-link">prefume</a>
          <a href="#" class="footer-category-link">Body soap</a>
          <a href="#" class="footer-category-link">scrub</a>
          <a href="#" class="footer-category-link">hair gel</a>
          <a href="#" class="footer-category-link">hair colors</a>
          <a href="#" class="footer-category-link">hair dye</a>
          <a href="#" class="footer-category-link">sunscreen</a>
          <a href="#" class="footer-category-link">skin loson</a>
          <a href="#" class="footer-category-link">liner</a>
          <a href="#" class="footer-category-link">lipstick</a>
        </div>

      </div>

    </div>

    <div class="footer-nav">

      <div class="container">

        <?php
        wp_nav_menu(array(
          'theme_location' => 'footer',
          'menu_class'     => 'footer-nav-list',
          'container'      => 'ul',
          'fallback_cb'    => false,
        ));
        ?>

        <ul class="footer-nav-list">

          <li class="footer-nav-item">
            <h2 class="nav-title">Popular Categories</h2>
          </li>

          <li class="footer-nav-item">
            <a href="#" class="footer-nav-link">Fashion</a>
          </li>

          <li class="footer-nav-item">
            <a href="#" class="footer-nav-link">Electronic</a>
          </li>

          <li class="footer-nav-item">
            <a href="#" class="footer-nav-link">Cosmetic</a>
          </li>

          <li class="footer-nav-item">
            <a href="#" class="footer-nav-link">Health</a>
          </li>

          <li class="footer-nav-item">
            <a href="#" class="footer-nav-link">Watches</a>
          </li>

        </ul>

        <ul class="footer-nav-list">

          <li class="footer-nav-item">
            <h2 class="nav-title">Our Company</h2>
          </li>

          <li class="footer-nav-item">
            <a href="<?php echo esc_url(home_url('/delivery')); ?>" class="footer-nav-link">Delivery</a>
          </li>

          <li class="footer-nav-item">
            <a href="<?php echo esc_url(home_url('/legal-notice')); ?>" class="footer-nav-link">Legal Notice</a>
          </li>

          <li class="footer-nav-item">
            <a href="<?php echo esc_url(home_url('/terms-and-conditions')); ?>" class="footer-nav-link">Terms and conditions</a>
          </li>

          <li class="footer-nav-item">
            <a href="<?php echo esc_url(home_url('/about-us')); ?>" class="footer-nav-link">About us</a>
          </li>

          <li class="footer-nav-item">
            <a href="<?php echo esc_url(home_url('/secure-payment')); ?>" class="footer-nav-link">Secure payment</a>
          </li>

        </ul>

        <ul class="footer-nav-list">

          <li class="footer-nav-item">
            <h2 class="nav-title">Contact</h2>
          </li>

          <?php
          $contact_address = footer_contact_get('contact_address', '419 State 414 Rte');
          $contact_city    = footer_contact_get('contact_city', 'Beaver Dams');
          $contact_region  = footer_contact_get('contact_region', 'New York(NY), 14812');
          $contact_country = footer_contact_get('contact_country', 'USA');
          $contact_phone   = footer_contact_get('contact_phone', '(607) 936-8058');
          $contact_email   = footer_contact_get('contact_email', 'example@gmail.com');
          $locality = implode(', ', array_filter(array($contact_city, $contact_region, $contact_country)));
          ?>

          <li class="footer-nav-item flex">
            <div class="icon-box">
              <ion-icon name="location-outline"></ion-icon>
            </div>

            <address class="content">
              <?php echo esc_html($contact_address); ?>
              <?php if ($locality) : ?><br><?php echo esc_html($locality); ?><?php endif; ?>
            </address>
          </li>

          <?php if ($contact_phone) : ?>
          <li class="footer-nav-item flex">
            <div class="icon-box">
              <ion-icon name="call-outline"></ion-icon>
            </div>

            <a href="tel:<?php echo esc_attr(preg_replace('/[^\d+]/', '', $contact_phone)); ?>" class="footer-nav-link"><?php echo esc_html($contact_phone); ?></a>
          </li>
          <?php endif; ?>

          <?php if ($contact_email) : ?>
          <li class="footer-nav-item flex">
            <div class="icon-box">
              <ion-icon name="mail-outline"></ion-icon>
            </div>

            <a href="mailto:<?php echo esc_attr($contact_email); ?>" class="footer-nav-link"><?php echo esc_html($contact_email); ?></a>
          </li>
          <?php endif; ?>

        </ul>

        <ul class="footer-nav-list">

          <li class="footer-nav-item">
            <h2 class="nav-title">Follow Us</h2>
          </li>

          <?php
          $social_items = array(
              'logo-facebook'  => 'social_facebook',
              'logo-instagram' => 'social_instagram',
              'logo-linkedin'  => 'social_linkedin',
              'logo-tiktok'    => 'social_tiktok',
              'logo-youtube'   => 'social_youtube',
          );

          $rendered = array();
          foreach ($social_items as $icon => $field) {
              $url = footer_contact_get($field);
              if ($url) {
                  $rendered[] = compact('icon', 'url');
              }
          }
          ?>

          <?php if (!empty($rendered)) : ?>
          <li>
            <ul class="social-link">
              <?php foreach ($rendered as $item) : ?>
              <li class="footer-nav-item">
                <a href="<?php echo esc_url($item['url']); ?>" class="footer-nav-link" target="_blank" rel="noopener noreferrer">
                  <ion-icon name="<?php echo $item['icon']; ?>"></ion-icon>
                </a>
              </li>
              <?php endforeach; ?>
            </ul>
          </li>
          <?php else : ?>

          <li>
            <ul class="social-link">

              <li class="footer-nav-item">
                <a href="#" class="footer-nav-link">
                  <ion-icon name="logo-facebook"></ion-icon>
                </a>
              </li>

              <li class="footer-nav-item">
                <a href="#" class="footer-nav-link">
                  <ion-icon name="logo-twitter"></ion-icon>
                </a>
              </li>

              <li class="footer-nav-item">
                <a href="#" class="footer-nav-link">
                  <ion-icon name="logo-linkedin"></ion-icon>
                </a>
              </li>

              <li class="footer-nav-item">
                <a href="#" class="footer-nav-link">
                  <ion-icon name="logo-instagram"></ion-icon>
                </a>
              </li>

            </ul>
          </li>

          <?php endif; ?>

        </ul>

      </div>

    </div>

    <div class="footer-bottom">

      <div class="container">

        <img src="<?php echo esc_url(get_template_directory_uri() . '/html-template/assets/images/payment.png'); ?>" alt="payment method" class="payment-img">

        <p class="copyright">
          Copyright &copy; <?php echo date('Y'); ?> <a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a> all rights reserved.
        </p>

      </div>

    </div>

  </footer>

<?php wp_footer(); ?>

</body>

</html>
