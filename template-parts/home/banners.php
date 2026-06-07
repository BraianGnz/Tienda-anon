<?php
$img_base = get_template_directory_uri() . '/html-template/assets/images';

$post_id = null;
if (function_exists('cta_banner_get_front_page_id')) {
    $post_id = cta_banner_get_front_page_id();
}

if (function_exists('get_field') && $post_id) {
    $cta_image       = get_field('cta_image', $post_id);
    $cta_badge       = get_field('cta_badge', $post_id);
    $cta_title       = get_field('cta_title', $post_id);
    $cta_text        = get_field('cta_text', $post_id);
    $cta_button_text = get_field('cta_button_text', $post_id);
    $cta_button_url  = get_field('cta_button_url', $post_id);
}

if (empty($cta_image))       { $cta_image       = $img_base . '/cta-banner.jpg'; }
if (empty($cta_badge))       { $cta_badge       = '25% Discount'; }
if (empty($cta_title))       { $cta_title       = 'Summer collection'; }
if (empty($cta_text))        { $cta_text        = 'Starting @ $10'; }
if (empty($cta_button_text)) { $cta_button_text = 'Shop now'; }
if (empty($cta_button_url))  { $cta_button_url  = '#'; }
?>
<div class="cta-container">

  <img src="<?php echo esc_url($cta_image); ?>" alt="<?php echo esc_attr($cta_title); ?>" class="cta-banner">

  <a href="<?php echo esc_url($cta_button_url); ?>" class="cta-content">

    <p class="discount"><?php echo esc_html($cta_badge); ?></p>

    <h2 class="cta-title"><?php echo esc_html($cta_title); ?></h2>

    <p class="cta-text"><?php echo esc_html($cta_text); ?></p>

    <button class="cta-btn"><?php echo esc_html($cta_button_text); ?></button>

  </a>

</div>
