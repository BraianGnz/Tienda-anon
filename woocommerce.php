<?php
if ( is_singular( 'product' ) ) {
    wc_get_template( 'single-product.php' );
} else {
    wc_get_template( 'archive-product.php' );
}
