<?php
$slides = array();

if (function_exists('get_field')) {
    $slides_query = new WP_Query(array(
        'post_type'      => 'hero_slide',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    ));

    if ($slides_query->have_posts()) {
        while ($slides_query->have_posts()) {
            $slides_query->the_post();
            $image = get_field('slide_image');
            if (empty($image)) {
                continue;
            }
            $slides[] = array(
                'image'       => $image,
                'subtitle'    => get_field('slide_subtitle'),
                'title'       => get_field('slide_title'),
                'price'       => get_field('slide_price'),
                'button_text' => get_field('slide_button_text'),
                'button_url'  => get_field('slide_button_url'),
            );
        }
        wp_reset_postdata();
    }
}

if (empty($slides)) {
    $img = get_template_directory_uri() . '/html-template/assets/images';
    $slides = array(
        array(
            'image'       => $img . '/banner-1.jpg',
            'subtitle'    => "Trending item",
            'title'       => "Women's latest fashion sale",
            'price'       => 'starting at &dollar; <b>20</b>.00',
            'button_text' => 'Shop now',
            'button_url'  => '#',
        ),
        array(
            'image'       => $img . '/banner-2.jpg',
            'subtitle'    => 'Trending accessories',
            'title'       => 'Modern sunglasses',
            'price'       => 'starting at &dollar; <b>15</b>.00',
            'button_text' => 'Shop now',
            'button_url'  => '#',
        ),
        array(
            'image'       => $img . '/banner-3.jpg',
            'subtitle'    => 'Sale Offer',
            'title'       => "New fashion summer sale",
            'price'       => 'starting at &dollar; <b>29</b>.99',
            'button_text' => 'Shop now',
            'button_url'  => '#',
        ),
    );
}
?>
<div class="banner">

  <div class="container">

    <div class="slider-container has-scrollbar" data-hero-slider>

      <div class="swiper-wrapper">

      <?php foreach ($slides as $slide): ?>

      <div class="slider-item swiper-slide">

        <img src="<?php echo esc_url($slide['image']); ?>" alt="<?php echo esc_attr($slide['title']); ?>" class="banner-img">

        <div class="banner-content">

          <p class="banner-subtitle"><?php echo esc_html($slide['subtitle']); ?></p>

          <h2 class="banner-title"><?php echo esc_html($slide['title']); ?></h2>

          <p class="banner-text">
            <?php echo wp_kses_post($slide['price']); ?>
          </p>

          <a href="<?php echo esc_url($slide['button_url']); ?>" class="banner-btn"><?php echo esc_html($slide['button_text']); ?></a>

        </div>

      </div>

      <?php endforeach; ?>

      </div>

      <div class="swiper-pagination"></div>

      <div class="swiper-button-prev"></div>
      <div class="swiper-button-next"></div>

    </div>

  </div>

</div>
