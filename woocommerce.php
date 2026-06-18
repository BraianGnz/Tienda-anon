<?php
if ( is_singular( 'product' ) ) {
    get_header();
    ?>

    <main>

      <div class="container">
        <?php woocommerce_content(); ?>
      </div>

    </main>

    <?php
    get_footer();
} else {
    wc_get_template( 'archive-product.php' );
}
