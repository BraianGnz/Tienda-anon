<?php
$img = get_template_directory_uri() . '/html-template/assets/images';

$testimonials_query = new WP_Query(array(
    'post_type'      => 'testimonial',
    'posts_per_page' => 4,
    'post_status'    => 'publish',
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
    'meta_query'     => array(
        array(
            'key'   => 'show_on_home',
            'value' => '1',
        ),
    ),
));

if ($testimonials_query->have_posts()) :
?>
<div class="testimonial">

  <h2 class="title"><?php esc_html_e('Testimonios', 'anon-theme'); ?></h2>

  <?php while ($testimonials_query->have_posts()) : $testimonials_query->the_post(); ?>

  <div class="testimonial-card">

    <?php if (has_post_thumbnail()) : ?>
      <?php the_post_thumbnail('thumbnail', array('class' => 'testimonial-banner', 'width' => 80, 'height' => 80)); ?>
    <?php endif; ?>

    <p class="testimonial-name"><?php the_title(); ?></p>

    <p class="testimonial-title">
      <?php
      $city    = get_field('client_city');
      $product = get_field('product_name');
      $parts   = array_filter(array($city, $product));
      echo esc_html(!empty($parts) ? implode(' — ', $parts) : '&nbsp;');
      ?>
    </p>

    <img src="<?php echo $img; ?>/icons/quotes.svg" alt="<?php esc_attr_e('comillas', 'anon-theme'); ?>" class="quotation-img" width="26">

    <p class="testimonial-desc"><?php echo esc_html(get_the_content()); ?></p>

  </div>

  <?php endwhile; ?>
  <?php wp_reset_postdata(); ?>

</div>
<?php endif; ?>

<?php
$services_query = new WP_Query(array(
    'post_type'      => 'service',
    'posts_per_page' => 10,
    'post_status'    => 'publish',
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
));

if ($services_query->have_posts()) :
?>

<div class="service">

  <h2 class="title"><?php esc_html_e('Nuestros servicios', 'anon-theme'); ?></h2>

  <div class="service-container">

    <?php while ($services_query->have_posts()) : $services_query->the_post();
      $icon = get_field('service_icon') ?: 'boat-outline';
      $desc = get_field('service_desc');
      $url  = get_field('service_url') ?: '#';
    ?>

    <a href="<?php echo esc_url($url); ?>" class="service-item">

      <div class="service-icon">
        <ion-icon name="<?php echo esc_attr($icon); ?>"></ion-icon>
      </div>

      <div class="service-content">

        <h3 class="service-title"><?php the_title(); ?></h3>
        <?php if ($desc) : ?>
        <p class="service-desc"><?php echo esc_html($desc); ?></p>
        <?php endif; ?>

      </div>

    </a>

    <?php endwhile; ?>
    <?php wp_reset_postdata(); ?>

  </div>

</div>

<?php endif; ?>
