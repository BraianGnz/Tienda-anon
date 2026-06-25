<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="profile" href="https://gmpg.org/xfn/11">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

  <div class="overlay" data-overlay></div>

  <header>

    <div class="header-top">

      <div class="container">

        <?php
        $header_social_rendered = array();
        if (footer_contact_acf_active()) {
            foreach (array(
                'logo-facebook'  => 'social_facebook',
                'logo-instagram' => 'social_instagram',
                'logo-linkedin'  => 'social_linkedin',
                'logo-tiktok'    => 'social_tiktok',
                'logo-youtube'   => 'social_youtube',
            ) as $icon => $field) {
                $url = footer_contact_get($field);
                if ($url) {
                    $header_social_rendered[] = compact('icon', 'url');
                }
            }
        }
        ?>

        <?php if (!empty($header_social_rendered)) : ?>
        <ul class="header-social-container">
          <?php foreach ($header_social_rendered as $item) : ?>
          <li>
            <a href="<?php echo esc_url($item['url']); ?>" class="social-link" target="_blank" rel="noopener noreferrer">
              <ion-icon name="<?php echo $item['icon']; ?>"></ion-icon>
            </a>
          </li>
          <?php endforeach; ?>
        </ul>
        <?php endif; ?>

        <div class="header-alert-news">
          <p>
            <?php
            $header_promo_text = footer_contact_get('header_promo_text');
            if ($header_promo_text) {
                echo esc_html($header_promo_text);
            } else {
                ?><b><?php esc_html_e('Envío gratis', 'anon-theme'); ?></b>
            <?php esc_html_e('Esta semana por pedidos mayores a $55', 'anon-theme'); ?><?php
            }
            ?>
          </p>
        </div>

      </div>

    </div>

    <div class="header-main">

      <div class="container">

        <a href="<?php echo esc_url(home_url('/')); ?>" class="header-logo">
          <?php
          if (has_custom_logo()) {
            the_custom_logo();
          } else {
          ?>
            <img src="<?php echo esc_url(get_template_directory_uri() . '/html-template/assets/images/logo/logo.svg'); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" width="120" height="36">
          <?php
          }
          ?>
        </a>

        <div class="header-search-container">

          <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
            <input type="search" name="s" class="search-field" placeholder="<?php esc_attr_e('Buscá tu producto...', 'anon-theme'); ?>" value="<?php echo get_search_query(); ?>">
            <button type="submit" class="search-btn">
              <ion-icon name="search-outline"></ion-icon>
            </button>
          </form>

        </div>

        <div class="header-user-actions">

          <?php if (is_user_logged_in()) : ?>
            <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>" class="action-btn">
              <ion-icon name="person-outline"></ion-icon>
            </a>
          <?php else : ?>
            <a href="<?php echo esc_url(wp_login_url()); ?>" class="action-btn">
              <ion-icon name="person-outline"></ion-icon>
            </a>
          <?php endif; ?>

          <?php if (class_exists('WooCommerce')) : ?>
            <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="action-btn">
              <ion-icon name="bag-handle-outline"></ion-icon>
              <span class="count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
            </a>
          <?php else : ?>
            <button class="action-btn">
              <ion-icon name="bag-handle-outline"></ion-icon>
              <span class="count">0</span>
            </button>
          <?php endif; ?>
        </div>

        </div>

      </div>
    <?php
    $primary_menu_args = array(
      'theme_location' => 'primary',
      'menu_class'     => 'desktop-menu-category-list',
      'container'      => 'nav',
      'container_class' => 'desktop-navigation-menu',
      'depth'          => 2,
      'fallback_cb'    => 'anon_theme_fallback_menu',
    );
    wp_nav_menu($primary_menu_args);
    ?>

    <div class="mobile-bottom-navigation">

      <button class="action-btn" data-mobile-menu-open-btn>
        <ion-icon name="menu-outline"></ion-icon>
      </button>

      <?php if (class_exists('WooCommerce')) : ?>
        <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="action-btn">
          <ion-icon name="bag-handle-outline"></ion-icon>
          <span class="count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
        </a>
      <?php else : ?>
        <button class="action-btn">
          <ion-icon name="bag-handle-outline"></ion-icon>
          <span class="count">0</span>
        </button>
      <?php endif; ?>

      <a href="<?php echo esc_url(home_url('/')); ?>" class="action-btn">
        <ion-icon name="home-outline"></ion-icon>
      </a>

      <button class="action-btn" data-mobile-menu-open-btn>
        <ion-icon name="grid-outline"></ion-icon>
      </button>

    </div>

    <nav class="mobile-navigation-menu has-scrollbar" data-mobile-menu>

      <div class="menu-top">
        <h2 class="menu-title"><?php esc_html_e('Menú', 'anon-theme'); ?></h2>

        <button class="menu-close-btn" data-mobile-menu-close-btn>
          <ion-icon name="close-outline"></ion-icon>
        </button>
      </div>

      <?php
      wp_nav_menu(array(
        'theme_location' => 'primary',
        'menu_class'     => 'mobile-menu-category-list',
        'container'      => false,
        'depth'          => 2,
        'fallback_cb'    => 'anon_theme_fallback_menu',
      ));
      ?>

      <div class="menu-bottom">

        <?php
        $mobile_social_rendered = array();
        if (footer_contact_acf_active()) {
            foreach (array(
                'logo-facebook'  => 'social_facebook',
                'logo-instagram' => 'social_instagram',
                'logo-linkedin'  => 'social_linkedin',
                'logo-tiktok'    => 'social_tiktok',
                'logo-youtube'   => 'social_youtube',
            ) as $icon => $field) {
                $url = footer_contact_get($field);
                if ($url) {
                    $mobile_social_rendered[] = compact('icon', 'url');
                }
            }
        }
        ?>

        <?php if (!empty($mobile_social_rendered)) : ?>
        <ul class="menu-social-container">
          <?php foreach ($mobile_social_rendered as $item) : ?>
          <li>
            <a href="<?php echo esc_url($item['url']); ?>" class="social-link" target="_blank" rel="noopener noreferrer">
              <ion-icon name="<?php echo $item['icon']; ?>"></ion-icon>
            </a>
          </li>
          <?php endforeach; ?>
        </ul>
        <?php endif; ?>

      </div>

    </nav>

  </header>
