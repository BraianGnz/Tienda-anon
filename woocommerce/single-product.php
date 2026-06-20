<?php
get_header();
?>

<main>

  <div class="container">

    <?php woocommerce_breadcrumb(); ?>

    <?php
    while ( have_posts() ) :
        the_post();
        wc_get_template_part( 'content', 'single-product' );
    endwhile;
    ?>

  </div>

</main>

<?php
get_footer();
