<?php get_header(); ?>

<main>

  <div class="container">
    <h1 class="title"><?php esc_html_e('Página no encontrada', 'anon-theme'); ?></h1>
    <p><?php esc_html_e('La página que buscas no existe o ha sido movida.', 'anon-theme'); ?></p>
    <p>
      <a href="<?php echo esc_url(home_url('/')); ?>" class="btn-newsletter"><?php esc_html_e('Ir al Inicio', 'anon-theme'); ?></a>
      <?php if (class_exists('WooCommerce')) : ?>
      <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="btn-newsletter"><?php esc_html_e('Ir a la Tienda', 'anon-theme'); ?></a>
      <?php endif; ?>
    </p>
    <?php get_search_form(); ?>
  </div>

</main>

<?php get_footer(); ?>
