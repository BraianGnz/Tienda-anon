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


function footer_menus_create_page($title, $slug, $content) {
    $existing = get_posts(array(
        'post_type'      => 'page',
        'name'           => $slug,
        'posts_per_page' => 1,
        'post_status'    => 'any',
    ));
    if (!empty($existing)) {
        return $existing[0]->ID;
    }
    return wp_insert_post(array(
        'post_title'   => $title,
        'post_name'    => $slug,
        'post_content' => $content,
        'post_status'  => 'publish',
        'post_type'    => 'page',
    ));
}


function footer_menus_clear_menu_items($menu_id) {
    $items = wp_get_nav_menu_items($menu_id);
    if (!empty($items)) {
        foreach ($items as $item) {
            wp_delete_post($item->ID, true);
        }
    }
}


function footer_menus_seed_defaults() {
    if (!get_option('footer_menus_defaults_created')) {
        footer_menus_seed_brand_categories();
    }
    if (!get_option('footer_menus_company_upgraded')) {
        footer_menus_upgrade_company_menu();
    }
}

function footer_menus_seed_brand_categories() {

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

    $locations = get_theme_mod('nav_menu_locations', array());
    if (!is_wp_error($brand_menu_id)) {
        $locations['footer_brand'] = $brand_menu_id;
    }
    if (!is_wp_error($cats_menu_id)) {
        $locations['footer_categories'] = $cats_menu_id;
    }
    set_theme_mod('nav_menu_locations', $locations);

    update_option('footer_menus_defaults_created', true);
}


function footer_menus_upgrade_company_menu() {
    $company_menu_id = wp_create_nav_menu('Footer Our Company');
    if (is_wp_error($company_menu_id)) {
        $company_menu = wp_get_nav_menu_object('Footer Our Company');
        $company_menu_id = $company_menu ? $company_menu->term_id : 0;
        if ($company_menu_id) {
            footer_menus_clear_menu_items($company_menu_id);
        }
    }

    if ($company_menu_id) {
        $company_pages = array(
            array('title' => 'Sobre Nosotros',       'slug' => 'about-us',              'content' => '<p>Somos una empresa especializada en la personalización de medias, calcetines, parches y accesorios corporativos. Nuestra misión es ofrecer productos de alta calidad que reflejen la identidad de cada marca.</p>'),
            array('title' => 'Términos y Condiciones', 'slug' => 'terms-and-conditions', 'content' => '<p>Al utilizar este sitio web, aceptas los siguientes términos y condiciones. Todos los productos están sujetos a disponibilidad. Nos reservamos el derecho de modificar estos términos en cualquier momento.</p>'),
            array('title' => 'Política de Privacidad', 'slug' => 'privacy-policy',       'content' => '<p>Tu privacidad es importante para nosotros. Esta política describe cómo recopilamos, utilizamos y protegemos tu información personal cuando navegas en nuestro sitio.</p>'),
            array('title' => 'Aviso Legal',            'slug' => 'legal-notice',          'content' => '<p>Este aviso legal regula el uso del sitio web. Los contenidos son propiedad de la empresa. Queda prohibida la reproducción total o parcial sin autorización expresa.</p>'),
            array('title' => 'Envíos y Devoluciones',  'slug' => 'shipping-returns',      'content' => '<p>Realizamos envíos a todo el país. Los plazos de entrega varían según la ubicación. Aceptamos devoluciones dentro de los 30 días posteriores a la recepción del pedido.</p>'),
        );

        foreach ($company_pages as $page_data) {
            $page_id = footer_menus_create_page($page_data['title'], $page_data['slug'], $page_data['content']);
            if ($page_id && !is_wp_error($page_id)) {
                wp_update_nav_menu_item($company_menu_id, 0, array(
                    'menu-item-title'     => $page_data['title'],
                    'menu-item-url'       => get_permalink($page_id),
                    'menu-item-status'    => 'publish',
                    'menu-item-object-id' => $page_id,
                    'menu-item-object'    => 'page',
                    'menu-item-type'      => 'post_type',
                ));
            }
        }
    }

    $locations = get_theme_mod('nav_menu_locations', array());
    if ($company_menu_id) {
        $locations['footer_company'] = $company_menu_id;
    }
    set_theme_mod('nav_menu_locations', $locations);

    update_option('footer_menus_company_upgraded', true);
}
add_action('after_switch_theme', 'footer_menus_seed_defaults');
add_action('admin_init', 'footer_menus_seed_defaults');
