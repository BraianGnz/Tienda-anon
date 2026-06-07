<?php
$img = get_template_directory_uri() . '/html-template/assets/images';

// Auto-seed: create sample blog posts if fewer than 4 published
$counts = wp_count_posts('post');
$pub = isset($counts->publish) ? (int) $counts->publish : 0;
if ($pub < 4 && !get_option('anon_blog_posts_seeded')) {
  $seed_cats = array('Consejos', 'Perfumes', 'Estilo');
  $cat_ids = array();
  foreach ($seed_cats as $cn) {
    $cid = term_exists($cn, 'category');
    $cat_ids[$cn] = $cid && isset($cid['term_id']) ? (int) $cid['term_id'] : (int) wp_create_category($cn);
  }

  $seeds = array(
    array(
      'title' => 'Diferencias Clave entre Medias Premium y Medias Economicas',
      'slug'  => 'diferencias-medias-premium-economicas',
      'cat'   => 'Consejos',
      'content' => 'Explica en que aspectos las medias premium se diferencian de las economicas, como la calidad del material, la resistencia, la comodidad, la elasticidad y la durabilidad. Destaca como estas diferencias impactan en la inversion a largo plazo y en la experiencia de uso, ayudando a los clientes a tomar decisiones informadas.',
    ),
    array(
      'title' => 'El Arte de Elegir Perfumes Bagues: Consejos para Encontrar tu Fragancia Ideal',
      'slug'  => 'arte-elegir-perfumes-bagues',
      'cat'   => 'Perfumes',
      'content' => 'Un blog dedicado a explicar las distintas lineas de perfumes Bagues, las notas caracteristicas de cada uno, y como seleccionar la fragancia que mejor se adapta a diferentes personalidades u ocasiones. Esto puede complementar la venta de productos relacionados o inspirar a los clientes a combinar accesorios con sus estilos.',
    ),
    array(
      'title' => 'Por que la Personalizacion Hace la Diferencia en tu Estilo',
      'slug'  => 'personalizacion-diferencia-estilo',
      'cat'   => 'Estilo',
      'content' => 'Habla sobre como las medias y prendas personalizadas reflejan la personalidad y aportan un toque unico a cualquier outfit. Incluye ejemplos de disenos, estilos y como la personalizacion puede ser una forma de expresion personal o un regalo especial.',
    ),
    array(
      'title' => 'Consejos para Cuidar tus Medias y Perfumes para Mantener su Calidad',
      'slug'  => 'consejos-cuidar-medias-perfumes',
      'cat'   => 'Consejos',
      'content' => 'Ofrece recomendaciones practicas sobre el cuidado adecuado de medias y perfumes, para que mantengan su calidad, aroma y apariencia por mas tiempo. Puedes incluir tips sobre lavado, almacenamiento y uso correcto.',
    ),
  );

  foreach ($seeds as $s) {
    $post_id = wp_insert_post(array(
      'post_title'   => $s['title'],
      'post_name'    => $s['slug'],
      'post_content' => $s['content'],
      'post_status'  => 'publish',
      'post_author'  => 1,
    ));
    if ($post_id && $cat_ids[$s['cat']]) {
      wp_set_post_categories($post_id, array($cat_ids[$s['cat']]));
    }
  }

  update_option('anon_blog_posts_seeded', 1);
}

// Query 4 most recent posts
$blog_posts = new WP_Query(array(
  'post_type'      => 'post',
  'posts_per_page' => 4,
  'post_status'    => 'publish',
  'no_found_rows'  => true,
));

$placeholder_images = array('blog-1.jpg', 'blog-2.jpg', 'blog-3.jpg', 'blog-4.jpg');
$placeholder_index = 0;

if ($blog_posts->have_posts()) :
?>
<div class="blog">

  <div class="container">

    <div class="blog-container has-scrollbar">

      <?php while ($blog_posts->have_posts()) : $blog_posts->the_post();
        $categories = get_the_category();
        $cat_name = !empty($categories) ? $categories[0]->name : '';
        $cat_link = !empty($categories) ? esc_url(get_category_link($categories[0]->term_id)) : '#';
        $thumb = $placeholder_images[$placeholder_index % 4];
        $placeholder_index++;
      ?>
      <div class="blog-card">

        <a href="<?php the_permalink(); ?>">
          <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('medium', array('class' => 'blog-banner', 'width' => 300)); ?>
          <?php else : ?>
            <img src="<?php echo $img; ?>/<?php echo $thumb; ?>" alt="<?php the_title_attribute(); ?>" width="300" class="blog-banner">
          <?php endif; ?>
        </a>

        <div class="blog-content">

          <a href="<?php echo $cat_link; ?>" class="blog-category"><?php echo esc_html($cat_name); ?></a>

          <a href="<?php the_permalink(); ?>">
            <h3 class="blog-title"><?php the_title(); ?></h3>
          </a>

          <p class="blog-meta">
            By <cite><?php the_author(); ?></cite> / <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date(); ?></time>
          </p>

        </div>

      </div>
      <?php endwhile; ?>

    </div>

  </div>

</div>
<?php
  wp_reset_postdata();
endif;
?>