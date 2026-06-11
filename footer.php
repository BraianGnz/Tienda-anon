  <footer>

    <div class="footer-category">

      <div class="container">

        <h2 class="footer-category-title">Brand directory</h2>

        <?php
        wp_nav_menu(array(
            'theme_location' => 'footer_brand',
            'container'      => false,
            'items_wrap'     => '%3$s',
            'fallback_cb'    => false,
            'depth'          => 2,
            'walker'         => new Footer_Brand_Walker(),
        ));
        ?>

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

          <?php
          wp_nav_menu(array(
              'theme_location' => 'footer_categories',
              'container'      => false,
              'items_wrap'     => '%3$s',
              'fallback_cb'    => false,
              'walker'         => new Footer_Column_Walker(),
          ));
          ?>

        </ul>

        <ul class="footer-nav-list">

          <li class="footer-nav-item">
            <h2 class="nav-title">Our Company</h2>
          </li>

          <?php
          wp_nav_menu(array(
              'theme_location' => 'footer_company',
              'container'      => false,
              'items_wrap'     => '%3$s',
              'fallback_cb'    => false,
              'walker'         => new Footer_Column_Walker(),
          ));
          ?>

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

          <?php if (footer_contact_acf_active()) : ?>

          <?php
          $rendered = array();
          foreach (array(
              'logo-facebook'  => 'social_facebook',
              'logo-instagram' => 'social_instagram',
              'logo-linkedin'  => 'social_linkedin',
              'logo-tiktok'    => 'social_tiktok',
              'logo-youtube'   => 'social_youtube',
          ) as $icon => $field) {
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
          <?php endif; ?>

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
