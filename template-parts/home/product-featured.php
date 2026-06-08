<div class="product-featured">

  <h2 class="title">Deal of the day</h2>

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
