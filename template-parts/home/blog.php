<?php
$front_id = (int) get_option('page_on_front');
$blog_title = $front_id ? get_field('home_blog_title', $front_id) : '';
if (!$blog_title) {
    $blog_title = __('Blog', 'anon-theme');
}
$blog_count = $front_id ? get_field('home_blog_count', $front_id) : 0;
if (!$blog_count || $blog_count < 1) {
    $blog_count = 4;
}

$blog_posts = new WP_Query(array(
    'post_type'      => 'post',
    'posts_per_page' => $blog_count,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
    'no_found_rows'  => true,
));

if (!$blog_posts->have_posts()) {
    return;
}

$img = get_template_directory_uri() . '/html-template/assets/images';
$placeholder_images = array('blog-1.jpg', 'blog-2.jpg', 'blog-3.jpg', 'blog-4.jpg');
$placeholder_index = 0;
?>

<div class="blog">

  <div class="container">

    <h2 class="title"><?php echo esc_html($blog_title); ?></h2>

    <div class="blog-container has-scrollbar">

      <?php while ($blog_posts->have_posts()) : $blog_posts->the_post();
        $categories = get_the_category();
        $cat_name = !empty($categories) ? $categories[0]->name : '';
        $cat_link = !empty($categories) ? esc_url(get_category_link($categories[0]->term_id)) : '';
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

          <?php if ($cat_link) : ?>
            <a href="<?php echo $cat_link; ?>" class="blog-category"><?php echo esc_html($cat_name); ?></a>
          <?php else : ?>
            <span class="blog-category"><?php echo esc_html($cat_name); ?></span>
          <?php endif; ?>

          <a href="<?php the_permalink(); ?>">
            <h3 class="blog-title"><?php the_title(); ?></h3>
          </a>

          <p class="blog-meta">
            <?php esc_html_e('Por', 'anon-theme'); ?> <cite><?php the_author(); ?></cite> / <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date(); ?></time>
          </p>

        </div>

      </div>

      <?php endwhile; ?>

    </div>

  </div>

</div>

<?php
wp_reset_postdata();
