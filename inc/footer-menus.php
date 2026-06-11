<?php

class Footer_Brand_Walker extends Walker_Nav_Menu {
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        if ($depth == 0) {
            $output .= '<div class="footer-category-box">';
            $output .= '<h3 class="category-box-title">' . esc_html($item->title) . ' :</h3>';
        } else {
            $output .= '<a href="' . esc_url($item->url) . '" class="footer-category-link">' . esc_html($item->title) . '</a>';
        }
    }

    public function end_el(&$output, $item, $depth = 0, $args = null) {
        if ($depth == 0) {
            $output .= '</div>';
        }
    }

    public function start_lvl(&$output, $depth = 0, $args = null) {}

    public function end_lvl(&$output, $depth = 0, $args = null) {}
}


class Footer_Column_Walker extends Walker_Nav_Menu {
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $output .= '<li class="footer-nav-item">';
        $output .= '<a href="' . esc_url($item->url) . '" class="footer-nav-link">' . esc_html($item->title) . '</a>';
    }

    public function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= '</li>';
    }

    public function start_lvl(&$output, $depth = 0, $args = null) {}

    public function end_lvl(&$output, $depth = 0, $args = null) {}
}


function footer_menus_get_cat_url($slug) {
    $term = get_term_by('slug', $slug, 'product_cat');
    if ($term && !is_wp_error($term)) {
        return get_term_link($term);
    }
    return home_url('/product-category/' . $slug . '/');
}


function footer_menus_seed_defaults() {
    if (get_option('footer_menus_defaults_created')) {
        return;
    }

    $brand_menu_id = wp_create_nav_menu('Footer Brand Directory');
    if (!is_wp_error($brand_menu_id)) {
        $medias_id = wp_update_nav_menu_item($brand_menu_id, 0, array(
            'menu-item-title' => 'Medias',
            'menu-item-url' => '#',
            'menu-item-status' => 'publish',
        ));
        if ($medias_id) {
            wp_update_nav_menu_item($brand_menu_id, 0, array(
                'menu-item-title' => 'Medias Personalizadas',
                'menu-item-url' => footer_menus_get_cat_url('medias'),
                'menu-item-status' => 'publish',
                'menu-item-parent-id' => $medias_id,
            ));
            wp_update_nav_menu_item($brand_menu_id, 0, array(
                'menu-item-title' => 'Medias Deportivas',
                'menu-item-url' => footer_menus_get_cat_url('medias'),
                'menu-item-status' => 'publish',
                'menu-item-parent-id' => $medias_id,
            ));
            wp_update_nav_menu_item($brand_menu_id, 0, array(
                'menu-item-title' => 'Medias Tobilleras',
                'menu-item-url' => footer_menus_get_cat_url('medias'),
                'menu-item-status' => 'publish',
                'menu-item-parent-id' => $medias_id,
            ));
        }

        $calcetines_id = wp_update_nav_menu_item($brand_menu_id, 0, array(
            'menu-item-title' => 'Calcetines',
            'menu-item-url' => '#',
            'menu-item-status' => 'publish',
        ));
        if ($calcetines_id) {
            wp_update_nav_menu_item($brand_menu_id, 0, array(
                'menu-item-title' => 'Calcetines Corporativos',
                'menu-item-url' => footer_menus_get_cat_url('calcetines'),
                'menu-item-status' => 'publish',
                'menu-item-parent-id' => $calcetines_id,
            ));
            wp_update_nav_menu_item($brand_menu_id, 0, array(
                'menu-item-title' => 'Calcetines de Vestir',
                'menu-item-url' => footer_menus_get_cat_url('calcetines'),
                'menu-item-status' => 'publish',
                'menu-item-parent-id' => $calcetines_id,
            ));
            wp_update_nav_menu_item($brand_menu_id, 0, array(
                'menu-item-title' => 'Calcetines Deportivos',
                'menu-item-url' => footer_menus_get_cat_url('calcetines'),
                'menu-item-status' => 'publish',
                'menu-item-parent-id' => $calcetines_id,
            ));
        }

        $parches_id = wp_update_nav_menu_item($brand_menu_id, 0, array(
            'menu-item-title' => 'Parches',
            'menu-item-url' => '#',
            'menu-item-status' => 'publish',
        ));
        if ($parches_id) {
            wp_update_nav_menu_item($brand_menu_id, 0, array(
                'menu-item-title' => 'Parches Planchados',
                'menu-item-url' => footer_menus_get_cat_url('parches'),
                'menu-item-status' => 'publish',
                'menu-item-parent-id' => $parches_id,
            ));
            wp_update_nav_menu_item($brand_menu_id, 0, array(
                'menu-item-title' => 'Parches Bordados',
                'menu-item-url' => footer_menus_get_cat_url('parches'),
                'menu-item-status' => 'publish',
                'menu-item-parent-id' => $parches_id,
            ));
            wp_update_nav_menu_item($brand_menu_id, 0, array(
                'menu-item-title' => 'Parches Termoadhesivos',
                'menu-item-url' => footer_menus_get_cat_url('parches'),
                'menu-item-status' => 'publish',
                'menu-item-parent-id' => $parches_id,
            ));
        }

        $accesorios_id = wp_update_nav_menu_item($brand_menu_id, 0, array(
            'menu-item-title' => 'Accesorios',
            'menu-item-url' => '#',
            'menu-item-status' => 'publish',
        ));
        if ($accesorios_id) {
            wp_update_nav_menu_item($brand_menu_id, 0, array(
                'menu-item-title' => 'Gorras Personalizadas',
                'menu-item-url' => footer_menus_get_cat_url('gorras'),
                'menu-item-status' => 'publish',
                'menu-item-parent-id' => $accesorios_id,
            ));
            wp_update_nav_menu_item($brand_menu_id, 0, array(
                'menu-item-title' => 'Remeras Personalizadas',
                'menu-item-url' => footer_menus_get_cat_url('remeras'),
                'menu-item-status' => 'publish',
                'menu-item-parent-id' => $accesorios_id,
            ));
            wp_update_nav_menu_item($brand_menu_id, 0, array(
                'menu-item-title' => 'Perfumes Personalizados',
                'menu-item-url' => footer_menus_get_cat_url('perfumes'),
                'menu-item-status' => 'publish',
                'menu-item-parent-id' => $accesorios_id,
            ));
        }
    }

    $cats_menu_id = wp_create_nav_menu('Footer Popular Categories');
    if (!is_wp_error($cats_menu_id)) {
        wp_update_nav_menu_item($cats_menu_id, 0, array(
            'menu-item-title' => 'Tienda',
            'menu-item-url' => home_url('/shop/'),
            'menu-item-status' => 'publish',
        ));
        wp_update_nav_menu_item($cats_menu_id, 0, array(
            'menu-item-title' => 'Blog',
            'menu-item-url' => home_url('/blog/'),
            'menu-item-status' => 'publish',
        ));
        wp_update_nav_menu_item($cats_menu_id, 0, array(
            'menu-item-title' => 'Contacto',
            'menu-item-url' => home_url('/contacto/'),
            'menu-item-status' => 'publish',
        ));
    }

    $company_menu_id = wp_create_nav_menu('Footer Our Company');
    if (!is_wp_error($company_menu_id)) {
        wp_update_nav_menu_item($company_menu_id, 0, array(
            'menu-item-title' => 'Sobre Nosotros',
            'menu-item-url' => home_url('/about-us/'),
            'menu-item-status' => 'publish',
        ));
        wp_update_nav_menu_item($company_menu_id, 0, array(
            'menu-item-title' => 'Términos y Condiciones',
            'menu-item-url' => home_url('/terms-and-conditions/'),
            'menu-item-status' => 'publish',
        ));
        wp_update_nav_menu_item($company_menu_id, 0, array(
            'menu-item-title' => 'Delivery',
            'menu-item-url' => home_url('/delivery/'),
            'menu-item-status' => 'publish',
        ));
        wp_update_nav_menu_item($company_menu_id, 0, array(
            'menu-item-title' => 'Pago Seguro',
            'menu-item-url' => home_url('/secure-payment/'),
            'menu-item-status' => 'publish',
        ));
        wp_update_nav_menu_item($company_menu_id, 0, array(
            'menu-item-title' => 'Aviso Legal',
            'menu-item-url' => home_url('/legal-notice/'),
            'menu-item-status' => 'publish',
        ));
    }

    $locations = get_theme_mod('nav_menu_locations', array());
    if (!is_wp_error($brand_menu_id)) {
        $locations['footer_brand'] = $brand_menu_id;
    }
    if (!is_wp_error($cats_menu_id)) {
        $locations['footer_categories'] = $cats_menu_id;
    }
    if (!is_wp_error($company_menu_id)) {
        $locations['footer_company'] = $company_menu_id;
    }
    set_theme_mod('nav_menu_locations', $locations);

    update_option('footer_menus_defaults_created', true);
}
add_action('after_switch_theme', 'footer_menus_seed_defaults');
add_action('admin_init', 'footer_menus_seed_defaults');
