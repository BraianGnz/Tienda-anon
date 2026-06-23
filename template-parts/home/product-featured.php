<div class="product-featured">

  <?php
  $front_id = (int) get_option('page_on_front');
  $deal_title = $front_id ? get_field('home_deal_title', $front_id) : '';
  if (!$deal_title) {
      $deal_title = 'Oferta del día';
  }
  ?>
  <h2 class="title"><?php echo esc_html($deal_title); ?></h2>

  <div class="showcase-wrapper has-scrollbar">

    <?php
    if (!function_exists('get_deal_of_the_day_query')) {
        return;
    }

    $deal_query = get_deal_of_the_day_query();

    if ($deal_query->have_posts()) :
      while ($deal_query->have_posts()) : $deal_query->the_post();
        global $product;
        get_template_part('template-parts/woocommerce/deal-product-card');
      endwhile;
      wp_reset_postdata();
    endif;
    ?>

  </div>

</div>
