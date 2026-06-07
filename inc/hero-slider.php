<?php

function hero_slider_register_post_type() {
    register_post_type('hero_slide', array(
        'labels' => array(
            'name'               => 'Hero Slides',
            'singular_name'      => 'Hero Slide',
            'add_new_item'       => 'Add New Slide',
            'edit_item'          => 'Edit Slide',
            'new_item'           => 'New Slide',
            'view_item'          => 'View Slide',
            'search_items'       => 'Search Slides',
            'not_found'          => 'No slides found',
            'not_found_in_trash' => 'No slides found in Trash',
        ),
        'public'       => false,
        'show_ui'      => true,
        'show_in_menu' => true,
        'menu_position' => 20,
        'menu_icon'    => 'dashicons-images-alt2',
        'supports'     => array('title', 'page-attributes'),
        'hierarchical' => false,
        'rewrite'      => false,
        'show_in_rest' => false,
    ));
}
add_action('init', 'hero_slider_register_post_type');


function hero_slider_acf_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key'    => 'group_hero_slider',
        'title'  => 'Hero Slide Fields',
        'fields' => array(
            array(
                'key'           => 'field_slide_image',
                'label'         => 'Imagen Desktop',
                'name'          => 'slide_image',
                'type'          => 'image',
                'return_format' => 'url',
                'required'      => 1,
            ),
            array(
                'key'           => 'field_slide_subtitle',
                'label'         => 'Título pequeño',
                'name'          => 'slide_subtitle',
                'type'          => 'text',
                'required'      => 1,
            ),
            array(
                'key'           => 'field_slide_title',
                'label'         => 'Título principal',
                'name'          => 'slide_title',
                'type'          => 'text',
                'required'      => 1,
            ),
            array(
                'key'           => 'field_slide_price',
                'label'         => 'Texto de precio/oferta',
                'name'          => 'slide_price',
                'type'          => 'text',
            ),
            array(
                'key'           => 'field_slide_button_text',
                'label'         => 'Texto del botón',
                'name'          => 'slide_button_text',
                'type'          => 'text',
                'default_value' => 'Shop now',
            ),
            array(
                'key'           => 'field_slide_button_url',
                'label'         => 'URL del botón',
                'name'          => 'slide_button_url',
                'type'          => 'url',
                'default_value' => '#',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'hero_slide',
                ),
            ),
        ),
    ));
}
add_action('acf/init', 'hero_slider_acf_fields');


function hero_slider_create_default_slides() {
    if (!function_exists('get_field')) {
        return;
    }

    if (get_option('hero_slider_defaults_created')) {
        return;
    }

    $existing = get_posts(array(
        'post_type'      => 'hero_slide',
        'posts_per_page' => 1,
        'post_status'    => 'any',
    ));

    if (!empty($existing)) {
        update_option('hero_slider_defaults_created', true);
        return;
    }

    $img_url = get_template_directory_uri() . '/html-template/assets/images';

    $defaults = array(
        array(
            'title'       => 'Medias Personalizadas Premium',
            'subtitle'    => 'Calidad Superior',
            'image'       => $img_url . '/banner-1.jpg',
            'price'       => 'desde <b>$15</b>.99',
            'button_text' => 'Ver Colección',
            'button_url'  => home_url('/shop/'),
        ),
        array(
            'title'       => 'Calcetines Corporativos',
            'subtitle'    => 'Personalización Total',
            'image'       => $img_url . '/banner-2.jpg',
            'price'       => 'pedido mínimo <b>100</b> pares',
            'button_text' => 'Cotizar Ahora',
            'button_url'  => home_url('/shop/'),
        ),
        array(
            'title'       => 'Parches Planchados',
            'subtitle'    => 'Diseño Exclusivo',
            'image'       => $img_url . '/banner-3.jpg',
            'price'       => 'personaliza <b>tu</b> estilo',
            'button_text' => 'Ver Diseños',
            'button_url'  => home_url('/shop/'),
        ),
    );

    foreach ($defaults as $index => $slide) {
        $post_id = wp_insert_post(array(
            'post_type'   => 'hero_slide',
            'post_title'  => $slide['title'],
            'post_status' => 'publish',
            'menu_order'  => $index + 1,
        ));

        if ($post_id && !is_wp_error($post_id)) {
            update_field('slide_subtitle', $slide['subtitle'], $post_id);
            update_field('slide_title', $slide['title'], $post_id);
            update_field('slide_image', $slide['image'], $post_id);
            update_field('slide_price', $slide['price'], $post_id);
            update_field('slide_button_text', $slide['button_text'], $post_id);
            update_field('slide_button_url', $slide['button_url'], $post_id);
        }
    }

    update_option('hero_slider_defaults_created', true);
}
add_action('after_switch_theme', 'hero_slider_create_default_slides');
add_action('admin_init', 'hero_slider_create_default_slides');
