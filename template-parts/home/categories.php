<?php
$product_cats = get_terms(array(
    'taxonomy'   => 'product_cat',
    'hide_empty' => true,
    'orderby'    => 'count',
    'order'      => 'DESC',
));

$product_cats = wp_list_filter($product_cats, array('slug' => 'uncategorized'), 'NOT');

$fallback_icon = get_template_directory_uri() . '/html-template/assets/images/icons/bag.svg';

if (!empty($product_cats) && !is_wp_error($product_cats)) :
?>
<div class="category">

  <div class="container">

    <div class="category-item-container has-scrollbar">

      <?php foreach ($product_cats as $cat) :
        $icon_id = get_field('category_icon', 'product_cat_' . $cat->term_id);
        $icon_url = $icon_id ? wp_get_attachment_image_url($icon_id, 'thumbnail') : '';
        if (empty($icon_url)) {
            $icon_url = $fallback_icon;
        }
      ?>
      <div class="category-item">

        <div class="category-img-box">
          <img src="<?php echo esc_url($icon_url); ?>" alt="<?php echo esc_attr($cat->name); ?>" width="30">
        </div>

        <div class="category-content-box">

          <div class="category-content-flex">
            <h3 class="category-item-title"><?php echo esc_html($cat->name); ?></h3>

            <p class="category-item-amount">(<?php echo esc_html($cat->count); ?>)</p>
          </div>

          <a href="<?php echo esc_url(get_term_link($cat)); ?>" class="category-btn"><?php esc_html_e('Ver más', 'anon-theme'); ?></a>

        </div>

      </div>
      <?php endforeach; ?>

    </div>

  </div>

</div>
<?php endif; ?>
