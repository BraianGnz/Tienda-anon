<?php
$img = get_template_directory_uri() . '/html-template/assets/images';

$cat_icons = array(
    'medias'       => 'shoes.svg',
    'calcetines'   => 'shoes.svg',
    'gorras'       => 'hat.svg',
    'perfumes'     => 'perfume.svg',
    'remeras'      => 'tee.svg',
    'uncategorized' => 'bag.svg',
);

$product_cats = get_terms(array(
    'taxonomy'   => 'product_cat',
    'hide_empty' => true,
    'orderby'    => 'count',
    'order'      => 'DESC',
));

$product_cats = wp_list_filter($product_cats, array('slug' => 'uncategorized'), 'NOT');

if (!empty($product_cats) && !is_wp_error($product_cats)) :
?>
<div class="category">

  <div class="container">

    <div class="category-item-container has-scrollbar">

      <?php foreach ($product_cats as $cat) :
        $icon = isset($cat_icons[$cat->slug]) ? $cat_icons[$cat->slug] : 'bag.svg';
      ?>
      <div class="category-item">

        <div class="category-img-box">
          <img src="<?php echo $img; ?>/icons/<?php echo $icon; ?>" alt="<?php echo esc_attr($cat->name); ?>" width="30">
        </div>

        <div class="category-content-box">

          <div class="category-content-flex">
            <h3 class="category-item-title"><?php echo esc_html($cat->name); ?></h3>

            <p class="category-item-amount">(<?php echo esc_html($cat->count); ?>)</p>
          </div>

          <a href="<?php echo esc_url(get_term_link($cat)); ?>" class="category-btn">Show all</a>

        </div>

      </div>
      <?php endforeach; ?>

    </div>

  </div>

</div>
<?php endif; ?>
